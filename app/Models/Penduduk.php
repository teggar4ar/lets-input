<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penduduk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'alamats_id',
        'no_kk',
        'nik',
        'nama',
        'jk',
        'tmp_lahir',
        'tgl_lahir',
        'agamas_id',
        'pendidikans_id',
        'pendidikan_sedangs_id',
        'pekerjaans_id',
        'stat_kawins_id',
        'stat_hub_keluargas_id',
        'kewarganegaraan',
        'ayah_nik',
        'jamkesnas',
        'ayah_nama',
        'ibu_nik',
        'ibu_nama',
        'gol_darahs_id',
        'akta_lahir',
        'dok_passport',
        'tgl_akhir_passport',
        'dok_kitas',
        'akta_perkawinan',
        'tgl_perkawinan',
        'akta_perceraian',
        'tgl_perceraian',
        'cacats_id',
        'cara_kbs_id',
        'hamil',
        'ktp_el',
        'stat_rekams_id',
        'stat_dasars_id',
        'suku',
        'tag_id_card',
        'asuransis_id'
    ];

    // Relationships
    public function alamat(): BelongsTo
    {
        return $this->belongsTo(Alamat::class, 'alamats_id');
    }

    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'agamas_id');
    }

    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikans_id');
    }

    public function pendidikanSedang(): BelongsTo
    {
        return $this->belongsTo(PendidikanSedang::class, 'pendidikan_sedangs_id');
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaans_id');
    }

    public function statKawin(): BelongsTo
    {
        return $this->belongsTo(StatKawin::class, 'stat_kawins_id');
    }

    public function statHubKeluarga(): BelongsTo
    {
        return $this->belongsTo(StatHubKeluarga::class, 'stat_hub_keluargas_id');
    }

    public function golDarah(): BelongsTo
    {
        return $this->belongsTo(GolDarah::class, 'gol_darahs_id');
    }

    public function cacat(): BelongsTo
    {
        return $this->belongsTo(Cacat::class, 'cacats_id');
    }

    public function caraKb(): BelongsTo
    {
        return $this->belongsTo(CaraKb::class, 'cara_kbs_id');
    }

    public function statRekam(): BelongsTo
    {
        return $this->belongsTo(StatRekam::class, 'stat_rekams_id');
    }

    public function statDasar(): BelongsTo
    {
        return $this->belongsTo(StatDasar::class, 'stat_dasars_id');
    }

    public function asuransi(): BelongsTo
    {
        return $this->belongsTo(Asuransi::class, 'asuransis_id');
    }
}
