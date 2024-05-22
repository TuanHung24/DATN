<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function Login(){
        return view('login');
    }
    public function hdLogin(Request $rq){

        
        $credentials = $rq->only('email', 'password');
    
        if (Auth::guard('web')->attempt($credentials)) {
            // Xác thực thành công
            return redirect()->route('main');
        } else {
            
            return view('login');
        }
    }
    public function passWordReset(){
        return view('password-reset');
    }
    public function logOut(){
        Auth::logout();
        return view('login');
    }
    
}
