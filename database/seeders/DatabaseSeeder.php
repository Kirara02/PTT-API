<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Fathul Hidayat',
        //     'email' => 'fathul@gmail.com',
        //     'password' => Hash::make('12345678'),
        // ]);

        // Server::create([
        //     "name" => "PTT UNIGUARD",
        //     "host" => "ptt.uniguard.co.id",
        //     "port" => 64738,
        //     "username" => "Fathul Hidayat",
        //     "user_id" => 1
        // ]);
        $this->call([
            TimezoneSeeder::class
        ]);
    }
}
