<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng không phải là admin thì chặn lại
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'giaovien'])) {
            return redirect()->route('frontend.home')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
        }

        return $next($request);
    }
}
