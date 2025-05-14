<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatDasar extends Model
{
    protected $table = 'stat_dasars';
    protected $fillable = ['nama_stat_dasars'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'stat_dasars_id');
    }
}
