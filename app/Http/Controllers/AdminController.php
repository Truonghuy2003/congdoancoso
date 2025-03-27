<?php

namespace App\Http\Controllers;
use App\Models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Baiviet;
use App\Models\Binh_luan_bai_viet;
use App\Models\File;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    public function getHome()
    {
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'giaovien'])) {
            return redirect()->route('frontend.home');
        }
        return view('admin.home');
    }
    public function statistics(Request $request)
    {
        // Lấy năm từ request, mặc định là năm hiện tại
        $year = $request->input('year', Carbon::now()->year);

        // Tổng bài viết
        $totalPosts = Baiviet::count();

        // Tổng bình luận
        $totalComments = Binh_luan_bai_viet::count();

        // Tổng lượt xem
        $totalViews = Baiviet::sum('luotxem');

        // Tổng file
        $totalFiles = File::count();

        // Thống kê bài viết theo tháng trong năm được chọn
        $postsByMonth = Baiviet::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')->toArray();

        // Thống kê bình luận theo tháng trong năm được chọn
        $commentsByMonth = Binh_luan_bai_viet::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')->toArray();

        // Đổ dữ liệu vào mảng 12 tháng
        $monthlyPosts = array_fill(1, 12, 0);
        $monthlyComments = array_fill(1, 12, 0);
        foreach ($postsByMonth as $month => $count) {
            $monthlyPosts[$month] = $count;
        }
        foreach ($commentsByMonth as $month => $count) {
            $monthlyComments[$month] = $count;
        }

        // Lấy danh sách năm để hiển thị trong dropdown
        $years = Baiviet::selectRaw('YEAR(created_at) as year')
            ->union(binh_luan_bai_viet::selectRaw('YEAR(created_at) as year'))
            ->union(File::selectRaw('YEAR(created_at) as year'))
            ->distinct()
            ->pluck('year')
            ->sortDesc();

        // Thống kê theo tài khoản quản trị (admin và giaovien)
        $adminStats = NguoiDung::whereIn('role', ['admin', 'giaovien'])
            ->withCount([
                'BaiViet as post_count',
                'BinhLuanBaiViet as comment_count',
            ])
            ->get()
            ->map(function ($user) {
                $file_count = File::where('nguoidung_id', $user->id)->count();
                return [
                    'name' => $user->name,
                    'role' => $user->role,
                    'post_count' => $user->post_count,
                    'comment_count' => $user->comment_count,
                    'file_count' => $file_count,
                ];
            });

        // Thống kê theo người dùng (role user)
        $userStats = NguoiDung::where('role', 'user')
            ->withCount([
                'BinhLuanBaiViet as comment_count',
            ])
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'role' => $user->role,
                    'comment_count' => $user->comment_count,
                ];
            });

        return view('admin.thongke.index', compact(
            'totalPosts',
            'totalComments',
            'totalViews',
            'totalFiles',
            'monthlyPosts',
            'monthlyComments',
            'year',
            'years',
            'adminStats',
            'userStats'
        ));
    }
}
