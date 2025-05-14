<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asuransi extends Model
{
    protected $table = 'asuransis';
    protected $fillable = ['nomor', 'nama_asuransi'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'asuransis_id');
    }
}
