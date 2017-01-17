<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $currentUser;

    public function guestMiddleware()
    {
        $guard = $this->getGuard();

        return $guard ? ('guest:' . $guard) : 'guest';
    }

    public function authMiddleware()
    {
        $guard = $this->getGuard();

        return $guard ? ('auth:' . $guard) : 'auth';
    }

    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : config('auth.defaults.guard');
    }

    protected function response($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
