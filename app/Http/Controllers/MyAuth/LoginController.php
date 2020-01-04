<?php

namespace App\Http\Controllers\MyAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    protected $redirectTo = '/user/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
