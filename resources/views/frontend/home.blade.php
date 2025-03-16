@extends('layouts.frontend')

@section('title', 'Trang chủ')

@section('content')
    <section class="container mt-4 mb-grid-gutter rounded-3 shadow-lg bg-body-secondary"> 
        <div class="rounded-3 py-5 px-4 px-sm-5"> 
            <div class="row align-items-center"> 
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('public/img/minhhoa.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Hình 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('public/img/minhhoa1.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Hình 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('public/img/minhhoa2.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Hình 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Lùi lại</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Tiến tới</span>
                    </button>
                </div>
            </div> 
        </div> 
    </section>

    <section class="container mt-4 mb-grid-gutter rounded-3 shadow-lg"> 
        <div class="rounded-3 py-1 px-4 px-sm-1"> 
            <div class="row align-items-center"> 
                <h2 class="h4 text-light mt-5 mb-4 text-dark text-center">Bài đăng mới nhất</h2>
                <div class="d-flex justify-content-end mt-4">
                    {{ $baiviet->links() }}
                </div>
                <div class="row pt-2 mx-n2 d-flex flex-wrap">
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
                            return $first_img ?: asset('public/img/noimage.png'); 
                        } 
                    @endphp


                    @foreach($baiviet as $bv)
                        <div class="col-lg-4 col-md-6 col-sm-12 px-2 mb-4"> 
                            <div class="card shadow-sm border-0"> 
                                <a class="card-img-top d-block overflow-hidden" 
                                    href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chude->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                                    <img src="{{ LayHinhDauTien($bv->noidung) }}" 
                                        style="width: 100%; height: 200px; object-fit: cover;" 
                                        alt="Hình minh họa bài viết" />
                                </a> 
                                <div class="card-body py-3 "> 
                                    <a class="badge bg-primary mb-2 text-decoration-none" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $bv->ChuDe->tenchude_slug]) }}">
                                        {{ $bv->ChuDe->tenchude }}
                                    </a> 
                                    <h5 class="card-title text-dark blog-entry-title"> 
                                        <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chude->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                                            {{ Str::limit($bv->tieude, 100)  }}
                                        </a> 
                                    </h5> 
                                    <p class="card-text text-muted small">{{ Str::limit($bv->tomtat, 100) }}</p>
                                </div> 
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center"> 
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $bv->nguoidung->name ?? 'Ẩn danh' }} 
                                        | <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($bv->created_at)->format('d/m/Y H:i') }} 
                                        | <i class="fas fa-eye"></i> {{ $bv->luotxem }} lượt xem
                                    </small>                    
                                </div> 
                            </div> 
                        </div> 
                    @endforeach 
                </div>
                <!-- Hiển thị nút phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $baiviet->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
