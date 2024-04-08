<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\Utility;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        try {
            return view('auth.register');
        } catch(Exception $e) {
            return abort('404', 'Page Not Found');
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function generateReferralCode()
    {
        $referralCode = random_int(100000, 999999); // Generate a random integer between 100000 and 999999 (inclusive)

        // Check if the generated referral code already exists in the database
        while (User::where('referral_code', $referralCode)->exists()) {
            $referralCode = random_int(100000, 999999); // Generate new referral code until unique
        }

        return $referralCode;
    }

    public function store(Request $request)
    {
        $referralCode = $this->generateReferralCode();

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required',
            // 'password_confirmation' =>  'required',
        ]);

        $default_language = Utility::getValByName('default_language');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'company',
            'lang' => !empty($default_language) ? $default_language : 'en',
            'plan' => Plan::first()->id,
            'created_by' => 1,
            'referral_code' => $referralCode,
            'used_referral_code' => $request->used_referral_code,
        ]);
        $user->email_verified_at = date("H:i:s");
        $user->save();
        // Auth::login($user);
        $user->userDefaultData();

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
