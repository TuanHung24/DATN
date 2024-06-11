<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Lấy thông tin người dùng hiện tại
            $user = Auth::user();

            // Kiểm tra trạng thái của người dùng
            if ($user->status === 0) {
                // Nếu trạng thái là 0, đăng xuất người dùng
                Auth::logout();

                // Điều hướng về trang đăng nhập và hiển thị thông báo lỗi
                return redirect()->route('login')->with('account_locked', true);
            }
        }
        return $next($request);
    }
}
