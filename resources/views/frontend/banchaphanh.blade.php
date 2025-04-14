@extends('layouts.frontend')

@section('title', 'Ban Chấp Hành Nhiệm Kỳ 2023-2028')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <!-- Bộ lọc nhiệm kỳ -->
        <div class="text-center mb-4">
            <form method="GET" action="{{ route('frontend.banchaphanh') }}">
                <label for="nhiem_ky" class="fw-bold me-2">Chọn nhiệm kỳ:</label>
                <select name="nhiem_ky" id="nhiem_ky" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                    @foreach($nhiem_ky_list as $nk)
                        <option value="{{ $nk }}" {{ $nhiem_ky == $nk ? 'selected' : '' }}>{{ $nk }}</option>
                    @endforeach
                </select>
                @if($ten_phong_ban)
                    <input type="hidden" name="ten_phong_ban" value="{{ $ten_phong_ban }}">
                @endif
            </form>
        </div>

        <!-- Tiêu đề -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-uppercase" style="color: #0072C6; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);">
                {{ $ten_phong_ban ?? 'Ban Chấp Hành Tất Cả Phòng Ban' }}
            </h1>
            <p class="lead text-muted">Nhiệm Kỳ {{ $nhiem_ky }}</p>
            <hr class="w-25 mx-auto border-3 rounded" style="border-color: #0072C6; opacity: 0.8;">
        </div>

        <!-- Danh sách thành viên -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($thanhvien as $member)
                <div class="col">
                    <div class="card h-100 border-0 shadow-lg team-card" style="border-radius: 20px; overflow: hidden; background: #fff;">
                        <!-- Ảnh -->
                        <div class="position-relative image-wrapper">
                            <img src="{{ $member->anh_dai_dien ? asset('public/storage/' . $member->anh_dai_dien) : asset('public/img/default_avatar.jpg') }}"
                                alt="{{ $member->ho_ten }}"
                                class="img-fluid"
                                style="width: 100%; object-fit: cover; border-radius: 20px 20px 0 0; transition: transform 0.6s ease, filter 0.3s ease;">
                            <div class="overlay position-absolute top-0 start-0 w-100 h-100"
                                style="background: linear-gradient(to bottom, rgba(0, 114, 198, 0.3), rgba(0, 0, 0, 0.5)); opacity: 0; transition: opacity 0.4s ease;"></div>
                        </div>
                        <!-- Thông tin -->
                        <div class="card-body text-center p-4" style="background: #fff; border-top: 4px solid #0072C6; transition: background 0.3s ease;">
                            <h5 class="card-title fw-bold mb-2" style="color: #0072C6; font-size: 1.5rem; text-transform: uppercase;">{{ $member->ho_ten }}</h5>
                            <p class="fw-semibold text-muted mb-2" style="font-size: 1.1rem;">{{ $member->chuc_vu }}</p>
                            <p class="text-muted mb-3" style="font-size: 1rem;">{{ $member->ten_phong_ban }}</p>
                            <ul class="list-unstyled text-muted mb-3" style="font-size: 0.95rem;">
                                <li><i class="fas fa-envelope me-2 text-primary"></i><a href="mailto:{{ $member->email }}" class="text-decoration-none text-dark hover-link">{{ $member->email }}</a></li>
                                <li><i class="fas fa-phone me-2 text-primary"></i>{{ $member->dien_thoai ?? '(0296) 6 256565' }}</li>
                            </ul>
                            <p class="card-text text-muted" style="font-size: 0.9rem; line-height: 1.6;">{!! nl2br(e($member->nhiem_vu)) !!}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Không có thành viên nào trong phòng ban này.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

    <style>
        /* Style mới cho label "Chọn nhiệm kỳ" */
        .task-label {
            font-size: 1.25rem; /* Tăng kích thước chữ */
            color: #0072C6; /* Màu xanh chủ đạo */
            text-transform: uppercase; /* Chữ in hoa */
            letter-spacing: 1px; /* Khoảng cách giữa các chữ */
            padding: 0.5rem 1rem; /* Thêm padding */
            background: rgba(0, 114, 198, 0.1); /* Nền mờ nhẹ */
            border-radius: 8px; /* Bo góc */
            display: inline-block; /* Để padding hoạt động */
            transition: background 0.3s ease, color 0.3s ease; /* Hiệu ứng chuyển màu */
        }
        .task-label:hover {
            background: rgba(0, 114, 198, 0.2); /* Nền đậm hơn khi hover */
            color: #005a9e; /* Màu đậm hơn khi hover */
        }
        /* Card tổng thể */
        .team-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .team-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        /* Hiệu ứng ảnh */
        .image-wrapper {
            overflow: hidden;
            position: relative;
        }
        .team-card:hover img {
            transform: scale(1.1);
        }
        .team-card:hover .overlay {
            opacity: 1;
        }

        /* Card body */
        .card-body {
            position: relative;
            z-index: 1;
        }
        .team-card:hover .card-body {
            background: #f8f9fa;
        }

        /* Hiệu ứng hover cho email */
        .hover-link {
            transition: color 0.3s ease;
        }
        .hover-link:hover {
            color: #0072C6 !important;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .team-card img {
                height: 280px;
            }
            .card-title {
                font-size: 1.3rem;
            }
            .card-body {
                padding: 3rem;
            }
        }
        @media (max-width: 768px) {
            .team-card img {
                height: 250px;
            }
            .display-5 {
                font-size: 2rem;
            }
            .lead {
                font-size: 1rem;
            }
            .card-title {
                font-size: 1.2rem;
            }
            .card-body {
                padding: 2.5rem;
            }
        }
        @media (max-width: 576px) {
            .team-card img {
                height: 220px;
            }
            .card-title {
                font-size: 1.1rem;
            }
            .card-text {
                font-size: 0.85rem;
            }
            .card-body {
                padding: 2rem;
            }
        }

        /* Hiệu ứng cho nhiệm vụ */
        .card-text {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 0.4s ease, max-height 0.4s ease;
        }
        .team-card:hover .card-text {
            opacity: 1;
            max-height: 200px; /* Điều chỉnh theo nội dung thực tế */
        }
    </style>
@endsection