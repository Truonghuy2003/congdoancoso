<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChuDe;
use App\Models\BaiViet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\NguoiDung;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
class HomeController extends Controller
{
    public function getHome()
    {
        $baiviet = BaiViet::with('chude')->whereHas('chude')->orderBy('created_at', 'desc')->limit(9)->get();
        foreach ($baiviet as $bv) {
            if (!$bv->chude) {
                dd("Lỗi: Bài viết ID {$bv->id} không có chủ đề!", $bv);
            }
        }
        return view('frontend.home', compact('baiviet'));
    }
    public function getBaiViet($tenchude_slug = '')
    {
        if (empty($tenchude_slug)) {
            $title = 'Tin tức';
            $baiviet = BaiViet::where('kichhoat', 1)
                ->where('kiemduyet', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $chude = ChuDe::where('tenchude_slug', $tenchude_slug)
                ->firstOrFail();
            $title = $chude->tenchude;
            $baiviet = BaiViet::where('kichhoat', 1)
                ->where('kiemduyet', 1)
                ->where('chude_id', $chude->id)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('frontend.baiviet', compact('title', 'baiviet'));
    }

    public function getBaiViet_ChiTiet($tenchude_slug = '', $tieude_slug = '')
    {
        $tieude_id = explode('.', $tieude_slug);
        $tieude = explode('-', $tieude_id[0]);
        $baiviet_id = $tieude[count($tieude) - 1];

        $baiviet = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('id', $baiviet_id)
            ->firstOrFail();

        if (!$baiviet) abort(404);

        // Cập nhật lượt xemm
        $daxem = 'BV' . $baiviet_id;
        if (!session()->has($daxem)) {
            $orm = BaiViet::find($baiviet_id);
            $orm->luotxem = $baiviet->luotxem + 1;
            $orm->save();
            session()->put($daxem, 1);
        }

        $baivietcungchuyemuc = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('chude_id', $baiviet->chude_id)
            ->where('id', '!=', $baiviet_id)
            ->orderBy('created_at', 'desc')
            ->take(4)->get();

        return view('frontend.baiviet_chitiet', compact('baiviet', 'baivietcungchuyemuc'));
    }
    /*
    public function getChuDe($tenchude_slug = ''){
        $chude = ChuDe::all(); // Lấy tất cả chủ đề
        return view('frontend.home', compact('topics'));
    }

    
    public function getChuDe($tenchude_slug = '')
    {
        $chude = ChuDe::where('tenchude_slug', $tenchude_slug)
            ->firstOrFail();
        $title = $chude->tenchude;
        $baiviet = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('chude_id', $chude->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('frontend.baiviet', compact('title', 'baiviet'));
    }
    */

    public function getLienHe()
    {
        return view('frontend.lienhe');
    }
    // Trang đăng ký dành cho khách hàng
    public function getDangKy()
    {
        return view('user.dangky');
    }
    // Trang đăng nhập dành cho khách hàng
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
            // Nếu người dùng đã tồn tại thì đăng nhập
            Auth::login($existingUser, true);
            return redirect()->route('user.home');
        } else {
            // Nếu chưa tồn tại người dùng thì thêm mới
            $newUser = NguoiDung::create([
                'name' => $user->name,
                'email' => $user->email,
                'username' => Str::before($user->email, '@'),
                'password' => Hash::make('larashop@2024'), // Gán mật khẩu tự do
            ]);

            // Sau đó đăng nhập
            Auth::login($newUser, true);
            return redirect()->route('user.home');
        }
    }
}
