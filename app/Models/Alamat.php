<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alamat extends Model
{
    protected $fillable = [
        'nama_alamat',
        'dusun',
        'no_rt',
        'no_rw',
        'lat',
        'lng',
        'alamat_sekarang'
    ];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'alamats_id');
    }
}
