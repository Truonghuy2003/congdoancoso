<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChuDe;
use App\Models\BaiViet;
use App\Models\BanChapHanh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\NguoiDung;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuiMail;
use Exception;

class HomeController extends Controller
{
    public function getHome()
    {
        $baiviet = BaiViet::with('chudes') // Sử dụng quan hệ nhiều-nhiều
            ->where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: 9);

        // Kiểm tra xem bài viết có chủ đề không
        foreach ($baiviet as $bv) {
            if ($bv->chudes->isEmpty()) {
                dd("Lỗi: Bài viết ID {$bv->id} không có chủ đề!", $bv);
            }
        }

        return view('frontend.home', compact('baiviet'));
    }

    public function getBaiViet($tenchude_slug = '')
    {
        if (empty($tenchude_slug)) {
            $title = 'Tin tức';
            $baiviet = BaiViet::with('chudes')
                ->where('kichhoat', 1)
                ->where('kiemduyet', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $chude = ChuDe::where('tenchude_slug', $tenchude_slug)->firstOrFail();
            $title = $chude->tenchude;
            $baiviet = BaiViet::with('chudes')
                ->where('kichhoat', 1)
                ->where('kiemduyet', 1)
                ->whereHas('chudes', function ($query) use ($chude) {
                    $query->where('chude.id', $chude->id);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('frontend.baiviet', compact('title', 'baiviet'));
    }

    public function getBanChapHanh(Request $request)
    {
        $ten_phong_ban = $request->input('ten_phong_ban');
    
        $nhiem_ky_query = BanChapHanh::select('nhiem_ky')->distinct();
        if ($ten_phong_ban) {
            $nhiem_ky_query->where('ten_phong_ban', $ten_phong_ban);
        }
        $nhiem_ky_list = $nhiem_ky_query->pluck('nhiem_ky');
    
        $nhiem_ky = $request->input('nhiem_ky', $nhiem_ky_list->first() ?? '2023-2028');
    
        $query = BanChapHanh::query();
        if ($ten_phong_ban) {
            $query->where('ten_phong_ban', $ten_phong_ban);
        }
        $query->where('nhiem_ky', $nhiem_ky);
        $thanhvien = $query->orderBy('created_at', 'desc')->get();
    
        $phong_ban_list = BanChapHanh::select('ten_phong_ban')->distinct()->pluck('ten_phong_ban');
    
        return view('frontend.banchaphanh', compact('thanhvien', 'nhiem_ky', 'nhiem_ky_list', 'phong_ban_list', 'ten_phong_ban'));
    }

    public function getBaiViet_ChiTiet($tenchude_slug, $tieude_slug)
    {
        $baiviet = BaiViet::with('chudes')
            ->where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('tieude_slug', $tieude_slug)
            ->firstOrFail();

        $daxem = 'BV' . $baiviet->id;
        if (!session()->has($daxem)) {
            $baiviet->increment('luotxem');
            session()->put($daxem, 1);
        }

        // Lấy bài viết cùng chủ đề (dựa trên một trong các chủ đề của bài viết)
        $chude_ids = $baiviet->chudes->pluck('id');
        $baivietcungchuyemuc = BaiViet::with('chudes')
            ->where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->whereHas('chudes', function ($query) use ($chude_ids) {
                $query->whereIn('chude.id', $chude_ids);
            })
            ->where('id', '!=', $baiviet->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('frontend.baiviet_chitiet', compact('baiviet', 'baivietcungchuyemuc'));
    }

    public function getLienHe()
    {
        return view('frontend.lienhe');
    }

    public function getDangKy()
    {
        return view('user.dangky');
    }

    public function getDangNhap()
    {
        if (Auth::check())
            return redirect()->route('user.home');
        else
            return view('user.dangnhap');
    }

    public function getGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function getTimKiem(Request $request)
    {
        $request->validate([
            'tukhoa' => ['required', 'string', 'max:255'],
        ]);

        $tukhoa = $request->input('tukhoa');

        $baiviet_timkiem = BaiViet::with('chudes')
            ->where('tieude', 'LIKE', "%$tukhoa%")
            ->orWhere('tomtat', 'LIKE', "%$tukhoa%")
            ->orWhere('noidung', 'LIKE', "%$tukhoa%")
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->appends(['tukhoa' => $tukhoa]);

        return view('frontend.baiviet_timkiem', compact('baiviet_timkiem', 'tukhoa'));
    }

    public function getGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();
        } catch (Exception $e) {
            return redirect()->route('user.dangnhap')->with('warning', 'Lỗi xác thực. Xin vui lòng thử lại!');
        }

        $existingUser = NguoiDung::where('email', $user->email)->first();
        if ($existingUser) {
            Auth::login($existingUser, true);
            return redirect()->route('user.home');
        } else {
            $newUser = NguoiDung::create([
                'name' => $user->name,
                'email' => $user->email,
                'username' => Str::before($user->email, '@'),
                'password' => Hash::make('larashop@2024'),
            ]);

            Auth::login($newUser, true);
            return redirect()->route('user.home');
        }
    }
}