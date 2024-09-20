<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'ALI DAVIT',
                'email' => 'alidavit@uniguard.co.id',
                'password' => Hash::make('alidavit@2024'),
                'company_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'TYTO MULYONO',
                'email' => 'tytomulyono@uniguard.co.id',
                'password' => Hash::make('tyto@2024'),
                'company_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'NABILA KHAIRUNNISA',
                'email' => 'nabila@uniguard.co.id',
                'password' => Hash::make('nabila@2024'),
                'company_id' => 1
            ],
            [
                'id' => 4,
                'name' => 'RAHMA WNJ',
                'email' => 'rahma.wnj@uniguard.co.id',
                'password' => Hash::make('rahma@2024'),
                'company_id' => 1
            ],
            [
                'id' => 5,
                'name' => 'IQBAL',
                'email' => 'iqbal.ir@uniguard.co.id',
                'password' => Hash::make('iqbal@2024'),
                'company_id' => 1
            ],
            [
                'id' => 6,
                'name' => 'FATHUL',
                'email' => 'fathul.hidayat@uniguard.co.id',
                'password' => Hash::make('fathul@2024'),
                'company_id' => 1
            ],
            [
                'id' => 7,
                'name' => 'TALITHA AULIA',
                'email' => 'talitha@uniguard.co.id',
                'password' => Hash::make('talitha@2024'),
                'company_id' => 1
            ],
            [
                'id' => 8,
                'name' => 'CON',
                'email' => 'con@uniguard.com.au',
                'password' => Hash::make('con@2024'),
                'company_id' => 2
            ],
            [
                'id' => 9,
                'name' => 'JEFF',
                'email' => 'jeff@uniguard.com.au',
                'password' => Hash::make('jeff@2024'),
                'company_id' => 2
            ],
            [
                'id' => 10,
                'name' => 'SANDY NUGROHO',
                'email' => 'sandy.nugroho@uniguard.co.id',
                'password' => Hash::make('sandy@2024'),
                'company_id' => 1
            ],
            [
                'id' => 11,
                'name' => 'ALFIAN',
                'email' => 'alfian.n@uniguard.co.id',
                'password' => Hash::make('alfian@2024'),
                'company_id' => 1
            ],
            [
                'id' => 12,
                'name' => 'ANDHIKA',
                'email' => 'andhika@uniguard.co.id',
                'password' => Hash::make('andhika@2024'),
                'company_id' => 1
            ],
        ];
        User::insert($data);
    }
}
