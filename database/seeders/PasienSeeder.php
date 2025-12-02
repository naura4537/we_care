<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pasiens')->truncate();
        
        DB::table('pasiens')->insert([
            [
                'id' => 1,
                'id_pasien' => 'P001',
                'user_id' => 4, // Terhubung ke 'Pasien 1'
                'tanggal_lahir' => '2019-05-12',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Contoh No. 45, Malang',
            ],
            [
                'id' => 2,
                'id_pasien' => 'P002',
                'user_id' => 5, // Terhubung ke 'Pasien 2'
                'tanggal_lahir' => '2001-01-26',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Contoh No. 31, Malang',
            ],
            [
                'id' => 3,
                'id_pasien' => 'P003',
                'user_id' => 6, // Terhubung ke 'Pasien 3'
                'tanggal_lahir' => '2016-05-17',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Contoh No. 17, Malang',
            ],

            // ... (DAN SETERUSNYA SAMPAI 40 PASIEN) ...

        ]);
    }
}