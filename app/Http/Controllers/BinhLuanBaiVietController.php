<?php

namespace App\Http\Controllers;

use App\Models\baiviet;
use App\Models\binh_luan_bai_viet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BinhLuanBaiVietController extends Controller
{
    //
    //
    protected $table = 'binhluanbaiviets';
    public function getDanhSach()
    {
        $binhluanbaiviet = binh_luan_bai_viet::orderBy('created_at', 'desc')->get();
        return view('binhluanbaiviet.danhsach', compact('binhluanbaiviet'));
    }

    public function getThem()
    {
        $baiviet = baiviet::orderBy('created_at', 'desc')->get();
        return view('binhluanbaiviet.them', compact('baiviet'));
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
        return redirect()->route('binhluanbaiviet');
    }

    public function getSua($id)
    {
        $baiviet = BaiViet::orderBy('created_at', 'desc')->get();
        $binhluanbaiviet = binh_luan_bai_viet::find($id);
        return view('binhluanbaiviet.sua', compact('baiviet', 'binhluanbaiviet'));
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
        return redirect()->route('binhluanbaiviet');
    }

    public function getXoa($id)
    {
        $orm = binh_luan_bai_viet::find($id);
        $orm->delete();

        // Sau khi xóa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('binhluanbaiviet');
    }

    public function getKiemDuyet($id)
    {
        $orm = binh_luan_bai_viet::find($id);
        $orm->kiemduyet = 1 - $orm->kiemduyet;
        $orm->save();

        return redirect()->route('binhluanbaiviet');
    }

    public function getKichHoat($id)
    {
        $orm = binh_luan_bai_viet::find($id);
        $orm->kichhoat = 1 - $orm->kichhoat;
        $orm->save();

        return redirect()->route('binhluanbaiviet');
    }
}
