<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function loginAction(Request $request){
        $validated = $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;
 
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1, 'type' => 2, 'verified' => 1])) {
            return redirect('admin-panel');
        }else{
            return redirect()->back()->withErrors(['error' => 'Credentials Not Matched!']);
        }
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('admin-login');
    }
}
