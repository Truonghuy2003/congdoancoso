@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header fw-bold">Bình luận bài viết</div>
    <div class="card-body table-responsive">
        <p><a href="{{ route('admin.binhluanbaiviet.them') }}" class="btn btn-info"><i class="fa-light fas fa-plus"></i> Thêm mới</a></p>
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Người đăng</th>
                    <th width="65%">Thông tin bình luận</th>
                    <th width="20%" colspan="4" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($binhluanmoinhat as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->NguoiDung->name }}</td>
                        <td style="text-align:justify">
                            <span class="d-block fw-bold text-primary ">
                                <a href="{{ route('admin.binhluanbaiviet.sua', ['id' => $value->id]) }}">{{ $value->BaiViet->tieude }}</a>
                                <button class="btn btn-link p-0 toggle-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $value->baiviet_id }}" aria-expanded="false" aria-controls="collapse{{ $value->baiviet_id }}">
                                    <i class="fas fa-chevron-down fa-lg ms-2"></i>
                                </button>
                            </span>
                            <span class="d-block small">
                                Ngày đăng: <strong>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y H:i:s') }}</strong>
                                <br />Nội dung bình luận: <strong>{{ $value->noidungbinhluan }}</strong>
                            </span>
                        </td>
                        <td class="text-center" title="Trạng thái kiểm duyệt">
                            <a href="{{ route('admin.binhluanbaiviet.kiemduyet', ['id' => $value->id]) }}">
                                @if($value->kiemduyet == 1)
                                <i class="fa-light fa-lg fas fa-circle-check text-success"></i>
                                @else
                                <i class="fa-light fa-lg fas fa-circle-xmark text-danger"></i>
                                @endif
                            </a>
                        </td>
                        <td class="text-center" title="Trạng thái hiển thị">
                            <a href="{{ route('admin.binhluanbaiviet.kichhoat', ['id' => $value->id]) }}">
                                @if($value->kichhoat == 1)
                                <i class="fa-light fa-lg fas fa-eye text-success"></i>
                                @else
                                <i class="fa-light fa-lg fas fa-eye-slash text-danger"></i>
                                @endif
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin.binhluanbaiviet.sua', ['id' => $value->id]) }}">
                                <i class="fa-light fa-lg fas fa-edit text-primary"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.binhluanbaiviet.xoa', ['id' => $value->id]) }}" onclick="return confirm('Bạn có muốn xóa bình luận của bài viết {{ $value->BaiViet->tieude }} không?')">
                                <i class="fa-light fa-lg fas fa-trash-alt text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    <!-- Danh sách bình luận mở rộng -->
                    <tr>
                        <td colspan="7" class="p-0">
                            <div class="collapse" id="collapse{{ $value->baiviet_id }}">
                                <div class="card card-body mt-2">
                                    <div class="text-end mb-2">
                                        <button class="btn btn-link p-0 toggle-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $value->baiviet_id }}" aria-expanded="true" aria-controls="collapse{{ $value->baiviet_id }}">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <h4>Các bình luận khác cùng bài viết</h4>
                                            <tr>
                                                <th width="15%">Người đăng</th>
                                                <th width="15%">Ngày đăng</th>
                                                <th width="30%">Nội dung</th>
                                                <th width="10%" class="text-center">Kiểm duyệt</th>
                                                <th width="10%" class="text-center">Kích hoạt</th>
                                                <th width="10%" class="text-center">Sửa</th>
                                                <th width="10%" class="text-center">Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tatcabinhluan->where('baiviet_id', $value->baiviet_id) as $bl)
                                                @if($bl->id != $value->id)
                                                    <tr>
                                                        <td>{{ $bl->NguoiDung->name }}</td>
                                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bl->created_at)->format('d/m/Y H:i:s') }}</td>
                                                        <td>{{ $bl->noidungbinhluan }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.binhluanbaiviet.kiemduyet', ['id' => $bl->id]) }}" title="Trạng thái kiểm duyệt">
                                                                @if($bl->kiemduyet == 1)
                                                                <i class="fa-light fa-lg fas fa-circle-check text-success"></i>
                                                                @else
                                                                <i class="fa-light fa-lg fas fa-circle-xmark text-danger"></i>
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.binhluanbaiviet.kichhoat', ['id' => $bl->id]) }}" title="Trạng thái hiển thị">
                                                                @if($bl->kichhoat == 1)
                                                                <i class="fa-light fa-lg fas fa-eye text-success"></i>
                                                                @else
                                                                <i class="fa-light fa-lg fas fa-eye-slash text-danger"></i>
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.binhluanbaiviet.sua', ['id' => $bl->id]) }}" class="text-primary" title="Sửa">
                                                                <i class="fa-light fa-lg fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.binhluanbaiviet.xoa', ['id' => $bl->id]) }}" class="text-danger" onclick="return confirm('Bạn có muốn xóa bình luận này không?')" title="Xóa">
                                                                <i class="fa-light fa-lg fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Nếu trang được reload (F5, Ctrl+R), thì xóa sessionStorage
                        if (performance.navigation.type === 1) {
                            sessionStorage.clear();
                        }
                
                        document.querySelectorAll('.toggle-collapse').forEach(button => {
                            let targetId = button.getAttribute('data-bs-target');
                            let collapseElement = document.querySelector(targetId);
                
                            // Kiểm tra nếu đã lưu trạng thái mở, thì mở lại collapse và đổi icon
                            if (sessionStorage.getItem(targetId) === 'open') {
                                collapseElement.classList.add('show');
                                let icon = button.querySelector('i');
                                icon.classList.remove('fa-chevron-down');
                                icon.classList.add('fa-chevron-up');
                            }
                
                            // Lắng nghe sự kiện khi collapse thay đổi trạng thái
                            collapseElement.addEventListener('shown.bs.collapse', function () {
                                sessionStorage.setItem(targetId, 'open');
                                let icon = button.querySelector('i');
                                icon.classList.remove('fa-chevron-down');
                                icon.classList.add('fa-chevron-up');
                            });
                
                            collapseElement.addEventListener('hidden.bs.collapse', function () {
                                sessionStorage.removeItem(targetId);
                                let icon = button.querySelector('i');
                                icon.classList.remove('fa-chevron-up');
                                icon.classList.add('fa-chevron-down');
                            });
                        });
                    });
                </script> 
                <style>
                    .toggle-collapse i {
                        transition: transform 0.3s ease-in-out, color 0.3s ease-in-out, text-shadow 0.3s ease-in-out;
                        font-size: 1.2rem; /* Kích thước icon */
                    }
                
                    /* Hiệu ứng khi hover */
                    .toggle-collapse i:hover {
                        color: #ff9800;  /* Đổi màu cam nổi bật */
                        text-shadow: 0px 0px 10px rgba(255, 152, 0, 0.8); /* Hiệu ứng phát sáng */
                    }
                    
                </style>
            </tbody>
        </table>
    </div>  
</div>
@endsection