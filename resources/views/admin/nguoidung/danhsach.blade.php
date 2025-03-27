@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header fw-bold">Người dùng</div>
        <div class="card-body">
            <p><a href="{{route('admin.nguoidung.them')}}" class="btn btn-info"><i class="fa-light fas fa-plus"></i> Thêm mới</a></p>

            <!-- Phân loại theo role -->
            @foreach(['admin' => 'Quản trị viên (Admin)', 'giaovien' => 'Giáo viên', 'user' => 'Người dùng'] as $role => $roleLabel)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center toggle-collapse-header" data-bs-toggle="collapse" data-bs-target="#{{ $role }}Collapse" aria-expanded="false" aria-controls="{{ $role }}Collapse">
                        <span>{{ $roleLabel }}</span>
                        <button class="btn btn-link p-0 toggle-collapse" type="button">
                            <i class="fas fa-chevron-down fa-lg"></i>
                        </button>
                    </div>
                    <div class="collapse" id="{{ $role }}Collapse">
                        <div class="card-body table-responsive custom-table-responsive">
                            <table class="table table-bordered table-hover table-sm mb-0 responsive-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Họ và tên</th>
                                        <th width="20%">Tên đăng nhập</th>
                                        <th width="35%">Email</th>
                                        <th width="10%">Quyền hạn</th>
                                        <th width="5%">Sửa</th>
                                        <th width="5%">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $index = 1; @endphp
                                    @foreach ($nguoidung as $value)
                                        @if ($value->role === $role)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->username }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->role }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.nguoidung.sua', ['id' => $value->id]) }}">
                                                        <i class="fa-light fas fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.nguoidung.xoa', ['id' => $value->id]) }}"
                                                       onclick="return confirm('Bạn có muốn xóa {{ $value->name }} không?')">
                                                        <i class="fa-light fas fa-trash-alt text-danger"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Xử lý trạng thái collapse cho từng role
        @foreach(['admin', 'giaovien', 'user'] as $role)
            const {{ $role }}CollapseElement = document.querySelector('#{{ $role }}Collapse');
            const {{ $role }}ToggleButton = document.querySelector('#{{ $role }}Collapse').closest('.card').querySelector('.toggle-collapse i');

            // Kiểm tra trạng thái ban đầu từ sessionStorage
            if (sessionStorage.getItem('{{ $role }}Collapse') === 'open') {
                {{ $role }}CollapseElement.classList.add('show');
                {{ $role }}ToggleButton.classList.remove('fa-chevron-down');
                {{ $role }}ToggleButton.classList.add('fa-chevron-up');
            }

            // Lắng nghe sự kiện khi collapse mở
            {{ $role }}CollapseElement.addEventListener('shown.bs.collapse', function () {
                sessionStorage.setItem('{{ $role }}Collapse', 'open');
                {{ $role }}ToggleButton.classList.remove('fa-chevron-down');
                {{ $role }}ToggleButton.classList.add('fa-chevron-up');
            });

            // Lắng nghe sự kiện khi collapse đóng
            {{ $role }}CollapseElement.addEventListener('hidden.bs.collapse', function () {
                sessionStorage.removeItem('{{ $role }}Collapse');
                {{ $role }}ToggleButton.classList.remove('fa-chevron-up');
                {{ $role }}ToggleButton.classList.add('fa-chevron-down');
            });
        @endforeach

        // Xử lý sự kiện click trên button để không lan ra header
        document.querySelectorAll('.toggle-collapse').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation(); // Ngăn chặn sự kiện click lan ra card-header
                const collapseTarget = this.closest('.card-header').getAttribute('data-bs-target');
                const collapseElement = document.querySelector(collapseTarget);
                const bsCollapse = new bootstrap.Collapse(collapseElement, {
                    toggle: true
                });
            });
        });
    });
</script>

<style>
    .toggle-collapse i {
        transition: transform 0.3s ease-in-out, color 0.3s ease-in-out, text-shadow 0.3s ease-in-out;
        font-size: 1.2rem;
    }

    .toggle-collapse i:hover {
        color: #ff9800;
        text-shadow: 0px 0px 10px rgba(255, 152, 0, 0.8);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        cursor: pointer;
    }

    .card-header:hover {
        background-color: #e9ecef;
    }

    /* Đảm bảo bảng có thể cuộn ngang trên thiết bị di động */
    .custom-table-responsive {
        display: block !important;
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch; /* Hỗ trợ cuộn mượt trên iOS */
    }

    .responsive-table {
        min-width: 1200px !important; /* Tăng chiều rộng tối thiểu để buộc xuất hiện thanh cuộn ngang */
    }

    /* Đảm bảo các cột không bị co lại quá nhỏ trên thiết bị di động */
    .responsive-table th,
    .responsive-table td {
        white-space: nowrap; /* Ngăn văn bản xuống dòng */
        padding: 8px !important; /* Đảm bảo padding hợp lý */
    }

    /* Media query để kiểm tra trên thiết bị di động */
    @media (max-width: 768px) {
        .custom-table-responsive {
            overflow-x: auto !important;
        }

        .responsive-table {
            min-width: 1200px !important;
        }
    }
</style>
@endsection