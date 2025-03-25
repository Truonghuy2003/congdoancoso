@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Sửa thông tin tệp</div>
    <div class="card-body">
        <form action="{{ route('admin.file.sua', $file->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label class="form-label" for="baiviet_id">Liên kết với bài viết (tùy chọn)</label>
                <select class="form-select @error('baiviet_id') is-invalid @enderror" id="baiviet_id" name="baiviet_id">
                    <option value="">-- Không liên kết --</option>
                    @foreach($baiviet as $bv)
                        <option value="{{ $bv->id }}" {{ $file->baiviet_id == $bv->id ? 'selected' : '' }}>{{ $bv->tieude }}</option>
                    @endforeach
                </select>
                @error('baiviet_id')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tệp hiện tại</label>
                <div class="mb-2">
                    <a href="{{ route('tai-tep', $file->id) }}" class="text-decoration-none">
                        <i class="fas fa-file"></i> {{ $file->ten_goc ?? basename($file->duong_dan_file) }}
                    </a>
                    <br><small>Loại tệp: {{ $file->loai_file }}</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="tep">Thay thế tệp (tùy chọn, tối đa 10MB, định dạng: jpg, png, pdf, txt)</label>
                <input type="file" class="form-control @error('tep') is-invalid @enderror" id="tep" name="tep" />
                @error('tep')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật tệp</button>
        </form>
    </div>
</div>
@endsection