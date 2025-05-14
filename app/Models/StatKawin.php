<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatKawin extends Model
{
    protected $fillable = ['nama_stat_kawins'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'stat_kawins_id');
    }
}
