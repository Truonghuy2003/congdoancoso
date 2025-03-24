@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Sửa bài viết</div>
    <div class="card-body">
        <form action="{{ route('admin.baiviet.sua', ['id' => $baiviet->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST') <!-- Thêm @method('POST') vì route sửa dùng POST -->
            <div class="mb-3">
                <label class="form-label" for="chude_id">Chủ đề</label>
                <select class="form-select @error('chude_id') is-invalid @enderror" id="chude_id" name="chude_id" required>
                    <option value="">-- Chọn --</option>
                    @foreach($chude as $value)
                    <option value="{{ $value->id }}" {{ ($baiviet->chude_id == $value->id) ? 'selected' : '' }}>{{ $value->tenchude }}</option>
                    @endforeach
                </select>
                @error('chude_id')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="tieude">Tiêu đề</label>
                <input type="text" class="form-control @error('tieude') is-invalid @enderror" id="tieude" name="tieude" value="{{ $baiviet->tieude }}" required />
                @error('tieude')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="tomtat">Tóm tắt</label>
                <textarea class="form-control @error('tomtat') is-invalid @enderror" id="tomtat" name="tomtat">{{ $baiviet->tomtat }}</textarea>
                @error('tomtat')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="noidung">Nội dung bài viết</label>
                <textarea class="form-control @error('noidung') is-invalid @enderror" id="noidung" name="noidung" required>{{ $baiviet->noidung }}</textarea>
                @error('noidung')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <!-- Hiển thị tệp hiện tại và tùy chọn xóa -->
            <div class="mb-3">
                <label class="form-label" for="tep">Đính kèm tệp (tùy chọn)</label>
                @if($baiviet->file->isNotEmpty())
                    <div class="mb-2">
                        <strong>Tệp hiện tại:</strong>
                        <a href="{{ route('tai-tep', $baiviet->file->first()->id) }}" class="text-decoration-none">
                            <i class="fas fa-file"></i> {{ $baiviet->file->first()->ten_goc ?? basename($baiviet->file->first()->duong_dan_file) }}
                        </a>
                        <div class="form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="xoa_tep" name="xoa_tep" value="1">
                            <label class="form-check-label" for="xoa_tep">Xóa tệp hiện tại</label>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control @error('tep') is-invalid @enderror" id="tep" name="tep" />
                @error('tep')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-light fas fa-save"></i> Cập nhật</button>
        </form>
    </div>
</div>
@endsection
@section('javascript')
<script>
    ClassicEditor.create(document.querySelector('#noidung'), {
        licenseKey: '',
    }).then(editor => {
        window.editor = editor;
    }).catch(error => {
        console.error(error);
    });
</script>
@endsection