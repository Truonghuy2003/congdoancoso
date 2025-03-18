@extends('layouts.frontend')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold">Kết quả tìm kiếm cho: "{{ $tukhoa }}"</h4>
    <hr>
    @if($baiviet_timkiem->count() > 0)
        <div class="row">
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
            @foreach ($baiviet_timkiem as $bv)
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mb-4 "> 
                <div class="card shadow-sm border-0 hover-shadow"> 
                    <a class="card-img-top d-block overflow-hidden" 
                        href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chude->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                        <img src="{{ LayHinhCuoiCung($bv->noidung) }}" 
                            style="width: 100%; height: 200px; object-fit: cover;" 
                            alt="Hình minh họa bài viết" />
                    </a> 
                    <div class="card-body py-3 "> 
                        <a class="badge bg-primary mb-2 hover-shadow text-decoration-none " href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $bv->ChuDe->tenchude_slug]) }}">
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
        <div class="d-flex justify-content-center">
            {{ $baiviet_timkiem->links() }}
        </div>
    @else
        <p class="text-muted">Không tìm thấy bài viết nào.</p>
    @endif
    <style>
        /* Hiệu ứng khi di chuột vào bài viết */
        .hover-shadow {
            transition: box-shadow 0.3s ease-in-out;
        }
    
        .hover-shadow:hover {
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
</div>
@endsection
