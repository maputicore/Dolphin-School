<?php

namespace App\Http\Controllers\Common\Auth;

use App\Models\Teacher;
// use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Input;
// use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\Auth\Factory as Auth;
// use Laravel\Socialite\Two\InvalidStateException;

class SocialController extends Controller
{
    protected $redirectTo = '/';
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function handleProviderCallback($service)
    {
        $user = Socialite::driver($service)->user();

        $data = [
            'google_id' => $user->getId(),
            'email' => $user->getEmail(),
            // 'nick' => $user->getNickname(),
            'name' => $user->getName(),
            'description' => 'something',
            // 'avatar' => $user->getAvatar(),
            // 'token' => $user->getToken(),
            'password' => 'Google',
        ];

        $this->auth->guard('teacher')->login(Teacher::firstOrCreate($data));
        return redirect()->to('/');
    }
}
