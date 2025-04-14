<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\ChuDeController;
use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\BinhLuanBaiVietController; 
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KhachController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\BanChapHanhController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

// Đăng ký, đăng nhập, Quên mật khẩu
Auth::routes();
// Google OAuth
Route::get('/login/google', [HomeController::class, 'getGoogleLogin'])->name('google.login');
Route::get('/login/google/callback', [HomeController::class, 'getGoogleCallback'])->name('google.callback');

// Route tải tệp (thêm ở đây để tất cả người dùng đều truy cập được)
Route::get('/tai-tep/{id}', [App\Http\Controllers\BaiVietController::class, 'taiTep'])->name('tai-tep');

// Các trang dành cho khách chưa đăng nhập
Route::name('frontend.')->group(function () {
    // Trang chủ
    Route::get('/', [HomeController::class, 'getHome'])->name('home');
    Route::get('/home', [HomeController::class, 'getHome'])->name('home');
    Route::get('/timkiem', [HomeController::class, 'getTimKiem'])->name('timkiem');

    // Tin tức
    Route::get('/bai-viet', [HomeController::class, 'getBaiViet'])->name('baiviet');
    Route::get('/bai-viet/{tenchude_slug}', [HomeController::class, 'getBaiViet'])->name('baiviet.chude');
    Route::get('/bai-viet/{tenchude_slug}/{tieude_slug}', [HomeController::class, 'getBaiViet_ChiTiet'])->name('baiviet.chitiet');

    Route::get('/ban-chap-hanh', [HomeController::class, 'getBanChapHanh'])->name('banchaphanh');

    // Liên hệ
    Route::get('/lien-he', [HomeController::class, 'getLienHe'])->name('lienhe');
});

// Trang khách 
Route::get('/khach/dang-ky', [HomeController::class, 'getDangKy'])->name('user.dangky');
Route::get('/khach/dang-nhap', [HomeController::class, 'getDangNhap'])->name('user.dangnhap');
// Trang tài khoản khách đã đăng nhập
Route::prefix('khach')->name('user.')->middleware('auth')->group(function () {
    // Trang chủ
    Route::get('/', [KhachController::class, 'getHome'])->name('home');
    Route::get('/home', [KhachController::class, 'getHome'])->name('home');
    // Cập nhật thông tin tài khoản
    Route::get('/ho-so-ca-nhan', [KhachController::class, 'getHoSoCaNhan'])->name('hosocanhan');
    Route::post('/ho-so-ca-nhan', [KhachController::class, 'postHoSoCaNhan'])->name('hosocanhan');

    // Bình luận bài viết
    Route::get('/binh-luan', [KhachController::class, 'getBinhLuanBaiViet'])->name('binhluan');
    Route::post('/bai-viet/{baiviet_id}/binh-luan', [KhachController::class, 'postBinhLuanBaiViet'])->name('baiviet.binhluan');
    Route::delete('/binh-luan/{id}', [KhachController::class, 'deleteBinhLuan'])->name('binhluan.xoa');
    // Lưu bài viết
    Route::post('/baiviet/luu', [BaiVietController::class, 'luuBaiViet'])->name('baiviet.luu')->middleware('auth');

    // Xem bài viết đã đăng
    Route::get('/bai-viet', [KhachController::class, 'postBaiViet'])->name('baiviet');
    // Xem bài viết đã lưu
    Route::get('/baiviet/luu', [BaivietController::class, 'baivietDaLuu'])->name('baiviet.luu');
    // Bỏ lưu bài viết
    Route::delete('/baiviet/boluu/{id}', [BaiVietController::class, 'boLuuBaiViet'])->name('baiviet.boluulai');

    // Đăng xuất
    Route::post('/dang-xuat', [KhachController::class, 'postDangXuat'])->name('dangxuat');
});

