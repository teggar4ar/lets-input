<?php

namespace Database\Seeders;

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PendidikanSedang;
use App\Models\StatKawin;
use App\Models\StatHubKeluarga;
use App\Models\GolDarah;
use App\Models\Cacat;
use App\Models\CaraKb;
use App\Models\StatRekam;
use App\Models\StatDasar;
use App\Models\Asuransi;
use Illuminate\Database\Seeder;

class ReferenceTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Agama
        $agamas = [
            ['nama_agama' => 'Islam'],
            ['nama_agama' => 'Kristen'],
            ['nama_agama' => 'Katolik'],
            ['nama_agama' => 'Hindu'],
            ['nama_agama' => 'Buddha'],
            ['nama_agama' => 'Konghucu'],
            ['nama_agama' => 'Lainnya'],
        ];
        foreach ($agamas as $agama) {
            Agama::create($agama);
        }

        // Pendidikan
        $pendidikans = [
            ['nama_pendidikan' => 'Tidak/Belum Sekolah'],
            ['nama_pendidikan' => 'Belum Tamat SD/Sederajat'],
            ['nama_pendidikan' => 'Tamat SD/Sederajat'],
            ['nama_pendidikan' => 'SLTP/Sederajat'],
            ['nama_pendidikan' => 'SLTA/Sederajat'],
            ['nama_pendidikan' => 'Diploma I/II'],
            ['nama_pendidikan' => 'Akademi/Diploma III/S. Muda'],
            ['nama_pendidikan' => 'Diploma IV/Strata I'],
            ['nama_pendidikan' => 'Strata II'],
            ['nama_pendidikan' => 'Strata III'],
        ];
        foreach ($pendidikans as $pendidikan) {
            Pendidikan::create($pendidikan);
        }

        // Pendidikan Sedang
        $pendidikanSedangs = [
            ['nama_pendidikan_sedangs' => 'Tidak/Belum Sekolah'],
            ['nama_pendidikan_sedangs' => 'SD/Sederajat'],
            ['nama_pendidikan_sedangs' => 'SLTP/Sederajat'],
            ['nama_pendidikan_sedangs' => 'SLTA/Sederajat'],
            ['nama_pendidikan_sedangs' => 'Diploma I/II'],
            ['nama_pendidikan_sedangs' => 'Akademi/Diploma III/S. Muda'],
            ['nama_pendidikan_sedangs' => 'Diploma IV/Strata I'],
            ['nama_pendidikan_sedangs' => 'Strata II'],
            ['nama_pendidikan_sedangs' => 'Strata III'],
        ];
        foreach ($pendidikanSedangs as $pendidikanSedang) {
            PendidikanSedang::create($pendidikanSedang);
        }

        // Pekerjaan
        $pekerjaans = [
            ['nama_pekerjaan' => 'Belum/Tidak Bekerja'],
            ['nama_pekerjaan' => 'Mengurus Rumah Tangga'],
            ['nama_pekerjaan' => 'Pelajar/Mahasiswa'],
            ['nama_pekerjaan' => 'Pensiunan'],
            ['nama_pekerjaan' => 'Pegawai Negeri Sipil'],
            ['nama_pekerjaan' => 'Tentara Nasional Indonesia'],
            ['nama_pekerjaan' => 'Kepolisian RI'],
            ['nama_pekerjaan' => 'Perdagangan'],
            ['nama_pekerjaan' => 'Petani/Pekebun'],
            ['nama_pekerjaan' => 'Peternak'],
            ['nama_pekerjaan' => 'Nelayan/Perikanan'],
            ['nama_pekerjaan' => 'Industri'],
            ['nama_pekerjaan' => 'Konstruksi'],
            ['nama_pekerjaan' => 'Transportasi'],
            ['nama_pekerjaan' => 'Karyawan Swasta'],
            ['nama_pekerjaan' => 'Karyawan BUMN'],
            ['nama_pekerjaan' => 'Karyawan BUMD'],
            ['nama_pekerjaan' => 'Karyawan Honorer'],
            ['nama_pekerjaan' => 'Buruh Harian Lepas'],
            ['nama_pekerjaan' => 'Buruh Tani/Perkebunan'],
            ['nama_pekerjaan' => 'Buruh Nelayan/Perikanan'],
            ['nama_pekerjaan' => 'Buruh Peternakan'],
            ['nama_pekerjaan' => 'Pembantu Rumah Tangga'],
            ['nama_pekerjaan' => 'Tukang Cukur'],
            ['nama_pekerjaan' => 'Tukang Listrik'],
            ['nama_pekerjaan' => 'Tukang Batu'],
            ['nama_pekerjaan' => 'Tukang Kayu'],
            ['nama_pekerjaan' => 'Tukang Sol Sepatu'],
            ['nama_pekerjaan' => 'Tukang Las/Pandai Besi'],
            ['nama_pekerjaan' => 'Tukang Jahit'],
            ['nama_pekerjaan' => 'Tukang Gigi'],
            ['nama_pekerjaan' => 'Penata Rias'],
            ['nama_pekerjaan' => 'Penata Busana'],
            ['nama_pekerjaan' => 'Penata Rambut'],
            ['nama_pekerjaan' => 'Mekanik'],
            ['nama_pekerjaan' => 'Seniman'],
            ['nama_pekerjaan' => 'Tabib'],
            ['nama_pekerjaan' => 'Paraji'],
            ['nama_pekerjaan' => 'Perancang Busana'],
            ['nama_pekerjaan' => 'Penterjemah'],
            ['nama_pekerjaan' => 'Imam Masjid'],
            ['nama_pekerjaan' => 'Pendeta'],
            ['nama_pekerjaan' => 'Pastor'],
            ['nama_pekerjaan' => 'Wartawan'],
            ['nama_pekerjaan' => 'Ustadz/Mubaligh'],
            ['nama_pekerjaan' => 'Juru Masak'],
            ['nama_pekerjaan' => 'Promotor Acara'],
            ['nama_pekerjaan' => 'Anggota DPR-RI'],
            ['nama_pekerjaan' => 'Anggota DPD'],
            ['nama_pekerjaan' => 'Anggota DPRD'],
            ['nama_pekerjaan' => 'Presiden'],
            ['nama_pekerjaan' => 'Wakil Presiden'],
            ['nama_pekerjaan' => 'Wiraswasta'],
        ];
        foreach ($pekerjaans as $pekerjaan) {
            Pekerjaan::create($pekerjaan);
        }

        // Status Kawin
        $statKawins = [
            ['nama_stat_kawins' => 'Belum Kawin'],
            ['nama_stat_kawins' => 'Kawin'],
            ['nama_stat_kawins' => 'Cerai Hidup'],
            ['nama_stat_kawins' => 'Cerai Mati'],
        ];
        foreach ($statKawins as $statKawin) {
            StatKawin::create($statKawin);
        }

        // Status Hubungan Keluarga
        $statHubKeluargas = [
            ['nama_hub_keluarga' => 'Kepala Keluarga'],
            ['nama_hub_keluarga' => 'Suami'],
            ['nama_hub_keluarga' => 'Istri'],
            ['nama_hub_keluarga' => 'Anak'],
            ['nama_hub_keluarga' => 'Menantu'],
            ['nama_hub_keluarga' => 'Cucu'],
            ['nama_hub_keluarga' => 'Orang Tua'],
            ['nama_hub_keluarga' => 'Mertua'],
            ['nama_hub_keluarga' => 'Famili Lain'],
            ['nama_hub_keluarga' => 'Pembantu'],
            ['nama_hub_keluarga' => 'Lainnya'],
        ];
        foreach ($statHubKeluargas as $statHubKeluarga) {
            StatHubKeluarga::create($statHubKeluarga);
        }

        // Golongan Darah
        $golDarahs = [
            ['nama_gol_darah' => 'A'],
            ['nama_gol_darah' => 'B'],
            ['nama_gol_darah' => 'AB'],
            ['nama_gol_darah' => 'O'],
            ['nama_gol_darah' => 'A+'],
            ['nama_gol_darah' => 'A-'],
            ['nama_gol_darah' => 'B+'],
            ['nama_gol_darah' => 'B-'],
            ['nama_gol_darah' => 'AB+'],
            ['nama_gol_darah' => 'AB-'],
            ['nama_gol_darah' => 'O+'],
            ['nama_gol_darah' => 'O-'],
            ['nama_gol_darah' => 'TIDAK TAHU'],
        ];
        foreach ($golDarahs as $golDarah) {
            GolDarah::create($golDarah);
        }

        // Cacat
        $cacats = [
            ['nama_cacat' => 'TIDAK CACAT'],
            ['nama_cacat' => 'Cacat Fisik'],
            ['nama_cacat' => 'Cacat Netra/Buta'],
            ['nama_cacat' => 'Cacat Rungu/Wicara'],
            ['nama_cacat' => 'Cacat Mental/Jiwa'],
            ['nama_cacat' => 'Cacat Fisik dan Mental'],
            ['nama_cacat' => 'Cacat Lainnya'],
        ];
        foreach ($cacats as $cacat) {
            Cacat::create($cacat);
        }

        // Cara KB
        $caraKbs = [
            ['nama_cara_kb' => 'Tidak Menggunakan'],
            ['nama_cara_kb' => 'Pil'],
            ['nama_cara_kb' => 'IUD'],
            ['nama_cara_kb' => 'Suntik'],
            ['nama_cara_kb' => 'Kondom'],
            ['nama_cara_kb' => 'Susuk KB'],
            ['nama_cara_kb' => 'Sterilisasi Wanita'],
            ['nama_cara_kb' => 'Sterilisasi Pria'],
            ['nama_cara_kb' => 'Lainnya'],
        ];
        foreach ($caraKbs as $caraKb) {
            CaraKb::create($caraKb);
        }

        // Status Rekam
        $statRekams = [
            ['nama_stat_rekam' => 'Belum Wajib'],
            ['nama_stat_rekam' => 'Belum Rekam'],
            ['nama_stat_rekam' => 'Sudah Rekam'],
            ['nama_stat_rekam' => 'Card Printed'],
            ['nama_stat_rekam' => 'Print Ready Record'],
            ['nama_stat_rekam' => 'Card Shipped'],
            ['nama_stat_rekam' => 'Send For Card Printing'],
        ];
        foreach ($statRekams as $statRekam) {
            StatRekam::create($statRekam);
        }

        // Status Dasar
        $statDasars = [
            ['nama_stat_dasars' => 'HIDUP'],
            ['nama_stat_dasars' => 'MATI'],
            ['nama_stat_dasars' => 'PINDAH'],
            ['nama_stat_dasars' => 'HILANG'],
        ];
        foreach ($statDasars as $statDasar) {
            StatDasar::create($statDasar);
        }

        // Asuransi
        $asuransis = [
            ['nomor' => 1, 'nama_asuransi' => 'TIDAK/BELUM PUNYA'],
            ['nomor' => 2, 'nama_asuransi' => 'BPJS Kesehatan'],
            ['nomor' => 3, 'nama_asuransi' => 'Asuransi Lainnya'],
        ];
        foreach ($asuransis as $asuransi) {
            Asuransi::create($asuransi);
        }
    }
}
