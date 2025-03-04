<?php

namespace App\Http\Controllers;

use App\Models\chude;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChudeController extends Controller
{
    public function getDanhSach()
    {
        $chude = chude::all();
        return view('chude.danhsach', compact('chude'));
    }

    public function getThem()
    {
        return view('chude.them');
    }

    public function postThem(Request $request)
    {
        // Kiểm tra
        $request->validate([
            'tenchude' => ['required', 'string', 'max:255', 'unique:chude'],
        ]);

        $orm = new ChuDe();
        $orm->tenchude = $request->tenchude;
        $orm->tenchude_slug = Str::slug($request->tenchude, '-');
        $orm->save();

        // Sau khi thêm thành công thì tự động chuyển về trang danh sách
        return redirect()->route('chude');
    }

    public function getSua($id)
    {
        $chude = ChuDe::find($id);
        return view('chude.sua', compact('chude'));
    }

    public function postSua(Request $request, $id)
    {
        // Kiểm tra
        $request->validate([
            'tenchude' => ['required', 'string', 'max:255', 'unique:chude,tenchude,' . $id],
        ]);

        $orm = ChuDe::find($id);
        $orm->tenchude = $request->tenchude;
        $orm->tenchude_slug = Str::slug($request->tenchude, '-');
        $orm->save();

        // Sau khi sửa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('chude');
    }

    public function getXoa($id)
    {
        $orm = ChuDe::find($id);
        $orm->delete();

        // Sau khi xóa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('chude');
    }
}
