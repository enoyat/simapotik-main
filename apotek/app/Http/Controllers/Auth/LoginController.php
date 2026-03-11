<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
     
        $roles = Auth::user()->roles_id;
        Session::put('globalkdpst', Auth::user()->kdpst);
        switch ($roles) {
            case 10:
                //dd('masuk manajer');
                Session::put('email', Auth::user()->email);
                return route('manajer.home.index');
                break;
            case 1:
                //dd('masuk administrasi');
                Session::put('email', Auth::user()->email);
                return route('administrator.home.index');
                break;
            case 3:
                    Session::put('email', Auth::user()->email);
                    return route('operator.home.index');
                    break;
            default:
                return redirect()->route('login');
                break;
        }


    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
