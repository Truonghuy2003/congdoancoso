<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class KhachController extends Controller
{
    //
    public function getHome()
    {
        if (Auth::check()) {
            $nguoidung = NguoiDung::find(Auth::user()->id);
            return view('user.home', compact('nguoidung'));
        } else
            return redirect()->route('user.dangnhap');
    }
    public function getHoSoCaNhan()
    {
        // Bổ sung code tại đây
        return redirect()->route('user.home');
    }

    public function postHoSoCaNhan(Request $request)
    {
        // Bổ sung code tại đây
        $id = Auth::user()->id;

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:nguoidung,email,' . $id],
            'password' => ['confirmed'],
        ]);

        $orm = NguoiDung::find($id);
        $orm->name = $request->name;
        $orm->username = Str::before($request->email, '@');
        $orm->email = $request->email;
        if (!empty($request->password)) $orm->password = Hash::make($request->password);
        $orm->save();

        return redirect()->route('user.home')->with('success', 'Đã cập nhật thông tin thành công.');
    }
        public function postDangXuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('frontend.home');
    }
}
