@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header fw-bold">Trang chủ</div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div style="background-color: #dff0d8; border: 1px solid #d6e9c6; padding: 15px; border-radius: 5px;">
            <p>
                <strong>
                Đây là trang chủ cho quản trị viên <br>
                Nếu cần hỗ trợ kỹ thuật, quý khách vui lòng thực hiện một trong những cách sau:
                </strong>
            </p>
            <ol>
                <li>Truy cập: <a href="#" target="_blank">vanhuy382003@gmail.com</a> và gửi yêu cầu hỗ trợ.</li>
                <li>Gửi email cho phòng kỹ thuật: <a href="mailto:vanhuy382003@gmail.com">kythuat@congdoan.agu.vn</a>.</li>
                <li>Liên kết MXH: <a href="https://www.facebook.com/van.huy.870768/">Facebook</a>, <a href="https://www.instagram.com/vhuy3aug_/profilecard/">Instagram</a></li>
                <li>Gọi số Hotline Hỗ Trợ Khách Hàng: <strong>0366652716</strong>.</li>
                <li>Hoặc đến địa chỉ số 18 Ung Văn Khiêm TPLX AG.</li>
            </ol>
        </div>
        <div class=" mt-3">
            <a href="{{ route('frontend.home') }}" class="btn btn-primary">
                <i class="fas fa-home me-2"></i> Về trang chủ
            </a>
        </div>
    </div>
</div>
@endsection