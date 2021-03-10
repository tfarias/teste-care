<?php

namespace LaravelMetronic\Http\Controllers\Auth;

use Illuminate\Http\Request;
use LaravelMetronic\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('sessao.login');
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        flash('E-mail ou senha incorretos.', 'danger');
        return redirect()->back()->withInput($request->only($this->username(), 'remember'));
    }

    /**
     * Get the auth username;
     * @return string
     */
    public function username()
    {
        return "email";
    }

    /**
     * Get the auth credentials;
     * @return array
     */
    public function credentials($request)
    {
        return [
            'email'      => $request->get('email'),
            'password' => $request->get('password'),
        ];
    }
}
