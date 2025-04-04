<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class baiviet extends Model
{
    //
    protected $table = 'baiviet';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($baiviet) {
            $baiviet->tieude_slug = Str::slug($baiviet->tieude);
        });
    }

    public function chude(): BelongsTo
    {
        return $this->belongsTo(ChuDe::class, 'chude_id', 'id');
    }

    public function NguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoidung_id', 'id');
    }

    public function BinhLuanBaiViet(): HasMany
    {
        return $this->hasMany(binh_luan_bai_viet::class, 'baiviet_id', 'id');
    }
    public function getNgayDangAttribute() {
        return Carbon::parse($this->created_at)->format('d/m/Y');
    }
    protected $fillable = ['tieude', 'slug', 'tomtat', 'chude_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function file()
    {
        return $this->hasMany(File::class, 'baiviet_id');
    }

}
