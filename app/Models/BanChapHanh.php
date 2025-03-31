<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BanChapHanh extends Model
{
    protected $table = 'banchaphanh';
    protected $fillable = [
        'ho_ten', 'chuc_vu', 'email', 'dien_thoai', 'anh_dai_dien', 'nhiem_vu', 'nhiem_ky' ,'ten_phong_ban'
    ];
}