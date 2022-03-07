<?php

namespace Database\Seeders;

use App\Models\Rate as ModelsRate;
use App\Models\Rates;
use Illuminate\Database\Seeder;

class rate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = [
            [
                'code_cover' => 'FL',
                'rate' => 0.3,
                'description' => 'flexas',
                'created_at' => date('Y-m-d H:i:s', time()),
            ],
            [
                'code_cover' => 'HM',
                'rate' => 0.025,
                'description' => 'hama',
                'created_at' => date('Y-m-d H:i:s', time()),

            ],
            [
                'code_cover' => 'PY',
                'rate' => 0.075,
                'description' => 'penyakit',
                'created_at' => date('Y-m-d H:i:s', time()),

            ],
            [
                'code_cover' => 'RSMDCC',
                'rate' => 0.025,
                'description' => 'RSMDCC',
                'created_at' => date('Y-m-d H:i:s', time()),
            ],

        ];

        ModelsRate::insert($rates);
    }
}
