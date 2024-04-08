<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function __construct()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }
    }

    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        Session()->put('crm_theme_setting', $user->dark_mode);
        setcookie('ThemeSetting', $user->dark_mode);
        if ($user != null) {
            $companyUser = User::where('id', $user->created_by)->first();
            $user = User::where('email', $request->email)->first();

            if ($user != null) {
                $companyUser = User::where('id', $user->created_by)->first();
            }

            if (($user != null && $user->is_enable_login == 0 || (isset($companyUser) && $companyUser != null) && $companyUser->is_enable_login == 0)  && $user->type != 'super admin') {
                return redirect()->back()->with('error', __('Your Account is disable from company.'));
            }

            $request->authenticate();
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->is_active == 0) {
                auth()->logout();
            }

            if ($user->is_active == 1) {
                $user->active_status = 1;
                // $user->save();
            }

            if ($user->type == 'company') {
                $free_plan = Plan::where('price', '=', '0.0')->first();
                $plan      = Plan::find($user->plan);

                if ($user->plan != $free_plan->id) {
                    if (date('Y-m-d') > $user->plan_expire_date && ucfirst($plan->duration) != 'Lifetime') {
                        $user->plan             = $free_plan->id;
                        $user->plan_expire_date = null;
                        $user->save();

                        $clients   = User::where('type', 'client')->where('created_by', '=', \Auth::user()->creatorId())->get();
                        $employees = User::where('type', 'employee')->where('created_by', '=', \Auth::user()->creatorId())->get();

                        if ($free_plan->max_client == -1) {
                            foreach ($clients as $client) {
                                $client->is_active = 1;
                                $client->save();
                            }
                        } else {
                            $clientCount = 0;
                            foreach ($clients as $client) {
                                $clientCount++;
                                if ($clientCount <= $free_plan->max_client) {
                                    $client->is_active = 1;
                                    $client->save();
                                } else {
                                    $client->is_active = 0;
                                    $client->save();
                                }
                            }
                        }


                        if ($free_plan->max_employee == -1) {
                            foreach ($employees as $employee) {
                                $employee->is_active = 1;
                                $employee->save();
                            }
                        } else {
                            $employeeCount = 0;
                            foreach ($employees as $employee) {
                                $employeeCount++;
                                if ($employeeCount <= $free_plan->max_employee) {
                                    $employee->is_active = 1;
                                    $employee->save();
                                } else {
                                    $employee->is_active = 0;
                                    $employee->save();
                                }
                            }
                        }
                        if ($user->trial_expire_date != null) {
                            if (Auth::user()->trial_expire_date > date('Y-m-d')) {
                                $user->assignPlan(1);

                                return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your Trial plan Expired.'));
                            }
                        }
                        return redirect()->route('dashboard')->with('error', 'Your plan expired limit is over, please upgrade your plan');
                    }
                }
            }

            // Update Last Login Time
            $user->update(
                [
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                ]
            );
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $usr = Auth::user();
        $usr->active_status = 0;
        $usr->save();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
//for user log
if (!function_exists('get_device_type')) {
    function get_device_type($user_agent)
    {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
        if (preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {
            if (preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }
        }
    }
}
