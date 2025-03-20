<?php

namespace App\Http\Controllers;
use App\Models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    //
    public function getHome()
    {
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'giaovien'])) {
            return redirect()->route('frontend.home');
        }
        return view('admin.home');
    }
}
