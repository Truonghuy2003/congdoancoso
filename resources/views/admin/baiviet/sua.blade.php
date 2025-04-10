@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Sửa bài viết</div>
    <div class="card-body">
        <form action="{{ route('admin.baiviet.sua', ['id' => $baiviet->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
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
                                           {{ $baiviet->chudes->contains('id', $value->id) ? 'checked' : '' }}>
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