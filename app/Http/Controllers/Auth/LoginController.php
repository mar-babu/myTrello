<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Login Form
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    /**
     * Registration Form
     */
    public function showRegistrationForm()
    {
        return view('backend.auth.registration');
    }

}
