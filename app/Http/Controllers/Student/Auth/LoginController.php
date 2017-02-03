<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Factory as Auth;

class LoginController extends Controller
{
    protected $auth;

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct(Auth $auth)
    {
        // $this->middleware('guest', ['except' => 'logout']);
        $this->auth = $auth;
    }

    public function showLoginForm()
    {
        return view('student.auth.login');
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return $this->auth->guard('student');
    }
}
