<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Method;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'SNI 1974:2011',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'SNI 2052:2017 butir 8.3.3.1',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'BS EN 13925-1:2003 / BS EN 13925-2:2003',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'ASTM D5865/ D5865-19',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'ASTM D4239-18e1',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'ASTM D7582-15',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'ASTM E384-17',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'ASTM E18-20',
                'parameter_id' => rand(1, 5)
            ],
            [
                'name' => 'ASTM E10-18',
                'parameter_id' => rand(1, 5)
            ],
        ];

        foreach($methods as $method) {
            Method::create($method);
        }
    }
}
