<?php

namespace App\Http\Controllers;

use App\AllStudent;
use App\LocalStudent;
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
        if (Auth::attempt($validated)) {
            // return redirect()->intended('student')->with(['allStudents' => $allStudent]);\
            return redirect()->route('student');
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
