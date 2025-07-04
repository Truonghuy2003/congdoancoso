@extends('layouts.frontend')

@section('title', 'Trang chủ')

@section('content')
    <section class="container mt-4 mb-grid-gutter rounded-3 shadow-lg bg-body-secondary"> 
        <div class="rounded-3 py-3 px-4 px-sm-2"> 
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
    <style>
        .hover-shadow { 
            transition: box-shadow 0.3s ease-in-out; 
        }
        .hover-shadow:hover { 
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2) !important; 
        }
        .card-body .badge-custom { 
            background-color: #2563eb; /* Base blue color */
            color: #ffffff; /* White text for contrast */
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            text-decoration: none;
            padding: 0.4em 0.8em;
            border-radius: 0.25rem;
        }
        .card-body .badge-custom:hover { 
            background-color: #1e40af !important; /* Darker blue on hover */
            transform: scale(1.05); /* Slight scale effect */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important; /* Subtle shadow */
            color: #ffffff !important; /* Ensure text stays white */
        }
    </style>
    <section class="container mt-4 mb-grid-gutter rounded-3 shadow-lg"> 
        <div class="rounded-3 py-1 px-4 px-sm-1"> 
            <div class="row align-items-center"> 
                <h2 class="h4 text-light mt-5 mb-4 text-dark text-center">Bài đăng mới nhất</h2>
                <div class="d-flex justify-content-end mt-4">
                    {{ $baiviet->links() }}
                </div>
                <div class="row pt-2 mx-n2 d-flex flex-wrap">
                    @php
                        function LayHinhDauTien($strNoiDung) { 
                            $first_img = ''; 
                            if (preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $strNoiDung, $matches)) {
                                $first_img = str_replace('&', '&', $matches[1]);
                            }
                            return $first_img ?: asset('public/img/noimage.jpg'); 
                        } 
                    @endphp
                    @foreach($baiviet as $bv)
                        <div class="col-lg-4 col-md-6 col-sm-12 px-2 mb-4"> 
                            <div class="card shadow-sm border-0 hover-shadow"> 
                                <a class="card-img-top d-block overflow-hidden" 
                                    href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chudes->first()->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                                    <img src="{{ LayHinhDauTien($bv->noidung) }}" 
                                        style="width: 100%; height: 200px; object-fit: cover;" 
                                        alt="Hình minh họa bài viết" />
                                </a> 
                                <div class="card-body py-3 "> 
                                    <div class="mb-2">
                                        @foreach($bv->chudes as $chude)
                                            <a class="badge badge-custom me-1 text-decoration-none" href="{{ route('frontend.baiviet.chude', ['tenchude_slug' => $chude->tenchude_slug]) }}">
                                                {{ $chude->tenchude }}
                                            </a>
                                        @endforeach
                                    </div>
                                    <h5 class="card-title text-dark blog-entry-title"> 
                                        <a href="{{ route('frontend.baiviet.chitiet', ['tenchude_slug' => $bv->chudes->first()->tenchude_slug, 'tieude_slug' => $bv->tieude_slug]) }}">
                                            {{ Str::limit($bv->tieude, 100)  }}
                                        </a> 
                                    </h5> 
                                    <p class="card-text text-muted small">{{ Str::limit($bv->tomtat, 100) }}</p>
                                </div> 
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center"> 
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $bv->NguoiDung->name ?? 'Ẩn danh' }} 
                                        | <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($bv->created_at)->format('d/m/Y H:i') }} 
                                        | <i class="fas fa-eye"></i> {{ $bv->luotxem }}
                                    </small>  
                                    <div>
                                        @auth
                                            <button class="btn btn-outline-primary btn-sm save-post" data-id="{{ $bv->id }}">
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
                        </div> 
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $baiviet->links() }}
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let buttons = document.querySelectorAll(".save-post");
                buttons.forEach((btn) => {
                    btn.onclick = function () {
                        let postId = this.dataset.id;
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
@endsection