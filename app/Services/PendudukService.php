<?php

namespace App\Services;

use App\Models\Penduduk;
use App\Models\Alamat;
use App\Repositories\PendudukRepository;
use App\Repositories\ReferenceDataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PendudukService
{
    protected PendudukRepository $pendudukRepository;
    protected ReferenceDataRepository $referenceDataRepository;

    public function __construct(
        PendudukRepository $pendudukRepository,
        ReferenceDataRepository $referenceDataRepository
    ) {
        $this->pendudukRepository = $pendudukRepository;
        $this->referenceDataRepository = $referenceDataRepository;
    }

    /**
     * Get paginated and filtered penduduk data
     */
    public function getPendudukWithFilters(Request $request): LengthAwarePaginator
    {
        $filters = $this->buildFilters($request);
        $sortField = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $perPage = $request->per_page ?? 10;

        return $this->pendudukRepository->getFilteredPenduduk(
            $filters,
            $sortField,
            $sortDirection,
            $perPage
        );
    }

    /**
     * Create a new family with members
     */
    public function createFamily(array $familyData): bool
    {
        try {
            DB::beginTransaction();

            // Create address
            $alamat = $this->createAlamat($familyData['address']);

            // Create family members
            foreach ($familyData['family_members'] as $memberData) {
                $this->createFamilyMember($alamat->id, $familyData['no_kk'], $memberData);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update penduduk data
     */
    public function updatePenduduk(Penduduk $penduduk, array $data): bool
    {
        try {
            DB::beginTransaction();

            // Update address if provided
            if (isset($data['address'])) {
                $this->updateAlamat($penduduk->alamat, $data['address']);
            }

            // Update penduduk data
            $pendudukData = $this->preparePendudukData($data);
            $penduduk->update($pendudukData);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Add a new family member
     */
    public function addFamilyMember(string $kkNumber, array $memberData): bool
    {
        try {
            $familyMember = $this->pendudukRepository->findByKkNumber($kkNumber);

            if (!$familyMember) {
                throw new \Exception('Nomor KK tidak ditemukan');
            }

            $pendudukData = $this->preparePendudukData($memberData);
            $pendudukData['alamats_id'] = $familyMember->alamats_id;
            $pendudukData['no_kk'] = $kkNumber;

            $this->pendudukRepository->create($pendudukData);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get family members by KK number
     */
    public function getFamilyMembers(string $kkNumber)
    {
        return $this->pendudukRepository->getFamilyMembers($kkNumber);
    }

    /**
     * Find penduduk with all relations by ID
     */
    public function findWithRelations(int $id): ?Penduduk
    {
        return $this->pendudukRepository->findWithRelations($id);
    }

    /**
     * Find penduduk by KK number
     */
    public function findByKkNumber(string $kkNumber): ?Penduduk
    {
        return $this->pendudukRepository->findByKkNumber($kkNumber);
    }

    /**
     * Delete penduduk and handle related data
     */    public function deletePenduduk(Penduduk $penduduk): bool
    {
        try {
            DB::beginTransaction();

            // Get the alamat before deleting penduduk
            $alamat = $penduduk->alamat;

            // Delete the penduduk record first
            $penduduk->delete();

            // After deleting the penduduk, check if there are any other family members
            if ($alamat) {
                // Use the safer method to check if address can be deleted
                $isSafeToDelete = $this->pendudukRepository->isAddressSafeToDelete($alamat->id);

                // If no other family members exist, delete the address
                if ($isSafeToDelete) {
                    $alamat->delete();
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Build filters array from request
     */
    private function buildFilters(Request $request): array
    {
        $filters = [];

        if ($request->filled('search')) {
            $filters['search'] = $request->search;
        }

        if ($request->filled('jk')) {
            $filters['jk'] = $request->jk;
        }

        if ($request->filled('agama_id')) {
            $filters['agama_id'] = $request->agama_id;
        }

        if ($request->filled('pekerjaan_id')) {
            $filters['pekerjaan_id'] = $request->pekerjaan_id;
        }

        if ($request->filled('pendidikan_id')) {
            $filters['pendidikan_id'] = $request->pendidikan_id;
        }

        if ($request->filled('stat_kawin_id')) {
            $filters['stat_kawin_id'] = $request->stat_kawin_id;
        }

        if ($request->filled('stat_hub_keluarga_id')) {
            $filters['stat_hub_keluarga_id'] = $request->stat_hub_keluarga_id;
        }

        if ($request->filled('stat_dasar_id')) {
            $filters['stat_dasar_id'] = $request->stat_dasar_id;
        }

        if ($request->filled('umur_dari') || $request->filled('umur_sampai')) {
            $filters['age_range'] = [
                'from' => $request->umur_dari,
                'to' => $request->umur_sampai
            ];
        }

        return $filters;
    }

    /**
     * Create alamat record
     */
    private function createAlamat(array $addressData): Alamat
    {
        return Alamat::create([
            'nama_alamat' => $addressData['alamat'],
            'dusun' => $addressData['dusun'],
            'no_rt' => $addressData['no_rt'],
            'no_rw' => $addressData['no_rw'],
            'lat' => $addressData['lat'] ?? null,
            'lng' => $addressData['lng'] ?? null,
            'alamat_sekarang' => $addressData['alamat_sekarang'] ?? null,
        ]);
    }

    /**
     * Update alamat record
     */
    private function updateAlamat(Alamat $alamat, array $addressData): void
    {
        $alamat->update([
            'nama_alamat' => $addressData['alamat'],
            'dusun' => $addressData['dusun'],
            'no_rt' => $addressData['no_rt'],
            'no_rw' => $addressData['no_rw'],
            'lat' => $addressData['lat'] ?? $alamat->lat,
            'lng' => $addressData['lng'] ?? $alamat->lng,
            'alamat_sekarang' => $addressData['alamat_sekarang'] ?? $alamat->alamat_sekarang,
        ]);
    }

    /**
     * Create family member
     */
    private function createFamilyMember(int $alamatId, string $noKk, array $memberData): void
    {
        $pendudukData = $this->preparePendudukData($memberData);
        $pendudukData['alamats_id'] = $alamatId;
        $pendudukData['no_kk'] = $noKk;

        $this->pendudukRepository->create($pendudukData);
    }

    /**
     * Prepare penduduk data for database insertion/update
     */
    private function preparePendudukData(array $data): array
    {
        return [
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'jk' => $data['jk'],
            'tmp_lahir' => $data['tmp_lahir'],
            'tgl_lahir' => $data['tgl_lahir'],
            'agamas_id' => $data['agamas_id'],
            'pendidikans_id' => $data['pendidikans_id'],
            'pendidikan_sedangs_id' => $data['pendidikan_sedangs_id'] ?? null,
            'pekerjaans_id' => $data['pekerjaans_id'],
            'stat_kawins_id' => $data['stat_kawins_id'],
            'stat_hub_keluargas_id' => $data['stat_hub_keluargas_id'],
            'kewarganegaraan' => $data['kewarganegaraan'] ?? 'wni',
            'ayah_nik' => $data['ayah_nik'] ?? null,
            'jamkesnas' => isset($data['jamkesnas']) ? 1 : 0,
            'ayah_nama' => $data['ayah_nama'] ?? null,
            'ibu_nik' => $data['ibu_nik'] ?? null,
            'ibu_nama' => $data['ibu_nama'] ?? null,
            'gol_darahs_id' => $data['gol_darahs_id'] ?? null,
            'akta_lahir' => $data['akta_lahir'] ?? null,
            'dok_passport' => $data['dok_passport'] ?? null,
            'tgl_akhir_passport' => $data['tgl_akhir_passport'] ?? null,
            'dok_kitas' => $data['dok_kitas'] ?? null,
            'akta_perkawinan' => $data['akta_perkawinan'] ?? null,
            'tgl_perkawinan' => $data['tgl_perkawinan'] ?? null,
            'akta_perceraian' => $data['akta_perceraian'] ?? null,
            'tgl_perceraian' => $data['tgl_perceraian'] ?? null,
            'cacats_id' => $data['cacats_id'] ?? null,
            'cara_kbs_id' => $data['cara_kbs_id'] ?? null,
            'hamil' => isset($data['hamil']) ? 1 : 0,
            'ktp_el' => isset($data['ktp_el']) ? 1 : 0,
            'stat_rekams_id' => $data['stat_rekams_id'] ?? null,
            'stat_dasars_id' => $data['stat_dasars_id'] ?? 1,
            'suku' => $data['suku'] ?? null,
            'tag_id_card' => $data['tag_id_card'] ?? null,
            'asuransis_id' => $data['asuransis_id'] ?? null,
        ];
    }
}
