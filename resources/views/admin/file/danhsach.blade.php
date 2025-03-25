@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header fw-bold">Quản lý tệp</div>
    <div class="card-body table-responsive">
        <p><a href="{{ route('admin.file.them') }}" class="btn btn-info"><i class="fas fa-plus"></i> Thêm tệp mới</a></p>
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Tên tệp</th>
                    <th width="20%">Loại tệp</th>
                    <th width="20%">Bài viết liên kết</th>
                    <th width="15%">Người upload</th>
                    <th width="20%" colspan="2" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('tai-tep', $file->id) }}" class="text-decoration-none">
                            <i class="fas fa-file"></i> {{ $file->ten_goc ?? basename($file->duong_dan_file) }}
                        </a>
                    </td>
                    <td>{{ $file->loai_file }}</td>
                    <td>
                        @if($file->baiviet)
                            <a href="{{ route('admin.baiviet.sua', $file->baiviet->id) }}">{{ $file->baiviet->tieude }}</a>
                        @else
                            <span class="text-muted">Không liên kết</span>
                        @endif
                    </td>
                    <td>{{ $file->nguoidung->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.file.sua', $file->id) }}" title="Sửa">
                            <i class="fas fa-edit fa-lg text-primary"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.file.xoa', $file->id) }}" onclick="return confirm('Bạn có muốn xóa tệp {{ $file->ten_goc ?? basename($file->duong_dan_file) }} không?')" title="Xóa">
                            <i class="fas fa-trash-alt fa-lg text-danger"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Không có tệp nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection