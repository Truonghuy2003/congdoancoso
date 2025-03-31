@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header fw-bold">Danh sách Ban Chấp Hành</div>
    <div class="card-body table-responsive">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <p><a href="{{ route('admin.banchaphanh.them') }}" class="btn btn-info"><i class="fa-light fas fa-plus"></i> Thêm mới</a></p>

        <!-- Hiển thị danh sách theo ten_phong_ban -->
        @foreach($thanhvien as $ten_phong_ban => $members)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center toggle-collapse-header" 
                     data-bs-toggle="collapse" 
                     data-bs-target="#phongBan{{ md5($ten_phong_ban) }}" 
                     aria-expanded="false" 
                     aria-controls="phongBan{{ md5($ten_phong_ban) }}">
                    <span>{{ $ten_phong_ban }}</span>
                    <button class="btn btn-link p-0 toggle-collapse" type="button">
                        <i class="fas fa-chevron-down fa-lg"></i>
                    </button>
                </div>
                <div class="collapse" id="phongBan{{ md5($ten_phong_ban) }}">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Họ tên</th>
                                    <th width="10%">Chức vụ</th>
                                    <th width="10%">Email</th>
                                    <th width="20%">Điện thoại</th>
                                    <th width="5%">Nhiệm kỳ</th>
                                    <th width="15%" colspan="2" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->ho_ten }}</td>
                                    <td>{{ $value->chuc_vu }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->dien_thoai ?? 'N/A' }}</td>
                                    <td>{{ $value->nhiem_ky }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.banchaphanh.sua', $value->id) }}">
                                            <i class="fa-light fa-lg fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.banchaphanh.xoa', $value->id) }}" 
                                           onclick="return confirm('Bạn có muốn xóa thành viên {{ $value->ho_ten }} không?')">
                                            <i class="fa-light fa-lg fas fa-trash-alt text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .toggle-collapse i {
        transition: transform 0.3s ease-in-out;
        font-size: 1.2rem;
    }
    .toggle-collapse i.fa-chevron-up {
        transform: rotate(180deg);
    }
    .card-header {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .card-header:hover {
        background-color: #e9ecef;
    }
</style>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-collapse').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const collapseTarget = this.closest('.card-header').getAttribute('data-bs-target');
                const collapseElement = document.querySelector(collapseTarget);
                const icon = this.querySelector('i');
                const bsCollapse = new bootstrap.Collapse(collapseElement, {
                    toggle: true
                });
                collapseElement.addEventListener('shown.bs.collapse', () => {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                });
                collapseElement.addEventListener('hidden.bs.collapse', () => {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                });
            });
        });
    });
</script>
@endsection
@endsection