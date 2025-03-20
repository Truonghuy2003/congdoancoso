<?php

namespace App\Http\Controllers;
use App\Models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class GiaoVienController extends Controller
{
    //
    public function getHome()
    {
        if (Auth::check() && Auth::user()->role !== 'giaovien') {
            return redirect()->route('frontend.home');
        }
        return view('admin.home');
    }
}
