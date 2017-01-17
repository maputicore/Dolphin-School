<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Common\SessionsController as BaseSessionsController;

class SessionsController extends BaseSessionsController
{
    protected $guard = 'teacher';
}
