<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RestrictGiaoVienFromNguoiDung
{
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu người dùng có role "giaovien", chặn truy cập
        if (Auth::check() && Auth::user()->role === 'giaovien') {
            return redirect()->route('giaovien.home')->with('error', 'Bạn không có quyền truy cập vào phần quản lý người dùng.');
        }

        return $next($request);
    }
}