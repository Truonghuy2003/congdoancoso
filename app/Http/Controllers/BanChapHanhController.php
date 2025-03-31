<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BanChapHanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BanChapHanhController extends Controller
{
    public function getDanhSach()
    {
        $thanhvien = BanChapHanh::orderBy('created_at', 'desc')->get()->groupBy('ten_phong_ban');
        return view('admin.banchaphanh.danhsach', compact('thanhvien'));
    }

    public function getThem()
    {
        return view('admin.banchaphanh.them');
    }

    public function postThem(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'chuc_vu' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'dien_thoai' => 'nullable|string|max:50',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nhiem_vu' => 'nullable|string',
            'nhiem_ky' => 'required|string|max:50',
            'ten_phong_ban' => 'required|string|max:255', // Thêm validation
        ]);

        $data = $request->all();
        if ($request->hasFile('anh_dai_dien')) {
            $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('images', 'public');
        }

        BanChapHanh::create($data);
        return redirect()->route('admin.banchaphanh')->with('success', 'Thêm thành viên thành công!');
    }

    public function getSua($id)
    {
        $thanhvien = BanChapHanh::findOrFail($id);
        return view('admin.banchaphanh.sua', compact('thanhvien'));
    }

    public function postSua(Request $request, $id)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'chuc_vu' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'dien_thoai' => 'nullable|string|max:50',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nhiem_vu' => 'nullable|string',
            'nhiem_ky' => 'required|string|max:50',
            'ten_phong_ban' => 'required|string|max:255', // Thêm validation
        ]);

        $thanhvien = BanChapHanh::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('anh_dai_dien')) {
            if ($thanhvien->anh_dai_dien) {
                Storage::disk('public')->delete($thanhvien->anh_dai_dien);
            }
            $data['anh_dai_dien'] = $request->file('anh_dai_dien')->store('images', 'public');
        }

        $thanhvien->update($data);
        return redirect()->route('admin.banchaphanh')->with('success', 'Cập nhật thành viên thành công!');
    }

    public function getXoa($id)
    {
        $thanhvien = BanChapHanh::findOrFail($id);
        if ($thanhvien->anh_dai_dien) {
            Storage::disk('public')->delete($thanhvien->anh_dai_dien);
        }
        $thanhvien->delete();
        return redirect()->route('admin.banchaphanh')->with('success', 'Xóa thành viên thành công!');
    }
}