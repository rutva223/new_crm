<?php

namespace App\Http\Controllers;


use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\Transaction;
use App\Models\UserCoupon;
use App\Models\Utility;
use App\Models\Client;
use App\Models\Setting;
use App\Models\transactions;
use Google\Service\AndroidPublisher\Resource\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    public $settings;

    public function refund(Request $request, $id, $user_id)
    {
        Order::where('id', $request->id)->update(['is_refund' => 1]);

        $user = User::find($user_id);

        $assignPlan = $user->assignPlan(1);

        return redirect()->back()->with('success', __('We successfully planned a refund and assigned a free plan.'));
    }

    public function stripe($code)
    {
        try {
            $plan_id               = \Illuminate\Support\Facades\Crypt::decrypt($code);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __($e->getMessage()));
        }

        $admin_payment_setting = Utility::getAdminPaymentSetting();
        $plan_id               = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan                  = Plan::find($plan_id);
        if ($plan) {
            return view('plan/stripe', compact('plan', 'admin_payment_setting'));
        } else {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
    }

    public function stripePost(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan           = Plan::find($planID);
        $authuser       = Auth::user();
        $data           = $request->all();
        $stripe_session = '';
        $Settings       = Setting::pluck('value', 'name');

        try {
            if ($plan) {
                $product = $plan->name;
                $P_price = $plan->price;

                /* Final price */
                // $stripe_formatted_price = in_array($this->currancy, [
                $stripe_formatted_price = in_array('USD', [
                    'MGA', 'BIF', 'CLP', 'PYG', 'DJF', 'RWF', 'GNF', 'UGX', 'JPY', 'VND', 'VUV', 'XAF', 'KMF', 'KRW', 'XOF', 'XPF',
                ]) ? number_format($P_price, 2, '.', '') : number_format($P_price * 100, 0, '', '');
                $return_url_parameters = function ($return_type) {
                    return '&return_type=' . $return_type .  '&payment_processor=stripe';
                };

                $stripe_secret_key = isset($Settings['stripe_secret_key']) ? $Settings['stripe_secret_key'] : '';
                \Stripe\Stripe::setApiKey($stripe_secret_key);

                $price = \Stripe\Price::create([
                    'product' => $plan->id,
                    'unit_amount' => $stripe_formatted_price,
                    'currency' => 'usd',
                    'recurring' => ['interval' => 'month'],
                ]);

                $stripe_session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price' => $price ? $price->id : null,
                            'quantity' => 1,
                        ],
                    ],
                    'mode' => 'subscription',
                    'metadata' => [
                        'user_id' => $authuser->id,
                        'package_id' => $plan->id,
                    ],
                    'success_url' => route('stripe.payment.status', [
                        'plan_id' => $plan->id,
                        'price' => $P_price,
                    ]) . $return_url_parameters('success'),
                    'cancel_url' => route('stripe.payment.status', [
                        'plan_id' => $plan->id,
                    ]) . $return_url_parameters('cancel'),
                ]);

                // session()->put('beauty_spa_variable', $data);
                $request->session()->put('stripe_session', $stripe_session);
                $stripe_session = $stripe_session ?? false;

                return view('plan.stripe', compact('stripe_session', 'plan'));
                // return redirect()->route('plans.index', $request->plan_id)->with(['stripe_session' => $stripe_session]);
            } else {
                return redirect()->route('payment', $request->plan_id)->with('error', __('Plan is deleted.'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function planGetStripePaymentStatus(Request $request)
    {
        // Session::forget('stripe_session');
        try {
            if ($request->return_type == 'success') {
                $objUser        = Auth::user();

                $plan           = Plan::find($request['plan_id']);
                $orderID        = strtoupper(str_replace('.', '', uniqid('', true)));
                $Settings       = Setting::pluck('value', 'name');

                $stripe_session = session()->get('stripe_session');

                $stripe_secret_key = isset($Settings['stripe_secret_key']) ? $Settings['stripe_secret_key'] : '';

                $stripe = new \Stripe\StripeClient($stripe_secret_key);

                Order::create(
                    [
                        'order_id' => $orderID,
                        'name' => $plan->name,
                        'card_number' => '',
                        'card_exp_month' => '',
                        'card_exp_year' => '',
                        'plan_name' => $plan->name,
                        'plan_id' => $plan->id,
                        'price' => $request->price,
                        'price_currency' => '',
                        'payment_status' => '',
                        'payment_type' => __('STRIPE'),
                        'user_id' => $objUser->id,
                    ]
                );

                $assignPlan     = $objUser->assignPlan($request->plan_id);
                if ($request->return_type == 'success') {
                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                } else {
                    return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                }
            } else {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function addPayment(Request $request, $id)
    {
        $company_payment_setting = Utility::getCompanyPaymentSetting();

        $settings  = DB::table('settings')->where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('value', 'name');
        $objUser = \Auth::user();

        $invoice = Invoice::find($id);

        if ($invoice) {
            if ($request->amount > $invoice->getDue()) {
                return redirect()->back()->with('error', __('Invalid amount.'));
            } else {
                $orderID        =   strtoupper(str_replace('.', '', uniqid('', true)));
                $price          =   $request->amount;
                Stripe\Stripe::setApiKey($company_payment_setting['stripe_secret']);

                $data = Stripe\Charge::create(
                    [
                        "amount"        =>   100 * $price,
                        "currency"      =>   Utility::getValByName('site_currency'),
                        "source"        =>   $request->stripeToken,
                        "description"   =>   __('Invoice') . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                        "metadata"      =>   ["order_id" => $orderID],
                    ]
                );

                if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {

                    $payments = InvoicePayment::create(
                        [
                            'invoice'           =>   $invoice->id,
                            'date'              =>   date('Y-m-d'),
                            'amount'            =>   $price,
                            'payment_method'    =>   1,
                            'transaction'       =>   $orderID,
                            'payment_type'      =>   __('STRIPE'),
                            'receipt'           =>   $data['receipt_url'],
                            'notes'             =>   __('Invoice') . ' ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),

                        ]
                    );

                    $invoice = Invoice::find($id);

                    if ($invoice->getDue() <= 0.0) {
                        Invoice::change_status($invoice->id, 5);
                    } elseif ($invoice->getDue() > 0) {
                        Invoice::change_status($invoice->id, 4);
                    } else {
                        Invoice::change_status($invoice->id, 3);
                    }

                    return redirect()->back()->with('success', __(' Payment successfully added.'));
                } else {
                    return redirect()->back()->with('error', __('Transaction has been failed.'));
                }
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function invoicePayWithStripe(Request $request)
    {
        $amount = $request->amount;
        $settings = Utility::settings();

        $validatorArray = [
            'amount' => 'required',
            'invoice_id' => 'required',
        ];
        $validator      = Validator::make(
            $request->all(),
            $validatorArray
        )->setAttributeNames(
            ['invoice_id' => 'Invoice']
        );
        if ($validator->fails()) {
            return Utility::error_res($validator->errors()->first());
        }

        $invoice = Invoice::find($request->invoice_id);
        $invoice_id = $invoice->id;
        $authuser = User::where('id', $invoice->created_by)->first();
        $amount = number_format((float)$request->amount, 2, '.', '');

        if (\Auth::check()) {
            $company_payment = Utility::getCompanyPaymentSetting();
        } else {
            $company_payment = Utility::getNonAuthCompanyPaymentSetting($invoice->created_by);
        }
        $invoice_getdue = number_format((float)$invoice->getDue(), 2, '.', '');

        if ($invoice_getdue < $amount) {
            // dd($invoice_getdue);
            return Utility::error_res('not correct amount');
        }

        $stripe_formatted_price = in_array(
            $settings['site_currency'],
            [
                'MGA',
                'BIF',
                'CLP',
                'PYG',
                'DJF',
                'RWF',
                'GNF',
                'UGX',
                'JPY',
                'VND',
                'VUV',
                'XAF',
                'KMF',
                'KRW',
                'XOF',
                'XPF',
            ]
        ) ? number_format($amount, 2, '.', '') : number_format($amount, 2, '.', '') * 100;

        $return_url_parameters = function ($return_type) {
            return '&return_type=' . $return_type . '&payment_processor=stripe';
        };

        /* Initiate Stripe */
        \Stripe\Stripe::setApiKey($company_payment['stripe_secret']);


        $stripe_session = \Stripe\Checkout\Session::create(
            [
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'name' => $settings['company_name'] . " - " . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                        'description' => 'payment for Invoice',
                        'amount' => $stripe_formatted_price,
                        'currency' => $settings['site_currency'],
                        'quantity' => 1,
                    ],
                ],
                'metadata' => [
                    'user_id' => $authuser->id,
                    'invoice_id' => $request->invoice_id,
                ],
                'success_url' => route('invoice.stripe', [encrypt($request->invoice_id), $amount, 'return_type' => 'success']),
                'cancel_url' => route('invoice.stripe', [encrypt($request->invoice_id), $amount, 'return_type' => 'cancel']),
            ]
        );

        $stripe_session = $stripe_session ?? false;

        try {
            return redirect()->to($stripe_session->url);
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return redirect()->route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice_id))->with('error', __('Transaction has been failed!'));
        }
    }

    public function getInvociePaymentStatus(Request $request, $invoice_id, $amount)
    {
        Session::forget('stripe_session');
        try {
            if ($request->return_type == 'success') {
                if (!empty($invoice_id)) {

                    $invoice_id = decrypt($invoice_id);
                    $invoice    = Invoice::find($invoice_id);

                    if (\Auth::check()) {
                        $user = \Auth::user();
                    } else {
                        $user = User::where('id', $invoice->created_by)->first();
                    }
                    if ($invoice) {
                        $settings = Utility::settingsById($invoice->created_by);
                        if ($request->return_type == 'success') {
                            $invoice_payment                 = new InvoicePayment();
                            $invoice_payment->transaction    =   time();
                            $invoice_payment->invoice     = $invoice_id;
                            $invoice_payment->amount         = isset($amount) ? $amount : 0;
                            $invoice_payment->date           = date('Y-m-d');
                            $invoice_payment->payment_method   = 1;
                            $invoice_payment->payment_type   = __('STRIPE');
                            $invoice_payment->notes          = Utility::invoiceNumberFormat($settings, $invoice->invoice_id);
                            $invoice_payment->created_by     =  $user->creatorId();
                            $invoice_payment->save();

                            $invoice_getdue = number_format((float)$invoice->getDue(), 2, '.', '');

                            if ($invoice_getdue <= 0.0) {

                                Invoice::change_status($invoice->id, 3);
                            } else {

                                Invoice::change_status($invoice->id, 2);
                            }


                            if (\Auth::check()) {
                                $user = \Auth::user();
                            } else {
                                $user = User::where('id', $invoice->created_by)->first();
                            }

                            $amt = isset($amount) ? $amount : 0;
                            $settings  = Utility::settings();
                            // if(isset($settings['payment_create_notification']) && $settings['payment_create_notification'] ==1){
                            //     $msg = __('New payment of ').$amt.' '.__('created for ').$user->name.__(' by STRIPE').'.';
                            //     Utility::send_slack_msg($msg);
                            // }
                            if (isset($settings['payment_create_notification']) && $settings['payment_create_notification'] == 1) {
                                $uArr = [
                                    'user_name' => $user->name,
                                    'amount' => $amt,
                                    'created_by' => 'by STRIPE',
                                ];
                                Utility::send_slack_msg('new_payment', $uArr);
                            }
                            if (isset($settings['telegram_payment_create_notification']) && $settings['telegram_payment_create_notification'] == 1) {
                                $uArr = [
                                    'user_name' => $user->name,
                                    'amount' => $amt,
                                    'created_by' => 'by STRIPE',
                                ];
                                Utility::send_telegram_msg('new_payment', $uArr);
                            }
                            if (isset($settings['twilio_invoice_payment_create_notification']) && $settings['twilio_invoice_payment_create_notification'] == 1) {
                                $uArr = [
                                    'user_name' => $user->name,
                                    'amount' => $amt,
                                    'created_by' => 'by STRIPE',
                                ];
                                Utility::send_twilio_msg('new_payment', $uArr);
                            }
                            $module = 'Invoice Status Update';
                            $webhook =  Utility::webhookSetting($module, $invoice->created_by);
                            if ($webhook) {
                                $parameter = json_encode($invoice);
                                // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                                $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                                // dd($status);
                                if ($status == true) {
                                    return redirect()->back()->with('success', __('Payment added Successfully!'));
                                } else {
                                    return redirect()->back()->with('error', __('Webhook call failed.'));
                                }
                            }

                            return redirect()->route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))->with('success', __('Payment added Successfully'));
                        } else {
                            return redirect()->route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))->with('error', __('Transaction has been failed!'));
                        }
                    } else {

                        return redirect()->route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))->with('error', __('Invoice not found.'));
                    }
                } else {

                    return redirect()->route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))->with('error', __('Invoice not found.'));
                }
            } else {

                return redirect()->route('pay.invoice', $invoice_id)->with('error', __('Transaction has been failed!'));
            }
        } catch (\Exception $exception) {
            return redirect()->route('pay.invoice', $invoice_id)->with('error', $exception->getMessage());
        }
    }

    public function orderAction($id)
    {
        $order = Order::find($id);
        $admin_payment_settings = Utility::getAdminPaymentSetting();
        // dd($admin_payment_settings);
        return view('order.order_action', compact('order', 'admin_payment_settings'));
    }
    public function changeAction(Request $request)
    {
        if (\Auth::user()->type == 'super admin') {
            $order = Order::find($request->order_id);

            $order->payment_status = $request->payment_status;

            if ($order->payment_status == 'success') {
                $order->payment_status = 'success';
            }
            $order->save();
            return redirect()->route('order.index')->with('success', __('Order status Successfully Updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function deleteOrder($id)
    {
        if (\Auth::user()->type == 'super admin') {

            $order = Order::find($id);
            $order->delete();
            return redirect()->route('order.index')->with('success', __('Order successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
