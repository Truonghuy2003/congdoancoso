<?php

namespace App\Http\Controllers;

use App\Models\ChuDe;
use App\Models\BaiViet;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\LuuBaiViet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BaivietController extends Controller
{
    public function getDanhSach()
    {
        // Lấy tất cả chủ đề để hiển thị trong dropdown
        $chude = ChuDe::all();

        // Lấy danh sách bài viết, áp dụng lọc và sắp xếp
        $query = BaiViet::with(['ChuDe', 'NguoiDung', 'file']);

        // Lọc theo chude_id nếu có
        if (request('chude_id')) {
            $query->where('chude_id', request('chude_id'));
        }

        // Tìm kiếm theo tiêu đề nếu có
        if (request('tieude')) {
            $query->where('tieude', 'like', '%' . request('tieude') . '%');
        }

        // Sắp xếp: Ưu tiên tuyệt đối
        if (request('date_sort')) {
            // Nếu có date_sort, chỉ sắp xếp theo ngày đăng
            $dateSort = request('date_sort', 'desc'); // Mặc định là mới nhất đến cũ nhất
            $query->orderBy('created_at', $dateSort);
        } elseif (request('sort')) {
            // Nếu không có date_sort nhưng có sort, sắp xếp theo tiêu đề
            $sort = request('sort', 'asc'); // Mặc định là A-Z
            $query->orderBy('tieude', $sort);
        } else {
            // Mặc định: Sắp xếp theo ngày đăng (mới nhất đến cũ nhất) nếu không có tiêu chí nào
            $query->orderBy('created_at', 'desc');
        }

        $baiviet = $query->get();

        // Trả về view với dữ liệu
        return view('admin.baiviet.danhsach', compact('baiviet', 'chude'));
    }

    public function getThem()
    {
        $chude = ChuDe::all();
        return view('admin.baiviet.them', compact('chude'));
    }

    public function postThem(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm bài viết.');
        }
        
        $request->validate([
            'chude_id' => ['required', 'integer'],
            'tieude' => ['required', 'string', 'max:300', 'unique:baiviet'],
            'noidung' => ['required', 'string', 'min:10'],
            'tep' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,application/pdf,text/plain', 'max:10240'],
        ], [
            'tep.file' => 'Tệp tải lên không hợp lệ.',
            'tep.mimetypes' => 'Tệp phải có định dạng: jpg, png, pdf, txt.',
            'tep.max' => 'Tệp không được vượt quá 10MB.',
        ]);
    
        $baiViet = new BaiViet();
        $baiViet->chude_id = $request->chude_id;
        $baiViet->nguoidung_id = Auth::user()->id;
        $baiViet->tieude = $request->tieude;
        $baiViet->tieude_slug = Str::slug($request->tieude, '-');
        if (!empty($request->tomtat)) $baiViet->tomtat = $request->tomtat;
        $baiViet->noidung = $request->noidung;
        $baiViet->kiemduyet = 0;
        $baiViet->kichhoat = 1;
        $baiViet->save();
    
        if ($request->hasFile('tep')) {
            $tep = $request->file('tep');
            $tenGoc = $tep->getClientOriginalName();
            $duongDanTep = $tep->store('tep_tin', 'public');
            $loaiTep = $tep->getClientMimeType();
    
            File::create([
                'baiviet_id' => $baiViet->id,
                'nguoidung_id' => Auth::user()->id,
                'duong_dan_file' => $duongDanTep,
                'loai_file' => $loaiTep,
                'ten_goc' => $tenGoc,
            ]);
        }
    
        return redirect()->route('admin.baiviet')->with('success', 'Bài viết đã được thêm!');
    }

    public function getSua($id)
    {
        $chude = ChuDe::all();
        $baiviet = BaiViet::find($id);
        return view('admin.baiviet.sua', compact('chude', 'baiviet'));
    }

    public function postSua(Request $request, $id)
    {
        $request->validate([
            'chude_id' => ['required', 'integer'],
            'tieude' => ['required', 'string', 'max:300', 'unique:baiviet,tieude,'.$id],
            'noidung' => ['required', 'string'],
            'tep' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,application/pdf,text/plain', 'max:10240'],
        ], [
            'tep.file' => 'Tệp tải lên không hợp lệ.',
            'tep.mimetypes' => 'Tệp phải có định dạng: jpg, png, pdf, txt.',
            'tep.max' => 'Tệp không được vượt quá 10MB.',
        ]);
    
        $baiViet = BaiViet::find($id);
        $baiViet->chude_id = $request->chude_id;
        $baiViet->tieude = $request->tieude;
        $baiViet->tieude_slug = Str::slug($request->tieude, '-');
        $baiViet->tomtat = $request->tomtat ?? null;
        $baiViet->noidung = $request->noidung;
        $baiViet->save();
    
        $xoaTep = $request->has('xoa_tep') && $request->xoa_tep == '1';
    
        if ($baiViet->file()->exists()) {
            $tepHienTai = $baiViet->file->first();
            if ($xoaTep || $request->hasFile('tep')) {
                Storage::disk('public')->delete($tepHienTai->duong_dan_file);
                $tepHienTai->delete();
            }
        }
    
        if ($request->hasFile('tep')) {
            $tep = $request->file('tep');
            $tenGoc = $tep->getClientOriginalName();
            $duongDanTep = $tep->store('tep_tin', 'public');
            $loaiTep = $tep->getClientMimeType();
    
            File::create([
                'baiviet_id' => $baiViet->id,
                'nguoidung_id' => Auth::user()->id,
                'duong_dan_file' => $duongDanTep,
                'loai_file' => $loaiTep,
                'ten_goc' => $tenGoc,
            ]);
        }
    
        return redirect()->route('admin.baiviet')->with('success', 'Bài viết đã được cập nhật!');
    }

    public function getXoa($id)
    {
        $baiViet = BaiViet::find($id);
        $baiViet->delete();
        return redirect()->route('admin.baiviet');
    }

    public function getKiemDuyet($id)
    {
        $baiViet = BaiViet::find($id);
        $baiViet->kiemduyet = 1 - $baiViet->kiemduyet;
        $baiViet->save();
        return redirect()->route('admin.baiviet');
    }

    public function getKichHoat($id)
    {
        $baiViet = BaiViet::find($id);
        $baiViet->kichhoat = 1 - $baiViet->kichhoat;
        $baiViet->save();
        return redirect()->route('admin.baiviet');
    }

    public function luuBaiViet(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để lưu bài viết!'], 401);
        }
    
        try {
            $request->validate([
                'baiviet_id' => 'required|exists:baiviet,id',
            ]);
    
            $baiviet_id = $request->baiviet_id;
            $user_id = Auth::id();
    
            if (LuuBaiViet::where('nguoidung_id', $user_id)->where('baiviet_id', $baiviet_id)->exists()) {
                return response()->json(['message' => 'Bạn đã lưu bài viết này rồi!'], 400);
            }
    
            LuuBaiViet::create([
                'nguoidung_id' => $user_id,
                'baiviet_id' => $baiviet_id,
            ]);
    
            return response()->json(['message' => 'Bài viết đã được lưu thành công!'], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lưu bài viết: ' . $e->getMessage());
            return response()->json(['message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }

    public function baivietDaLuu()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem bài viết đã lưu.');
        }
    
        $nguoidung = Auth::user();
    
        $baiviet = BaiViet::join('luubaiviet', 'baiviet.id', '=', 'luubaiviet.baiviet_id')
            ->where('luubaiviet.nguoidung_id', Auth::id())
            ->select('baiviet.*')
            ->get();
    
        return view('user.baivietdaluu', compact('baiviet', 'nguoidung'));
    }

    public function boLuuBaiViet($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thực hiện thao tác này.');
        }

        DB::table('luubaiviet')
            ->where('nguoidung_id', Auth::id())
            ->where('baiviet_id', $id)
            ->delete();

        return redirect()->route('user.baiviet.luu')->with('success', 'Bỏ lưu bài viết thành công.');
    }

    public function taiTep($id)
    {
        $tep = File::findOrFail($id);
        $duongDan = storage_path('app/public/' . $tep->duong_dan_file);
    
        if (!file_exists($duongDan)) {
            return redirect()->back()->with('error', 'Tệp không tồn tại!');
        }
    
        $tenTaiXuong = $tep->ten_goc ?? basename($tep->duong_dan_file);
        return response()->download($duongDan, $tenTaiXuong);
    }
}