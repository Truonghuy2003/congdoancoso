<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class LuuBaiViet extends Model
{
    use HasFactory;
    protected $table = 'luubaiviet'; // Laravel sẽ dùng đúng bảng trong database


    protected $fillable = ['nguoidung_id', 'baiviet_id'];

    public function nguoidung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoidung_id');
    }

    public function baiviet()
    {
        return $this->belongsTo(BaiViet::class, 'baiviet_id');
    }
    
}
