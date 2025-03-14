
@extends('layouts.frontend')

@section('title',  $title)

@section('content') 	
    <div class="bg-body-secondary py-0">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('frontend.home') }}"><i class="fas fa-home"></i>Trang chủ</a>
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

    <div class="container pb-5 mb-2 mb-md-4">
        {{ $baiviet->links() }}
        <div class="pt-3 mt-md-3">
            <div class="masonry-grid" data-columns="3">
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
                @foreach($baiviet as $value) 
                    <article class="masonry-grid-item"> 
                        <div class="card">
                            <a class="blog-entry-thumb" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chude->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}"> 
                                <img class="card-img-top" src="{{ LayHinhCuoiCung($value->noidung) }}" /> 
                            </a> 
                            <div class="card-body"> 
                                <h2 class="h6 blog-entry-title"> 
                                    <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chude->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}"> 
                                        {{ $value->tieude }} 
                                    </a> 
                                </h2> 
                                <p class="fs-sm " style="text-align:justify">{{ $value->tomtat }}</p> 
                                <a class="badge bg-primary mb-2 " href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $value->ChuDe->tenchude_slug]) }}">
                                    {{ $value->ChuDe->tenchude }}
                                </a> 
                            </div> 
                            <div class="card-footer d-flex align-items-center fs-xs"> 
                                <a class="blog-entry-meta-link" href="{{ route('user.hosocanhan') }}"> 
                                    <div class="blog-entry-author-ava">
                                        <img src="{{ $value->NguoiDung->hinhanh ? asset('storage/'.$value->NguoiDung->hinhanh) : asset('public/img/avatar.jpg') }}" />
                                    </div> 
                                    {{ $value->NguoiDung->name }} 
                                </a> 
                                <div class="ms-auto text-nowrap"> 
                                    <a class="blog-entry-meta-link text-nowrap">{{ $value->ngay_dang }}</a> 
                                    <span class="blog-entry-meta-divider mx-2"></span> 
                                    <a class="blog-entry-meta-link text-nowrap"><i class="fas fa-eye"></i>{{ $value->luotxem }}</a> 
                                </div> 
                            </div> 
                        </div> 
                    </article> 
                @endforeach 
            </div>
        </div>
        <!-- Hiển thị nút chuyển trang -->
        {{ $baiviet->links() }}       
    </div>
@endsection
