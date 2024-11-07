<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Pengujian Nilai Kalori Batubara',
                'satuan' => 'Per Spesimen',
                'harga' => 300000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kandungan Sulfur Batubara',
                'satuan' => 'Per Spesimen',
                'harga' => 200000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kandungan Kadar Air, Kadar Abu dan Zat Terbang (Uji Batubara)',
                'satuan' => 'Per Spesimen',
                'harga' => 275000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekerasan Bahan Micro-Vickers',
                'satuan' => '1 Titik Per Spesimen',
                'harga' => 20000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekerasan Bahan Rockwell',
                'satuan' => 'Per 1 Titik',
                'harga' => 15000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekerasan Bahan Brinnel',
                'satuan' => '1 Titik Per Spesimen',
                'harga' => 25000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Pengujian Kekuatan Tekan Beton Silinder',
                'satuan' => 'Per Spesimen',
                'harga' => 70000,
                'catatan' => 'Biaya keping beton di luar biaya pengujian di atas',
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'Uji Tarik Baja Tulangan beton',
                'satuan' => 'Per Spesimen',
                'harga' => 230000,
                'catatan' => 'Tanpa disaksikan (non witness). Panjang minimal 1 Meter. Diameter maksimal 25mm. Biaya uji berat dan uji tekuk di luar biaya pengujian diatas',
                'laboratory_id' => rand(1, 5)
            ],
            [
                'name' => 'X-Ray Diffraction (XRD)',
                'satuan' => 'Per Spesimen',
                'harga' => 200000,
                'catatan' => null,
                'laboratory_id' => rand(1, 5)
            ],
        ];

        foreach($packages as $package) {
            Package::create($package);
        }
    }
}
