@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Thêm Thành viên Ban Chấp hành</div>
    <div class="card-body">
        <form action="{{ route('admin.banchaphanh.them') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="ho_ten">Họ tên</label>
                <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" id="ho_ten" name="ho_ten" value="{{ old('ho_ten') }}" required />
                @error('ho_ten')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="ten_phong_ban">Tên phòng ban</label>
                <input type="text" class="form-control @error('ten_phong_ban') is-invalid @enderror" id="ten_phong_ban" name="ten_phong_ban" value="{{ old('ten_phong_ban') }}" required />
                @error('ten_phong_ban')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="chuc_vu">Chức vụ</label>
                <input type="text" class="form-control @error('chuc_vu') is-invalid @enderror" id="chuc_vu" name="chuc_vu" value="{{ old('chuc_vu') }}" required />
                @error('chuc_vu')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required />
                @error('email')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="dien_thoai">Điện thoại</label>
                <input type="text" class="form-control @error('dien_thoai') is-invalid @enderror" id="dien_thoai" name="dien_thoai" value="{{ old('dien_thoai') }}" />
                @error('dien_thoai')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="anh_dai_dien">Ảnh đại diện</label>
                <input type="file" class="form-control @error('anh_dai_dien') is-invalid @enderror" id="anh_dai_dien" name="anh_dai_dien" />
                @error('anh_dai_dien')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nhiem_vu">Nhiệm vụ</label>
                <textarea class="form-control @error('nhiem_vu') is-invalid @enderror" id="nhiem_vu" name="nhiem_vu">{{ old('nhiem_vu') }}</textarea>
                @error('nhiem_vu')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nhiem_ky">Nhiệm kỳ</label>
                <input type="text" class="form-control @error('nhiem_ky') is-invalid @enderror" id="nhiem_ky" name="nhiem_ky" value="{{ old('nhiem_ky') }}" required />
                @error('nhiem_ky')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa-light fas fa-save"></i> Thêm vào CSDL</button>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection