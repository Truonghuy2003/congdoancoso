<?php

namespace App\Http\Controllers;
use App\Models\ChuDe;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


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
    /*
    public function show($slug)
    {
        $baiviet = BaiViet::where('slug', $slug)->firstOrFail();
        return view('frontend.baiviet', compact('baiviet'));
    }
    public function chiTiet($tenchude_slug, $tieude_slug)
    {
        $baiviet = BaiViet::where('slug', $tieude_slug)->with('chude')->firstOrFail();
        return view('frontend.baiviet.chitiet', compact('baiviet'));
    }
    */

}
