<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class baiviet extends Model
{
    protected $table = 'baiviet';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($baiviet) {
            $baiviet->tieude_slug = Str::slug($baiviet->tieude);
        });
    }

    // Quan hệ nhiều-nhiều với Chude
    public function chudes(): BelongsToMany
    {
        return $this->belongsToMany(Chude::class, 'baiviet_chude', 'baiviet_id', 'chude_id');
    }

    public function NguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoidung_id', 'id');
    }

    public function BinhLuanBaiViet(): HasMany
    {
        return $this->hasMany(binh_luan_bai_viet::class, 'baiviet_id', 'id');
    }

    public function getNgayDangAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y');
    }

    protected $fillable = ['tieude', 'tieude_slug', 'tomtat', 'noidung'];

    public function getRouteKeyName()
    {
        return 'tieude_slug';
    }

    public function file()
    {
        return $this->hasMany(File::class, 'baiviet_id');
    }
}