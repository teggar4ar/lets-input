<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatHubKeluarga extends Model
{
    protected $fillable = ['nama_hub_keluarga'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'stat_hub_keluargas_id');
    }
}
