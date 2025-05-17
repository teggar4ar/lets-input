<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Alamat;
use App\Models\Asuransi;
use App\Models\Cacat;
use App\Models\CaraKb;
use App\Models\GolDarah;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PendidikanSedang;
use App\Models\Penduduk;
use App\Models\StatDasar;
use App\Models\StatHubKeluarga;
use App\Models\StatKawin;
use App\Models\StatRekam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penduduk::with(['alamat', 'agama', 'pendidikan', 'pekerjaan', 'statKawin', 'statDasar', 'statHubKeluarga']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
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

        // Filters
        if ($request->filled('jk')) {
            $query->where('jk', $request->jk);
        }

        if ($request->filled('agama_id')) {
            $query->where('agamas_id', $request->agama_id);
        }

        if ($request->filled('pekerjaan_id')) {
            $query->where('pekerjaans_id', $request->pekerjaan_id);
        }

        if ($request->filled('pendidikan_id')) {
            $query->where('pendidikans_id', $request->pendidikan_id);
        }

        if ($request->filled('stat_kawin_id')) {
            $query->where('stat_kawins_id', $request->stat_kawin_id);
        }

        if ($request->filled('stat_hub_keluarga_id')) {
            $query->where('stat_hub_keluargas_id', $request->stat_hub_keluarga_id);
        }

        if ($request->filled('stat_dasar_id')) {
            $query->where('stat_dasars_id', $request->stat_dasar_id);
        }

        // Age range filter
        if ($request->filled('umur_dari') || $request->filled('umur_sampai')) {
            $today = now();

            if ($request->filled('umur_dari')) {
                $maxDate = $today->copy()->subYears($request->umur_dari);
                $query->where('tgl_lahir', '<=', $maxDate->format('Y-m-d'));
            }

            if ($request->filled('umur_sampai')) {
                $minDate = $today->copy()->subYears($request->umur_sampai + 1)->addDay();
                $query->where('tgl_lahir', '>=', $minDate->format('Y-m-d'));
            }
        }

        // Sort functionality
        $sortField = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        // Get the per page value from the request or use default value
        $perPage = $request->per_page ?? 10;

        $penduduks = $query->paginate($perPage)->withQueryString();

        // Get all reference data for filters
        $agamas = Agama::all();
        $pendidikans = Pendidikan::all();
        $pekerjaans = Pekerjaan::all();
        $statKawins = StatKawin::all();
        $statHubKeluargas = StatHubKeluarga::all();
        $statDasars = StatDasar::all();

        return view('penduduk.index', compact(
            'penduduks',
            'agamas',
            'pendidikans',
            'pekerjaans',
            'statKawins',
            'statHubKeluargas',
            'statDasars'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Load all reference data for form dropdowns
        $agamas = Agama::all();
        $pendidikans = Pendidikan::all();
        $pendidikanSedangs = PendidikanSedang::all();
        $pekerjaans = Pekerjaan::all();
        $statKawins = StatKawin::all();
        $statHubKeluargas = StatHubKeluarga::all();
        $golDarahs = GolDarah::all();
        $cacats = Cacat::all();
        $caraKbs = CaraKb::all();
        $statRekams = StatRekam::all();
        $statDasars = StatDasar::all();
        $asuransis = Asuransi::all();

        // Pass reference data to the view
        return view('penduduk.create', compact(
            'agamas',
            'pendidikans',
            'pendidikanSedangs',
            'pekerjaans',
            'statKawins',
            'statHubKeluargas',
            'golDarahs',
            'cacats',
            'caraKbs',
            'statRekams',
            'statDasars',
            'asuransis'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:16',
            'family_members' => 'required|array|min:1',
            'family_members.*.nik' => 'required|string|max:16|unique:penduduks,nik',
            'family_members.*.nama' => 'required|string|max:255',
            'family_members.*.jk' => 'required|in:laki-laki,perempuan',
            'family_members.*.tmp_lahir' => 'required|string|max:100',
            'family_members.*.tgl_lahir' => 'required|date',
            'family_members.*.agamas_id' => 'required|exists:agamas,id',
            'family_members.*.pendidikans_id' => 'required|exists:pendidikans,id',
            'family_members.*.pekerjaans_id' => 'required|exists:pekerjaans,id',
            'family_members.*.stat_kawins_id' => 'required|exists:stat_kawins,id',
            'family_members.*.stat_hub_keluargas_id' => 'required|exists:stat_hub_keluargas,id',
            'alamat' => 'required|string',
            'dusun' => 'required|string',
            'no_rt' => 'required|integer',
            'no_rw' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            // Create alamat first
            $alamat = Alamat::create([
                'nama_alamat' => $request->alamat,
                'dusun' => $request->dusun,
                'no_rt' => $request->no_rt,
                'no_rw' => $request->no_rw,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'alamat_sekarang' => $request->alamat_sekarang,
            ]);

            // Create each family member
            foreach ($request->family_members as $member) {
                Penduduk::create([
                    'alamats_id' => $alamat->id,
                    'no_kk' => $request->no_kk,
                    'nik' => $member['nik'],
                    'nama' => $member['nama'],
                    'jk' => $member['jk'],
                    'tmp_lahir' => $member['tmp_lahir'],
                    'tgl_lahir' => $member['tgl_lahir'],
                    'agamas_id' => $member['agamas_id'],
                    'pendidikans_id' => $member['pendidikans_id'],
                    'pendidikan_sedangs_id' => $member['pendidikan_sedangs_id'] ?? null,
                    'pekerjaans_id' => $member['pekerjaans_id'],
                    'stat_kawins_id' => $member['stat_kawins_id'],
                    'stat_hub_keluargas_id' => $member['stat_hub_keluargas_id'],
                    'kewarganegaraan' => $member['kewarganegaraan'] ?? 'wni',
                    'ayah_nik' => $member['ayah_nik'] ?? null,
                    'jamkesnas' => isset($member['jamkesnas']) ? 1 : 0,
                    'ayah_nama' => $member['ayah_nama'] ?? null,
                    'ibu_nik' => $member['ibu_nik'] ?? null,
                    'ibu_nama' => $member['ibu_nama'] ?? null,
                    'gol_darahs_id' => $member['gol_darahs_id'] ?? null,
                    'akta_lahir' => $member['akta_lahir'] ?? null,
                    'dok_passport' => $member['dok_passport'] ?? null,
                    'tgl_akhir_passport' => $member['tgl_akhir_passport'] ?? null,
                    'dok_kitas' => $member['dok_kitas'] ?? null,
                    'akta_perkawinan' => $member['akta_perkawinan'] ?? null,
                    'tgl_perkawinan' => $member['tgl_perkawinan'] ?? null,
                    'akta_perceraian' => $member['akta_perceraian'] ?? null,
                    'tgl_perceraian' => $member['tgl_perceraian'] ?? null,
                    'cacats_id' => $member['cacats_id'] ?? null,
                    'cara_kbs_id' => $member['cara_kbs_id'] ?? null,
                    'hamil' => isset($member['hamil']) ? 1 : 0,
                    'ktp_el' => isset($member['ktp_el']) ? 1 : 0,
                    'stat_rekams_id' => $member['stat_rekams_id'] ?? null,
                    'stat_dasars_id' => $member['stat_dasars_id'] ?? 1, // Default to "HIDUP"
                    'suku' => $member['suku'] ?? null,
                    'tag_id_card' => $member['tag_id_card'] ?? null,
                    'asuransis_id' => $member['asuransis_id'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('penduduk.index')->with('success', 'Data keluarga berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penduduk = Penduduk::with([
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
        ])->findOrFail($id);

        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penduduk = Penduduk::with('alamat')->findOrFail($id);

        // Get family members with the same KK number
        $familyMembers = Penduduk::where('no_kk', $penduduk->no_kk)->get();

        // Load all reference data for form dropdowns
        $agamas = Agama::all();
        $pendidikans = Pendidikan::all();
        $pendidikanSedangs = PendidikanSedang::all();
        $pekerjaans = Pekerjaan::all();
        $statKawins = StatKawin::all();
        $statHubKeluargas = StatHubKeluarga::all();
        $golDarahs = GolDarah::all();
        $cacats = Cacat::all();
        $caraKbs = CaraKb::all();
        $statRekams = StatRekam::all();
        $statDasars = StatDasar::all();
        $asuransis = Asuransi::all();

        return view('penduduk.edit', compact(
            'penduduk',
            'familyMembers',
            'agamas',
            'pendidikans',
            'pendidikanSedangs',
            'pekerjaans',
            'statKawins',
            'statHubKeluargas',
            'golDarahs',
            'cacats',
            'caraKbs',
            'statRekams',
            'statDasars',
            'asuransis'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:16|unique:penduduks,nik,' . $id,
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:laki-laki,perempuan',
            'tmp_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'agamas_id' => 'required|exists:agamas,id',
            'pendidikans_id' => 'required|exists:pendidikans,id',
            'pekerjaans_id' => 'required|exists:pekerjaans,id',
            'stat_kawins_id' => 'required|exists:stat_kawins,id',
            'stat_hub_keluargas_id' => 'required|exists:stat_hub_keluargas,id',
        ]);

        try {
            DB::beginTransaction();

            // Update alamat if needed
            if ($request->has('alamat')) {
                $penduduk->alamat->update([
                    'nama_alamat' => $request->alamat,
                    'dusun' => $request->dusun,
                    'no_rt' => $request->no_rt,
                    'no_rw' => $request->no_rw,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'alamat_sekarang' => $request->alamat_sekarang,
                ]);
            }

            // Update penduduk information
            $penduduk->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'agamas_id' => $request->agamas_id,
                'pendidikans_id' => $request->pendidikans_id,
                'pendidikan_sedangs_id' => $request->pendidikan_sedangs_id,
                'pekerjaans_id' => $request->pekerjaans_id,
                'stat_kawins_id' => $request->stat_kawins_id,
                'stat_hub_keluargas_id' => $request->stat_hub_keluargas_id,
                'kewarganegaraan' => $request->kewarganegaraan ?? 'wni',
                'ayah_nik' => $request->ayah_nik,
                'jamkesnas' => isset($request->jamkesnas) ? 1 : 0,
                'ayah_nama' => $request->ayah_nama,
                'ibu_nik' => $request->ibu_nik,
                'ibu_nama' => $request->ibu_nama,
                'gol_darahs_id' => $request->gol_darahs_id,
                'akta_lahir' => $request->akta_lahir,
                'dok_passport' => $request->dok_passport,
                'tgl_akhir_passport' => $request->tgl_akhir_passport,
                'dok_kitas' => $request->dok_kitas,
                'akta_perkawinan' => $request->akta_perkawinan,
                'tgl_perkawinan' => $request->tgl_perkawinan,
                'akta_perceraian' => $request->akta_perceraian,
                'tgl_perceraian' => $request->tgl_perceraian,
                'cacats_id' => $request->cacats_id,
                'cara_kbs_id' => $request->cara_kbs_id,
                'hamil' => isset($request->hamil) ? 1 : 0,
                'ktp_el' => isset($request->ktp_el) ? 1 : 0,
                'stat_rekams_id' => $request->stat_rekams_id,
                'stat_dasars_id' => $request->stat_dasars_id,
                'suku' => $request->suku,
                'tag_id_card' => $request->tag_id_card,
                'asuransis_id' => $request->asuransis_id,
            ]);

            DB::commit();
            return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $penduduk = Penduduk::findOrFail($id);
            $penduduk->delete();

            return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for adding a new family member
     */
    public function addFamilyMember($kkNumber)
    {
        // Find other family members to get the address
        $familyMember = Penduduk::where('no_kk', $kkNumber)->first();

        if (!$familyMember) {
            return redirect()->route('penduduk.index')->with('error', 'Nomor KK tidak ditemukan');
        }

        $alamatsId = $familyMember->alamats_id;

        // Load all reference data for form dropdowns
        $agamas = Agama::all();
        $pendidikans = Pendidikan::all();
        $pendidikanSedangs = PendidikanSedang::all();
        $pekerjaans = Pekerjaan::all();
        $statKawins = StatKawin::all();
        $statHubKeluargas = StatHubKeluarga::all();
        $golDarahs = GolDarah::all();
        $cacats = Cacat::all();
        $caraKbs = CaraKb::all();
        $statRekams = StatRekam::all();
        $statDasars = StatDasar::all();
        $asuransis = Asuransi::all();

        return view('penduduk.add-family-member', compact(
            'kkNumber',
            'alamatsId',
            'agamas',
            'pendidikans',
            'pendidikanSedangs',
            'pekerjaans',
            'statKawins',
            'statHubKeluargas',
            'golDarahs',
            'cacats',
            'caraKbs',
            'statRekams',
            'statDasars',
            'asuransis'
        ));
    }

    /**
     * Store a new family member
     */
    public function storeFamilyMember(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:16|exists:penduduks,no_kk',
            'alamats_id' => 'required|exists:alamats,id',
            'nik' => 'required|string|max:16|unique:penduduks,nik',
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:laki-laki,perempuan',
            'tmp_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'agamas_id' => 'required|exists:agamas,id',
            'pendidikans_id' => 'required|exists:pendidikans,id',
            'pekerjaans_id' => 'required|exists:pekerjaans,id',
            'stat_kawins_id' => 'required|exists:stat_kawins,id',
            'stat_hub_keluargas_id' => 'required|exists:stat_hub_keluargas,id',
        ]);

        try {
            Penduduk::create([
                'alamats_id' => $request->alamats_id,
                'no_kk' => $request->no_kk,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'agamas_id' => $request->agamas_id,
                'pendidikans_id' => $request->pendidikans_id,
                'pendidikan_sedangs_id' => $request->pendidikan_sedangs_id,
                'pekerjaans_id' => $request->pekerjaans_id,
                'stat_kawins_id' => $request->stat_kawins_id,
                'stat_hub_keluargas_id' => $request->stat_hub_keluargas_id,
                'kewarganegaraan' => $request->kewarganegaraan ?? 'wni',
                'ayah_nik' => $request->ayah_nik,
                'jamkesnas' => isset($request->jamkesnas) ? 1 : 0,
                'ayah_nama' => $request->ayah_nama,
                'ibu_nik' => $request->ibu_nik,
                'ibu_nama' => $request->ibu_nama,
                'gol_darahs_id' => $request->gol_darahs_id,
                'akta_lahir' => $request->akta_lahir,
                'dok_passport' => $request->dok_passport,
                'tgl_akhir_passport' => $request->tgl_akhir_passport,
                'dok_kitas' => $request->dok_kitas,
                'akta_perkawinan' => $request->akta_perkawinan,
                'tgl_perkawinan' => $request->tgl_perkawinan,
                'akta_perceraian' => $request->akta_perceraian,
                'tgl_perceraian' => $request->tgl_perceraian,
                'cacats_id' => $request->cacats_id,
                'cara_kbs_id' => $request->cara_kbs_id,
                'hamil' => isset($request->hamil) ? 1 : 0,
                'ktp_el' => isset($request->ktp_el) ? 1 : 0,
                'stat_rekams_id' => $request->stat_rekams_id,
                'stat_dasars_id' => $request->stat_dasars_id ?? 1, // Default to "HIDUP"
                'suku' => $request->suku,
                'tag_id_card' => $request->tag_id_card,
                'asuransis_id' => $request->asuransis_id,
            ]);

            return redirect()->route('penduduk.index')->with('success', 'Anggota keluarga berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
