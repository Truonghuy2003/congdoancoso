@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Banner động -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="banner text-center text-white p-4 rounded" style="background: linear-gradient(135deg, #007bff, #00c4b4);">
                <h2 class="fw-bold animate__animated animate__fadeInDown">Chào mừng đến với Trang Quản Trị</h2>
                <p class="animate__animated animate__fadeInUp">Quản lý nội dung dễ dàng và hiệu quả!</p>
            </div>
        </div>
    </div>

    <!-- Thông báo session -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Số liệu thống kê nhanh -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-newspaper me-2"></i>Tổng bài viết</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\Baiviet::count() }}">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-comments me-2"></i>Tổng bình luận</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\Binh_luan_bai_viet::count() }}">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning"><i class="fas fa-eye me-2"></i>Tổng lượt xem</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\Baiviet::sum('luotxem') }}">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info"><i class="fas fa-file me-2"></i>Tổng file</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\File::count() }}">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin hỗ trợ -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header fw-bold bg-success text-white">
                    <i class="fas fa-info-circle me-2"></i>Thông tin hỗ trợ
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <strong>Đây là trang chủ dành cho quản trị viên và cán bộ giáo viên.</strong><br>
                        Nếu cần hỗ trợ kỹ thuật, quý khách vui lòng thực hiện một trong những cách sau:
                    </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-envelope me-2 text-primary"></i>
                            Truy cập: <a href="mailto:vanhuy382003@gmail.com" class="support-link">vanhuy382003@gmail.com</a> và gửi yêu cầu hỗ trợ.
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-mail-bulk me-2 text-primary"></i>
                            Gửi email cho phòng kỹ thuật: <a href="mailto:kythuat@congdoan.agu.vn" class="support-link">kythuat@congdoan.agu.vn</a>.
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-share-alt me-2 text-primary"></i>
                            Liên kết MXH: 
                            <a href="https://www.facebook.com/van.huy.870768/" class="support-link">Facebook</a>, 
                            <a href="https://www.instagram.com/vhuy3aug_/profilecard/" class="support-link">Instagram</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-phone me-2 text-primary"></i>
                            Gọi số Hotline Hỗ Trợ Khách Hàng: <strong class="text-danger">0366652716</strong>.
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            Hoặc đến địa chỉ: <strong>Số 18 Ung Văn Khiêm, TPLX AG.</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút về trang chủ -->
    <div class="text-center">
        <a href="{{ route('frontend.home') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-home me-2"></i> Về trang chủ
        </a>
    </div>
</div>
@endsection

@section('javascript')
<!-- Thêm Animate.css từ CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<script>
    // Hiệu ứng đếm số
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('.counter');
        const speed = 50; // Tốc độ đếm (càng nhỏ càng nhanh)

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;

                // Tính bước tăng
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        });
    });
</script>

<style>
    /* Hiệu ứng cho banner */
    .banner {
        position: relative;
        overflow: hidden;
    }

    .banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://www.transparenttextures.com/patterns/cubes.png');
        opacity: 0.1;
        z-index: 0;
    }

    .banner h2, .banner p {
        position: relative;
        z-index: 1;
    }

    /* Hiệu ứng hover cho liên kết hỗ trợ */
    .support-link {
        color: #007bff;
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }

    .support-link:hover {
        color: #ff9800;
        text-shadow: 0 0 5px rgba(255, 152, 0, 0.5);
        text-decoration: none;
    }

    /* Card shadow và hover */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    /* Tùy chỉnh list-group */
    .list-group-item {
        border: none;
        padding: 10px 0;
    }
</style>
@endsection