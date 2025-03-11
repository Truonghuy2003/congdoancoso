@extends('layouts.frontend')

@section('title', $baiviet->tieude)

@section('content')
    <div class="bg-secondary py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('frontend.home') }}"><i class="ci-home"></i>Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap">
                            <a href="{{ route('frontend.baiviet') }}">Tin tức</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Chi tiết</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 mb-0">{{ $baiviet->tieude }}</h1>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center pt-3 mt-md-3">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4 mt-n1">
                    <div class="d-flex align-items-center fs-sm mb-2">
                        <span class="blog-entry-meta-link">{{ optional($baiviet->NguoiDung)->name }}</span>
                        <span class="blog-entry-meta-divider"></span>
                        <span class="blog-entry-meta-link">{{ Carbon\Carbon::parse($baiviet->created_at)->format('d/m/Y') }}</span>
                    </div>
                    <div class="fs-sm mb-2">
                        <span class="blog-entry-meta-link text-nowrap"><i class="ci-eye"></i> {{ $baiviet->luotxem }}</span>
                    </div>
                </div>
                <p style="text-align:justify" class="fw-bold">{{ $baiviet->tomtat }}</p>
                <p style="text-align:justify">{!! $baiviet->noidung !!}</p>

                <div class="d-flex flex-wrap justify-content-between pt-2 pb-4 mb-1">
                    <div class="mt-3 me-3">
                        <a class="btn-tag mb-2" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => optional($baiviet->ChuDe)->tenchude_slug]) }}">
                            {{ optional($baiviet->ChuDe)->tenchude }}
                        </a>
                    </div>

                    <div class="pt-2 mt-5" id="comments">
                        <h2 class="h4">Bình luận<span class="badge bg-secondary fs-sm text-body align-middle ms-2">{{ $baiviet->BinhLuanBaiViet->count() }}</span></h2>
                        @foreach($baiviet->BinhLuanBaiViet as $value)
                            <div class="d-flex align-items-start py-4">
                                <img class="rounded-circle" src="{{ asset('public/img/avatar.jpg') }}" width="50" />
                                <div class="ps-3">
                                    <h6 class="fs-md mb-0">{{ optional($value->NguoiDung)->name }}</h6>
                                    <p class="fs-md mb-1" style="text-align:justify">{{ $value->noidungbinhluan }}</p>
                                    <span class="fs-ms text-muted"><i class="ci-time align-middle me-2"></i>{{ Carbon\Carbon::parse($value->created_at)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endforeach

                        @auth
                            <div class="card border-0 shadow mt-2 mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <img class="rounded-circle" src="{{ asset('public/img/avatar.jpg') }}" width="50" />
                                        <form class="w-100 needs-validation ms-3" method="POST" action="{{ route('frontend.binhluan.store', ['baiviet_id' => $baiviet->id]) }}" novalidate>
                                            @csrf
                                            <div class="mb-3">
                                                <textarea class="form-control" name="noidung" rows="3" placeholder="Chia sẻ ý kiến của bạn..." required></textarea>
                                                <div class="invalid-feedback">Nội dung bình luận không được bỏ trống.</div>
                                            </div>
                                            <button class="btn btn-primary btn-sm" type="submit">Đăng bình luận</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center"><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-secondary py-5">
        <div class="container py-3">
            <h2 class="h4 text-center pb-4">Bài viết cùng chuyên mục</h2>
            <div class="tns-carousel">
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
                <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: false, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 20},&quot;900&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 30}}}">
                    @foreach($baivietcungchuyemuc as $value)
                        <article>
                            <a class="blog-entry-thumb mb-3" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chude->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}">
                                <img src="{{ LayHinhCuoiCung($value->noidung) }}" />
                            </a>
                            <div class="d-flex align-items-center fs-sm mb-2">
                                <span class="blog-entry-meta-link">bởi {{ optional($value->NguoiDung)->name }}</span>
                                <span class="blog-entry-meta-divider"></span>
                                <span class="blog-entry-meta-link">📅 {{ Carbon\Carbon::parse($bv->created_at)->format('d/m/Y H:i') }} 
                                    | 👁️ {{ $bv->luotxem }} lượt xem</span>
                            </div>
                            <h3 class="h6 blog-entry-title">
                                <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chude->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}">
                                    {{ $value->tieude }}
                                </a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
