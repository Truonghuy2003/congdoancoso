@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Thêm bài viết</div>
    <div class="card-body">
        <form action="{{ route('admin.baiviet.them') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="chude_id">Chủ đề</label>
                <select class="form-select @error('chude_id') is-invalid @enderror" id="chude_id" name="chude_id" required>
                    <option value="">-- Chọn --</option>
                    @foreach($chude as $value)
                    <option value="{{ $value->id }}">{{ $value->tenchude }}</option>
                    @endforeach
                </select>
                @error('chude_id')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="tieude">Tiêu đề</label>
                <input type="text" class="form-control @error('tieude') is-invalid @enderror" id="tieude" name="tieude" value="{{ old('tieude') }}" required />
                @error('tieude')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="tomtat">Tóm tắt</label>
                <textarea class="form-control" id="tomtat" name="tomtat">{{ old('tomtat') }}</textarea>
                @error('tomtat')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="noidung">Nội dung bài viết</label>
                {{--<textarea class="form-control" id="noidung" name="noidung" required>{{ old('noidung') }}</textarea>--}}
                <textarea class="form-control" id="noidung" name="noidung">{{ old('noidung') }}</textarea>
                @error('noidung')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
            <!-- Thêm vào trước nút submit -->
            <div class="mb-3">
                <label class="form-label" for="tep">Đính kèm tệp (tùy chọn)</label>
                <input type="file" class="form-control @error('tep') is-invalid @enderror" id="tep" name="tep" />
                @error('tep')
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