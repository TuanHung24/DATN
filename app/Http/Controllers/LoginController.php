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
        $remember = $rq->has('remember'); 
    
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            
            return redirect()->route('main');
        } else {
            return view('login')->with(['email' => 'Email hoặc mật khẩu không đúng.']);
        }
    }
    public function passWordReset(){
        return view('password-reset');
    }
    public function logOut(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    
}
