<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class chude extends Model
{
    //
    protected $table = 'chude';
    protected $fillable = ['slug'];
    public function BaiViet(): HasMany
    {
        return $this->hasMany(BaiViet::class, 'chude_id', 'id');
    }
}
