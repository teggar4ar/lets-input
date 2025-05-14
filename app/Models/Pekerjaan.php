<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaans';
    protected $fillable = ['nama_pekerjaan'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'pekerjaans_id');
    }
}
