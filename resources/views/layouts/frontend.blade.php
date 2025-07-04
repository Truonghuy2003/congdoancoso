<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />

    <!-- SEO Meta Tags -->
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#ffffff" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Trang chủ') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon and Touch Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/img/favicon-removebg.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/img/favicon-removebg.png') }}" />

    <!-- CSS -->
    <link rel="stylesheet" media="screen" href="{{ asset('public/vendor/simplebar/simplebar.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('public/vendor/tiny-slider/tiny-slider.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('public/vendor/nouislider/nouislider.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('public/vendor/drift-zoom/drift-basic.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('public/vendor/lightgallery/lightgallery-bundle.min.css') }}" />
    <link rel="stylesheet" media="screen" href="{{ asset('public/css/theme.css') }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        /* Tối ưu hóa header top */
        .header-top .contact-info {
            display: flex;
            flex-wrap: nowrap; /* Giữ nằm ngang trên mọi thiết bị */
            justify-content: flex-start; /* Căn trái trên desktop */
            align-items: center;
        }
        .header-top .contact-info span {
            margin-right: 1.5rem; /* Khoảng cách giữa các thông tin */
            font-size: 0.9rem; /* Kích thước chữ mặc định */
            white-space: nowrap; /* Không cho text xuống dòng */
        }
        /* Tối ưu hóa thanh tìm kiếm */
        .search-bar {
            position: relative;
            width: 100%;
            max-width: 500px; /* Chiều rộng tối đa trên desktop */
        }
        .search-bar input {
            padding-right: 40px; /* Đảm bảo không che icon tìm kiếm */
        }
        .search-bar button {
            cursor: pointer;
        }
        .hover-shadow { 
            transition: box-shadow 0.3s ease-in-out; 
        }
        .hover-shadow:hover { 
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2) !important; 
        }
        .card-body .badge-custom { 
            background-color: #2563eb; /* Base blue color */
            color: #ffffff; /* White text for contrast */
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            text-decoration: none;
            padding: 0.4em 0.8em;
            border-radius: 0.25rem;
        }
        .card-body .badge-custom:hover { 
            background-color: #1e40af !important; /* Darker blue on hover */
            transform: scale(1.05); /* Slight scale effect */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important; /* Subtle shadow */
            color: #ffffff !important; /* Ensure text stays white */
        }
        /* Tối ưu hóa navbar trên desktop */
        @media (min-width: 992px) {
            .search-bar {
                max-width: 750px; /* Chiều rộng tối đa trên desktop */
                margin: 0 20px; /* Thêm khoảng cách hai bên */
            }
            .navbar-brand img {
                max-width: 300px;
            }
            .navbar-toolbar {
                margin-left: auto; /* Đẩy các nút sang bên phải */
            }
        }
        /* Tối ưu hóa trên thiết bị di động */
        @media (max-width: 991px) {
            .search-bar {
                display: none; /* Ẩn thanh tìm kiếm mặc định trên mobile */
            }
            .navbar-brand img {
                max-width: 74px; /* Logo nhỏ trên mobile */
            }
            .navbar-toolbar {
                margin-left: auto; /* Đẩy các nút sang bên phải */
            }
            .btn.d-lg-none {
                margin-right: 10px; /* Khoảng cách giữa nút tìm kiếm và các nút khác */
            }
        }
        @media (max-width: 576px) {
            .header-top .contact-info {
                flex-wrap: nowrap; /* Vẫn giữ nằm ngang trên mobile */
                justify-content: center; /* Căn giữa trên mobile */
                overflow-x: auto; /* Cho phép cuộn ngang nếu nội dung quá dài */
                padding: 0 10px; /* Thêm padding để không bị sát mép */
            }
            .header-top .contact-info span {
                margin-right: 1rem; /* Giảm khoảng cách trên mobile */
                font-size: 0.75rem; /* Giảm kích thước chữ trên mobile */
            }
        }
    </style>
</head>

