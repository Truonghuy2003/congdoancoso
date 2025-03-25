<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getDanhSach()
    {
        $files = File::with(['baiviet', 'nguoidung'])->orderBy('created_at', 'desc')->get();
        return view('admin.file.danhsach', compact('files'));
    }

    public function getThem()
    {
        $baiviet = BaiViet::all();
        return view('admin.file.them', compact('baiviet'));
    }

    public function postThem(Request $request)
    {
        $request->validate([
            'baiviet_id' => 'nullable|exists:baiviet,id',
            'tep' => 'required|file|mimetypes:image/jpeg,image/png,application/pdf,text/plain|max:10240',
        ], [
            'tep.required' => 'Vui lòng chọn một tệp để tải lên.',
            'tep.file' => 'Tệp tải lên không hợp lệ.',
            'tep.mimetypes' => 'Tệp phải có định dạng: jpg, png, pdf, txt.',
            'tep.max' => 'Tệp không được vượt quá 10MB.',
        ]);

        $tep = $request->file('tep');
        $tenGoc = $tep->getClientOriginalName();
        $duongDanTep = $tep->store('tep_tin', 'public');
        $loaiTep = $tep->getClientMimeType();

        File::create([
            'baiviet_id' => $request->baiviet_id,
            'nguoidung_id' => Auth::id(),
            'duong_dan_file' => $duongDanTep,
            'loai_file' => $loaiTep,
            'ten_goc' => $tenGoc,
        ]);

        return redirect()->route('admin.file')->with('success', 'Tệp đã được thêm!');
    }

    public function getSua($id)
    {
        $file = File::findOrFail($id);
        $baiviet = BaiViet::all();
        return view('admin.file.sua', compact('file', 'baiviet'));
    }

    public function postSua(Request $request, $id)
    {
        $request->validate([
            'baiviet_id' => 'nullable|exists:baiviet,id',
            'tep' => 'nullable|file|mimetypes:image/jpeg,image/png,application/pdf,text/plain|max:10240',
        ], [
            'tep.file' => 'Tệp tải lên không hợp lệ.',
            'tep.mimetypes' => 'Tệp phải có định dạng: jpg, png, pdf, txt.',
            'tep.max' => 'Tệp không được vượt quá 10MB.',
        ]);

        $file = File::findOrFail($id);

        // Nếu có tệp mới được upload, xóa tệp cũ và lưu tệp mới
        if ($request->hasFile('tep')) {
            Storage::disk('public')->delete($file->duong_dan_file);
            $tep = $request->file('tep');
            $tenGoc = $tep->getClientOriginalName();
            $duongDanTep = $tep->store('tep_tin', 'public');
            $loaiTep = $tep->getClientMimeType();

            $file->update([
                'duong_dan_file' => $duongDanTep,
                'loai_file' => $loaiTep,
                'ten_goc' => $tenGoc,
            ]);
        }

        // Cập nhật baiviet_id (có thể null)
        $file->update(['baiviet_id' => $request->baiviet_id]);

        // Sửa redirect từ 'admin.file.danhsach' thành 'admin.file'
        return redirect()->route('admin.file')->with('success', 'Tệp đã được cập nhật!');
    }

    public function getXoa($id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->duong_dan_file);
        $file->delete();
        return redirect()->route('admin.file')->with('success', 'Tệp đã được xóa!');
    }
}