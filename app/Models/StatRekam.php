<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatRekam extends Model
{
    protected $fillable = ['nama_stat_rekam'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'stat_rekams_id');
    }
}
