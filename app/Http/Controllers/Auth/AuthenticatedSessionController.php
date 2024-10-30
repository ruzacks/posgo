<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\User;
use App\Models\Vendor;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    /*protected function authenticated(Request $request, $user)
    {
        if($user->delete_status == 1)
        {
            auth()->logout();
        }

        return redirect('/check');
    }*/

    public function store(LoginRequest $request)
    {
        if (env('RECAPTCHA_MODULE') == 'yes') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();


        if ($user->user_status == 0) {
            auth()->logout();
            if ($user->user_status == 0) {
                Session::flash('message', 'Your Account has been Deactivated. Please contact your Administrator.!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            Session::flash('message', 'Success message !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        }

        if (\Auth::user()->isOwner()) {
            $plan = plan::find($user->plan_id);

            if ($plan) {
                if ($plan->duration != 'Unlimited') {
                    $datetime1 = $user->plan_expire_date;
                    $datetime2 = date('Y-m-d');



                    if (!empty($datetime1) && $datetime1 < $datetime2) {
                        $user->assignplan(1);

                        return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your plan expired limit is over, please upgrade your plan.'));
                    }
                }
            }
        }



        $email    = $request->has('email') ? $request->email : '';
        $password    = $request->has('password') ? $request->password : '';

        $user->last_login_at = date('Y-m-d H:i:s');
        $user->save();

        $user       = $user;


        if (Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 1, 'user_status' => 1])) {
            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();

            if ($user->isOwner()) {
                $free_plan = Plan::where('price', '=', '0.0')->first();
            }

            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('error', __('Your Account has been Deactivated. Please contact your Administrator.'));
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function showLoginForm($lang = '')
    {
        if ($lang == '') {
            $lang = env('DEFAULT_LANG') ?? 'id';
        }

        \App::setLocale($lang);

        return view('auth.login', compact('lang'));
    }

    public function showLinkRequestForm($lang = '')
    {
        if ($lang == '') {
            $lang = env('DEFAULT_LANG') ?? 'en';
        }

        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
