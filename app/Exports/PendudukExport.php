<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Http\Request;

class PendudukExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $request;

    public function __construct(Request $request)
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

        // Apply filters if they exist in the request
        if ($this->request) {
            // Search functionality
            if ($this->request->has('search') && !empty($this->request->search)) {
                $searchTerm = $this->request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('nama', 'like', '%' . $searchTerm . '%')
                        ->orWhere('nik', 'like', '%' . $searchTerm . '%')
                        ->orWhere('no_kk', 'like', '%' . $searchTerm . '%');
                });
            }

            // Dusun filter
            if ($this->request->has('filter_dusun') && !empty($this->request->filter_dusun)) {
                $query->whereHas('alamat', function ($q) {
                    $q->where('dusun', $this->request->filter_dusun);
                });
            }
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
