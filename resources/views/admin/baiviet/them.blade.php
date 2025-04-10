@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Thêm bài viết</div>
    <div class="card-body">
        <form action="{{ route('admin.baiviet.them') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="chude_ids">Chủ đề</label>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start @error('chude_ids') is-invalid @enderror" 
                            type="button" 
                            id="dropdownChude" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        Chọn chủ đề
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownChude" style="max-height: 200px; overflow-y: auto;">
                        @foreach($chude as $value)
                            <li>
                                <div class="form-check px-3 ms-3">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="chude_{{ $value->id }}" 
                                           name="chude_ids[]" 
                                           value="{{ $value->id }}" 
                                           {{ in_array($value->id, old('chude_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="chude_{{ $value->id }}">{{ $value->tenchude }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @error('chude_ids')
                    <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
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
                <textarea class="form-control" id="noidung" name="noidung">{{ old('noidung') }}</textarea>
                @error('noidung')
                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                @enderror
            </div>

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

    // Tùy chỉnh hiển thị nút dropdown dựa trên các checkbox được chọn
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.getElementById('dropdownChude');
        const checkboxes = document.querySelectorAll('input[name="chude_ids[]"]');
        
        function updateButtonText() {
            const selected = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.nextElementSibling.textContent.trim());
            dropdownButton.textContent = selected.length > 0 ? selected.join(', ') : 'Chọn chủ đề';
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateButtonText);
        });

        updateButtonText(); // Cập nhật lần đầu khi tải trang
    });
</script>
@endsection