<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cacat extends Model
{
    protected $fillable = ['nama_cacat'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'cacats_id');
    }
}
