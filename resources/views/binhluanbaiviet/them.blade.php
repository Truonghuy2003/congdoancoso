@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Thêm bình luận bài viết</div>
    <div class="card-body">
        <form action="{{ route('binhluanbaiviet.them') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="baiviet_id">Bài viết</label>
                <select class="form-select @error('baiviet_id') is-invalid @enderror" id="baiviet_id" name="baiviet_id" required>
                    <option value="">-- Chọn --</option>
                    @foreach($baiviet as $value)
                    <option value="{{ $value->id }}">{{ $value->tieude }}</option>
                    @endforeach
                </select>
                @error('baiviet_id')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="noidungbinhluan">Nội dung bình luận</label>
                <textarea class="form-control" id="noidungbinhluan" name="noidungbinhluan" >{{ old('noidungbinhluan') }}</textarea>
                @error('noidungbinhluan')
                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-light fa-save"></i> Thêm vào CSDL</button>
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
    ClassicEditor.create(document.querySelector('#noidungbinhluan'), {
        licenseKey: '',
    }).then(editor => {
        window.editor = editor;
    }).catch(error => {
        console.error(error);
    });
</script>
@endsection