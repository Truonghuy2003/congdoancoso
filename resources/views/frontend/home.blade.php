@extends('layouts.frontend')

@section('title', 'Trang chủ')

@section('content')
    <section class="container mt-4 mb-grid-gutter text-white rounded-3 shadow-lg bg-dark"> 
        <div class="rounded-3 py-5 px-4 px-sm-5"> 
            <div class="row align-items-center"> 
                <div class="col-md-5 mb-4 mb-md-0"> 
                    <div class="text-center text-sm-start"> 
                        <span class="badge bg-primary fs-6 px-4 py-2 text-uppercase">Chào mừng đến với Website Công Đoàn Cơ Sở</span> 
                        <h3 class="mt-4 mb-2 text-light fw-light fs-5">Cập nhật thông tin nhanh chóng về công đoàn</h3> 
                        <p class="fs-6 fw-light fst-italic border-start border-3 ps-2">Trang web hỗ trợ giáo viên kết nối, tham gia phong trào, nâng cao đời sống và bảo vệ quyền lợi lao động.</p> 
                    </div>
                </div>  
                <div class="col-md-7 text-center">
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
        </div> 
    </section>

    <section class="container mt-4 mb-grid-gutter rounded-3 shadow-lg"> 
        <div class="rounded-3 py-1 px-4 px-sm-1"> 
            <div class="row align-items-center"> 
                <h2 class="h4 text-light mt-5 mb-4 text-dark text-center">Bài viết mới nhất</h2>
                
                <div class="row pt-2 mx-n2 d-flex flex-wrap">
                    @php
                        function LayHinhCuoiCung($strNoiDung) 
                        { 
                            $first_img = ''; 
                            ob_start(); 
                            ob_end_clean(); 
                            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $strNoiDung, $matches); 
                            if(empty($output)) 
                                return asset('public/img/noimage.png'); 
                            else 
                                return str_replace('&amp;', '&', $matches[1][0]); 
                        } 
                    @endphp 

                    @foreach($baiviet as $bv)
                        <div class="col-lg-4 col-md-6 col-sm-12 px-2 mb-4"> 
                            <div class="card shadow-sm border-0"> 
                                <a class="card-img-top d-block overflow-hidden" 
                                    href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chude->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                                    <img src="{{ LayHinhCuoiCung($bv->noidung) }}" 
                                        style="width: 100%; height: 200px; object-fit: cover;" 
                                        alt="Hình minh họa bài viết" />
                                </a> 
                                <div class="card-body py-3"> 
                                    <span class="badge bg-primary mb-2">{{ $bv->chude->tenchude ?? 'Không có chủ đề' }}</span>
                                    <h5 class="card-title text-dark"> 
                                        <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chude->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                                            {{ $bv->tieude }}
                                        </a> 
                                    </h5> 
                                    <p class="card-text text-muted small">{{ Str::limit($bv->tomtat, 100) }}</p>
                                </div> 
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center"> 
                                    <small class="text-muted">
                                        📅 {{ Carbon\Carbon::parse($bv->created_at)->format('d/m/Y H:i') }} 
                                        | 👁️ {{ $bv->luotxem }} lượt xem
                                    </small>
                                </div> 
                            </div> 
                        </div> 
                    @endforeach 
                </div>
            </div>
        </div>
    </section>
@endsection
