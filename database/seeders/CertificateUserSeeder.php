<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificateUserSeeder extends Seeder
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
                'user_id' => 1,
                'certificate_path' => 'certificates/alidavit_certs.p12'
            ],
            [
                'user_id' => 2,
                'certificate_path' => 'certificates/tytomulyono_certs.p12'
            ],
            [
                'user_id' => 3,
                'certificate_path' => 'certificates/nabila_certs.p12'
            ],
            [
                'user_id' => 4,
                'certificate_path' => 'certificates/rahma_certs.p12'
            ],
            [
                'user_id' => 5,
                'certificate_path' => 'certificates/iqbal_certs.p12'
            ],
            [
                'user_id' => 6,
                'certificate_path' => 'certificates/fathul_certs.p12'
            ],
            [
                'user_id' => 7,
                'certificate_path' => 'certificates/talitha_certs.p12'
            ],
            [
                'user_id' => 8,
                'certificate_path' => 'certificates/con_certs.p12'
            ],
            [
                'user_id' => 9,
                'certificate_path' => 'certificates/jeff_certs.p12'
            ],
            [
                'user_id' => 10,
                'certificate_path' => 'certificates/sandy_certs.p12'
            ],
            [
                'user_id' => 11,
                'certificate_path' => 'certificates/alfi_certs.p12'
            ],
            [
                'user_id' => 12,
                'certificate_path' => 'certificates/andhika_certs.p12'
            ],
        ];
        Certificate::insert($data);
    }
}
