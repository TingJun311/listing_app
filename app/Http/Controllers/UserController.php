<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show register form
    public function create() {
        return view('users.register');
    }

    public function store(Request $request) {

        $formValue = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $formValue['password'] = bcrypt($formValue['password']);

        // Create user
        $user = User::create($formValue);
        auth()->login($user);

        return redirect('/')->with('message', "User created and logged in");
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', "You have been logged out");
    }

    public function login() {
        return view('users.login');
    }


    public function authenticate(Request $request) {
        $formValue = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        if (auth()->attempt($formValue)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Log in successfully');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
