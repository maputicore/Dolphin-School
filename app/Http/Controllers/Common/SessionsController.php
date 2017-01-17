<?php

namespace App\Http\Controllers\Common;

use App;
// use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Factory as Auth;

abstract class SessionsController extends Controller
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'index']]);
        $this->auth = $auth;
    }

    public function index()
    {
        $auth = ['loggedIn' => false];
        // $language = [];
        if ($this->auth->guard($this->getGuard())->check()) {
            $auth['user'] = $this->auth->guard($this->getGuard())->user()->toArray();
            $auth['loggedIn'] = true;

            // if ($auth['user']['is_active'] === false) {
                $this->logout();
                return $this->response(['error' => trans('auth.deactived')], 400);
            // }
        }

        return $this->response(['auth' => $auth]);
    }

    public function store(Request $request)
    {
        $this->validateLogin($request);
        $credentials = $this->getCredentials($request);

        if ($this->attemptLogin($request, $credentials)) {
            return $this->userWasAuthenticated();
        }

        return $this->responseToFailedLogin();
    }

    public function logout()
    {
        $this->auth->guard($this->getGuard())->logout();

        return redirect('/');
    }

    protected function attemptLogin(Request $request, $credentials)
    {
        return $this->auth->guard($this->getGuard())->attempt($credentials, true);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
    }

    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    protected function userWasAuthenticated()
    {
        $guard = $this->getGuard();
        $user = $this->auth->guard($guard)->user();
        if ($user->is_active) {
            return $this->response(['user' => $user->toArray()]);
        }

        $this->logout();
        return $this->response(['error' => trans('auth.deactived')], 400);
    }

    protected function responseToFailedLogin()
    {
        return $this->response(['error' => trans('auth.failed')], 400);
    }
}
