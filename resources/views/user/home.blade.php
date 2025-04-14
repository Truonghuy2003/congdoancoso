@extends('layouts.frontend')
@section('title', 'Hồ sơ cá nhân')
@section('content')
<div class="page-title-overlap bg-body-secondary pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item ">
                        <a class="text-nowrap text-dark text-decoration-none" href="{{ route('frontend.home') }}">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap ">
                        <a class="text-dark text-decoration-none" href="{{ route('user.home') }}">Khách</a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active text-dark" aria-current="page">Hồ sơ</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-dark fw-bold">Hồ sơ cá nhân</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
            <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
                <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
                    <div class="d-md-flex align-items-center">
                        <div class="img-thumbnail rounded-circle flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width:6.375rem;">
                            <img class="rounded" src="{{ asset('storage/avatars/' . ($nguoidung->avatar ?? 'default_avatar.jpg')) }}" width="90" />
                        </div>
                        <div class="ps-md-3">
                            <h3 class="fs-base mb-0">{{ $nguoidung->name }}</h3>
                            <span class="text-accent fs-sm">{{ $nguoidung->email }}</span>
                            <div>
                                <span class="badge 
                                    @if($nguoidung->role == 'admin') bg-danger 
                                    @elseif($nguoidung->role == 'giaovien') bg-primary 
                                    @else bg-secondary text-white @endif fs-xs">
                                    Vai trò: {{ ucfirst($nguoidung->role) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-lg-block collapse" id="account-menu">
                    <div class="px-4 py-3">
                        <h3 class="fs-sm mb-0 text-muted">Quản lý</h3>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="border-bottom mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none" href="{{ route('user.baiviet') }}">
                                <i class="fas fa-newspaper me-2"></i> Bài đăng
                            </a>
                        </li>
                        <li class="border-bottom mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none" href="{{ route('user.baiviet.luu') }}">
                                <i class="fas fa-bookmark me-2"></i> Bài viết đã lưu
                            </a>
                        </li> 
                        <li class="border-bottom mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none" href="{{ route('user.binhluan') }}">
                                <i class="fas fa-comment me-2"></i> Bình luận
                            </a>
                        </li>         
                        <li class="d-lg-none border-top mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="d-lg-block collapse" id="account-menu">
                    <div class="px-4 py-3">
                        <h3 class="fs-sm mb-0 text-muted">Thiết lập tài khoản</h3>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="border-bottom mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 active text-decoration-none" href="{{ route('user.hosocanhan') }}">
                                <i class="fas fa-user me-2"></i> Hồ sơ cá nhân
                            </a>
                        </li>      
                        <li class="d-lg-none border-top mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <section class="col-lg-8">
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                <h5 class="text-dark mb-0">Cập nhật chi tiết hồ sơ của bạn:</h5>
                <a class="btn btn-primary btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                </a>
            </div>
            <form action="{{ route('user.hosocanhan') }}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="bg-body-secondary rounded-3 p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img class="rounded" src="{{ asset('storage/avatars/' . ($nguoidung->avatar ?? 'default_avatar.jpg')) }}" width="90" />
                            <div class="ps-3">
                                <input type="file" name="avatar" class="form-control mb-2" accept="image/*">
                                <button class="btn btn-light btn-shadow btn-sm" type="submit">
                                    <i class="fas fa-image"></i> Đổi ảnh đại diện
                                </button>
                            </div>
                        </div>
                        @if($nguoidung->role === 'admin')
                            <a href="{{ route('admin.home') }}" class="btn btn-danger btn-sm">
                                <i class="fas fa-user-shield me-2"></i>Trang quản trị
                            </a>
                        @elseif($nguoidung->role === 'giaovien')
                            <a href="{{ route('admin.home') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Trang giáo viên
                            </a>
                        @endif
                    </div>
                </div>         
                <div class="row gx-4 gy-3 bg-white rounded-3 p-4">
                    <div class="col-sm-6">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" name="name" value="{{ $nguoidung->name }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $nguoidung->email }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="password" placeholder="Để trống nếu không thay đổi">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Để trống nếu không thay đổi">
                    </div>
                    <div class="col-12">
                        <hr class="mt-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="subscribe" checked>
                                <label class="form-check-label" for="subscribe">Đăng ký nhận thông báo</label>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save me-2"></i> Cập nhật hồ sơ
                            </button>
                        </div>
                    </div>
                </div>
            </form>            
        </section>
    </div>
</div>
@endsection