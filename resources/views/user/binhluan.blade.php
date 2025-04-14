@extends('layouts.frontend')
@section('title', 'Bình luận của tôi')
@section('content')
<div class="page-title-overlap bg-body-secondary pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item">
                        <a class="text-nowrap text-dark text-decoration-none" href="{{ route('frontend.home') }}">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap">
                        <a class="text-dark text-decoration-none" href="{{ route('user.home') }}">Khách</a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active text-dark" aria-current="page">Bình luận</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-dark fw-bold">Bình luận của tôi</h1>
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
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none active" href="{{ route('user.binhluan') }}">
                                <i class="fas fa-comment me-2"></i> Bình luận
                            </a>
                        </li>
                        <li class="d-lg-none border-top mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('user.dangxuat') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('user.dangxuat') }}" method="post" class="d-none">
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
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none" href="{{ route('user.hosocanhan') }}">
                                <i class="fas fa-user me-2"></i> Hồ sơ cá nhân
                            </a>
                        </li>
                        <li class="d-lg-none border-top mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('user.dangxuat') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('user.dangxuat') }}" method="post" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <section class="col-lg-8">
            <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                <h5 class="text-dark mb-0">Danh sách bình luận của bạn:</h5>
            </div>
            @if ($binhluans->count() > 0)
                <table class="table table-bordered table-hover table-sm mb-0">
                    <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th width="30%">Nội dung bình luận</th>
                            <th width="30%">Bài viết</th>
                            <th width="15%">Ngày bình luận</th>
                            <th width="10%">Trạng thái</th>
                            <th width="10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($binhluans as $key => $binhluan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::limit($binhluan->noidungbinhluan, 100) }}</td>
                            <td>
                                <a class="text-decoration-none" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $binhluan->baiviet->chudes->first()->tenchude_slug, 'tieude_slug' => $binhluan->baiviet->tieude_slug]) }}">
                                    {{ $binhluan->baiviet->tieude }}
                                </a>
                            </td>
                            <td>{{ $binhluan->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($binhluan->kiemduyet == 0)
                                    <span class="badge bg-warning">Chờ duyệt</span>
                                @elseif ($binhluan->kiemduyet == 1 && $binhluan->kichhoat == 1)
                                    <span class="badge bg-success">Đã duyệt</span>
                                @elseif ($binhluan->kichhoat == 0 && $binhluan->kiemduyet == 1)
                                    <span class="badge bg-secondary text-white">Bị ẩn</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $binhluan->baiviet->chudes->first()->tenchude_slug, 'tieude_slug' => $binhluan->baiviet->tieude_slug]) }}" 
                                   class="btn btn-sm btn-primary">Xem bài</a>
                                @if ($binhluan->nguoidung_id == Auth::id())
                                    <form action="{{ route('user.binhluan.xoa', $binhluan->id) }}" method="post" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger ms-1">Xóa</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Bạn chưa có bình luận nào.</p>
            @endif
        </section>
    </div>
</div>
@endsection