<?php

namespace Database\Seeders;

use App\Models\Laboratory;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laboratories = [
            'Labor Fisika',
            'Labor X-Ray Diffraction / Fisika',
            'Labor Metallurgy dan Metrology / T Mesin',
            'Labor Batubara / T Tambang',
            'Labor Workshop Konstruksi / T Sipil',
        ];

        foreach($laboratories as $lab) {
            Laboratory::create(['name' => $lab]);
        }
    }
}
