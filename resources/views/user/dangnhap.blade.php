@extends('layouts.frontend')
@section('title', 'Đăng nhập')
@section('content')
<div class="container py-4 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h4 mb-1 text-center">Đăng nhập</h2>
                    <div class="py-0">
                        <h3 class="d-inline-block align-middle fs-base fw-medium mb-2 me-2">Đăng nhập với:</h3>
                        <div class="d-inline-block align-middle">
                            <a class="btn-social bs-google me-2 mb-2" href="{{ route('google.login') }}" data-bs-toggle="tooltip" title="Đăng nhập với Google">
                                <i class="fab fa-google"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <h3 class="fs-base pt-4 pb-2 ms-3 ">Hoặc sử dụng thông tin đã có</h3>
                <form method="post" action="{{ route('login') }}" class="needs-validation" novalidate>
                    @csrf
                    @if(session('warning'))
                    <div class="alert alert-danger fs-base" role="alert">
                        <i class="ci-close-circle me-2"></i>{{ session('warning') }}
                    </div>
                    @endif
                    @if($errors->has('email') || $errors->has('username'))
                    <div class="alert alert-danger fs-base" role="alert">
                        <i class="ci-close-circle me-2"></i>{{ empty($errors->first('email')) ? $errors->first('username') : $errors->first('email') }}
                    </div>
                    @endif
                    <div class="input-group mb-3 mx-auto"style="max-width: 600px;">
                        <i class="fas fa-user position-absolute top-50 translate-middle-y text-muted fs-base ms-3 "></i>
                        <input type="text" class="form-control rounded-start {{ ($errors->has('email') || $errors->has('username')) ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                    </div>
                    <div class="input-group mb-3 mx-auto" style="max-width: 600px;">
                        <i class="fas fa-lock position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                        <div class="password-toggle w-100 position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Mật khẩu" required />
                            <span class="position-absolute end-0 top-50 translate-middle-y me-3 cursor-pointer" 
                                  onclick="togglePassword()">
                                <i id="togglePasswordIcon" class="fas fa-eye-slash text-muted"></i>
                            </span>
                        </div>
                    </div>
                    
                    <script>
                        function togglePassword() {
                            let passwordInput = document.getElementById("password");
                            let icon = document.getElementById("togglePasswordIcon");
                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                                icon.classList.remove("fa-eye-slash");
                                icon.classList.add("fa-eye");
                            } else {
                                passwordInput.type = "password";
                                icon.classList.remove("fa-eye");
                                icon.classList.add("fa-eye-slash");
                            }
                        }
                    </script>                    
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input ms-2" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                            <label class="form-check-label ms-2" for="remember">Duy trì đăng nhập</label>
                        </div>
                        @if (Route::has('register'))
                        <a class="nav-link-inline fs-sm" href="{{ route('user.dangky') }}">Chưa có tài khoản?</a>
                        @endif
                        @if (Route::has('password.request'))
                        <a class="nav-link-inline fs-sm me-4" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        @endif
                    </div>
                    <hr class="mt-4">
                    <div class="text-end pt-4">
                        <button class="btn btn-primary " type="submit"><i class="fas fa-sign-in-alt"></i> Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection