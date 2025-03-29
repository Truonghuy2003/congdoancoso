@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Thống kê</h1>
        <form method="GET" action="{{ route('admin.thongke') }}" class="d-flex align-items-center">
            <label for="year" class="me-2">Chọn năm:</label>
            <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-newspaper me-2"></i>Tổng bài viết</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\Baiviet::count() }}">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-comments me-2"></i>Tổng bình luận</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\Binh_luan_bai_viet::count() }}">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning"><i class="fas fa-eye me-2"></i>Tổng lượt xem</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\Baiviet::sum('luotxem') }}">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info"><i class="fas fa-file me-2"></i>Tổng file</h5>
                    <p class="card-text display-4 counter" data-target="{{ \App\Models\File::count() }}">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Bài viết theo tháng ({{ $year }})</div>
                <div class="card-body">
                    <canvas id="postsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Bình luận theo tháng ({{ $year }})</div>
                <div class="card-body">
                    <canvas id="commentsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê theo tài khoản quản trị (admin và giaovien) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Thống kê theo tài khoản quản trị</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Tên người dùng</th>
                                <th width="15%">Vai trò</th>
                                <th width="20%">Số bài viết</th>
                                <th width="20%">Số bình luận</th>
                                <th width="20%">Số file</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adminStats as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['role'] }}</td>
                                    <td>{{ $user['post_count'] }}</td>
                                    <td>{{ $user['comment_count'] }}</td>
                                    <td>{{ $user['file_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê theo người dùng (role user) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Thống kê theo người dùng</span>
                    <button class="btn btn-link p-0 toggle-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#userStatsCollapse" aria-expanded="false" aria-controls="userStatsCollapse">
                        <i class="fas fa-chevron-down fa-lg"></i>
                    </button>
                </div>
                <div class="collapse" id="userStatsCollapse">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Tên người dùng</th>
                                    <th width="30%">Vai trò</th>
                                    <th width="35%">Số bình luận</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userStats as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['role'] }}</td>
                                        <td>{{ $user['comment_count'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Hiệu ứng đếm số
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('.counter');
        const speed = 50; // Tốc độ đếm (càng nhỏ càng nhanh)

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;

                // Tính bước tăng
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        });
    });
    // JavaScript cho biểu đồ
    const postsCtx = document.getElementById('postsChart').getContext('2d');
    new Chart(postsCtx, {
        type: 'bar',
        data: {
            labels: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
            datasets: [{
                label: 'Số bài viết',
                data: @json(array_values($monthlyPosts)),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            return label + ' bài viết trong tháng ' + context.label;
                        }
                    }
                }
            }
        }
    });

    const commentsCtx = document.getElementById('commentsChart').getContext('2d');
    new Chart(commentsCtx, {
        type: 'bar',
        data: {
            labels: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
            datasets: [{
                label: 'Số bình luận',
                data: @json(array_values($monthlyComments)),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            return label + ' bình luận trong tháng ' + context.label;
                        }
                    }
                }
            }
        }
    });

    // JavaScript cho collapse
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.querySelector('.toggle-collapse');
        const collapseElement = document.querySelector('#userStatsCollapse');

        // Kiểm tra trạng thái ban đầu (mặc định đóng)
        if (sessionStorage.getItem('userStatsCollapse') === 'open') {
            collapseElement.classList.add('show');
            toggleButton.querySelector('i').classList.remove('fa-chevron-down');
            toggleButton.querySelector('i').classList.add('fa-chevron-up');
        }

        // Lắng nghe sự kiện khi collapse mở
        collapseElement.addEventListener('shown.bs.collapse', function () {
            sessionStorage.setItem('userStatsCollapse', 'open');
            toggleButton.querySelector('i').classList.remove('fa-chevron-down');
            toggleButton.querySelector('i').classList.add('fa-chevron-up');
        });

        // Lắng nghe sự kiện khi collapse đóng
        collapseElement.addEventListener('hidden.bs.collapse', function () {
            sessionStorage.removeItem('userStatsCollapse');
            toggleButton.querySelector('i').classList.remove('fa-chevron-up');
            toggleButton.querySelector('i').classList.add('fa-chevron-down');
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
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

</style>
@endsection