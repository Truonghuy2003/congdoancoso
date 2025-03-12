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

    <!-- Header Top -->
    <div class="header-top bg-primary text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="contact-info d-flex">
                <span class="me-5">
                    <i class="fas fa-phone"></i> +84 0366 527 16
                </span>
                <span class="me-5">
                    <i class="fas fa-fax"></i> +84 0376 031 905
                </span>
                <span>
                    <i class="fas fa-envelope"></i> congdoan@agu.edu.vn
                </span>
            </div>
        </div>
    </div>
</head>

<body class="handheld-toolbar-enabled ">
    <main class="page-wrapper">
        <header class="shadow-sm">
            <div class="navbar-sticky bg-light">
                <div class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <a class="navbar-brand d-none d-sm-block flex-shrink-0" href="{{ route('frontend.home') }}">
                            <img src="{{ asset('public/img/logo.png') }}" width="300" />
                        </a>
                        <a class="navbar-brand d-sm-none flex-shrink-0 me-2" href="{{ route('frontend.home') }}">
                            <img src="{{ asset('public/img/favicon.png') }}" width="74" />
                        </a>
                        <div class="input-group d-none d-lg-flex mx-4">
                            <form action="{{ route('frontend.timkiem') }}" method="GET" class="w-100">
                                    <input class="form-control rounded-end pe-5" type="text" name="tukhoa" placeholder="Tìm kiếm" />
                                    <button type="submit" class="position-absolute top-50 end-0 translate-middle-y text-muted border-0 bg-transparent me-3">
                                        <i class="fas fa-search fs-base"></i>
                                    </button>
                            </form>
                        </div>
                        <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a class="navbar-tool navbar-stuck-toggler" href="#menu">
                                <span class="navbar-tool-tooltip">Mở rộng menu</span>
                                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon fas fa-bars"></i></div>
                            </a>
                            @guest
                            <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="{{ route('user.dangnhap') }}">
                                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon fas fa-user"></i></div>
                                <div class="navbar-tool-text ms-n3"><small>Xin chào</small>Khách</div>
                            </a>
                            @else
                            <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="{{ route('user.home') }}">
                                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon fas fa-user"></i></div>
                                <div class="navbar-tool-text ms-n3"><small>Xin chào</small>{{ Auth::user()->name }}</div>
                            </a>
                            @endguest

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
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" href="{{ route('frontend.baiviet') }}"><i class="fas fa-newspaper me-2 fw-bold"></i>Tin tức</a>
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

    </div>
    <footer class="footer bg-dark">
        <div class="pt-5 bg-darker">
            <div class="container">
                <div class="row pb-2">
                    <div class="col-md-6 text-center text-md-start mb-4">
                        <div class="text-nowrap mb-4">
                            <a class="d-inline-block align-middle mt-n1 me-3" href="#"><img class="d-block" src="{{ asset('public/img/favicon-removebg.png') }}" width="117" /></a>
                        </div>
                        <div class="widget widget-links widget-light ">
                            <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
                                <li class="widget-list-item me-4"><a class="widget-list-link" href="{{ route('frontend.home') }}">Trang chủ</a></li>
                                <li class="widget-list-item me-4"><a class="widget-list-link" href="{{ route('frontend.baiviet') }}">Tin tức</a></li>
                                <li class="widget-list-item me-4"><a class="widget-list-link" href="{{ route('frontend.lienhe') }}">Liên hệ</a></li>
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
    <script src="{{ asset('public/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('public/vendor/shufflejs/shuffle.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/lightgallery.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/plugins/zoom/lg-zoom.min.js') }}"></script>
    <script src="{{ asset('public/vendor/lightgallery/plugins/video/lg-video.min.js') }}"></script>
    <script src="{{ asset('public/vendor/drift-zoom/Drift.min.js') }}"></script>
    <script src="{{ asset('public/js/theme.min.js') }}"></script>
</body>

</html>