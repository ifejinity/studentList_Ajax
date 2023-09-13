<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // log in process
    public function loginProcess(Request $request) {
        $validated = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remember = $request->rememberMe ? true : false;
        if($validated->fails()){
            return response()->json(['status'=>500, 'message'=>'Failed to login', 'errors' => $validated->errors()]);
        } else {
            $credentials = ['email'=>$request->email, 'password' => $request->password];
            if (Auth::attempt($credentials, $remember)) {
                return response()->json(['status'=>200, 'message'=>'Login success']);
            } else {
                return response()->json(['status'=> 500, 'message'=>'Failed to login']);
            }
        }
    }
    // logout
    public function logoutProcess() {
        Auth::logout();
        return redirect()->route('login');
    }
}
