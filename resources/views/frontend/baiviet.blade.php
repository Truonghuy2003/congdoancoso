
@extends('layouts.frontend')

@section('title',  $title)

@section('content') 	
    <div class="bg-body-secondary py-0">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap text-decoration-none" href="{{ route('frontend.home') }}"><i class="fas fa-home"></i>Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 mb-0">{{ $title }}</h1>
            </div>
        </div>
    </div>
    <style>
        /* Hiệu ứng khi di chuột vào bài viết */
        .hover-shadow {
            transition: box-shadow 0.3s ease-in-out;
        }
    
        .hover-shadow:hover {
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2) !important;
        }
    </style>

    <div class="container pb-5 mb-2 mb-md-4">
        {{ $baiviet->links() }}
        <div class="pt-3 mt-md-3">
            <div class="masonry-grid" data-columns="3">
                @php
                    function LayHinhDauTien($strNoiDung) 
                    { 
                        // Khởi tạo biến lưu ảnh
                        $first_img = ''; 
                        // Dùng preg_match để chỉ lấy ảnh đầu tiên (thay vì lấy tất cả)
                        if (preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $strNoiDung, $matches)) {
                            $first_img = str_replace('&amp;', '&', $matches[1]); // Chuyển đổi URL
                        }
                        // Nếu không tìm thấy ảnh, trả về ảnh mặc định
                        return $first_img ?: asset('public/img/noimage.jpg'); 
                    } 
                @endphp
                @foreach($baiviet as $value)
                <article class="masonry-grid-item">
                    <div class="card hover-shadow">
                        <a class="blog-entry-thumb" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chude->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}">
                            <img class="card-img-top" src="{{ LayHinhDauTien($value->noidung) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Hình minh họa bài viết" />
                        </a>
                        <div class="card-body">
                            <a class="badge bg-primary mb-2 hover-shadow text-decoration-none" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $value->ChuDe->tenchude_slug]) }}">
                                {{ $value->ChuDe->tenchude }}
                            </a>
                            <h5 class="h6 blog-entry-title">
                                <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chude->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}">
                                    {{ Str::limit($value->tieude, 100) }}
                                </a>
                            </h5>
                            <p class="fs-sm" style="text-align:justify">{{ Str::limit($value->tomtat, 100) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> {{ $value->NguoiDung->name ?? 'Ẩn danh' }}
                                | <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i') }}
                                | <i class="fas fa-eye"></i> {{ $value->luotxem }}
                            </small>
                            <div>
                                @auth
                                    <button class="btn btn-outline-primary btn-sm save-post" data-id="{{ $value->id }}">
                                        <i class="fas fa-bookmark"></i> Lưu
                                    </button>
                                @else
                                    <button class="btn btn-outline-secondary btn-sm" onclick="alert('Vui lòng đăng nhập để lưu bài viết!')">
                                        <i class="fas fa-bookmark"></i> Lưu
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
            @push('scripts')
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let buttons = document.querySelectorAll(".save-post");
                
                        buttons.forEach((btn) => {
                            btn.onclick = function () {
                                let postId = this.dataset.id;
                                
                                // Vô hiệu hóa nút khi đang gửi request
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
                
                                fetch("{{ route('user.baiviet.luu') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    },
                                    body: JSON.stringify({ baiviet_id: postId }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.message) {
                                        alert(data.message);
                                        btn.innerHTML = '<i class="fas fa-check"></i> Đã lưu';
                                        btn.classList.remove("btn-outline-primary");
                                        btn.classList.add("btn-success");
                                    }
                                })
                                .catch(error => {
                                    console.error("Lỗi khi lưu bài viết:", error);
                                    alert("Đã xảy ra lỗi, vui lòng thử lại!");
                                })
                                .finally(() => {
                                    btn.disabled = false;
                                });
                            };
                        });
                    });
                </script>                        
            @endpush
            @stack('scripts')            
            </div>
        </div>
        <!-- Hiển thị nút chuyển trang -->
        {{ $baiviet->links() }}       
    </div>
@endsection
