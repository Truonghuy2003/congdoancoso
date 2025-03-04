<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\ChuDeController;
use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\BinhLuanBaiVietController; 
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
// Trang chủ

Route::get('/', [HomeController::class, 'getHome'])->name('home');
Route::get('/home', [HomeController::class, 'getHome'])->name('home');
// Quản lý Tài khoản người dùng
Route::get('/nguoidung', [NguoiDungController::class, 'getDanhSach'])->name('nguoidung');
Route::get('/nguoidung/them', [NguoiDungController::class, 'getThem'])->name('nguoidung.them');
Route::post('/nguoidung/them', [NguoiDungController::class, 'postThem'])->name('nguoidung.them');
Route::get('/nguoidung/sua/{id}', [NguoiDungController::class, 'getSua'])->name('nguoidung.sua');
Route::post('/nguoidung/sua/{id}', [NguoiDungController::class, 'postSua'])->name('nguoidung.sua');
Route::get('/nguoidung/xoa/{id}', [NguoiDungController::class, 'getXoa'])->name('nguoidung.xoa');
// Quản lý Chủ đề
Route::get('/chude', [ChuDeController::class, 'getDanhSach'])->name('chude');
Route::get('/chude/them', [ChuDeController::class, 'getThem'])->name('chude.them');
Route::post('/chude/them', [ChuDeController::class, 'postThem'])->name('chude.them');
Route::get('/chude/sua/{id}', [ChuDeController::class, 'getSua'])->name('chude.sua');
Route::post('/chude/sua/{id}', [ChuDeController::class, 'postSua'])->name('chude.sua');
Route::get('/chude/xoa/{id}', [ChuDeController::class, 'getXoa'])->name('chude.xoa');
// Quản lý Bài viết
Route::get('/baiviet', [BaiVietController::class, 'getDanhSach'])->name('baiviet');
Route::get('/baiviet/them', [BaiVietController::class, 'getThem'])->name('baiviet.them');
Route::post('/baiviet/them', [BaiVietController::class, 'postThem'])->name('baiviet.them');
Route::get('/baiviet/sua/{id}', [BaiVietController::class, 'getSua'])->name('baiviet.sua');
Route::post('/baiviet/sua/{id}', [BaiVietController::class, 'postSua'])->name('baiviet.sua');
Route::get('/baiviet/xoa/{id}', [BaiVietController::class, 'getXoa'])->name('baiviet.xoa');
Route::get('/baiviet/kiemduyet/{id}', [BaiVietController::class, 'getKiemDuyet'])->name('baiviet.kiemduyet');
Route::get('/baiviet/kichhoat/{id}', [BaiVietController::class, 'getKichHoat'])->name('baiviet.kichhoat');
// Quản lý Bình luận bài viết
Route::get('/binhluanbaiviet', [BinhLuanBaiVietController::class, 'getDanhSach'])->name('binhluanbaiviet');
Route::get('/binhluanbaiviet/them', [BinhLuanBaiVietController::class, 'getThem'])->name('binhluanbaiviet.them');
Route::post('/binhluanbaiviet/them', [BinhLuanBaiVietController::class, 'postThem'])->name('binhluanbaiviet.them');
Route::get('/binhluanbaiviet/sua/{id}', [BinhLuanBaiVietController::class, 'getSua'])->name('binhluanbaiviet.sua');
Route::post('/binhluanbaiviet/sua/{id}', [BinhLuanBaiVietController::class, 'postSua'])->name('binhluanbaiviet.sua');
Route::get('/binhluanbaiviet/xoa/{id}', [BinhLuanBaiVietController::class, 'getXoa'])->name('binhluanbaiviet.xoa');
Route::get('/binhluanbaiviet/kiemduyet/{id}', [BinhLuanBaiVietController::class, 'getKiemDuyet'])->name('binhluanbaiviet.kiemduyet');
Route::get('/binhluanbaiviet/kichhoat/{id}', [BinhLuanBaiVietController::class, 'getKichHoat'])->name('binhluanbaiviet.kichhoat');

// Đăng nhập
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', function () {
    $credentials = request()->only('email', 'password');
    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();
        return redirect()->intended('home');
    }
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login');
// Đăng xuất
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('login');
})->name('logout'); // Add missing semicolon
// Đăng ký
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', function () {
    $credentials = request()->only('name', 'email', 'password');
    $credentials['password'] = bcrypt($credentials['password']);
    $user = App\Models\NguoiDung::create($credentials);
    Auth::login($user);
    return redirect('home');
})->name('register');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/home');
})->name('logout');





Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');