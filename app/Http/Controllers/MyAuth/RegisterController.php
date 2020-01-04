<?php

namespace App\Http\Controllers\Myauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // LINK REDIRECT
    protected $redirectTo = '/user/dashboard';

    // GUARD NAME
    protected $guard = 'web';

    public function __construct() {
        $this->middleware('myguest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'i_name' => ['required', 'string', 'max:255'],
            'i_notelp' => ['required', 'string', 'max:16'],
            'i_username' => ['required', 'string', 'max:255', 'unique:users'],
            'i_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]); 
    }

    protected function create(array $data)
    {
        return Users::create(

        );
    }
}