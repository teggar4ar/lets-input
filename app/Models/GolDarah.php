<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GolDarah extends Model
{
    protected $fillable = ['nama_gol_darah'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'gol_darahs_id');
    }
}
