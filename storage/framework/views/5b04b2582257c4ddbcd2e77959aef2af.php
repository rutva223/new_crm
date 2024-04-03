<?php
$logo = Utility::GetLogo();
$logos = \App\Models\Utility::get_file('uploads/logo/');
// $logo = \App\Models\Utility::get_file('uploads/logo/');
$dark_logo = Utility::getValByName('company_logo_dark');
$settings = Utility::settings();

?>

<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Invoice')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Invoice')); ?> </h5>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<a href="<?php echo e(route('invoice.pdf', \Crypt::encrypt($invoice->id))); ?>" target="_blank"
    class="btn btn-sm btn-primary btn-icon m-1">
    <span class="btn-inner--icon"><i class="ti ti-printer"></i></span>
    <span class="btn-inner--text"><?php echo e(__('Print')); ?></span>
</a>
<?php if($invoice->getDue() > 0): ?>
<a href="#" data-bs-toggle="modal" data-bs-target="#paymentModal" class="btn btn-sm btn-primary btn-icon m-1">
    <span class="btn-inner--icon text-white"><i class="fa fa-credit-card"></i></span>
    <span class="btn-inner--text text-white"><?php echo e(__(' Pay Now')); ?></span>
</a>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- [ Invoice ] start -->
    <div class="container">
        <div>
            <div class="card" id="printTable">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-8 invoice-contact">
                            <div class="invoice-box row">
                                <div class="col-sm-12">
                                    <table class="table mt-0 table-responsive invoice-table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php if(Utility::getValByName('cust_darklayout') == 'on'): ?>
                                                    <img src="<?php echo e($logos . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png')); ?>"
                                                        alt="" class="img-fluid" />
                                                    <?php else: ?>
                                                    <img src="<?php echo e($logos . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png')); ?>"
                                                        alt="" class="img-fluid" />
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e($company_setting['company_name']); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?php echo e($company_setting['company_address']); ?> <br>
                                                    <?php echo e($company_setting['company_city']); ?><br>
                                                    <?php echo e($company_setting['company_state']); ?>

                                                    <?php echo e($company_setting['company_zipcode']); ?> <br>
                                                    <?php echo e($company_setting['company_country']); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e($company_setting['company_telephone']); ?>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="float-end">
                                <?php echo DNS2D::getBarcodeHTML(
                                route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)),
                                'QRCODE',
                                2,
                                2,
                                ); ?>

                            </div>
                        </div>
                    </div>


                    <div class="row invoive-info d-print-inline-flex">
                        <?php if(!empty($invoice->clientDetail)): ?>
                        <div class="col-sm-4 invoice-client-info">
                            <h6><?php echo e(__('Invoice To :')); ?></h6>
                            <h6 class="m-0">
                                <?php echo e(!empty($invoice->clientDetail->company_name) ? $invoice->clientDetail->company_name : ''); ?>

                            </h6>

                            <p class="m-0 m-t-10">
                                <?php echo e(!empty($invoice->clientDetail->address_1) ? $invoice->clientDetail->address_1 : ''); ?>

                                <br><?php echo e(!empty($invoice->clientDetail->city) ? $invoice->clientDetail->city : ''); ?>

                                <br> <?php echo e(!empty($invoice->clientDetail->state) ? $invoice->clientDetail->state : ''); ?>

                                <a class="text-secondary" href="$" target="_top"><span class="__cf_email__"
                                        data-cfemail="6a0e0f07052a0d070b030644090507">
                                        <?php echo e(!empty($invoice->clientDetail->zip_code) ? $invoice->clientDetail->zip_code : ''); ?></span>
                                </a>
                                <br>
                                <?php echo e(!empty($invoice->clientDetail->country) ? $invoice->clientDetail->country : ''); ?>

                            </p><br>
                            <p class="m-0">
                                <?php echo e(!empty($invoice->clientDetail->mobile) ? $invoice->clientDetail->mobile : ''); ?></p>
                        </div>
                        <?php endif; ?>
                        <div class="col-sm-4">
                            <h6 class="m-b-20"><?php echo e(__('Order Details :')); ?></h6>
                            <table class="table table-responsive mt-0 invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th><?php echo e(__('Issue Date :')); ?></th>
                                        <td>
                                            <?php if(\Auth::check()): ?>
                                            <?php echo e(\Auth::user()->dateFormat($invoice->issue_date)); ?>

                                            <?php else: ?>
                                            <?php echo e(\App\Models\User::dateFormat($invoice->issue_date)); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('Expiry Date : ')); ?></th>
                                        <td>
                                            <?php if(\Auth::check()): ?>
                                            <?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?>

                                            <?php else: ?>
                                            <?php echo e(\App\Models\User::dateFormat($invoice->due_date)); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('Status : ')); ?></th>
                                        <td>
                                            <?php if($invoice->status == 0): ?>
                                            <span
                                                class="badge bg-primary rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                            <?php elseif($invoice->status == 1): ?>
                                            <span
                                                class="badge bg-info rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                            <?php elseif($invoice->status == 2): ?>
                                            <span
                                                class="badge bg-secondary rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                            <?php elseif($invoice->status == 3): ?>
                                            <span
                                                class="badge bg-danger rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                            <?php elseif($invoice->status == 4): ?>
                                            <span
                                                class="badge bg-warning rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                            <?php elseif($invoice->status == 5): ?>
                                            <span
                                                class="badge bg-success rounded"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="m-b-20"><?php echo e(__('Invoice No.')); ?></h6>
                            <h6 class="text-uppercase text-primary">
                                <?php if(\Auth::check()): ?>
                                <?php echo e(\Auth::user()->invoicenumberFormat($invoice->invoice_id)); ?>

                                <?php else: ?>
                                <?php echo e(\App\Models\Utility::invoicenumberFormat($settings, $invoice->invoice_id)); ?>

                                <?php endif; ?>

                            </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive mb-4">
                                <table class="table invoice-detail-table">
                                    <thead>
                                        <tr class="thead-default">
                                            <th><?php echo e(__('Item')); ?></th>
                                            <th><?php echo e(__('Quantity')); ?></th>
                                            <th><?php echo e(__('Rate')); ?></th>
                                            <th><?php echo e(__('Tax')); ?></th>
                                            <th><?php echo e(__('Discount')); ?></th>
                                            <th><?php echo e(__('Price')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalQuantity = 0;
                                        $totalRate = 0;
                                        $totalAmount = 0;
                                        $totalTaxPrice = 0;
                                        $totalDiscount = 0;
                                        $taxesData = [];
                                        ?>
                                        <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if (!empty($item->tax)) {
                                        $taxes = \Utility::tax($item->tax);
                                        $totalQuantity += $item->quantity;
                                        $totalRate += $item->price;
                                        $totalDiscount += $item->discount;

                                        foreach ($taxes as $taxe) {
                                        $taxDataPrice = \Utility::taxRate($taxe->rate, $item->price, $item->quantity);
                                        if (array_key_exists($taxe->name, $taxesData)) {
                                        $taxesData[$taxe->name] = $taxesData[$taxe->name] + $taxDataPrice;
                                        } else {
                                        $taxesData[$taxe->name] = $taxDataPrice;
                                        }
                                        }
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <h6><?php echo e(!empty($item->items) ? $item->items->name : '-'); ?></h6>
                                                <p><?php echo e($item->description); ?></p>
                                            </td>
                                            <td><?php echo e($item->quantity); ?></td>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($item->price)); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($item->price)); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($item->tax)): ?>
                                                <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $taxPrice = \Utility::taxRate($tax->rate, $item->price,
                                                $item->quantity);
                                                $totalTaxPrice += $taxPrice;
                                                ?>
                                                <a href="#!"
                                                    class="d-block text-sm text-muted"><?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?>

                                                    &nbsp;&nbsp; <?php if(\Auth::check()): ?>
                                                    <?php echo e(\Auth::user()->priceFormat($item->price)); ?>

                                                    <?php else: ?>
                                                    <?php echo e(\App\Models\User::priceFormat($item->price)); ?>

                                                    <?php endif; ?>
                                                </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($item->discount)); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($item->discount)); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($item->price * $item->quantity)); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($item->price * $item->quantity)); ?>

                                                <?php endif; ?>
                                            </td>
                                            <?php
                                            $totalQuantity += $item->quantity;
                                            $totalRate += $item->price;
                                            $totalDiscount += $item->discount;
                                            $totalAmount += $item->price * $item->quantity;
                                            ?>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="invoice-total">
                                <table class="table invoice-table ">
                                    <tbody>
                                        <tr>
                                            <th><?php echo e(__('Sub Total :')); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($invoice->getSubTotal())); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($invoice->getSubTotal())); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('Discount :')); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($invoice->getTotalDiscount())); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($invoice->getTotalDiscount())); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if(!empty($taxesData)): ?>
                                        <?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>

                                            <th><?php echo e($taxName); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($taxPrice)); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($taxPrice)); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                        <tr>
                                            <th><?php echo e(__('Total :')); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($invoice->getTotal())); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($invoice->getTotal())); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('Credit Note :')); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($invoice->invoiceCreditNote())); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($invoice->invoiceCreditNote())); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('Paid :')); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceCreditNote())); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceCreditNote())); ?>

                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('Due :')); ?></th>
                                            <td>
                                                <?php if(\Auth::check()): ?>
                                                <?php echo e(\Auth::user()->priceFormat($invoice->getDue())); ?>

                                                <?php else: ?>
                                                <?php echo e(\App\Models\User::priceFormat($invoice->getDue())); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <hr />
                                                <h5 class="text-primary m-r-10"><?php echo e(__('Total :')); ?></h5>
                                            </td>
                                            <td>
                                                <hr />
                                                <h5 class="text-primary">
                                                    <?php if(\Auth::check()): ?>
                                                    <?php echo e(\Auth::user()->priceFormat($invoice->getTotal())); ?>

                                                    <?php else: ?>
                                                    <?php echo e(\App\Models\User::priceFormat($invoice->getTotal())); ?>

                                                    <?php endif; ?>
                                                </h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Invoice ] end -->
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card table-responsive mb-4">
            <div class="card-header">
                <h5><?php echo e(__('Receipt Summary')); ?></h5>
                <?php if($user_storage >= $plan_storage): ?>
                <span
                    class="text-danger"><small><?php echo e(__('Your plan storage limit is over , so you can not see customer uploaded payment receipt.')); ?></small></span>
                <?php endif; ?>
            </div>
            <table class="card-body table invoice-detail-table">
                <thead>
                    <tr class="thead-default">
                        <th><?php echo e(__('Transaction ID')); ?></th>
                        <th><?php echo e(__('Payment Date')); ?></th>
                        <th><?php echo e(__('Payment Method')); ?></th>
                        <th><?php echo e(__('Payment Type')); ?></th>
                        <th><?php echo e(__('Note')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Action')); ?></th>

                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($payment->transaction); ?> </td>
                        <td>
                            <?php if(\Auth::check()): ?>
                            <?php echo e(\Auth::user()->dateFormat($payment->date)); ?>

                            <?php else: ?>
                            <?php echo e(\App\Models\User::dateFormat($payment->date)); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e(!empty($payment->payments) ? $payment->payments->name : ''); ?> </td>
                        <td><?php echo e($payment->payment_type); ?> </td>
                        <td><?php echo e($payment->notes); ?> </td>
                        <td>
                            <?php if(\Auth::check()): ?>
                            <?php echo e(\Auth::user()->priceFormat($payment->amount)); ?>

                            <?php else: ?>
                            <?php echo e(\App\Models\User::priceFormat($payment->amount)); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($user_storage >= $plan_storage): ?>
                            --
                            <?php else: ?>
                            <?php if(!empty($payment->receipt)): ?>
                            <?php
                            $x = pathinfo($payment->receipt, PATHINFO_FILENAME);
                            $extension = pathinfo($payment->receipt, PATHINFO_EXTENSION);
                            $result = str_replace(['#', "'", ';'], '', $payment->receipt);

                            ?>
                            <a href="<?php echo e(route('invoice.receipt', [$x, "$extension"])); ?>" data-toggle="tooltip"
                                class="btn btn-sm btn-primary btn-icon rounded-pill">
                                <i class="ti ti-download" data-bs-toggle="tooltip"
                                    data-bs-original-title="<?php echo e(__('Download')); ?>"></i>
                            </a>
                            <a href="<?php echo e(asset(Storage::url('uploads/attachment/' . $x . '.' . $extension))); ?>"
                                target="_blank" data-toggle="tooltip"
                                class="btn btn-sm btn-secondary btn-icon rounded-pill">
                                <i class="ti ti-crosshair" data-bs-toggle="tooltip"
                                    data-bs-original-title="<?php echo e(__('Preview')); ?>"></i>
                            </a>
                            <?php else: ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $banktransfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($bank_payment->order_id); ?> </td>
                        <td><?php echo e(\App\Models\Utility::dateFormat($settings, $bank_payment->date)); ?> </td>
                        <td><?php echo e('-'); ?> </td>
                        <td> <?php echo e(__('Bank Transfer')); ?> </td>
                        <td>
                            <?php echo e(\App\Models\Utility::invoiceNumberFormat($settings, $invoice->invoice_id)); ?>

                        </td>
                        <td><?php echo e(\App\Models\Utility::priceFormat($settings, $bank_payment->amount)); ?> </td>
                        <td></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($invoice->getDue() > 0): ?>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel"><?php echo e(__('Add Payment')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <div class="card"> -->
                <ul class="nav nav-pills  mb-3" role="tablist">
                    <?php if(isset($payment_setting['is_bank_transfer_enabled']) &&
                    $payment_setting['is_bank_transfer_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['bank_details']) && !empty($payment_setting['bank_details'])): ?>
                    <li class="nav-item mb-2">
                        <a href="#banktransfer-payment" class="btn btn-outline-primary btn-sm active"
                            aria-controls="banktransfer" data-bs-toggle="tab" role="tab" aria-selected="false">
                            <?php echo e(__('BankTransfer')); ?>

                        </a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_stripe_enabled']) && $payment_setting['is_stripe_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['stripe_key']) &&
                    !empty($payment_setting['stripe_key']) &&
                    (isset($payment_setting['stripe_secret']) && !empty($payment_setting['stripe_secret']))): ?>
                    <li class="nav-item mb-2">
                        <a href="#stripe-payment" class="btn btn-outline-primary btn-sm ml-1" data-bs-toggle="tab"
                            role="tab" aria-selected="false">
                            <?php echo e(__('Stripe')); ?>

                        </a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_paypal_enabled']) && $payment_setting['is_paypal_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['paypal_client_id']) &&
                    !empty($payment_setting['paypal_client_id']) &&
                    (isset($payment_setting['paypal_secret_key']) && !empty($payment_setting['paypal_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#paypal-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="paypal" aria-selected="false"><?php echo e(__('Paypal')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_paystack_enabled']) && $payment_setting['is_paystack_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['paystack_public_key']) &&
                    !empty($payment_setting['paystack_public_key']) &&
                    (isset($payment_setting['paystack_secret_key']) && !empty($payment_setting['paystack_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#paystack-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="paystack" aria-selected="false"><?php echo e(__('Paystack')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_flutterwave_enabled']) && $payment_setting['is_flutterwave_enabled']
                    == 'on'): ?>
                    <?php if(isset($payment_setting['flutterwave_secret_key']) &&
                    !empty($payment_setting['flutterwave_secret_key']) &&
                    (isset($payment_setting['flutterwave_public_key']) &&
                    !empty($payment_setting['flutterwave_public_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#flutterwave-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="flutterwave" aria-selected="false"><?php echo e(__('Flutterwave')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_razorpay_enabled']) && $payment_setting['is_razorpay_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['razorpay_public_key']) &&
                    !empty($payment_setting['razorpay_public_key']) &&
                    (isset($payment_setting['razorpay_secret_key']) && !empty($payment_setting['razorpay_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#razorpay-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="razorpay" aria-selected="false"><?php echo e(__('Razorpay')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_mercado_enabled']) && $payment_setting['is_mercado_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['mercado_access_token']) &&
                    !empty($payment_setting['mercado_access_token'])): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#mercado-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="mercado" aria-selected="false"><?php echo e(__('Mercado Pago')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_paytm_enabled']) && $payment_setting['is_paytm_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['paytm_merchant_id']) &&
                    !empty($payment_setting['paytm_merchant_id']) &&
                    (isset($payment_setting['paytm_merchant_key']) && !empty($payment_setting['paytm_merchant_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#paytm-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="paytm" aria-selected="false"><?php echo e(__('Paytm')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_mollie_enabled']) && $payment_setting['is_mollie_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['mollie_api_key']) &&
                    !empty($payment_setting['mollie_api_key']) &&
                    (isset($payment_setting['mollie_profile_id']) && !empty($payment_setting['mollie_profile_id']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#mollie-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="mollie" aria-selected="false"><?php echo e(__('Mollie')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_skrill_enabled']) && $payment_setting['is_skrill_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['skrill_email']) && !empty($payment_setting['skrill_email'])): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#skrill-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="skrill" aria-selected="false"><?php echo e(__('Skrill')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_coingate_enabled']) && $payment_setting['is_coingate_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['coingate_auth_token']) &&
                    !empty($payment_setting['coingate_auth_token'])): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#coingate-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="coingate" aria-selected="false"><?php echo e(__('CoinGate')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_paymentwall_enabled']) && $payment_setting['is_paymentwall_enabled']
                    == 'on'): ?>
                    <?php if(isset($payment_setting['paymentwall_public_key']) &&
                    !empty($payment_setting['paymentwall_public_key']) &&
                    (isset($payment_setting['paymentwall_private_key']) &&
                    !empty($payment_setting['paymentwall_private_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#paymentwall-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="paymentwall" aria-selected="false"><?php echo e(__('PaymentWall')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_toyyibpay_enabled']) && $payment_setting['is_toyyibpay_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['toyyibpay_secret_key']) &&
                    !empty($payment_setting['toyyibpay_secret_key']) &&
                    (isset($payment_setting['category_code']) && !empty($payment_setting['category_code']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#toyyibpay-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="toyyibpay" aria-selected="false"><?php echo e(__('Toyyibpay')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_payfast_enabled']) && $payment_setting['is_payfast_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['payfast_merchant_id']) &&
                    !empty($payment_setting['payfast_merchant_id']) &&
                    (isset($payment_setting['payfast_merchant_key']) &&
                    !empty($payment_setting['payfast_merchant_key']))): ?>
                    <li class="nav-item mb-2">
                        <a href="#payfast-payment" class="btn btn-outline-primary btn-sm ml-1" id="pills-payfast-tab"
                            data-bs-toggle="pill" role="tab" aria-controls="payfast"
                            aria-selected="false"><?php echo e(__('Payfast')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_iyzipay_enabled']) && $payment_setting['is_iyzipay_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['iyzipay_public_key']) &&
                    !empty($payment_setting['iyzipay_public_key']) &&
                    (isset($payment_setting['iyzipay_secret_key']) && !empty($payment_setting['iyzipay_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#iyzipay-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="iyzipay" aria-selected="false"><?php echo e(__('Iyzipay')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_sspay_enabled']) && $payment_setting['is_sspay_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['sspay_secret_key']) &&
                    !empty($payment_setting['sspay_secret_key']) &&
                    (isset($payment_setting['sspay_category_code']) && !empty($payment_setting['sspay_category_code']))): ?>
                    <li class="nav-item mb-2">
                        <a data-bs-toggle="tab" href="#sspay-payment" class="btn btn-outline-primary btn-sm ml-1"
                            role="tab" aria-controls="sspay" aria-selected="false"><?php echo e(__('Sspay')); ?></a>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_paytab_enabled']) && $payment_setting['is_paytab_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['paytab_profile_id']) && !empty($payment_setting['paytab_profile_id'])
                    && (isset($payment_setting['paytab_server_key']) && !empty($payment_setting['paytab_server_key']))
                    && (isset($payment_setting['paytab_region']) && !empty($payment_setting['paytab_region']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#paytab-payment" role="tab" aria-controls="paytab" type="button"
                            aria-selected="false"><?php echo e(__('PayTab')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_benefit_enabled']) && $payment_setting['is_benefit_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['benefit_api_key']) &&
                    !empty($payment_setting['benefit_api_key']) &&
                    (isset($payment_setting['benefit_secret_key']) && !empty($payment_setting['benefit_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#benefit-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('Benefit')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_cashfree_enabled']) && $payment_setting['is_cashfree_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['cashfree_api_key']) &&
                    !empty($payment_setting['cashfree_api_key']) &&
                    (isset($payment_setting['cashfree_secret_key']) && !empty($payment_setting['cashfree_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#cashfree-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('Cashfree')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_aamarpay_enabled']) && $payment_setting['is_aamarpay_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['aamarpay_store_id']) &&
                    !empty($payment_setting['aamarpay_store_id']) &&
                    (isset($payment_setting['aamarpay_signature_key']) &&
                    !empty($payment_setting['aamarpay_signature_key'])) &&
                    (isset($payment_setting['aamarpay_description']) &&
                    !empty($payment_setting['aamarpay_description']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#aamarpay-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('Aamarpay')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(isset($payment_setting['is_paytr_enabled']) && $payment_setting['is_paytr_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['paytr_merchant_id']) &&
                    !empty($payment_setting['paytr_merchant_id']) &&
                    (isset($payment_setting['paytr_merchant_key']) && !empty($payment_setting['paytr_merchant_key'])) &&
                    (isset($payment_setting['paytr_merchant_salt']) && !empty($payment_setting['paytr_merchant_salt']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#paytr-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('PayTr')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>


                    <?php if(isset($payment_setting['is_yookassa_enabled']) && $payment_setting['is_yookassa_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['is_yookassa_enabled']) &&
                    !empty($payment_setting['is_yookassa_enabled']) &&
                    (isset($payment_setting['yookassa_shop_id']) && !empty($payment_setting['yookassa_shop_id'])) &&
                    (isset($payment_setting['yookassa_secret_key']) && !empty($payment_setting['yookassa_secret_key']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#yookassa-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('Yookassa')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(isset($payment_setting['is_midtrans_enabled']) && $payment_setting['is_midtrans_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['is_midtrans_enabled']) &&
                    !empty($payment_setting['is_midtrans_enabled']) &&
                    (isset($payment_setting['midtrans_secret']) && !empty($payment_setting['midtrans_secret']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#midtrans-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('Midtrans')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(isset($payment_setting['is_xendit_enabled']) && $payment_setting['is_xendit_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['is_xendit_enabled']) &&
                    !empty($payment_setting['is_xendit_enabled']) &&
                    (isset($payment_setting['xendit_api_key']) && !empty($payment_setting['xendit_api_key'])) &&
                    (isset($payment_setting['xendit_token']) && !empty($payment_setting['xendit_token']))): ?>
                    <li class="nav-item mb-2">
                        <button class="btn btn-outline-primary btn-sm" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#xendit-payment" role="tab" aria-controls="benefit" type="button"
                            aria-selected="false"><?php echo e(__('Xendit')); ?></button>
                    </li>&nbsp;
                    <?php endif; ?>
                    <?php endif; ?>

                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="banktransfer-payment" role="tabpanel"
                        aria-labelledby="banktransfer-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_bank_transfer_enabled']) &&
                            $payment_setting['is_bank_transfer_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['bank_details']) && !empty($payment_setting['bank_details'])): ?>
                            <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                                action="<?php echo e(route('invoice.pay.with.banktransfer')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo isset($payment_setting['bank_details']) ?
                                                $payment_setting['bank_details'] : ''; ?>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="payment_receipt"
                                                    class="form-label"><?php echo e(__('Payment Receipt :')); ?></label>
                                                <input type="file" name="payment_receipt" class="form-control">
                                            </div>
                                            <?php $__errorArgs = ['payment_receipt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-payment_receipt text-danger text-xs"
                                                role="alert"><?php echo e($messages); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div><br>

                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span>
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span> <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                        </div>
                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-amount text-danger text-xs"
                                            role="alert"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-12 form-group mt-3 text-right">
                                        <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                            class="btn btn-sm btn-primary rounded-pill">
                                    </div>
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="stripe-payment" role="tabpanel" aria-labelledby="stripe-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_stripe_enabled']) && $payment_setting['is_stripe_enabled']
                            == 'on'): ?>
                            <?php if(isset($payment_setting['stripe_key']) &&
                            !empty($payment_setting['stripe_key']) &&
                            (isset($payment_setting['stripe_secret']) && !empty($payment_setting['stripe_secret']))): ?>
                            <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                                action="<?php echo e(route('invoice.pay.with.stripe')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span>
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span> <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                        </div>
                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-amount text-danger text-xs"
                                            role="alert"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-12 form-group mt-3 text-right">
                                        <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                            class="btn btn-sm btn-primary rounded-pill">
                                    </div>
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="paypal-payment" role="tabpanel" aria-labelledby="paypal-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_paypal_enabled']) && $payment_setting['is_paypal_enabled']
                            == 'on'): ?>
                            <?php if(isset($payment_setting['paypal_client_id']) &&
                            !empty($payment_setting['paypal_client_id']) &&
                            (isset($payment_setting['paypal_secret_key']) &&
                            !empty($payment_setting['paypal_secret_key']))): ?>
                            <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                                action="<?php echo e(route('client.pay.with.paypal', $invoice->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        </div>
                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-amount text-danger text-xs"
                                            role="alert"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-12 form-group mt-3 text-right">
                                        <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                            class="btn btn-sm btn-primary rounded-pill">
                                    </div>
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="paystack-payment" role="tabpanel"
                        aria-labelledby="paystack-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_paystack_enabled']) &&
                            $payment_setting['is_paystack_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['paystack_public_key']) &&
                            !empty($payment_setting['paystack_public_key']) &&
                            (isset($payment_setting['paystack_secret_key']) &&
                            !empty($payment_setting['paystack_secret_key']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.paystack')); ?>"
                                class="require-validation" id="paystack-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="Email" class="form-control-label"><?php echo e(__('Email')); ?></label>
                                        <span class="fa fa-envelope"></span>
                                        <div class="form-icon-addon">
                                            <!-- <span class="fa fa-envelope"></span> -->
                                            <input class="form-control" required="required" id="paystack_email"
                                                name="email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="button" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill" id="pay_with_paystack">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="flutterwave-payment" role="tabpanel"
                        aria-labelledby="flutterwave-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_flutterwave_enabled']) &&
                            $payment_setting['is_flutterwave_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['flutterwave_secret_key']) &&
                            !empty($payment_setting['flutterwave_secret_key']) &&
                            (isset($payment_setting['flutterwave_public_key']) &&
                            !empty($payment_setting['flutterwave_public_key']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.flaterwave')); ?>"
                                class="require-validation" id="flaterwave-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="button" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill" id="pay_with_flaterwave">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="razorpay-payment" role="tabpanel"
                        aria-labelledby="razorpay-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_razorpay_enabled']) &&
                            $payment_setting['is_razorpay_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['razorpay_public_key']) &&
                            !empty($payment_setting['razorpay_public_key']) &&
                            (isset($payment_setting['razorpay_secret_key']) &&
                            !empty($payment_setting['razorpay_secret_key']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.razorpay')); ?>"
                                class="require-validation" id="razorpay-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="Email" class="form-control-label"><?php echo e(__('Email')); ?></label>
                                        <span class="fa fa-envelope"></span>
                                        <div class="form-icon-addon">
                                            <!-- <span class="fa fa-envelope"></span> -->
                                            <input class="form-control" required="required" id="razorpay_email"
                                                name="email" type="email" placeholder="Enter Email"
                                                value="company@wxample.com">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="button" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill" id="pay_with_razorpay">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="mollie-payment" role="tabpanel" aria-labelledby="mollie-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_mollie_enabled']) && $payment_setting['is_mollie_enabled']
                            == 'on'): ?>
                            <?php if(isset($payment_setting['mollie_api_key']) &&
                            !empty($payment_setting['mollie_api_key']) &&
                            (isset($payment_setting['mollie_profile_id']) &&
                            !empty($payment_setting['mollie_profile_id']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.mollie')); ?>"
                                class="require-validation" id="mollie-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="mercado-payment" role="tabpanel"
                        aria-labelledby="mercado-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_mercado_enabled']) && $payment_setting['is_mercado_enabled']
                            == 'on'): ?>
                            <?php if(isset($payment_setting['mercado_access_token']) &&
                            !empty($payment_setting['mercado_access_token'])): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.mercado')); ?>"
                                class="require-validation" id="mercado-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="paytm-payment" role="tabpanel" aria-labelledby="paytm-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_paytm_enabled']) && $payment_setting['is_paytm_enabled'] ==
                            'on'): ?>
                            <?php if(isset($payment_setting['paytm_merchant_id']) &&
                            !empty($payment_setting['paytm_merchant_id']) &&
                            (isset($payment_setting['paytm_merchant_key']) &&
                            !empty($payment_setting['paytm_merchant_key']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.paytm')); ?>"
                                class="require-validation" id="paytm-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">

                                        <label for="Email" class="form-control-label"><?php echo e(__('Email')); ?></label>
                                        <span class="fa fa-envelope"></span>
                                        <div class="form-icon-addon">
                                            <!-- <span class="fa fa-envelope"></span> -->
                                            <input class="form-control" required="required" id="paytm_email"
                                                name="email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="mobile"
                                            class="form-control-label text-dark"><?php echo e(__('Mobile Number')); ?></label>
                                        <span class="fa fa-phone"></span>
                                        <div class="form-icon-addon">
                                            <!-- <span class="fa fa-phone"></span> -->
                                            <input type="text" id="mobile" name="mobile" class="form-control mobile"
                                                data-from="mobile" placeholder="<?php echo e(__('Enter Mobile Number')); ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">

                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="skrill-payment" role="tabpanel" aria-labelledby="skrill-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_skrill_enabled']) && $payment_setting['is_skrill_enabled']
                            == 'on'): ?>
                            <?php if(isset($payment_setting['skrill_email']) && !empty($payment_setting['skrill_email'])): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.skrill')); ?>"
                                class="require-validation" id="skrill-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-6">

                                        <label for="Name" class="form-control-label"><?php echo e(__('Name')); ?></label>
                                        <span class="fa fa-user"></span>
                                        <div class="form-icon-addon">
                                            <!-- <span class="fa fa-user"></span> -->
                                            <input class="form-control" required="required" id="skrill_name" name="name"
                                                type="text" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label for="Email" class="form-control-label"><?php echo e(__('Email')); ?></label>
                                        <span class="fa fa-envelope"></span>
                                        <div class="form-icon-addon">
                                            <!-- <span class="fa fa-envelope"></span> -->
                                            <input class="form-control" required="required" id="skrill_email"
                                                name="email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="coingate-payment" role="tabpanel"
                        aria-labelledby="coingate-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_coingate_enabled']) &&
                            $payment_setting['is_coingate_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['coingate_auth_token']) &&
                            !empty($payment_setting['coingate_auth_token'])): ?>
                            <form method="post" action="<?php echo e(route('invoice.pay.with.coingate')); ?>"
                                class="require-validation" id="coingate-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="paymentwall-payment" role="tabpanel"
                        aria-labelledby="paymentwall-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_paymentwall_enabled']) &&
                            $payment_setting['is_paymentwall_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['paymentwall_public_key']) &&
                            !empty($payment_setting['paymentwall_public_key']) &&
                            (isset($payment_setting['paymentwall_private_key']) &&
                            !empty($payment_setting['paymentwall_private_key']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.paymentwallpayment')); ?>"
                                class="require-validation" id="paymentwall-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="toyyibpay-payment" role="tabpanel"
                        aria-labelledby="toyyibpay-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_toyyibpay_enabled']) &&
                            $payment_setting['is_toyyibpay_enabled'] == 'on'): ?>
                            <?php if(isset($payment_setting['toyyibpay_secret_key']) &&
                            !empty($payment_setting['toyyibpay_secret_key']) &&
                            (isset($payment_setting['category_code']) && !empty($payment_setting['category_code']))): ?>
                            <form method="post" action="<?php echo e(route('invoice.toyyibpaypayment')); ?>"
                                class="require-validation" id="toyyibpay-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                            <input type="hidden"
                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>"
                                                name="invoice_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="payfast-payment" role="tabpanel"
                        aria-labelledby="payfast-payment-tab">
                        <?php if(isset($payment_setting['is_payfast_enabled']) && $payment_setting['is_payfast_enabled'] ==
                        'on'): ?>
                        <?php if(isset($payment_setting['payfast_merchant_id']) &&
                        !empty($payment_setting['payfast_merchant_id']) &&
                        (isset($payment_setting['payfast_merchant_key']) &&
                        !empty($payment_setting['payfast_merchant_key']))): ?>
                        <?php
                        $pfHost = $payment_setting['payfast_mode'] == 'sandbox' ? 'sandbox.payfast.co.za' :
                        'www.payfast.co.za';

                        ?>
                        <form action=<?php echo e('https://' . $pfHost . '/eng/process'); ?> method="post"
                            class="require-validation" id="payfast-form">
                            
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-lable"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input type="number" class="form-control input_payfast" required min="0"
                                            name="amount" id="amount" value="<?php echo e($invoice->getDue()); ?>" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id"
                                            id="invoice_id">
                                    </div>
                                </div>
                            </div>
                            <div id="get-payfast-inputs"></div>
                            <div class="col-12 form-group mt-3 text-end">
                                <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                    class="btn btn-print-invoice btn-primary m-r-10" id="pay_with_payfast">
                            </div>
                        </form>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    
                    <div class="tab-pane fade" id="iyzipay-payment" role="tabpanel"
                        aria-labelledby="iyzipay-payment-tab">
                        <div class="card-body">
                            <?php if(isset($payment_setting['is_iyzipay_enabled']) && $payment_setting['is_iyzipay_enabled']
                            == 'on'): ?>
                            
                            <?php if(isset($payment_setting['iyzipay_public_key']) &&
                            !empty($payment_setting['iyzipay_public_key']) &&
                            (isset($payment_setting['iyzipay_secret_key']) &&
                            !empty($payment_setting['iyzipay_secret_key']))): ?>
                            <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                                action="<?php echo e(route('client.pay.with.iyzipay', $invoice->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span>
                                        <div class="form-icon-addon">
                                            <!-- <span><?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?></span> -->
                                            <input class="form-control" required="required" min="0" name="amount"
                                                type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                                max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        </div>
                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-amount text-danger text-xs"
                                            role="alert"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-12 form-group mt-3 text-right">
                                        <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                            class="btn btn-sm btn-primary rounded-pill">
                                    </div>
                                </div>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(
                    !empty($payment_setting) &&
                    ($payment_setting['is_sspay_enabled'] == 'on' &&
                    !empty($payment_setting['sspay_secret_key']) &&
                    !empty($payment_setting['sspay_category_code']))): ?>
                    <div class="tab-pane fade " id="sspay-payment" role="tabpanel" aria-labelledby="sspay-payment">
                        <form class="w3-container w3-display-middle w3-card-4" method="POST" id="sspay-payment-form"
                            action="<?php echo e(route('invoice.sspaypayment')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="invoice_id"
                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>">

                            <div class="form-group col-md-12">
                                <label for="amount"><?php echo e(__('Amount')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-prepend"><span
                                            class="input-group-text"><?php echo e(Utility::getValByName('site_currency')); ?></span></span>
                                    <input class="form-control" required="required" min="0" name="amount" type="number"
                                        value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                        max="<?php echo e($invoice->getDue()); ?>" id="amount">

                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input class="btn btn-sm btn-primary rounded-pill" id="pay_with_sspay" type="submit"
                                    value="<?php echo e(__('Make Payment')); ?>">
                            </div>

                        </form>
                    </div>
                    <?php endif; ?>

                    <!-- 
                    <?php if(isset($payment_setting['is_paytab_enabled']) && $payment_setting['is_paytab_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['paytab_profile_id']) &&
                    !empty($payment_setting['paytab_profile_id']) &&
                    (isset($payment_setting['paytab_server_key']) && !empty($payment_setting['paytab_server_key'])) &&
                    (isset($payment_setting['paytab_region']) && !empty($payment_setting['paytab_region']))): ?>
                    <div class="tab-pane fade" id="paytab-payment" role="tabpanel" aria-labelledby="paytab-payment">

                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('pay.with.benefit', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?> -->

                    <?php if(isset($payment_setting['is_paytab_enabled']) && $payment_setting['is_paytab_enabled'] == 'on'): ?>
                                <?php if(isset($payment_setting['paytab_profile_id']) &&
                                        !empty($payment_setting['paytab_profile_id']) &&
                                        (isset($payment_setting['paytab_server_key']) && !empty($payment_setting['paytab_server_key'])) &&
                                        (isset($payment_setting['paytab_region']) && !empty($payment_setting['paytab_region']))): ?>
                                    <div class="tab-pane fade" id="paytab-payment" role="tabpanel" aria-labelledby="paytab-payment">

                                        <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                            id="payment-form" action="<?php echo e(route('pay.with.paytab', $invoice->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="amount"
                                                        class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                                    <div class="input-group col-md-12">
                                                        <div class="input-group-text">
                                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                                        </div>
                                                        <input class="form-control" required="required" min="0"
                                                            name="amount" type="number"
                                                            value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                            step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                            id="amount">
                                                        <input type="hidden" value="<?php echo e($invoice->id); ?>"
                                                            name="invoice_id">
                                                    </div>
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-amount text-danger text-xs"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-12 form-group mt-3 text-right">
                                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                                        class="btn btn-sm btn-primary rounded-pill">
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                    

                    <?php if(isset($payment_setting['is_benefit_enabled']) && $payment_setting['is_benefit_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['benefit_api_key']) &&
                    !empty($payment_setting['benefit_api_key']) &&
                    (isset($payment_setting['benefit_secret_key']) && !empty($payment_setting['benefit_secret_key']))): ?>
                    <div class="tab-pane fade" id="benefit-payment" role="tabpanel" aria-labelledby="benefit-payment">

                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('pay.with.benefit', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(isset($payment_setting['is_cashfree_enabled']) && $payment_setting['is_cashfree_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['cashfree_api_key']) &&
                    !empty($payment_setting['cashfree_api_key']) &&
                    (isset($payment_setting['cashfree_secret_key']) && !empty($payment_setting['cashfree_secret_key']))): ?>
                    <div class="tab-pane fade" id="cashfree-payment" role="tabpanel" aria-labelledby="cashfree-payment">

                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('pay.with.cashfree', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(isset($payment_setting['is_aamarpay_enabled']) && $payment_setting['is_aamarpay_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['aamarpay_store_id']) &&
                    !empty($payment_setting['aamarpay_store_id']) &&
                    (isset($payment_setting['aamarpay_signature_key']) &&
                    !empty($payment_setting['aamarpay_signature_key'])) &&
                    (isset($payment_setting['aamarpay_description']) &&
                    !empty($payment_setting['aamarpay_description']))): ?>
                    <div class="tab-pane fade" id="aamarpay-payment" role="tabpanel" aria-labelledby="aamarpay-payment">

                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('pay.with.aamarpay', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(isset($payment_setting['is_paytr_enabled']) && $payment_setting['is_paytr_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['paytr_merchant_id']) &&
                    !empty($payment_setting['paytr_merchant_id']) &&
                    (isset($payment_setting['paytr_merchant_key']) && !empty($payment_setting['paytr_merchant_key'])) &&
                    (isset($payment_setting['paytr_merchant_salt']) && !empty($payment_setting['paytr_merchant_salt']))): ?>
                    <div class="tab-pane fade" id="paytr-payment" role="tabpanel" aria-labelledby="paytr-payment">

                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('pay.with.paytr', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(isset($payment_setting['is_yookassa_enabled']) && $payment_setting['is_yookassa_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['is_yookassa_enabled']) &&
                    !empty($payment_setting['is_yookassa_enabled']) &&
                    (isset($payment_setting['yookassa_shop_id']) && !empty($payment_setting['yookassa_shop_id'])) &&
                    (isset($payment_setting['yookassa_secret_key']) && !empty($payment_setting['yookassa_secret_key']))): ?>
                    <div class="tab-pane fade" id="yookassa-payment" role="tabpanel" aria-labelledby="yookassa-payment">

                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('invoice.with.yookassa', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(isset($payment_setting['is_midtrans_enabled']) && $payment_setting['is_midtrans_enabled'] ==
                    'on'): ?>
                    <?php if(isset($payment_setting['is_midtrans_enabled']) &&
                    !empty($payment_setting['is_midtrans_enabled']) &&
                    (isset($payment_setting['midtrans_secret']) && !empty($payment_setting['midtrans_secret']))): ?>
                    <div class="tab-pane fade" id="midtrans-payment" role="tabpanel" aria-labelledby="midtrans-payment">
                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('invoice.with.midtrans', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(isset($payment_setting['is_xendit_enabled']) && $payment_setting['is_xendit_enabled'] == 'on'): ?>
                    <?php if(isset($payment_setting['is_xendit_enabled']) &&
                    !empty($payment_setting['is_xendit_enabled']) &&
                    (isset($payment_setting['xendit_api_key']) && !empty($payment_setting['xendit_api_key'])) &&
                    (isset($payment_setting['xendit_token']) && !empty($payment_setting['xendit_token']))): ?>
                    <div class="tab-pane fade" id="xendit-payment" role="tabpanel" aria-labelledby="xendit-payment">
                        <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"
                            action="<?php echo e(route('invoice.with.xendit', $invoice->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                                    <div class="input-group col-md-12">
                                        <div class="input-group-text">
                                            <?php echo e(isset($payment_setting['currency_symbol']) ? $payment_setting['currency_symbol'] : '$'); ?>

                                        </div>
                                        <input class="form-control" required="required" min="0" name="amount"
                                            type="number" value="<?php echo e($invoice->getDue()); ?>" min="0" step="0.01"
                                            max="<?php echo e($invoice->getDue()); ?>" id="amount">
                                        <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                    </div>
                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-amount text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 form-group mt-3 text-right">
                                    <input type="submit" value="<?php echo e(__('Make Payment')); ?>"
                                        class="btn btn-sm btn-primary rounded-pill">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>



<?php if(
$invoice->getDue() > 0 &&
isset($payment_setting['is_payfast_enabled']) &&
$payment_setting['is_payfast_enabled'] == 'on'): ?>
<script>
$(".input_payfast").keyup(function() {

    var invoice_amount = $(this).val();
    //    alert(invoice_amount);
    get_payfast_status(invoice_amount);
});

$(document).ready(function() {
    get_payfast_status(amount = 0);

})

function get_payfast_status(amount) {
    var invoice_id = $('#invoice_id').val();
    var invoice_amount = amount;
    $.ajax({
        url: '<?php echo e(route('invoice-pay-with-payfast')); ?>',
        method: 'POST',
        data: {
            'invoice_id': invoice_id,
            'amount': invoice_amount,
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.success == true) {
                $('#get-payfast-inputs').append(data.inputs);
            } else {
                show_toastr('Error', data.inputs, 'error');
            }
        }
    });
}
</script>
<?php endif; ?>


<?php if(
$invoice->getDue() > 0 &&
isset($payment_setting['is_stripe_enabled']) &&
$payment_setting['is_stripe_enabled'] == 'on'): ?>
<?php $stripe_session = Session::get('stripe_session'); ?>
<?php if(isset($stripe_session) && $stripe_session): ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe('<?php echo e($payment_setting['
    stripe_key ']); ?>');
stripe.redirectToCheckout({
    sessionId: '<?php echo e($stripe_session->id); ?>',
}).then((result) => {
    console.log(result);
});
</script>
<?php endif ?>
<?php endif; ?>

<?php if(
$invoice->getDue() > 0 &&
isset($payment_setting['is_paystack_enabled']) &&
$payment_setting['is_paystack_enabled'] == 'on'): ?>
<script src="https://js.paystack.co/v1/inline.js"></script>

<script type="text/javascript">
$(document).on("click", "#pay_with_paystack", function() {

    $('#paystack-payment-form').ajaxForm(function(res) {
        if (res.flag == 1) {
            var coupon_id = res.coupon;

            var paystack_callback = "<?php echo e(url('/invoice-pay-with-paystack')); ?>";
            var order_id = '<?php echo e(time()); ?>';
            var handler = PaystackPop.setup({
                key: '<?php echo e($payment_setting['paystack_public_key']); ?>',
                email: res.email,
                amount: res.total_price * 100,
                currency: res.currency,
                ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                    1
                ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                metadata: {
                    custom_fields: [{
                        display_name: "Email",
                        variable_name: "email",
                        value: res.email,
                    }]
                },

                callback: function(response) {
                    console.log(response.reference, order_id);
                    window.location.href = "<?php echo e(url('/invoice/paystack')); ?>/" +
                        response.reference + "/<?php echo e(encrypt($invoice->id)); ?>";
                },
                onClose: function() {
                    alert('window closed');
                }
            });
            handler.openIframe();
        } else if (res.flag == 2) {

        } else {
            toastrs('Error', data.message, 'msg');
        }

    }).submit();
});
</script>
<?php endif; ?>

<?php if(
$invoice->getDue() > 0 &&
isset($payment_setting['is_flutterwave_enabled']) &&
$payment_setting['is_flutterwave_enabled'] == 'on'): ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
</script>

<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>

<script type="text/javascript">
//    Flaterwave Payment
$(document).on("click", "#pay_with_flaterwave", function() {

    $('#flaterwave-payment-form').ajaxForm(function(res) {
        if (res.flag == 1) {
            var coupon_id = res.coupon;
            var amount = res.total_price;
            var API_publicKey = '';
            if ("<?php echo e(isset($payment_setting['flutterwave_public_key'])); ?>") {
                API_publicKey = "<?php echo e($payment_setting['flutterwave_public_key']); ?>";
            }
            var nowTim = "<?php echo e(date('d-m-Y-h-i-a')); ?>";
            var flutter_callback = "<?php echo e(url('/invoice-pay-with-flaterwave')); ?>";
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: res.email,
                amount: res.total_price,
                currency: res.currency,
                txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                    'fluttpay_online-' + '<?php echo e(date('Y - m - d ')); ?>' + '?amount=' + amount,
                meta: [{
                    metaname: "payment_id",
                    metavalue: "id"
                }],
                onclose: function() {},
                callback: function(response) {
                    var txref = response.tx.txRef;
                    if (response.tx.chargeResponseCode == "00" || response.tx
                        .chargeResponseCode == "0") {
                        window.location.href = '<?php echo e(url('invoice / flaterwave ')); ?>' +'/' +'<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)); ?>' +'/' + txref;
                    } else {
                        // redirect to a failure page.
                    }
                    x.close(); // use this to close the modal immediately after payment.
                }
            });
        } else if (res.flag == 2) {

        } else {
            toastrs('Error', data.message, 'msg');
        }

    }).submit();
});
</script>
<?php endif; ?>

<?php if(
$invoice->getDue() > 0 &&
isset($payment_setting['is_razorpay_enabled']) &&
$payment_setting['is_razorpay_enabled'] == 'on'): ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script type="text/javascript">
// Razorpay Payment
$(document).on("click", "#pay_with_razorpay", function() {
    $('#razorpay-payment-form').ajaxForm(function(res) {

        if (res.flag == 1) {

            var razorPay_callback = "<?php echo e(url('/invoice-pay-with-razorpay')); ?>";
            var totalAmount = res.total_price * 100;
            var coupon_id = res.coupon;
            var API_publicKey = '';
            if ("<?php echo e(isset($payment_setting['razorpay_public_key'])); ?>") {
                API_publicKey = "<?php echo e($payment_setting['razorpay_public_key']); ?>";
            }
            var options = {
                "key": API_publicKey, // your Razorpay Key Id
                "amount": totalAmount,
                "name": 'Invoice Payment',
                "currency": res.currency,
                "description": "",
                "handler": function(response) {
                    window.location.href = "<?php echo e(url('/invoice/razorpay')); ?>/" + response
                        .razorpay_payment_id + "/<?php echo e(encrypt($invoice->id)); ?>";
                },
                "theme": {
                    "color": "#528FF0"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        } else if (res.flag == 2) {

        } else {
            //                                                                                                                             console.log(message);
            // toastrs('Error', data.message, 'msg');
        }
    }).submit();
});
</script>

<?php if(Session::has('success')): ?>
<script>
toastrs('<?php echo e(__('
    Success ')); ?>', '<?php echo session('
    success '); ?>', 'success');
</script>
<?php echo e(Session::forget('success')); ?>

<?php endif; ?>
<?php if(Session::has('error')): ?>
<script>
toastrs('<?php echo e(__('
    Error ')); ?>', '<?php echo session('
    error '); ?>', 'error');
</script>
<?php echo e(Session::forget('error')); ?>

<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
</script>
<?php endif; ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.invoicepayheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/invoice/invoicepay.blade.php ENDPATH**/ ?>