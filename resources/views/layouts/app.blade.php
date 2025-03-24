<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CkEditor -->
    <script src="{{ asset('public/vendor/ckeditor5/ckeditor.js') }}"></script>
    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
</head>
<body>
    <style>
        /* Tùy chỉnh navbar */
        .navbar-nav .nav-item-custom {
            position: relative; /* Để định vị dấu | */
            margin-right: 10px; /* Khoảng cách giữa các mục */
        }
        /* Thêm dấu | sau mỗi mục, trừ mục cuối cùng */
        .navbar-nav .nav-item-custom:not(:last-child)::after {
            content: "|"; /* Dấu phân cách */
            position: absolute;
            right: -10px; /* Đặt dấu | ở bên phải */
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d; /* Màu của dấu | (có thể tùy chỉnh) */
            font-size: 1.2rem; /* Kích thước dấu | */
        }

        /* Tùy chỉnh liên kết */
        .navbar-nav .nav-item-custom .nav-link {
            padding: 8px 15px; /* Khoảng cách bên trong */
            border-radius: 5px; /* Bo góc */
            transition: all 0.3s ease; /* Hiệu ứng chuyển động mượt mà */
        }

        /* Hiệu ứng hover */
        .navbar-nav .nav-item-custom .nav-link:hover {
            background-color: #007bff; /* Màu nền khi hover (màu xanh Bootstrap) */
            color: #fff; /* Màu chữ khi hover */
            transform: scale(1.1); /* Phóng to 110% */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Thêm bóng */
        }
    </style>
    <!-- Đây là trang giao diện cho admin -->
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <i class=" fas fa-light fa-star"></i> {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'giaovien']))
                            <!-- Hiển thị liên kết "Chủ đề" -->
                            <li class="nav-item nav-item-custom">
                                <a class="nav-link" href="{{ route('admin.chude') }}">
                                    <i class="fas fa-th-list"></i> Chủ đề
                                </a>
                            </li>
                            <!-- Hiển thị liên kết "Bài viết" -->
                            <li class="nav-item nav-item-custom">
                                <a class="nav-link" href="{{ route('admin.baiviet') }}">
                                    <i class="fas fa-light fa-fw fa-newspaper"></i> Bài viết
                                </a>
                            </li>
                            <!-- Hiển thị liên kết "Bình luận bài viết" chỉ cho admin -->
                            @if(auth()->user()->role === 'admin')
                                <li class="nav-item nav-item-custom">
                                    <a class="nav-link" href="{{ route('admin.binhluanbaiviet') }}">
                                        <i class="fas fa-light fa-fw fa-comments"></i> Bình luận bài viết
                                    </a>
                                </li>
                            @endif
                            <!-- Chỉ hiển thị liên kết "Quản lý người dùng" cho admin -->
                            @if(auth()->user()->role === 'admin')
                                <li class="nav-item nav-item-custom">
                                    <a class="nav-link" href="{{ route('admin.nguoidung') }}">
                                        <i class="fas fa-users"></i> Quản lý người dùng
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                    <!-- Right side of Navbar -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fa-light fa-fw fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fa-light fa-fw fas fa-user-plus"></i> Đăng ký
                            </a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#nguoidung" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-light fa-fw fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa-light fa-fw fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pt-3">
            @yield('content')
        </main>

        <hr class="shadow-sm" />
        <footer>Bản quyền &copy; {{ date('Y') }} bởi {{ config('app.name', 'Laravel') }}.</footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('javascript')
</body>
</html>
