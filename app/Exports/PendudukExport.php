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
            'No. KK',
            'NIK',
            'Nama',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Dusun',
            'RT',
            'RW',
            'Agama',
            'Pendidikan',
            'Pendidikan Sedang',
            'Pekerjaan',
            'Status Perkawinan',
            'Status Hubungan Keluarga',
            'Kewarganegaraan',
            'Nama Ayah',
            'Nama Ibu',
            'Golongan Darah',
            'Status Rekam KTP',
            'Status Dasar',
            'Asuransi'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            "'" . $row->no_kk, // Prefix with a single quote to force text format
            "'" . $row->nik,  // Prefix with a single quote to force text format
            $row->nama,
            $row->jk,
            $row->tmp_lahir,
            $row->tgl_lahir,
            $row->alamat->nama_alamat ?? '',
            $row->alamat->dusun ?? '',
            $row->alamat->no_rt ?? '',
            $row->alamat->no_rw ?? '',
            $row->agama->nama_agama ?? '',
            $row->pendidikan->nama_pendidikan ?? '',
            $row->pendidikanSedang->nama_pendidikan_sedangs ?? '',
            $row->pekerjaan->nama_pekerjaan ?? '',
            $row->statKawin->nama_stat_kawins ?? '',
            $row->statHubKeluarga->nama_hub_keluarga ?? '',
            $row->kewarganegaraan,
            $row->ayah_nama,
            $row->ibu_nama,
            $row->golDarah->nama_gol_darah ?? '',
            $row->statRekam->nama_stat_rekam ?? '',
            $row->statDasar->nama_stat_dasars ?? '',
            $row->asuransi->nama_asuransi ?? ''
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // No. KK column
            'B' => NumberFormat::FORMAT_TEXT, // NIK column
        ];
    }
}