// Trang tài khoản quản lý Admin (quản lý tất cả)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Trang chủ
    Route::get('/', [AdminController::class, 'getHome'])->name('home');
    Route::get('/home', [AdminController::class, 'getHome'])->name('home');

    // Quản lý Tài khoản người dùng (chỉ admin được truy cập)
    Route::prefix('nguoidung')->middleware('restrict.giaovien.nguoidung')->group(function () {
        Route::get('/', [NguoiDungController::class, 'getDanhSach'])->name('nguoidung');
        Route::get('/them', [NguoiDungController::class, 'getThem'])->name('nguoidung.them');
        Route::post('/them', [NguoiDungController::class, 'postThem'])->name('nguoidung.them');
        Route::get('/sua/{id}', [NguoiDungController::class, 'getSua'])->name('nguoidung.sua');
        Route::post('/sua/{id}', [NguoiDungController::class, 'postSua'])->name('nguoidung.sua');
        Route::get('/xoa/{id}', [NguoiDungController::class, 'getXoa'])->name('nguoidung.xoa');

        // Quản lý Bình luận bài viết (chỉ admin được truy cập)
        Route::get('/binhluanbaiviet', [BinhLuanBaiVietController::class, 'getDanhSach'])->name('binhluanbaiviet');
        Route::get('/binhluanbaiviet/them', [BinhLuanBaiVietController::class, 'getThem'])->name('binhluanbaiviet.them');
        Route::post('/binhluanbaiviet/them', [BinhLuanBaiVietController::class, 'postThem'])->name('binhluanbaiviet.them');
        Route::get('/binhluanbaiviet/xoa/{id}', [BinhLuanBaiVietController::class, 'getXoa'])->name('binhluanbaiviet.xoa');
        Route::get('/binhluanbaiviet/kiemduyet/{id}', [BinhLuanBaiVietController::class, 'getKiemDuyet'])->name('binhluanbaiviet.kiemduyet');
        Route::get('/binhluanbaiviet/kichhoat/{id}', [BinhLuanBaiVietController::class, 'getKichHoat'])->name('binhluanbaiviet.kichhoat');
        Route::get('/binhluanbaiviet/autocomplete', [BinhLuanBaiVietController::class, 'autocomplete'])->name('binhluanbaiviet.autocomplete');

        // Route cho BanChapHanh
        Route::get('/banchaphanh', [BanChapHanhController::class, 'getDanhSach'])->name('banchaphanh');
        Route::get('/banchaphanh/them', [BanChapHanhController::class, 'getThem'])->name('banchaphanh.them');
        Route::post('/banchaphanh/them', [BanChapHanhController::class, 'postThem']);
        Route::get('/banchaphanh/sua/{id}', [BanChapHanhController::class, 'getSua'])->name('banchaphanh.sua');
        Route::post('/banchaphanh/sua/{id}', [BanChapHanhController::class, 'postSua']);
        Route::get('/banchaphanh/xoa/{id}', [BanChapHanhController::class, 'getXoa'])->name('banchaphanh.xoa');
    });

    // Quản lý Chủ đề (cả admin và giaovien đều được truy cập)
    Route::get('/chude', [ChuDeController::class, 'getDanhSach'])->name('chude');
    Route::get('/chude/them', [ChuDeController::class, 'getThem'])->name('chude.them');
    Route::post('/chude/them', [ChuDeController::class, 'postThem'])->name('chude.them');
    Route::get('/chude/sua/{id}', [ChuDeController::class, 'getSua'])->name('chude.sua');
    Route::post('/chude/sua/{id}', [ChuDeController::class, 'postSua'])->name('chude.sua');
    Route::get('/chude/xoa/{id}', [ChuDeController::class, 'getXoa'])->name('chude.xoa');

    // Quản lý Bài viết (cả admin và giaovien đều được truy cập)
    Route::get('/baiviet/danhsach', [BaiVietController::class, 'getDanhSach'])->name('baiviet.danhsach');
    Route::get('/baiviet', [BaiVietController::class, 'getDanhSach'])->name('baiviet');
    Route::get('/baiviet/them', [BaiVietController::class, 'getThem'])->name('baiviet.them');
    Route::post('/baiviet/them', [BaiVietController::class, 'postThem'])->name('baiviet.them');
    Route::get('/baiviet/sua/{id}', [BaiVietController::class, 'getSua'])->name('baiviet.sua');
    Route::post('/baiviet/sua/{id}', [BaiVietController::class, 'postSua'])->name('baiviet.sua');
    Route::get('/baiviet/xoa/{id}', [BaiVietController::class, 'getXoa'])->name('baiviet.xoa');
    Route::get('/baiviet/kiemduyet/{id}', [BaiVietController::class, 'getKiemDuyet'])->name('baiviet.kiemduyet');
    Route::get('/baiviet/kichhoat/{id}', [BaiVietController::class, 'getKichHoat'])->name('baiviet.kichhoat');

    // Quản lý file được cả gv sử dụng
    Route::get('/file', [FileController::class, 'getDanhSach'])->name('file');
    Route::get('/file/them', [FileController::class, 'getThem'])->name('file.them');
    Route::post('/file/them', [FileController::class, 'postThem'])->name('file.them');
    Route::get('/file/sua/{id}', [FileController::class, 'getSua'])->name('file.sua');
    Route::post('/file/sua/{id}', [FileController::class, 'postSua'])->name('file.sua');
    Route::get('/file/xoa/{id}', [FileController::class, 'getXoa'])->name('file.xoa');

    Route::get('/thongke', [AdminController::class, 'statistics'])->name('thongke');
});

// Trang tài khoản giáo viên
Route::prefix('giaovien')->name('giaovien.')->middleware(['auth', 'giaovien'])->group(function () {
    // Trang chủ
    Route::get('/', [AdminController::class, 'getHome'])->name('home');
    Route::get('/home', [AdminController::class, 'getHome'])->name('home');
});

// Gửi email từ form liên hệ mà không cần tạo controller
Route::post('/contact', function (Request $request) {
    $request->validate([
        'HoVaTen' => 'required',
        'Email' => 'required|email',
        'DienThoai' => 'required',
        'NoiDung' => 'required'
    ]);

    Mail::raw("Tin nhắn từ: {$request->HoVaTen}\nEmail: {$request->Email}\nSĐT: {$request->DienThoai}\nNội dung: {$request->NoiDung}", function ($message) use ($request) {
        $message->to('vanhuy382003@gmail.com')
            ->subject("Lời nhắn từ {$request->HoVaTen}");
    });

    return back()->with('success', 'Tin nhắn đã được gửi thành công!');
});