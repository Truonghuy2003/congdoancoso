@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Sửa Thành viên Ban Chấp hành</div>
    <div class="card-body">
        <form action="{{ route('admin.banchaphanh.sua', $thanhvien->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="ho_ten">Họ tên</label>
                <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" id="ho_ten" name="ho_ten" value="{{ $thanhvien->ho_ten }}" required />
                @error('ho_ten')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="ten_phong_ban">Tên phòng ban</label>
                <input type="text" class="form-control @error('ten_phong_ban') is-invalid @enderror" id="ten_phong_ban" name="ten_phong_ban" value="{{ $thanhvien->ten_phong_ban }}" required />
                @error('ten_phong_ban')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="chuc_vu">Chức vụ</label>
                <input type="text" class="form-control @error('chuc_vu') is-invalid @enderror" id="chuc_vu" name="chuc_vu" value="{{ $thanhvien->chuc_vu }}" required />
                @error('chuc_vu')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $thanhvien->email }}" required />
                @error('email')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="dien_thoai">Điện thoại</label>
                <input type="text" class="form-control @error('dien_thoai') is-invalid @enderror" id="dien_thoai" name="dien_thoai" value="{{ $thanhvien->dien_thoai }}" />
                @error('dien_thoai')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="anh_dai_dien">Ảnh đại diện</label>
                @if($thanhvien->anh_dai_dien)
                    <div class="mb-2">
                        <strong>Ảnh hiện tại:</strong>
                        <img src="{{ Storage::url($thanhvien->anh_dai_dien) }}" alt="{{ $thanhvien->ho_ten }}" width="100">
                    </div>
                @endif
                <input type="file" class="form-control @error('anh_dai_dien') is-invalid @enderror" id="anh_dai_dien" name="anh_dai_dien" />
                @error('anh_dai_dien')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nhiem_vu">Nhiệm vụ</label>
                <textarea class="form-control @error('nhiem_vu') is-invalid @enderror" id="nhiem_vu" name="nhiem_vu">{{ $thanhvien->nhiem_vu }}</textarea>
                @error('nhiem_vu')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nhiem_ky">Nhiệm kỳ</label>
                <input type="text" class="form-control @error('nhiem_ky') is-invalid @enderror" id="nhiem_ky" name="nhiem_ky" value="{{ $thanhvien->nhiem_ky }}" required />
                @error('nhiem_ky')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa-light fas fa-save"></i> Cập nhật</button>
        </form>
    </div>
</div>
@endsection