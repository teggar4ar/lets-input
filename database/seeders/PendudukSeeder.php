<?php

namespace Database\Seeders;

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
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Use Indonesian locale

        // Get IDs from reference tables for use in relationships
        $agamaIds = Agama::pluck('id')->toArray();
        $pendidikanIds = Pendidikan::pluck('id')->toArray();
        $pendidikanSedangIds = PendidikanSedang::pluck('id')->toArray();
        $pekerjaanIds = Pekerjaan::pluck('id')->toArray();
        $statKawinIds = StatKawin::pluck('id')->toArray();
        $statHubKeluargaIds = StatHubKeluarga::pluck('id')->toArray();
        $golDarahIds = GolDarah::pluck('id')->toArray();
        $cacatIds = Cacat::pluck('id')->toArray();
        $caraKbIds = CaraKb::pluck('id')->toArray();
        $statRekamIds = StatRekam::pluck('id')->toArray();
        $statDasarIds = StatDasar::pluck('id')->toArray();
        $asuransiIds = Asuransi::pluck('id')->toArray();

        // Define a list of Indonesian cities for place of birth
        $cities = [
            'Jakarta',
            'Surabaya',
            'Bandung',
            'Medan',
            'Semarang',
            'Makassar',
            'Palembang',
            'Yogyakarta',
            'Malang',
            'Padang',
            'Denpasar',
            'Balikpapan',
            'Manado',
            'Pekanbaru',
            'Banjarmasin',
            'Pontianak',
            'Ambon',
            'Samarinda',
            'Mataram',
            'Kupang'
        ];

        // Generate 30 addresses to be shared among the penduduk
        $alamatIds = [];
        for ($i = 0; $i < 30; $i++) {
            $alamat = Alamat::create([
                'nama_alamat' => $faker->streetAddress,
                'dusun' => 'Dusun ' . $faker->randomElement(['I', 'II', 'III', 'IV', 'V']),
                'no_rt' => $faker->numberBetween(1, 20),
                'no_rw' => $faker->numberBetween(1, 10),
                'lat' => $faker->latitude(-8.5, -7.5), // Central Java approximate latitude
                'lng' => $faker->longitude(110.0, 111.0), // Central Java approximate longitude
                'alamat_sekarang' => $faker->boolean(80) ? null : $faker->address
            ]);
            $alamatIds[] = $alamat->id;
        }

        // Generate 20 KK numbers (families)
        $kkNumbers = [];
        for ($i = 0; $i < 20; $i++) {
            $kkNumbers[] = $this->generateUniqueKkNumber();
        }

        // Create 100 penduduk entries (people)
        DB::beginTransaction();
        try {
            // Generate 100 records
            for ($i = 0; $i < 100; $i++) {
                // Assign each person to one of the KK numbers (families)
                $kkIndex = $faker->numberBetween(0, count($kkNumbers) - 1);
                $noKK = $kkNumbers[$kkIndex];

                // Determine family role
                // First person in each family is usually the head (KK), followed by spouse, then children
                $familyCount = Penduduk::where('no_kk', $noKK)->count();
                $hubId = 0;

                if ($familyCount == 0) {
                    // Head of family (kepala keluarga)
                    $hubId = StatHubKeluarga::where('nama_hub_keluarga', 'KEPALA KELUARGA')->first()->id ?? $statHubKeluargaIds[0];
                    $gender = 'laki-laki'; // Most heads of family in Indonesia are male (traditional)
                } elseif ($familyCount == 1) {
                    // Spouse (usually wife)
                    $hubId = StatHubKeluarga::where('nama_hub_keluarga', 'ISTRI')->first()->id ?? $statHubKeluargaIds[1];
                    $gender = 'perempuan';
                } else {
                    // Children or other family members
                    if ($faker->boolean(75)) {
                        $hubId = StatHubKeluarga::where('nama_hub_keluarga', 'ANAK')->first()->id ?? $statHubKeluargaIds[2];
                        $gender = $faker->randomElement(['laki-laki', 'perempuan']);
                    } else {
                        $hubId = $faker->randomElement($statHubKeluargaIds);
                        $gender = $faker->randomElement(['laki-laki', 'perempuan']);
                    }
                }

                // Generate birth date based on role
                $birthDate = null;
                if (
                    $hubId == (StatHubKeluarga::where('nama_hub_keluarga', 'KEPALA KELUARGA')->first()->id ?? $statHubKeluargaIds[0])
                    || $hubId == (StatHubKeluarga::where('nama_hub_keluarga', 'ISTRI')->first()->id ?? $statHubKeluargaIds[1])
                ) {
                    // Adults (18-65 years old)
                    $birthDate = $faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d');
                } elseif ($hubId == (StatHubKeluarga::where('nama_hub_keluarga', 'ANAK')->first()->id ?? $statHubKeluargaIds[2])) {
                    // Children (0-25 years old)
                    $birthDate = $faker->dateTimeBetween('-25 years', '-1 month')->format('Y-m-d');
                } else {
                    // Others (any age)
                    $birthDate = $faker->dateTimeBetween('-90 years', '-1 month')->format('Y-m-d');
                }

                // Calculate appropriate marriage status based on age
                $age = Carbon::parse($birthDate)->age;
                $marriageId = null;

                if ($age < 17) {
                    // Children are usually not married
                    $marriageId = StatKawin::where('nama_stat_kawins', 'BELUM KAWIN')->first()->id ?? $statKawinIds[0];
                } elseif (
                    $hubId == (StatHubKeluarga::where('nama_hub_keluarga', 'KEPALA KELUARGA')->first()->id ?? $statHubKeluargaIds[0])
                    || $hubId == (StatHubKeluarga::where('nama_hub_keluarga', 'ISTRI')->first()->id ?? $statHubKeluargaIds[1])
                ) {
                    // Heads and spouses are usually married
                    $marriageId = StatKawin::where('nama_stat_kawins', 'KAWIN')->first()->id ?? $statKawinIds[1];
                } else {
                    // Others based on random distribution
                    $marriageStatus = $faker->randomElement([
                        'BELUM KAWIN' => 40,
                        'KAWIN' => 45,
                        'CERAI HIDUP' => 10,
                        'CERAI MATI' => 5
                    ]);

                    $marriageId = StatKawin::where('nama_stat_kawins', array_search($marriageStatus, $faker->randomElements(
                        ['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'],
                        1,
                        [40, 45, 10, 5]
                    )))->first()->id ?? $faker->randomElement($statKawinIds);
                }

                // Generate NIK (16 digits unique identifier)
                $nik = $this->generateUniqueNik();

                // Create the penduduk record
                Penduduk::create([
                    'alamats_id' => $faker->randomElement($alamatIds),
                    'no_kk' => $noKK,
                    'nik' => $nik,
                    'nama' => $gender == 'laki-laki' ? $faker->firstNameMale . ' ' . $faker->lastNameMale : $faker->firstNameFemale . ' ' . $faker->lastNameFemale,
                    'jk' => $gender,
                    'tmp_lahir' => $faker->randomElement($cities),
                    'tgl_lahir' => $birthDate,
                    'agamas_id' => $faker->randomElement($agamaIds),
                    'pendidikans_id' => $faker->randomElement($pendidikanIds),
                    'pendidikan_sedangs_id' => ($age < 25 && $age > 5) ? $faker->randomElement($pendidikanSedangIds) : null,
                    'pekerjaans_id' => $age >= 15 ? $faker->randomElement($pekerjaanIds) : $pekerjaanIds[0], // First is usually "Tidak/Belum Bekerja"
                    'stat_kawins_id' => $marriageId,
                    'stat_hub_keluargas_id' => $hubId,
                    'kewarganegaraan' => $faker->boolean(97) ? 'wni' : 'wna', // 97% are Indonesian citizens
                    'ayah_nik' => $faker->boolean(30) ? $this->generateUniqueNik() : null, // 30% have father's NIK
                    'jamkesnas' => $faker->boolean(40), // 40% have Jamkesnas
                    'ayah_nama' => $faker->boolean(80) ? $faker->firstNameMale . ' ' . $faker->lastNameMale : null, // 80% have father's name
                    'ibu_nik' => $faker->boolean(20) ? $this->generateUniqueNik() : null, // 20% have mother's NIK
                    'ibu_nama' => $faker->boolean(85) ? $faker->firstNameFemale . ' ' . $faker->lastNameFemale : null, // 85% have mother's name
                    'gol_darahs_id' => $faker->boolean(70) ? $faker->randomElement($golDarahIds) : null, // 70% have blood type info
                    'akta_lahir' => $faker->boolean(60) ? $faker->bothify('AKL-####/???/####') : null, // 60% have birth certificate
                    'dok_passport' => $faker->boolean(10) ? $faker->bothify('P####?????') : null, // 10% have passport
                    'tgl_akhir_passport' => $faker->boolean(10) ? $faker->dateTimeBetween('+1 month', '+5 years')->format('Y-m-d') : null,
                    'dok_kitas' => $faker->boolean(5) ? $faker->bothify('KTS-####-???') : null, // 5% have KITAS (for foreigners)
                    'akta_perkawinan' => $marriageId == (StatKawin::where('nama_stat_kawins', 'KAWIN')->first()->id ?? $statKawinIds[1]) && $faker->boolean(60) ?
                        $faker->bothify('AKW-####/???/####') : null, // 60% of married have marriage certificate
                    'tgl_perkawinan' => $marriageId == (StatKawin::where('nama_stat_kawins', 'KAWIN')->first()->id ?? $statKawinIds[1]) && $faker->boolean(60) ?
                        $faker->dateTimeBetween('-30 years', '-1 year')->format('Y-m-d') : null,
                    'akta_perceraian' => ($marriageId == (StatKawin::where('nama_stat_kawins', 'CERAI HIDUP')->first()->id ?? null) && $faker->boolean(50)) ?
                        $faker->bothify('AKC-####/???/####') : null, // 50% of divorced have certificate
                    'tgl_perceraian' => ($marriageId == (StatKawin::where('nama_stat_kawins', 'CERAI HIDUP')->first()->id ?? null) && $faker->boolean(50)) ?
                        $faker->dateTimeBetween('-20 years', '-1 month')->format('Y-m-d') : null,
                    'cacats_id' => $faker->boolean(5) ? $faker->randomElement($cacatIds) : null, // 5% have disability
                    'cara_kbs_id' => ($age > 17 && $age < 50 && $gender == 'perempuan' && $faker->boolean(40)) ?
                        $faker->randomElement($caraKbIds) : null, // 40% of women in fertile age have KB
                    'hamil' => ($gender == 'perempuan' && $age >= 18 && $age <= 45) ? $faker->boolean(10) : false, // 10% of women in fertile age are pregnant
                    'ktp_el' => $age >= 17 ? $faker->boolean(85) : false, // 85% of adults have e-KTP
                    'stat_rekams_id' => $age >= 17 ? $faker->randomElement($statRekamIds) : null, // Recording status for adults only
                    'stat_dasars_id' => $faker->randomElement($statDasarIds), // Basic status (usually "HIDUP")
                    'suku' => $faker->boolean(70) ? $faker->randomElement([
                        'JAWA',
                        'SUNDA',
                        'BATAK',
                        'MADURA',
                        'BETAWI',
                        'MINANGKABAU',
                        'BUGIS',
                        'MELAYU',
                        'BANTEN',
                        'BANJAR',
                        'BALI',
                        'SASAK',
                        'MAKASSAR',
                        'CIREBON',
                        'TIONGHOA',
                        'DAYAK',
                        'ACEH'
                    ]) : null, // 70% have ethnicity
                    'tag_id_card' => $faker->boolean(15) ? $faker->bothify('TID#########') : null, // 15% have ID card tag
                    'asuransis_id' => $faker->boolean(60) ? $faker->randomElement($asuransiIds) : null, // 60% have insurance
                ]);
            }

            DB::commit();
            $this->command->info('Successfully created 100 dummy penduduk records with 30 alamat and 20 family groups.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Failed to seed penduduk data: ' . $e->getMessage());
        }
    }

    /**
     * Generate a unique 16-digit NIK (Nomor Induk Kependudukan)
     */
    private function generateUniqueNik(): string
    {
        do {
            $nik = rand(1, 9); // First digit should not be 0

            // Generate 15 more random digits
            for ($i = 0; $i < 15; $i++) {
                $nik .= rand(0, 9);
            }
        } while (Penduduk::where('nik', $nik)->exists());

        return $nik;
    }

    /**
     * Generate a unique 16-digit KK Number (Nomor Kartu Keluarga)
     */
    private function generateUniqueKkNumber(): string
    {
        do {
            $kkNumber = rand(1, 9); // First digit should not be 0

            // Generate 15 more random digits
            for ($i = 0; $i < 15; $i++) {
                $kkNumber .= rand(0, 9);
            }
        } while (Penduduk::where('no_kk', $kkNumber)->exists());

        return $kkNumber;
    }
}
