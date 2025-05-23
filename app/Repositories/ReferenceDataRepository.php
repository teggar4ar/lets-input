<?php

namespace App\Repositories;

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PendidikanSedang;
use App\Models\StatKawin;
use App\Models\StatHubKeluarga;
use App\Models\StatDasar;
use App\Models\GolDarah;
use App\Models\Cacat;
use App\Models\CaraKb;
use App\Models\StatRekam;
use App\Models\Asuransi;
use Illuminate\Database\Eloquent\Collection;

class ReferenceDataRepository
{
    /**
     * Get all reference data for forms
     */
    public function getAllReferenceData(): array
    {
        return [
            'agamas' => Agama::all(),
            'pendidikans' => Pendidikan::all(),
            'pendidikanSedangs' => PendidikanSedang::all(),
            'pekerjaans' => Pekerjaan::all(),
            'statKawins' => StatKawin::all(),
            'statHubKeluargas' => StatHubKeluarga::all(),
            'golDarahs' => GolDarah::all(),
            'cacats' => Cacat::all(),
            'caraKbs' => CaraKb::all(),
            'statRekams' => StatRekam::all(),
            'statDasars' => StatDasar::all(),
            'asuransis' => Asuransi::all(),
        ];
    }

    /**
     * Get reference data for filters only
     */
    public function getFilterReferenceData(): array
    {
        return [
            'agamas' => Agama::all(),
            'pendidikans' => Pendidikan::all(),
            'pekerjaans' => Pekerjaan::all(),
            'statKawins' => StatKawin::all(),
            'statHubKeluargas' => StatHubKeluarga::all(),
            'statDasars' => StatDasar::all(),
        ];
    }

    /**
     * Get religions
     */
    public function getAgamas(): Collection
    {
        return Agama::all();
    }

    /**
     * Get educations
     */
    public function getPendidikans(): Collection
    {
        return Pendidikan::all();
    }

    /**
     * Get ongoing educations
     */
    public function getPendidikanSedangs(): Collection
    {
        return PendidikanSedang::all();
    }

    /**
     * Get jobs
     */
    public function getPekerjaans(): Collection
    {
        return Pekerjaan::all();
    }

    /**
     * Get marital statuses
     */
    public function getStatKawins(): Collection
    {
        return StatKawin::all();
    }

    /**
     * Get family relationships
     */
    public function getStatHubKeluargas(): Collection
    {
        return StatHubKeluarga::all();
    }

    /**
     * Get basic statuses
     */
    public function getStatDasars(): Collection
    {
        return StatDasar::all();
    }

    /**
     * Get blood types
     */
    public function getGolDarahs(): Collection
    {
        return GolDarah::all();
    }

    /**
     * Get disabilities
     */
    public function getCacats(): Collection
    {
        return Cacat::all();
    }

    /**
     * Get contraception methods
     */
    public function getCaraKbs(): Collection
    {
        return CaraKb::all();
    }

    /**
     * Get record statuses
     */
    public function getStatRekams(): Collection
    {
        return StatRekam::all();
    }

    /**
     * Get insurance types
     */
    public function getAsuransis(): Collection
    {
        return Asuransi::all();
    }
}
