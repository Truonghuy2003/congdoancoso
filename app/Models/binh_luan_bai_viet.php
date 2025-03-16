<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class binh_luan_bai_viet extends Model
{
    //
    protected $table = 'binhluanbaiviet';
    protected $fillable = ['nguoidung_id', 'baiviet_id', 'noidungbinhluan', 'kiemduyet', 'kichhoat'];
    public function BaiViet(): BelongsTo
    {
        return $this->belongsTo(BaiViet::class, 'baiviet_id', 'id');
    }

    public function NguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoidung_id', 'id');
    }
}
