<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function loginProcess(Request $request) {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validated)) {
            // return redirect()->back()->with('success', 'Success to login');
            return redirect()->intended('student');
        } else {
            return redirect()->back()->with('error', 'Failed to login');
        }
    }
}