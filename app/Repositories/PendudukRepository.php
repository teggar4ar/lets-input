<?php

namespace App\Repositories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PendudukRepository
{
    protected Penduduk $model;

    public function __construct(Penduduk $model)
    {
        $this->model = $model;
    }

    /**
     * Get filtered and paginated penduduk data
     */
    public function getFilteredPenduduk(
        array $filters = [],
        string $sortField = 'updated_at',
        string $sortDirection = 'desc',
        int $perPage = 10
    ): LengthAwarePaginator {
        $query = $this->model->with([
            'alamat',
            'agama',
            'pendidikan',
            'pekerjaan',
            'statKawin',
            'statDasar',
            'statHubKeluarga'
        ]);

        $query = $this->applyFilters($query, $filters);
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Find penduduk by ID with relationships
     */
    public function findWithRelations(int $id): ?Penduduk
    {
        return $this->model->with([
            'alamat',
            'agama',
            'pendidikan',
            'pendidikanSedang',
            'pekerjaan',
            'statKawin',
            'statHubKeluarga',
            'golDarah',
            'cacat',
            'caraKb',
            'statRekam',
            'statDasar',
            'asuransi'
        ])->find($id);
    }

    /**
     * Find penduduk by KK number
     */
    public function findByKkNumber(string $kkNumber): ?Penduduk
    {
        return $this->model->where('no_kk', $kkNumber)->first();
    }

    /**
     * Get family members by KK number
     */
    public function getFamilyMembers(string $kkNumber): Collection
    {
        return $this->model->where('no_kk', $kkNumber)->get();
    }

    /**
     * Create new penduduk record
     */
    public function create(array $data): Penduduk
    {
        return $this->model->create($data);
    }

    /**
     * Update penduduk record
     */
    public function update(Penduduk $penduduk, array $data): bool
    {
        return $penduduk->update($data);
    }

    /**
     * Delete penduduk record
     */
    public function delete(Penduduk $penduduk): bool
    {
        return $penduduk->delete();
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        // Search filter
        if (isset($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                    ->orWhere('nik', 'like', "%{$searchTerm}%")
                    ->orWhere('no_kk', 'like', "%{$searchTerm}%")
                    ->orWhereHas('alamat', function ($q2) use ($searchTerm) {
                        $q2->where('nama_alamat', 'like', "%{$searchTerm}%")
                            ->orWhere('dusun', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Gender filter
        if (isset($filters['jk'])) {
            $query->where('jk', $filters['jk']);
        }

        // Religion filter
        if (isset($filters['agama_id'])) {
            $query->where('agamas_id', $filters['agama_id']);
        }

        // Job filter
        if (isset($filters['pekerjaan_id'])) {
            $query->where('pekerjaans_id', $filters['pekerjaan_id']);
        }

        // Education filter
        if (isset($filters['pendidikan_id'])) {
            $query->where('pendidikans_id', $filters['pendidikan_id']);
        }

        // Marital status filter
        if (isset($filters['stat_kawin_id'])) {
            $query->where('stat_kawins_id', $filters['stat_kawin_id']);
        }

        // Family relationship filter
        if (isset($filters['stat_hub_keluarga_id'])) {
            $query->where('stat_hub_keluargas_id', $filters['stat_hub_keluarga_id']);
        }

        // Basic status filter
        if (isset($filters['stat_dasar_id'])) {
            $query->where('stat_dasars_id', $filters['stat_dasar_id']);
        }

        // Age range filter
        if (isset($filters['age_range'])) {
            $this->applyAgeRangeFilter($query, $filters['age_range']);
        }

        return $query;
    }

    /**
     * Apply age range filter to the query
     */
    private function applyAgeRangeFilter(Builder $query, array $ageRange): void
    {
        $today = now();

        if (!empty($ageRange['from'])) {
            $maxDate = $today->copy()->subYears($ageRange['from']);
            $query->where('tgl_lahir', '<=', $maxDate->format('Y-m-d'));
        }

        if (!empty($ageRange['to'])) {
            $minDate = $today->copy()->subYears($ageRange['to'] + 1)->addDay();
            $query->where('tgl_lahir', '>=', $minDate->format('Y-m-d'));
        }
    }

    /**
     * Count penduduk records by alamat_id
     * This counts all penduduk records (not deleted) that are associated with the given alamat
     */
    public function countByAlamatId(int $alamatId): int
    {
        // Make sure we don't count soft-deleted records and that the count is accurate
        return $this->model->where('alamats_id', $alamatId)->whereNull('deleted_at')->count();
    }

    /**
     * Check if an address is safe to delete by ensuring no other penduduk records reference it
     */
    public function isAddressSafeToDelete(int $alamatId, int $excludePendudukId = null): bool
    {
        $query = $this->model->where('alamats_id', $alamatId)->whereNull('deleted_at');

        // Exclude the current penduduk if ID provided
        if ($excludePendudukId) {
            $query->where('id', '!=', $excludePendudukId);
        }

        // If count is 0, it's safe to delete
        return $query->count() === 0;
    }
}
