@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Thêm tệp mới</div>
    <div class="card-body">
        <form action="{{ route('admin.file.them') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="baiviet_id">Liên kết với bài viết (tùy chọn)</label>
                <select class="form-select @error('baiviet_id') is-invalid @enderror" id="baiviet_id" name="baiviet_id">
                    <option value="">-- Không liên kết --</option>
                    @foreach($baiviet as $bv)
                        <option value="{{ $bv->id }}">{{ $bv->tieude }}</option>
                    @endforeach
                </select>
                @error('baiviet_id')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="tep">Chọn tệp (tối đa 10MB, định dạng: jpg, png, pdf, txt)</label>
                <input type="file" class="form-control @error('tep') is-invalid @enderror" id="tep" name="tep" required />
                @error('tep')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Thêm tệp</button>
        </form>
    </div>
</div>
@endsection