<?php

namespace App\Http\Controllers\Common\Auth;

use App\Models\Student;
use App\Models\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
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
            'description' => 'Write something',
            // 'avatar' => $user->getAvatar(),
            // 'token' => $user->getToken(),
            'password' => 'Set the password',
        ];
        if (url('/') == "http://teacher.jumping-dolphin.local/") {
            if ($teacher = Teacher::where('google_id', [$data['google_id']])->first()) {
                $this->auth->guard('teacher')->loginUsingId($teacher->id);
                return redirect()->to('/');
            } else {
                $this->auth->guard('teacher')->login(Teacher::create($data));
                return redirect()->to('/settings/profile');
            }
        } else {
            if ($student = Student::where('google_id', [$data['google_id']])->first()) {
                $this->auth->guard('student')->loginUsingId($student->id);
                return redirect()->to('/');
            } else {
                $this->auth->guard('student')->login(Student::create($data));
                return redirect()->to('/settings/profile');
            }
        }
    }
}