<body class="handheld-toolbar-enabled">
    <main class="page-wrapper">
        <!-- Header Top -->
        <div class="header-top text-white py-2" style="background-color: #0072C6">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="contact-info d-flex">
                    <span>
                        <i class="fas fa-phone"></i> +84 366 652 716
                    </span>
                    <span>
                        <i class="fas fa-fax"></i> +84 376 031 905
                    </span>
                    <span>
                        <i class="fas fa-envelope"></i> congdoan@agu.edu.vn
                    </span>
                </div>
            </div>
        </div>
        <header class="shadow-sm">
            <div class="navbar-sticky bg-light">
                <div class="navbar navbar-expand-lg navbar-light">
                    <div class="container d-flex align-items-center justify-content-between">
                        <!-- Logo -->
                        <a class="navbar-brand d-none d-sm-block flex-shrink-0" href="{{ route('frontend.home') }}">
                            <img src="{{ asset('public/img/logo.png') }}" width="300" />
                        </a>
                        <a class="navbar-brand d-sm-none flex-shrink-0 me-2" href="{{ route('frontend.home') }}">
                            <img src="{{ asset('public/img/favicon.png') }}" width="74" />
                        </a>

                        <!-- Tìm kiếm trên mobile (nút mở modal) -->
                        <button class="btn d-lg-none border-0 bg-transparent" type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fas fa-search fs-4 text-muted"></i>
                        </button>

                        <!-- Thanh tìm kiếm trên desktop -->
                        <div class="search-bar d-none d-lg-flex mx-4">
                            <form action="{{ route('frontend.timkiem') }}" method="GET" class="w-100 position-relative">
                                <input class="form-control rounded-end pe-5" type="text" name="tukhoa" placeholder="Tìm kiếm" />
                                <button type="submit" class="position-absolute top-50 end-0 translate-middle-y text-muted border-0 bg-transparent me-3">
                                    <i class="fas fa-search fs-base"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Navbar toolbar (menu và user) -->
                        <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a class="navbar-tool navbar-stuck-toggler" href="#menu">
                                <span class="navbar-tool-tooltip">Mở rộng menu</span>
                                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon fas fa-bars"></i></div>
                            </a>
                            @guest
                            <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2 text-decoration-none" href="{{ route('user.dangnhap') }}">
                                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon fas fa-user"></i></div>
                                <div class="navbar-tool-text ms-n3"><small>Xin chào</small>Khách</div>
                            </a>
                            @else
                            <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2 text-decoration-none" href="{{ route('user.home') }}">
                                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon fas fa-user"></i></div>
                                <div class="navbar-tool-text ms-n3"><small>Xin chào</small>{{ Auth::user()->name }}</div>
                            </a>
                            @endguest
                        </div>
                    </div>
                </div>

                <!-- Modal tìm kiếm cho mobile -->
                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Tìm kiếm</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('frontend.timkiem') }}" method="GET">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="tukhoa" placeholder="Nhập từ khóa..." />
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0 pb-2">
                    <div class="container">
                        <div class="collapse navbar-collapse" id="navbarCollapse">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link ps-lg-0 fw-bold" href="{{ route('frontend.home') }}">
                                        <i class="fas fa-home me-2 fw-bold"></i>Trang chủ
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="{{ route('frontend.baiviet') }}" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i class="fas fa-info-circle me-2"></i>Giới thiệu▾
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ route('frontend.baiviet.chitiet', [
                                                   'tenchude_slug' => 'gioi-thieu', 
                                                   'tieude_slug' => 'gioi-thieu-ve-cong-doan-co-so-truong-dai-hoc-an-giang'
                                               ]) }}">
                                               Về công đoàn cơ sở
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chitiet', [
                                                   'tenchude_slug' => 'gioi-thieu', 
                                                   'tieude_slug' => 'nghi-quyet-dai-hoi-cong-doan-co-so-truong-dai-hoc-an-giang-nhiem-ky-2023-2028'
                                               ]) }}">Nghị quyết Đại hội nhiệm kỳ 2023-2028</a></li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chitiet', [
                                                   'tenchude_slug' => 'gioi-thieu', 
                                                   'tieude_slug' => 'van-kien-dai-hoi-nhiem-ky-2023-2028'
                                               ]) }}">Văn kiện Đại hội nhiệm kỳ 2023-2028</a></li>
                                    </ul>
                                </li>
                                <!-- Thêm mục Cơ cấu tổ chức -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i class="fas fa-sitemap me-2"></i>Cơ cấu tổ chức▾
                                    </a>
                                    <ul class="dropdown-menu">
                                        @php
                                            $phong_ban_list = App\Models\BanChapHanh::select('ten_phong_ban')->distinct()->pluck('ten_phong_ban');
                                        @endphp
                                        @foreach($phong_ban_list as $phong_ban)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('frontend.banchaphanh', ['ten_phong_ban' => $phong_ban]) }}">
                                                    {{ $phong_ban }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="{{ route('frontend.baiviet') }}" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i class="fas fa-book me-2"></i>Quy chế▾
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" 
                                               href="{{ route('frontend.baiviet.chitiet', [
                                                   'tenchude_slug' => 'gioi-thieu', 
                                                   'tieude_slug' => 'quy-che-lam-viec-cua-ban-chap-hanh-cong-doan-co-so'
                                               ]) }}">
                                               Quy chế làm việc của BCH CĐCS</a></li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chitiet', [
                                                   'tenchude_slug' => 'gioi-thieu', 
                                                   'tieude_slug' => 'quy-che-chi-tieu-noi-bo-cong-doan-co-so'
                                               ]) }}">Quy chế chi tiêu nội bộ CĐCS</a></li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chitiet', [
                                                   'tenchude_slug' => 'gioi-thieu', 
                                                   'tieude_slug' => 'quy-che-lam-viec-cua-uy-ban-kiem-tra'
                                               ]) }}">Quy chế làm việc của UBKT</a></li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chitiet', [
                                                'tenchude_slug' => 'gioi-thieu', 
                                                'tieude_slug' => 'quy-che-phoi-hop-hoat-dong-giua-bch-cong-doan-co-so-va-hieu-truong'
                                            ]) }}">Quy chế phối hợp hoạt động giữa BCHCĐCS & HT</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="{{ route('frontend.baiviet') }}" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="fas fa-newspaper me-2 "></i>Tin Tức▾</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => 'thong-bao']) }}">Thông báo</a></li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => 'hoat-dong']) }}">Hoạt động</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-bold" href="{{ route('frontend.baiviet') }}" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="fas fa-file-alt me-2 "></i>Văn bản▾</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => 'van-ban-di']) }}">Văn bản đi</a></li>
                                        <li><a class="dropdown-item" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => 'van-ban-den']) }}">Văn bản đến</a></li>
                                        <li><a class="dropdown-item" href="#">Báo cáo tháng</a></li>
                                        <li><a class="dropdown-item" href="#">Báo cáo năm</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link fw-bold"><i class="fas fa-link me-2 fw-bold"></i>Liên kết▾</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="http://agu.edu.vn/">Đại học An Giang</a></li>
                                        <li><a class="dropdown-item" href="http://ldld.angiang.gov.vn/wps/portal/">LĐLĐ Tỉnh An Giang</a></li>
                                        <li><a class="dropdown-item" href="http://mail.agu.edu.vn/">Thư điện tử</a></li>
                                        <li><a class="dropdown-item" href="http://lib.agu.edu.vn/">Tạp chí khoa học</a></li>
                                        <li><a class="dropdown-item" href="http://enews.agu.edu.vn/">e-News</a></li> 
                                        <li><a class="dropdown-item" href="https://fit.agu.edu.vn/">Khoa CNTT</a></li> 
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" href="{{ route('frontend.lienhe') }}"><i class="fas fa-headset me-2 fw-bold"></i>Liên hệ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
    </main>

    <footer class="footer" style="background-color: #222222">
        <div class="pt-5">
            <div class="container">
                <div class="row pb-2">
                    <div class="col-md-6 text-center text-md-start mb-4">
                        <div class="text-nowrap mb-4">
                            <a class="d-inline-block align-middle mt-n1 me-3" href="#"><img class="d-block" src="{{ asset('public/img/favicon-removebg.png') }}" width="117" /></a>
                        </div>
                        <div class="widget widget-links widget-light ">
                            <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
                                <li class="widget-list-item me-4"><a class="widget-list-link text-decoration-none" href="{{ route('frontend.home') }}">Trang chủ</a></li>
                                <li class="widget-list-item me-4"><a class="widget-list-link text-decoration-none" href="{{ route('frontend.baiviet') }}">Tin tức</a></li>
                                <li class="widget-list-item me-4"><a class="widget-list-link text-decoration-none" href="{{ route('frontend.lienhe') }}">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-end mb-4">
                        <div class="mb-3">
                            <a class="btn-social bs-light bs-twitter ms-2 mb-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn-social bs-light bs-facebook ms-2 mb-2" href="https://www.facebook.com/vanhuy383/"><i class="fab fa-facebook"></i></a>
                            <a class="btn-social bs-light bs-instagram ms-2 mb-2" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="btn-social bs-light bs-pinterest ms-2 mb-2" href="#"><i class="fab fa-pinterest"></i></a>
                            <a class="btn-social bs-light bs-youtube ms-2 mb-2" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-4 fs-xs text-light opacity-50 text-center text-md-start">Bản quyền © 2025 bởi {{ config('app.name', 'Laravel') }}.</div>
            </div>
        </div>
    </footer>

    <a class="btn-scroll-top" href="#top" data-scroll>
        <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span>
        <i class="btn-scroll-top-icon fas fa-arrow-up"></i>
    </a>

    <script src="{{ asset('public/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/vendor/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/vendor/tiny-slider/tiny-slider.js') }}"></script>
    <script src="{{ asset('public/vendor/smooth-scroll/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('public/vendor/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('public/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}" ></script>
    <script src="{{ asset('public/vendor/shufflejs/shuffle.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/lightgallery.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/plugins/zoom/lg-zoom.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/plugins/video/lg-video.min.js') }}"></script>
    <script src="{{ asset('public/vendor/drift-zoom/Drift.min.js') }}"></script>
    <script src="{{ asset('public/js/theme.min.js') }}"></script>
    @stack('scripts')
</body>

</html>