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

    /**
     * Registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        session()->flash('success', 'Registration Successfull !');

        return redirect()->route('login');
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        // Validate Login Data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Attempt to login
        if (Auth::attempt($data)) {
            $user = User::where('email', request('email'))->first();
            Auth::login($user, true);
            session()->flash('success', 'Successfully Logged in !');

            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'Invalid email and password');

            return redirect()->back();
        }

    }

    /**
     * Logout
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }
}
