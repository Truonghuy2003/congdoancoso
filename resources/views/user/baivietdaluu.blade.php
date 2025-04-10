@extends('layouts.frontend')
@section('title', 'Hồ sơ khách hàng')
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
                        <a class="text-dark text-decoration-none" href="{{ route('user.home') }}">Khách hàng</a>
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
                        </div>
                    </div>
                </div>
                <div class="d-lg-block collapse" id="account-menu">
                    <div class="px-4 py-3">
                        <h3 class="fs-sm mb-0 text-muted">Quản lý</h3>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="border-bottom mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none " href="{{ route('user.baiviet') }}">
                                <i class="fas fa-newspaper me-2"></i> Bài đăng
                            </a>
                        </li>    
                        <li class="border-bottom mb-0">
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none active" href="{{ route('user.baiviet.luu') }}">
                                <i class="fas fa-bookmark me-2"></i> Bài viết đã lưu
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
                            <a class="nav-link-style d-flex align-items-center px-4 py-3 text-decoration-none" href="{{ route('user.hosocanhan') }}">
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
                <h6 class="fs-base text-dark mb-0">Danh sách bài viết đã lưu:</h6>
            </div>
            @if ($baiviet->count() > 0)
                <table class="table table-bordered table-hover table-sm mb-0">
                    <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th width="30%">Tiêu đề</th>
                            <th width="30%">Tóm tắt</th>
                            <th width="10%">Lượt xem</th>
                            <th width="15%">Ngày đăng</th>
                            <th width="10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($baiviet as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->tieude }}</td>
                            <td>{{ Str::limit($value->tomtat, 90) }}</td>
                            <td class="text-center">{{ $value->luotxem }}</td>
                            <td>{{ $value->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chudes->first()->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                                <form action="{{ route('user.baiviet.boluulai', $value->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger mt-2 " onclick="return confirm('Bạn có chắc chắn muốn bỏ lưu bài viết này?');">
                                        <i class="fas fa-times"></i> <!-- Đổi biểu tượng X để bỏ lưu -->
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Bạn chưa lưu bài viết nào.</p>
            @endif
        </section>
        
    </div>
</div>
@endsection