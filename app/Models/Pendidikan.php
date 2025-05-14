<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendidikan extends Model
{
    protected $fillable = ['nama_pendidikan'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'pendidikans_id');
    }
}
