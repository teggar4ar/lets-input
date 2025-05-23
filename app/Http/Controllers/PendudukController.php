<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Services\PendudukService;
use App\Repositories\ReferenceDataRepository;
use App\Http\Requests\StoreFamilyRequest;
use App\Http\Requests\UpdatePendudukRequest;
use App\Http\Requests\StoreFamilyMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PendudukController extends Controller
{
    protected PendudukService $pendudukService;
    protected ReferenceDataRepository $referenceDataRepository;

    public function __construct(
        PendudukService $pendudukService,
        ReferenceDataRepository $referenceDataRepository
    ) {
        $this->pendudukService = $pendudukService;
        $this->referenceDataRepository = $referenceDataRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $penduduks = $this->pendudukService->getPendudukWithFilters($request);
        $referenceData = $this->referenceDataRepository->getFilterReferenceData();

        return view('penduduk.index', array_merge(
            compact('penduduks'),
            $referenceData
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $referenceData = $this->referenceDataRepository->getAllReferenceData();

        return view('penduduk.create', $referenceData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request): RedirectResponse
    {
        try {
            $familyData = [
                'no_kk' => $request->no_kk,
                'family_members' => $request->family_members,
                'address' => [
                    'alamat' => $request->alamat,
                    'dusun' => $request->dusun,
                    'no_rt' => $request->no_rt,
                    'no_rw' => $request->no_rw,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'alamat_sekarang' => $request->alamat_sekarang,
                ]
            ];

            $this->pendudukService->createFamily($familyData);

            return redirect()->route('penduduk.index')
                ->with('success', 'Data keluarga berhasil disimpan');
        } catch (\Exception $e) {
            // Log the error
            Log::error('PendudukController@store error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $penduduk = $this->pendudukService->findWithRelations((int) $id);

        if (!$penduduk) {
            abort(404, 'Data penduduk tidak ditemukan');
        }

        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $penduduk = $this->pendudukService->findWithRelations((int) $id);

        if (!$penduduk) {
            abort(404, 'Data penduduk tidak ditemukan');
        }

        $familyMembers = $this->pendudukService->getFamilyMembers($penduduk->no_kk);
        $referenceData = $this->referenceDataRepository->getAllReferenceData();

        return view('penduduk.edit', array_merge(
            compact('penduduk', 'familyMembers'),
            $referenceData
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendudukRequest $request, string $id): RedirectResponse
    {
        try {
            $penduduk = $this->pendudukService->findWithRelations((int) $id);

            if (!$penduduk) {
                return redirect()->route('penduduk.index')
                    ->with('error', 'Data penduduk tidak ditemukan');
            }

            $updateData = $request->validated();

            // Separate address data if provided
            if ($request->has('alamat')) {
                $updateData['address'] = [
                    'alamat' => $request->alamat,
                    'dusun' => $request->dusun,
                    'no_rt' => $request->no_rt,
                    'no_rw' => $request->no_rw,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'alamat_sekarang' => $request->alamat_sekarang,
                ];
            }

            $this->pendudukService->updatePenduduk($penduduk, $updateData);

            return redirect()->route('penduduk.index')
                ->with('success', 'Data penduduk berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $penduduk = $this->pendudukService->findWithRelations((int) $id);

            if (!$penduduk) {
                return redirect()->route('penduduk.index')
                    ->with('error', 'Data penduduk tidak ditemukan');
            }

            $this->pendudukService->deletePenduduk($penduduk);

            return redirect()->route('penduduk.index')
                ->with('success', 'Data penduduk berhasil dihapus');
        } catch (\Exception $e) {
            // Return a more user-friendly error message
            $errorMsg = 'Terjadi kesalahan saat menghapus data. ';

            // If it's a foreign key constraint violation, provide a clearer message
            if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                $errorMsg .= 'Data ini masih terkait dengan data lain dan tidak dapat dihapus.';
            } else {
                $errorMsg .= $e->getMessage();
            }

            return redirect()->back()->with('error', $errorMsg);
        }
    }

    /**
     * Show the form for adding a new family member
     */
    public function addFamilyMember(string $kkNumber): View|RedirectResponse
    {
        $familyMember = $this->pendudukService->findByKkNumber($kkNumber);

        if (!$familyMember) {
            return redirect()->route('penduduk.index')
                ->with('error', 'Nomor KK tidak ditemukan');
        }

        $alamatsId = $familyMember->alamats_id;
        $referenceData = $this->referenceDataRepository->getAllReferenceData();

        return view('penduduk.add-family-member', array_merge(
            compact('kkNumber', 'alamatsId'),
            $referenceData
        ));
    }

    /**
     * Store a new family member
     */
    public function storeFamilyMember(StoreFamilyMemberRequest $request): RedirectResponse
    {
        try {
            $memberData = $request->validated();
            $this->pendudukService->addFamilyMember($request->no_kk, $memberData);

            return redirect()->route('penduduk.index')
                ->with('success', 'Anggota keluarga berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
