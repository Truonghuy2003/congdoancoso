<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;;

class NguoiDungController extends Controller
{
    public function getDanhSach()
    {
        $nguoidung = NguoiDung::all();
        return view('admin.nguoidung.danhsach', compact('nguoidung'));
    }

    public function getThem()
    {
        return view('admin.nguoidung.them');
    }

    public function postThem(Request $request)
    {
        
        // Kiểm tra
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:nguoidung'],
            'role' => ['required'],
            'password' => ['required', 'min:4', 'confirmed'],
        ]);
        $orm = new NguoiDung();
        $orm->name = $request->name;
        $orm->username = Str::before($request->email, '@');
        $orm->email = $request->email;
        $orm->password = Hash::make($request->password);
        $orm->role = $request->role;
        $orm->save();
        return redirect()->route('admin.nguoidung');
        // Sau khi thêm thành công thì tự động chuyển về trang danh sách

    }

    public function getSua($id)
    {

        $nguoidung = NguoiDung::find($id); // find rỗng là null findOrFail là lỗi 404
        return view('admin.nguoidung.sua', compact('nguoidung'));
    }
    public function postSua(Request $request, $id)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:nguoidung,email,' . $id],
            'role' => ['required'],
            'password' => ['nullable', 'min:4', 'confirmed'], // Cho phép password rỗng, nhưng nếu nhập phải xác nhận
        ]);
        $orm = NguoiDung::find($id);
        $orm->name = $request->name;
        $orm->username = Str::before($request->email, '@');
        $orm->email = $request->email;
        $orm->role = $request->role;

        // Chỉ cập nhật mật khẩu nếu người dùng nhập vào
        if (!empty($request->password)) {
            $orm->password = Hash::make($request->password);
        }

        $orm->save();
        return redirect()->route('admin.nguoidung');
    }


    public function getXoa($id)
    {

        $orm = NguoiDung::find($id);
        $orm->delete();

        return redirect()->route('admin.nguoidung');
    }

}
