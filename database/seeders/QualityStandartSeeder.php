<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QualityStandart;

class QualityStandartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QualityStandart::create([
            'name' => 'Standart 1',
        ]);
    }
}
