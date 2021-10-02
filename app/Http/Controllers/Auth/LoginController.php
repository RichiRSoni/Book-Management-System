<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);
    //     $remember_me = $request->has('remember') ? true : false;

    //     if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {

    //        // $user = auth()->user();

    //       //  return dd($user);
    //      $request->session()->regenerate();

    //      return redirectTo('/users/home');
    //     //->intended('/users/home');
    //     } else {
    //         return back()->withErrors([
    //             'email' => 'The provided credentials do not match our records.',
    //         ]);
    //     }

    //     // return $this->sendFailedLoginResponse($request, 'Some message here');
    // }

    protected function redirectTo()
    {
        if (Auth::check() && Auth::user()->user_type == 'user') {
            return '/users/home';
        } elseif (Auth::check() && Auth::user()->user_type == 'admin') {
            return '/admin/dashboard';
        } else {
          //  return 'user/about';
            Auth::logout();
            return route('login');
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
