<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // log in process
    public function loginProcess(Request $request) {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $remember = $request->rememberMe ? true : false;
        if (Auth::attempt($validated, $remember)) {
            return redirect()->intended('student')->with('success', 'Login success!');
        } else {
            return redirect()->back()->with('error', 'Failed to login');
        }
    }
    // logout
    public function logoutProcess() {
        Auth::logout();
        return redirect()->route('login');
    }
}
