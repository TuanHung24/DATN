<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        // Lấy vai trò của người dùng hiện tại
        $userRole = Auth::user()->roles;

        // Kiểm tra xem vai trò của người dùng có trong danh sách cho phép không
        if (!in_array($userRole, $roles)) {
            // Nếu không có quyền, bạn có thể chuyển hướng hoặc trả về trang lỗi
            return abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
