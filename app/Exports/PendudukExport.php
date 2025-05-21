<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PendudukExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $request;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct($request = null)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Penduduk::with([
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
        ]);

        // Apply filters if request is provided
        if ($this->request) {
            // Search functionality
            if ($this->request->filled('search')) {
                $searchTerm = $this->request->search;
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
            if ($this->request->filled('jk')) {
                $query->where('jk', $this->request->jk);
            }

            if ($this->request->filled('agama_id')) {
                $query->where('agamas_id', $this->request->agama_id);
            }

            if ($this->request->filled('pekerjaan_id')) {
                $query->where('pekerjaans_id', $this->request->pekerjaan_id);
            }

            if ($this->request->filled('pendidikan_id')) {
                $query->where('pendidikans_id', $this->request->pendidikan_id);
            }

            if ($this->request->filled('stat_kawin_id')) {
                $query->where('stat_kawins_id', $this->request->stat_kawin_id);
            }

            if ($this->request->filled('stat_hub_keluarga_id')) {
                $query->where('stat_hub_keluargas_id', $this->request->stat_hub_keluarga_id);
            }

            if ($this->request->filled('stat_dasar_id')) {
                $query->where('stat_dasars_id', $this->request->stat_dasar_id);
            }

            // Age range filter
            if ($this->request->filled('umur_dari') || $this->request->filled('umur_sampai')) {
                $today = now();

                if ($this->request->filled('umur_dari')) {
                    $maxDate = $today->copy()->subYears($this->request->umur_dari);
                    $query->where('tgl_lahir', '<=', $maxDate->format('Y-m-d'));
                }

                if ($this->request->filled('umur_sampai')) {
                    $minDate = $today->copy()->subYears($this->request->umur_sampai + 1)->addDay();
                    $query->where('tgl_lahir', '>=', $minDate->format('Y-m-d'));
                }
            }

            // Sort functionality
            $sortField = $this->request->sort_by ?? 'updated_at';
            $sortDirection = $this->request->sort_direction ?? 'desc';
            $query->orderBy($sortField, $sortDirection);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ALAMAT',
            'DUSUN',
            'RW',
            'RT',
            'NAMA',
            'NO. KK',
            'NIK',
            'JENIS KELAMIN',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'AGAMA',
            'PENDIDIKAN',
            'PENDIDIKAN SEDANG',
            'PEKERJAAN',
            'STATUS PERKAWINAN',
            'STATUS HUBUNGAN KELUARGA',
            'KEWARGANEGARAAN',
            'NIK AYAH',
            'NAMA AYAH',
            'NIK IBU',
            'NAMA IBU',
            'GOLONGAN DARAH',
            'AKTA LAHIR',
            'DOKUMEN PASSPORT',
            'TANGGAL AKHIR PASPOR',
            'DOKUMEN KITAS',
            'AKTA PERKAWINAN',
            'TANGGAL PERKAWINAN',
            'AKTA PERCERAIAN',
            'TANGGAL PERCERAIAN',
            'CACAT',
            'CARA KB',
            'HAMIL',
            'KTP EL',
            'STATUS REKAM',
            'ALAMAT SEKARANG',
            'STATUS DASAR',
            'SUKU',
            'TAG ID CARD',
            'ASURANSI',
            'NO ASURANSI'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // Convert string values to uppercase
        return [
            strtoupper($row->alamat->nama_alamat ?? ''),
            strtoupper($row->alamat->dusun ?? ''),
            strtoupper($row->alamat->no_rw ?? ''),
            strtoupper($row->alamat->no_rt ?? ''),
            strtoupper($row->nama ?? ''),
            "'" . $row->no_kk, // Prefix with a single quote to force text format
            "'" . $row->nik,  // Prefix with a single quote to force text format
            strtoupper($row->jk ?? ''),
            strtoupper($row->tmp_lahir ?? ''),
            $row->tgl_lahir ?? '',
            strtoupper($row->agama->nama_agama ?? ''),
            strtoupper($row->pendidikan->nama_pendidikan ?? ''),
            strtoupper($row->pendidikanSedang->nama_pendidikan_sedangs ?? ''),
            strtoupper($row->pekerjaan->nama_pekerjaan ?? ''),
            strtoupper($row->statKawin->nama_stat_kawins ?? ''),
            strtoupper($row->statHubKeluarga->nama_hub_keluarga ?? ''),
            strtoupper($row->kewarganegaraan ?? ''),
            "'" . ($row->ayah_nik ?? ''),
            strtoupper($row->ayah_nama ?? ''),
            "'" . ($row->ibu_nik ?? ''),
            strtoupper($row->ibu_nama ?? ''),
            strtoupper($row->golDarah->nama_gol_darah ?? ''),
            strtoupper($row->akta_lahir ?? ''),
            strtoupper($row->dok_passport ?? ''),
            $row->tgl_akhir_passport ?? '',
            strtoupper($row->dok_kitas ?? ''),
            strtoupper($row->akta_perkawinan ?? ''),
            $row->tgl_perkawinan ?? '',
            strtoupper($row->akta_perceraian ?? ''),
            $row->tgl_perceraian ?? '',
            strtoupper($row->cacat->nama_cacat ?? ''),
            strtoupper($row->caraKb->nama_cara_kb ?? ''),
            $row->hamil ? 'YA' : 'TIDAK',
            $row->ktp_el ? 'YA' : 'TIDAK',
            strtoupper($row->statRekam->nama_stat_rekam ?? ''),
            strtoupper($row->alamat->alamat_sekarang ?? ''),
            strtoupper($row->statDasar->nama_stat_dasars ?? ''),
            strtoupper($row->suku ?? ''),
            strtoupper($row->tag_id_card ?? ''),
            strtoupper($row->asuransi->nama_asuransi ?? ''),
            strtoupper($row->asuransi->nomor ?? '')
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT, // No. KK column
            'G' => NumberFormat::FORMAT_TEXT, // NIK column
            'R' => NumberFormat::FORMAT_TEXT, // NIK Ayah column
            'T' => NumberFormat::FORMAT_TEXT, // NIK Ibu column
        ];
    }
}
