<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class chude extends Model
{
    protected $table = 'chude';
    protected $fillable = ['tenchude', 'tenchude_slug'];

    // Quan hệ nhiều-nhiều với Baiviet
    public function baiviets(): BelongsToMany
    {
        return $this->belongsToMany(BaiViet::class, 'baiviet_chude', 'chude_id', 'baiviet_id');
    }
}