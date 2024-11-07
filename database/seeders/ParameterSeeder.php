<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameter;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parameters = [
            [
                'name' => 'Uji Tarik Baja Tulangan beton',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekerasan Bahan Brinnel',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekerasan Bahan Rockwell',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekerasan Bahan Micro-Vickers',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kandungan Kadar Air, Kadar Abu dan Zat Terbang (Uji Batubara)',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kandungan Sulfur Batubara',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Nilai Kalori Batubara',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'X-Ray Diffraction (XRD)',
                'package_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekuatan Tekan Beton Silinder',
                'package_id' => rand(1, 5)
            ],
        ];

        foreach($parameters as $parameter) {
            Parameter::create($parameter);
        }
    }
}
