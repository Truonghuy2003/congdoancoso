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
use App\Mail\GuiMail;
use Exception;
class HomeController extends Controller
{
    //Controller cho khách
    public function getHome()
    {
        $baiviet = BaiViet::with('chude')
        ->where('kichhoat', 1)
        ->where('kiemduyet', 1)
        ->whereHas('chude')
        ->orderBy('created_at', 'desc')
        ->paginate(perPage: 9);
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

    public function getBaiViet_ChiTiet($tenchude_slug, $tieude_slug)
    {
        // Tìm bài viết theo slug và đảm bảo bài viết đã kích hoạt và được kiểm duyệt
        $baiviet = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('tieude_slug', $tieude_slug)
            ->firstOrFail(); // Trả về 404 nếu không tìm thấy

        // Cập nhật lượt xem
        $daxem = 'BV' . $baiviet->id;
        if (!session()->has($daxem)) {
            $baiviet->increment('luotxem');
            session()->put($daxem, 1);
        }

        // Lấy danh sách bài viết cùng chủ đề
        $baivietcungchuyemuc = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('chude_id', $baiviet->chude_id)
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
    // Trang đăng ký dành cho khách
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
    public function getTimKiem(Request $request)
    {
        // Kiểm tra dữ liệu nhập
        $request->validate([
            'tukhoa' => ['required', 'string', 'max:255'],
        ]);

        // Lấy từ khóa tìm kiếm từ request
        $tukhoa = $request->input('tukhoa');

        // Tìm bài viết có tiêu đề hoặc nội dung chứa từ khóa
        $baiviet_timkiem = BaiViet::where('tieude', 'LIKE', "%$tukhoa%")
            ->orWhere('tomtat', 'LIKE', "%$tukhoa%")
            ->orWhere('noidung', 'LIKE', "%$tukhoa%")
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->appends(['tukhoa' => $tukhoa]);

        // Trả về view hiển thị kết quả tìm kiếm
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
