<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $currentTeacher;
    protected $currentStudent;
    protected $currentUser;

    public function __construct(Auth $auth)
    {
        $this->middleware(function ($request, $next) use ($auth) {
            $this->currentTeacher = $auth->guard('teacher')->user();
            $this->currentStudent = $auth->guard('student')->user();
            $this->currentUser = $this->currentStudent ?: $this->currentTeacher;
            return $next($request);
        });
    }



}
