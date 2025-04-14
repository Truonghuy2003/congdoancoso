<?php

namespace App\Http\Controllers;

use App\Models\baiviet;
use App\Models\binh_luan_bai_viet;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BinhLuanBaiVietController extends Controller
{
    public function getDanhSach(Request $request)
    {
        $search = $request->query('search');

        // Lấy bình luận mới nhất cho mỗi baiviet_id
        $query = binh_luan_bai_viet::select('binhluanbaiviet.*')
            ->join(DB::raw('(SELECT baiviet_id, MAX(created_at) as max_created_at FROM binhluanbaiviet GROUP BY baiviet_id) as latest'), function ($join) {
                $join->on('binhluanbaiviet.baiviet_id', '=', 'latest.baiviet_id')
                     ->on('binhluanbaiviet.created_at', '=', 'latest.max_created_at');
            })
            ->with(['NguoiDung', 'BaiViet']);

        if ($search) {
            $query->whereHas('NguoiDung', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $binhluanmoinhat = $query->orderBy('created_at', 'desc')->get();

        // Lấy tất cả bình luận để hiển thị khi mở rộng
        $tatcabinhluan = binh_luan_bai_viet::with(['NguoiDung', 'BaiViet'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.binhluanbaiviet.danhsach', compact('binhluanmoinhat', 'tatcabinhluan'));
    }

    public function getThem()
    {
        $baiviet = baiviet::orderBy('created_at', 'desc')->get();
        return view('admin.binhluanbaiviet.them', compact('baiviet'));
    }

    public function postThem(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm bình luận.');
        }
        // Kiểm tra
        $request->validate([
            'baiviet_id' => ['required', 'integer'],
            'noidungbinhluan' => ['required', 'string', 'min:2'],
        ]);

        $orm = new binh_luan_bai_viet();
        $orm->baiviet_id = $request->baiviet_id;
        $orm->nguoidung_id = Auth::user()->id;
        $orm->noidungbinhluan = $request->noidungbinhluan;
        $orm->save();

        // Sau khi thêm thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getSua($id)
    {
        $baiviet = baiviet::orderBy('created_at', 'desc')->get();
        $binhluanbaiviet = binh_luan_bai_viet::find($id);
        return view('admin.binhluanbaiviet.sua', compact('baiviet', 'binhluanbaiviet'));
    }

    public function postSua(Request $request, $id)
    {
        // Kiểm tra
        $request->validate([
            'baiviet_id' => ['required', 'integer'],
            'noidungbinhluan' => ['required', 'string', 'min:20'],
        ]);

        $orm = binh_luan_bai_viet::find($id);
        $orm->baiviet_id = $request->baiviet_id;
        $orm->noidungbinhluan = $request->noidungbinhluan;
        $orm->save();

        // Sau khi sửa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getXoa($id)
    {
        $orm = binh_luan_bai_viet::find($id);
        $orm->delete();

        // Sau khi xóa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getKiemDuyet($id)
    {
        $orm = binh_luan_bai_viet::find($id);
        $orm->kiemduyet = 1 - $orm->kiemduyet;
        $orm->save();

        return redirect()->route('admin.binhluanbaiviet');
    }

    public function getKichHoat($id)
    {
        $orm = binh_luan_bai_viet::find($id);
        $orm->kichhoat = 1 - $orm->kichhoat;
        $orm->save();

        return redirect()->route('admin.binhluanbaiviet');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->query('query');
        $users = NguoiDung::where('name', 'like', '%' . $query . '%')
            ->select('name')
            ->distinct()
            ->limit(10)
            ->get()
            ->pluck('name')
            ->toArray();

        return response()->json($users);
    }
}