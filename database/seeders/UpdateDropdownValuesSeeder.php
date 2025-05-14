<?php

namespace Database\Seeders;

use App\Models\Asuransi;
use App\Models\Pekerjaan;
use App\Models\PendidikanSedang;
use App\Models\StatDasar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDropdownValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data in tables we're updating
        DB::table('pendidikan_sedangs')->delete();
        DB::table('pekerjaans')->delete();
        DB::table('stat_dasars')->delete();
        DB::table('asuransis')->delete();

        // Reset auto-increment for MySQL
        $connection = config('database.default');
        if ($connection === 'mysql') {
            DB::statement('ALTER TABLE pendidikan_sedangs AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE pekerjaans AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE stat_dasars AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE asuransis AUTO_INCREMENT = 1');
        } else {
            // SQLite way
            $statement = "UPDATE sqlite_sequence SET seq = 0 WHERE name = 'pendidikan_sedangs'";
            DB::statement($statement);
            $statement = "UPDATE sqlite_sequence SET seq = 0 WHERE name = 'pekerjaans'";
            DB::statement($statement);
            $statement = "UPDATE sqlite_sequence SET seq = 0 WHERE name = 'stat_dasars'";
            DB::statement($statement);
            $statement = "UPDATE sqlite_sequence SET seq = 0 WHERE name = 'asuransis'";
            DB::statement($statement);
        }

        // Pendidikan Sedang - new values
        $pendidikanSedangs = [
            ['nama_pendidikan_sedangs' => 'BELUM MASUK TK/KELOMPOK BERMAIN'],
            ['nama_pendidikan_sedangs' => 'SEDANG TK/KELOMPOK BERMAIN'],
            ['nama_pendidikan_sedangs' => 'TIDAK PERNAH SEKOLAH'],
            ['nama_pendidikan_sedangs' => 'SEDANG SD/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'TIDAK TAMAT SD/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG SLTP/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG SLTA/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG D-1/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG D-2/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG D-3/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG S-1/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG S-2/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG S-3/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG SLB A/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG SLB B/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'SEDANG SLB C/SEDERAJAT'],
            ['nama_pendidikan_sedangs' => 'TIDAK DAPAT MEMBACA DAN MENULIS HURUF LATIN/ARAB'],
            ['nama_pendidikan_sedangs' => 'TIDAK SEDANG SEKOLAH']
        ];
        foreach ($pendidikanSedangs as $pendidikanSedang) {
            PendidikanSedang::create($pendidikanSedang);
        }

        // Pekerjaan - new values
        $pekerjaans = [
            ['nama_pekerjaan' => 'BELUM/TIDAK BEKERJA'],
            ['nama_pekerjaan' => 'MENGURUS RUMAH TANGGA'],
            ['nama_pekerjaan' => 'PELAJAR/MAHASISWA'],
            ['nama_pekerjaan' => 'PENSIUNAN'],
            ['nama_pekerjaan' => 'PEGAWAI NEGERI SIPIL (PNS)'],
            ['nama_pekerjaan' => 'TENTARA NASIONAL INDONESIA (TNI)'],
            ['nama_pekerjaan' => 'KEPOLISIAN RI (POLRI)'],
            ['nama_pekerjaan' => 'PERDAGANGAN'],
            ['nama_pekerjaan' => 'PETANI/PEKEBUN'],
            ['nama_pekerjaan' => 'PETERNAK'],
            ['nama_pekerjaan' => 'NELAYAN/PERIKANAN'],
            ['nama_pekerjaan' => 'INDUSTRI'],
            ['nama_pekerjaan' => 'KONSTRUKSI'],
            ['nama_pekerjaan' => 'TRANSPORTASI'],
            ['nama_pekerjaan' => 'KARYAWAN SWASTA'],
            ['nama_pekerjaan' => 'KARYAWAN BUMN'],
            ['nama_pekerjaan' => 'KARYAWAN BUMD'],
            ['nama_pekerjaan' => 'KARYAWAN HONORER'],
            ['nama_pekerjaan' => 'BURUH HARIAN LEPAS'],
            ['nama_pekerjaan' => 'BURUH TANI/PERKEBUNAN'],
            ['nama_pekerjaan' => 'BURUH NELAYAN/PERIKANAN'],
            ['nama_pekerjaan' => 'BURUH PETERNAKAN'],
            ['nama_pekerjaan' => 'PEMBANTU RUMAH TANGGA'],
            ['nama_pekerjaan' => 'TUKANG CUKUR'],
            ['nama_pekerjaan' => 'TUKANG LISTRIK'],
            ['nama_pekerjaan' => 'TUKANG BATU'],
            ['nama_pekerjaan' => 'TUKANG KAYU'],
            ['nama_pekerjaan' => 'TUKANG SOL SEPATU'],
            ['nama_pekerjaan' => 'TUKANG LAS/PANDAI BESI'],
            ['nama_pekerjaan' => 'TUKANG JAHIT'],
            ['nama_pekerjaan' => 'TUKANG GIGI'],
            ['nama_pekerjaan' => 'PENATA RIAS'],
            ['nama_pekerjaan' => 'PENATA BUSANA'],
            ['nama_pekerjaan' => 'PENATA RAMBUT'],
            ['nama_pekerjaan' => 'MEKANIK'],
            ['nama_pekerjaan' => 'SENIMAN'],
            ['nama_pekerjaan' => 'TABIB'],
            ['nama_pekerjaan' => 'PARAJI'],
            ['nama_pekerjaan' => 'PERANCANG BUSANA'],
            ['nama_pekerjaan' => 'PENTERJEMAH'],
            ['nama_pekerjaan' => 'IMAM MASJID'],
            ['nama_pekerjaan' => 'PENDETA'],
            ['nama_pekerjaan' => 'PASTOR'],
            ['nama_pekerjaan' => 'WARTAWAN'],
            ['nama_pekerjaan' => 'USTADZ/MUBALIGH'],
            ['nama_pekerjaan' => 'JURU MASAK'],
            ['nama_pekerjaan' => 'PROMOTOR ACARA'],
            ['nama_pekerjaan' => 'ANGGOTA DPR-RI'],
            ['nama_pekerjaan' => 'ANGGOTA DPD'],
            ['nama_pekerjaan' => 'ANGGOTA BPK'],
            ['nama_pekerjaan' => 'PRESIDEN'],
            ['nama_pekerjaan' => 'WAKIL PRESIDEN'],
            ['nama_pekerjaan' => 'ANGGOTA MAHKAMAH KONSTITUSI'],
            ['nama_pekerjaan' => 'ANGGOTA KABINET KEMENTERIAN'],
            ['nama_pekerjaan' => 'DUTA BESAR'],
            ['nama_pekerjaan' => 'GUBERNUR'],
            ['nama_pekerjaan' => 'WAKIL GUBERNUR'],
            ['nama_pekerjaan' => 'BUPATI'],
            ['nama_pekerjaan' => 'WAKIL BUPATI'],
            ['nama_pekerjaan' => 'WALIKOTA'],
            ['nama_pekerjaan' => 'WAKIL WALIKOTA'],
            ['nama_pekerjaan' => 'ANGGOTA DPRD PROVINSI'],
            ['nama_pekerjaan' => 'ANGGOTA DPRD KABUPATEN/KOTA'],
            ['nama_pekerjaan' => 'DOSEN'],
            ['nama_pekerjaan' => 'GURU'],
            ['nama_pekerjaan' => 'PILOT'],
            ['nama_pekerjaan' => 'PENGACARA'],
            ['nama_pekerjaan' => 'NOTARIS'],
            ['nama_pekerjaan' => 'ARSITEK'],
            ['nama_pekerjaan' => 'AKUNTAN'],
            ['nama_pekerjaan' => 'KONSULTAN'],
            ['nama_pekerjaan' => 'DOKTER'],
            ['nama_pekerjaan' => 'BIDAN'],
            ['nama_pekerjaan' => 'PERAWAT'],
            ['nama_pekerjaan' => 'APOTEKER'],
            ['nama_pekerjaan' => 'PSIKIATER/PSIKOLOG'],
            ['nama_pekerjaan' => 'PENYIAR TELEVISI'],
            ['nama_pekerjaan' => 'PENYIAR RADIO'],
            ['nama_pekerjaan' => 'PELAUT'],
            ['nama_pekerjaan' => 'PENELITI'],
            ['nama_pekerjaan' => 'SOPIR'],
            ['nama_pekerjaan' => 'PIALANG'],
            ['nama_pekerjaan' => 'PARANORMAL'],
            ['nama_pekerjaan' => 'PEDAGANG'],
            ['nama_pekerjaan' => 'PERANGKAT DESA'],
            ['nama_pekerjaan' => 'KEPALA DESA'],
            ['nama_pekerjaan' => 'BIARAWATI'],
            ['nama_pekerjaan' => 'WIRASWASTA'],
            ['nama_pekerjaan' => 'LAINNYA']
        ];
        foreach ($pekerjaans as $pekerjaan) {
            Pekerjaan::create($pekerjaan);
        }

        // Status Dasar - new values
        $statDasars = [
            ['nama_stat_dasars' => 'HIDUP'],
            ['nama_stat_dasars' => 'MATI'],
            ['nama_stat_dasars' => 'PINDAH'],
            ['nama_stat_dasars' => 'HILANG'],
            ['nama_stat_dasars' => 'PERGI'],
            ['nama_stat_dasars' => 'TIDAK VALID']
        ];
        foreach ($statDasars as $statDasar) {
            StatDasar::create($statDasar);
        }

        // Asuransi - new values
        $asuransis = [
            ['nomor' => 1, 'nama_asuransi' => 'TIDAK/BELUM PUNYA'],
            ['nomor' => 2, 'nama_asuransi' => 'BPJS PENERIMA BANTUAN IURAN'],
            ['nomor' => 3, 'nama_asuransi' => 'BPJS NON PENERIMA BANTUAN IURAN'],
            ['nomor' => 4, 'nama_asuransi' => 'BPJS BANTUAN DAERAH'],
            ['nomor' => 5, 'nama_asuransi' => 'ASURANSI LAINNYA']
        ];
        foreach ($asuransis as $asuransi) {
            Asuransi::create($asuransi);
        }
    }
}
