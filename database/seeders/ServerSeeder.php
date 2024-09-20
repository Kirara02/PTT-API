<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
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
                "name" => "PTT UNIGUARD",
                "host" => "ptt.uniguard.co.id",
                "port" => 64738,
                "username" => "",
                'password' => '',
                'user_id' => 1
            ]
        ];
        Server::insert($data);
    }
}
