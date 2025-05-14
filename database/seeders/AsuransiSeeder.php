<?php

namespace Database\Seeders;

use App\Models\Asuransi;
use Illuminate\Database\Seeder;

class AsuransiSeeder extends Seeder
{
    public function run()
    {
        $asuransis = [
            ['nomor' => 1, 'nama_asuransi' => 'BPJS Kesehatan'],
            ['nomor' => 2, 'nama_asuransi' => 'BPJS Ketenagakerjaan'],
            ['nomor' => 3, 'nama_asuransi' => 'Asuransi Swasta'],
            ['nomor' => 4, 'nama_asuransi' => 'Tidak Ada']
        ];

        foreach ($asuransis as $asuransi) {
            Asuransi::updateOrCreate(
                ['nomor' => $asuransi['nomor']],
                $asuransi
            );
        }
    }
}
