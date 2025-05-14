<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agama extends Model
{
    protected $fillable = ['nama_agama'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'agamas_id');
    }
}
