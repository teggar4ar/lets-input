<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaraKb extends Model
{
    protected $fillable = ['nama_cara_kb'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'cara_kbs_id');
    }
}
