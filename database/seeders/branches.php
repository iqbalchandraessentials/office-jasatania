<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class branches extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branch = [
            [
                'branch_code' => '323',
                'branch_name' => 'KCP. Tarutung',

            ],
        ];

        Branch::insert($branch);
    }
}
