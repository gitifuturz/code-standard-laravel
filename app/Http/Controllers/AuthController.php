<?php

namespace Project\Http\Controllers;

use Illuminate\Http\Request;

use Project\Http\Requests;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login-signup');
    }


    public function register()
    {
        return view('auth.login-signup');
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }
}
