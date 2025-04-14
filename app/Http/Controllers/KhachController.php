<?php

namespace App\Http\Controllers;

use App\Models\baiviet;
use App\Models\binh_luan_bai_viet;
use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\ChuDe;

class KhachController extends Controller
{
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
        $nguoidung = Auth::user();
        return view('user.home', compact('nguoidung'));
    }

    public function postHoSoCaNhan(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:nguoidung,email,' . $id],
            'password' => ['confirmed'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $orm = NguoiDung::find($id);
        $orm->name = $request->name;
        $orm->username = Str::before($request->email, '@');
        $orm->email = $request->email;
        if (!empty($request->password)) $orm->password = Hash::make($request->password);
        
        if ($request->hasFile('avatar')) {
            if ($orm->avatar && Storage::exists('public/avatars/' . $orm->avatar)) {
                Storage::delete('public/avatars/' . $orm->avatar);
            }
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/avatars', $filename);
            $orm->avatar = $filename;
        }

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

    public function chude()
    {
        $chude = ChuDe::all();
        return view('user.home', compact('chude'));
    }

    public function postBaiViet()
    {
        $nguoidung = Auth::user();
        $baiviet = baiviet::where('nguoidung_id', $nguoidung->id)->orderBy('created_at', 'desc')->get();
        return view('user.baiviet', compact('nguoidung', 'baiviet'));
    }

    public function getBinhLuanBaiViet()
    {
        $nguoidung = Auth::user();
        $binhluans = binh_luan_bai_viet::where('nguoidung_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.binhluan', compact('nguoidung', 'binhluans'));
    }

    public function postBinhLuanBaiViet(Request $request, $baiviet_id)
    {
        $request->validate([
            'noidung' => 'required|string|max:1000',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        $baiviet = baiviet::findOrFail($baiviet_id);
        $nguoidung = Auth::user();
        
        $kiemduyet = in_array($nguoidung->role, ['admin', 'giaovien']) ? 1 : 0;

        binh_luan_bai_viet::create([
            'nguoidung_id' => $nguoidung->id,
            'baiviet_id' => $baiviet->id,
            'noidungbinhluan' => $request->noidung,
            'kiemduyet' => $kiemduyet,
            'kichhoat' => 1,
        ]);

        return redirect()->back()->with('success', $kiemduyet ? 'Bình luận của bạn đã được đăng!' : 'Bình luận của bạn đã được gửi và đang chờ duyệt!');
    }

    public function deleteBinhLuan($id)
    {
        $binhluan = binh_luan_bai_viet::where('id', $id)->where('nguoidung_id', Auth::id())->firstOrFail();
        $binhluan->delete();
        return redirect()->route('user.binhluan')->with('success', 'Đã xóa bình luận thành công.');
    }
}