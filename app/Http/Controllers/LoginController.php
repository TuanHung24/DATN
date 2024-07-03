<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function Login()
    {
        return view('login');
    }

    public function hdLogin(Request $rq)
    {
        try {
            $credentials = $rq->only('email', 'password',);

            $remember = $rq->has('remember');

            if (Auth::guard('web')->attempt($credentials, $remember)) {
                if (Auth::user()->roles === 1) {
                    return redirect()->route('statistical');
                } else if (Auth::user()->roles === 3) {
                    return redirect()->route('warehouse.list');
                } else {
                    return redirect()->route('invoice.list');
                }
            } else {
                return back()->withInput()->with(['Error' => 'Email hoặc mật khẩu không đúng.']);
            }
        } catch (Exception $e) {
            return back()->withInput()->with(['Error' => 'Đăng nhập không thành công!']);
        }
    }
    public function passWordReset()
    {
        return view('password-reset');
    }
    public function hdPasswordReset(Request $request)
    {
        try {


            $request->validate([
                'email' => 'required|exists:admin,email'
            ], [
                'email.required' => "Vui lòng nhập email hợp lệ!",
                'email.exists' => "Email này không tồn tại!",
            ]);


            $newPassword = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);


            $token = strtoupper(Str::random(20));
            $admin = Admin::where('email', $request->email)->first();
            $admin->update([
                'token' => $token,
                'password' => Hash::make($newPassword)
            ]);


            Mail::send('email', ['admin' => $admin, 'newPassword' => $newPassword], function ($email) use ($admin) {
                $email->subject('HK PHONE - Lấy lại mật khẩu tài khoản');
                $email->to($admin->email, $admin->name);
            });

            return redirect()->route('login')->with('Success', 'Vui lòng check email để nhận mật khẩu mới!');
        } catch (Exception $e) {
            return back()->with(['Error' => 'Lỗi gửi email thất bại!']);
        }
    }
    public function logOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
