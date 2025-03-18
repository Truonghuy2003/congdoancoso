<?php

namespace App\Http\Controllers;
use App\Models\ChuDe;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\LuuBaiViet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class BaivietController extends Controller
{
    //Controller cho admin
    public function getDanhSach()
    {
        $baiviet = BaiViet::orderBy('created_at', 'desc')->get();
        return view('admin.baiviet.danhsach', compact('baiviet')); // 
    }

    public function getThem()
    {
        $chude = ChuDe::all();
        return view('admin.baiviet.them', compact('chude')); // 
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
        ]);
        $orm = new BaiViet();
        $orm->chude_id = $request->chude_id;
        $orm->nguoidung_id = Auth::user()->id;
        $orm->tieude = $request->tieude;
        $orm->tieude_slug = Str::slug($request->tieude, '-');
        if (!empty($request->tomtat)) $orm->tomtat = $request->tomtat;
        $orm->noidung = $request->noidung;
        $orm->kiemduyet = 0; // Đặt trạng thái kiểm duyệt mặc định là 0 (chưa duyệt)
        $orm->kichhoat = 1;
        $orm->save();

        return redirect()->route('admin.baiviet'); // 

        //dd($validatedData); //  Dừng lại để kiểm tra dữ liệu nhận được
    }

    public function getSua($id)
    {
        $chude = ChuDe::all();
        $baiviet = BaiViet::find($id);
        return view('admin.baiviet.sua', compact('chude', 'baiviet')); // 
    }

    public function postSua(Request $request, $id)
    {
        $request->validate([
            'chude_id' => ['required', 'integer'],
            'tieude' => ['required', 'string', 'max:300', 'unique:baiviet,tieude,'.$id],
            'noidung' => ['required', 'string', 'min:20'],
        ]);

        $orm = BaiViet::find($id);
        $orm->chude_id = $request->chude_id;
        $orm->tieude = $request->tieude;
        $orm->tieude_slug = Str::slug($request->tieude, '-');
        $orm->tomtat = $request->tomtat?? null;;
        $orm->noidung = $request->noidung;
        $orm->save();

        return redirect()->route('admin.baiviet')->with('success', 'Bài viết đã được thêm!'); // 
    }

    public function getXoa($id)
    {
        $orm = BaiViet::find($id);
        $orm->delete();
        return redirect()->route('admin.baiviet'); //
    }

    public function getKiemDuyet($id)
    {
        $orm = BaiViet::find($id);
        $orm->kiemduyet = 1 - $orm->kiemduyet;
        $orm->save();

        return redirect()->route('admin.baiviet'); //
    }

    public function getKichHoat($id)
    {
        $orm = BaiViet::find($id);
        $orm->kichhoat = 1 - $orm->kichhoat;
        $orm->save();

        return redirect()->route('admin.baiviet'); //
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
            Log::error('Lỗi khi lưu bài viết: ' . $e->getMessage()); // Use the imported Log facade
            return response()->json(['message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }
    public function baivietDaLuu()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem bài viết đã lưu.');
        }
    
        $nguoidung = Auth::user(); // Lấy thông tin người dùng hiện tại
    
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




}
