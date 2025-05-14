<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PendidikanSedang extends Model
{
    protected $table = 'pendidikan_sedangs';
    protected $fillable = ['nama_pendidikan_sedangs'];

    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'pendidikan_sedangs_id');
    }
}
