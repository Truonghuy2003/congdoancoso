@extends('layouts.frontend')

@section('title', $baiviet->tieude)

@section('content')
    <div class="bg-body-secondary py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap text-decoration-none" href="{{ route('frontend.home') }}"><i class="fas fa-home"></i>Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap">
                            <a class="text-decoration-none" href="{{ route('frontend.baiviet') }}">Tin tức</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active ms-1" aria-current="page">Chi tiết</li>
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
                        <span class="blog-entry-meta-link">{{ Carbon\Carbon::parse($baiviet->created_at)->format('d/m/Y - H:i') }}</span>
                        <span class="blog-entry-meta-divider"></span>
                        <span class="blog-entry-meta-link text-nowrap"><i class="fas fa-eye"></i> {{ $baiviet->luotxem }}</span>
                    </div>
                    <div>
                        <span class="blog-entry-meta-link text-nowrap fs-sm"><i class="fas fa-pencil-alt"></i>Đã chỉnh sửa: {{ ($baiviet->updated_at)->format('d/m/Y - H:i') }}</span>
                    </div>
                </div>
                <p style="text-align:justify" class="fw-bold text-center">{{ $baiviet->tomtat }}</p>
                <div class="content-with-centered-images" style="text-align:justify">
                    {!! $baiviet->noidung !!}
                </div>

                @if ($baiviet->file->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="h5">Tệp đính kèm:</h3>
                        <ul>
                            @foreach ($baiviet->file as $tep)
                                <li>
                                    <a href="{{ route('tai-tep', $tep->id) }}" class="text-decoration-none">
                                        <i class="fas fa-file"></i> Tải xuống ({{ $tep->ten_goc}})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex flex-wrap justify-content-between pt-2 pb-4 mb-1">
                    <div class="mt-3 me-3">
                        @foreach($baiviet->chudes as $chude)
                            <a class="badge badge-custom me-1 text-decoration-none" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $chude->tenchude_slug]) }}">
                                {{ $chude->tenchude }}
                            </a>
                        @endforeach
                    </div>
    
                    <div class="pt-2 mt-5 text-center w-100" id="comments">
                        <h2 class="h4">
                            Bình luận
                            <span class="badge bg-body-secondary fs-sm text-body align-middle ms-2">
                                {{ $baiviet->BinhLuanBaiViet->where('kiemduyet', 1)->where('kichhoat', 1)->count() }}
                            </span>                            
                        </h2>
                        <div class="d-flex flex-column align-items-center">
                            @foreach($baiviet->BinhLuanBaiViet as $value)
                                @php
                                    $laBinhLuanCuaChinhToi = Auth::check() && $value->nguoidung_id === Auth::id();
                                    $binhLuanHienThi = $value->kiemduyet == 1 && $value->kichhoat == 1;
                                    $binhLuanBiAn = $value->kichhoat == 0;
                                @endphp
                                @if($binhLuanHienThi || $laBinhLuanCuaChinhToi)
                                    <div class="d-flex align-items-start py-4 w-50">
                                        <img class="rounded-circle me-3" src="{{ asset('public/img/avatar.png') }}" width="50" />
                                        <div class="text-start w-100">
                                            <h6 class="fs-md mb-0">
                                                {{ optional($value->NguoiDung)->name }}
                                                @if(optional($value->NguoiDung)->role === 'admin')
                                                    <span class="badge bg-danger ms-2">Admin</span>
                                                @elseif(optional($value->NguoiDung)->role === 'giaovien')
                                                    <span class="badge bg-primary ms-2">Giáo viên</span>
                                                @endif
                                            </h6>
                                            @if($binhLuanBiAn && $laBinhLuanCuaChinhToi)
                                                <p class="fs-md mb-1 d-inline text-muted" style="text-align: justify;">
                                                    {{ $value->noidungbinhluan }}
                                                </p>
                                                <span class="badge bg-secondary text-light ms-2 align-middle">Bình luận đã bị ẩn</span>
                                            @elseif(!$binhLuanBiAn)
                                                <p class="fs-md mb-1 d-inline" style="text-align: justify;">
                                                    {{ $value->noidungbinhluan }}
                                                </p>
                                            @endif
                                            @if($value->kiemduyet == 0 && $laBinhLuanCuaChinhToi)
                                                <span class="badge bg-warning text-dark ms-2 align-middle">Đang chờ duyệt</span>
                                            @endif
                                            <div class="fs-ms text-muted mt-1">
                                                <i class="fas fa-calendar-alt align-middle me-2"></i>
                                                {{ Carbon\Carbon::parse($value->created_at)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @auth
                            <div class="card border-0 shadow mt-2 mb-4 w-50 mx-auto">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-3" src="{{ asset('public/img/avatar.png') }}" width="50" />
                                        <form class="w-100 needs-validation" method="POST" action="{{ route('user.baiviet.binhluan', $baiviet->id) }}" novalidate>
                                            @csrf
                                            <div class="mb-3">
                                                <textarea class="form-control" name="noidung" rows="3" placeholder="Chia sẻ ý kiến của bạn..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Nội dung bình luận không được bỏ trống.
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm" type="submit">Đăng bình luận</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning text-center mt-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Bạn cần 
                                <a href="{{ route('user.dangnhap') }}" class="fw-bold text-decoration-none">Đăng nhập</a> 
                                để bình luận.
                            </div>
                        @endauth   
                    </div> 
                </div>
            </div>
        </div>
    </div>    
    <div class="bg-body-secondary py-5">
        <div class="container py-3">
            <h2 class="h4 text-center pb-4">Bài viết cùng chuyên mục</h2>
            <div class="tns-carousel">
                @php
                    function LayHinhCuoiCung($strNoiDung) { 
                        $first_img = ''; 
                        ob_start(); 
                        ob_end_clean(); 
                        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $strNoiDung, $matches); 
                        return empty($output) ? asset('public/img/noimage.jpg') : str_replace('&', '&', $matches[1][0]); 
                    } 
                @endphp
                <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: false, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 20},&quot;900&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 30}}}">
                    @foreach($baivietcungchuyemuc as $value)
                        <article>
                            <a class="blog-entry-thumb mb-3 d-block" href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chudes->first()->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}">
                                <img class="img-fluid rounded shadow" src="{{ LayHinhCuoiCung($value->noidung) }}" alt="{{ $value->tieude }}">
                            </a>
                            <div class="d-flex align-items-center fs-sm mb-2 justify-content-center">
                                <span class="blog-entry-meta-link">bởi {{ optional($value->NguoiDung)->name }}</span>
                                <span class="blog-entry-meta-divider"></span>
                                <span class="blog-entry-meta-link">📅 {{ Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i') }} | 👁️ {{ $value->luotxem }} lượt xem</span>
                            </div>
                            <h3 class="h6 blog-entry-title">
                                <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $value->chudes->first()->tenchude_slug, 'tieude_slug' => $value->tieude_slug]) }}">
                                    {{ $value->tieude }}
                                </a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge.bg-danger { background-color: #dc3545 !important; font-size: 0.75rem; font-weight: bold; padding: 4px 8px; border-radius: 10px; }
        .blog-entry-thumb img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out; }
        .blog-entry-thumb img:hover { box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); transform: scale(1.05); }    
        article { text-align: center; padding: 10px; }
        .blog-entry-title a { text-decoration: none; color: #333; font-weight: bold; }
        .blog-entry-title a:hover { color: #FE696A; }
        .content-with-centered-images img { display: block; margin: 0 auto; max-width: 100%; height: auto; }
        .content-with-centered-images figcaption, .content-with-centered-images p:empty + img + p { text-align: center; font-style: italic; color: #666; margin-top: 10px; margin-bottom: 20px; }
    </style>
@endsection