<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';
    protected $fillable = ['baiviet_id', 'nguoidung_id', 'duong_dan_file', 'loai_file', 'ten_goc'];

    public function baiviet()
    {
        return $this->belongsTo(BaiViet::class, 'baiviet_id');
    }

    public function nguoidung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoidung_id');
    }
}