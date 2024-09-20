<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'UniGuard ID',
                'expire_date' => date('Y-m-d', strtotime('2025-01-01')),
                'created_by' => 'DB Seeder',
                'updated_by' => 'DB Seeder',
            ],
            [
                'id' => 2,
                'name' => 'UniGuard AU',
                'expire_date' => date('Y-m-d', strtotime('2025-01-01')),
                'created_by' => 'DB Seeder',
                'updated_by' => 'DB Seeder',
            ],
        ];
        Company::insert($data);
    }
}
