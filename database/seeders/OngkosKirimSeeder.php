<?php

namespace Database\Seeders;

use App\Models\OngkosKirim;
use Illuminate\Database\Seeder;

class OngkosKirimSeeder extends Seeder
{
    public function run(): void
    {
        $daerahList = [
            ['daerah' => 'Jakarta', 'biaya' => 15000],
            ['daerah' => 'Bogor', 'biaya' => 20000],
            ['daerah' => 'Depok', 'biaya' => 18000],
            ['daerah' => 'Tangerang', 'biaya' => 20000],
            ['daerah' => 'Bekasi', 'biaya' => 18000],
            ['daerah' => 'Bandung', 'biaya' => 25000],
            ['daerah' => 'Surabaya', 'biaya' => 35000],
            ['daerah' => 'Yogyakarta', 'biaya' => 30000],
            ['daerah' => 'Semarang', 'biaya' => 28000],
            ['daerah' => 'Medan', 'biaya' => 45000],
        ];

        foreach ($daerahList as $daerah) {
            OngkosKirim::create($daerah);
        }
    }
}
