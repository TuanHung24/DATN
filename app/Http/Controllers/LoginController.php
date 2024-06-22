<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
    public function Login(){
        return view('login');
    }
   
    public function hdLogin(Request $rq){
        $credentials = $rq->only('email', 'password',);
        
        $remember = $rq->has('remember'); 
    
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            
            return redirect()->route('main');
        } else {
            return back()->withInput()->with(['Error' => 'Email hoặc mật khẩu không đúng.']);
        }
    }
    public function passWordReset(){
        return view('password-reset');
    }
    public function hdPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:admin,email'
        ], [
            'email.required' => "Vui lòng nhập email hợp lệ!",
            'email.exists' => "Email này không tồn tại!",
        ]);
    
        // Sinh password ngẫu nhiên gồm 6 chữ số
        $newPassword = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    
        // Cập nhật token và password mới vào database
        $token = strtoupper(Str::random(20));
        $admin = Admin::where('email', $request->email)->first();
        $admin->update([
            'token' => $token,
            'password' => bcrypt($newPassword) // Bạn có thể sử dụng bcrypt để mã hóa password
        ]);
    
        // Gửi email thông báo và password mới cho admin
        Mail::send('email', ['admin' => $admin, 'newPassword' => $newPassword], function ($email) use ($admin) {
            $email->subject('HK PHONE - Lấy lại mật khẩu tài khoản');
            $email->to($admin->email, $admin->name);
        });
    
        return redirect()->route('login')->with('Success', 'Vui lòng check email để nhận mật khẩu mới!');
    }
    public function logOut(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
}
