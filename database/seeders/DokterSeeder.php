<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dokters')->truncate();
        
        DB::table('dokters')->insert([
            [
                'id' => 1,
                'id_dokter' => 'D001',
                'user_id' => 2, // Ini terhubung ke 'Dr. Budi Santoso'
                'jenis_kelamin' => 'Laki-laki',
                'spesialisasi' => 'Dokter Umum',
                'riwayat_pendidikan' => 'S1 FK Universitas Brawijaya',
                'no_str' => 'STR001',
                'biaya' => 100000.00,
                'jadwal' => null,
            ],
            [
                'id' => 2,
                'id_dokter' => 'D002',
                'user_id' => 3, // Ini terhubung ke 'James' (Admin)
                'jenis_kelamin' => 'Perempuan',
                'spesialisasi' => 'Dokter Gigi',
                'riwayat_pendidikan' => 'S1 FKG Universitas Airlangga',
                'no_str' => 'STR002',
                'biaya' => 150000.00,
                'jadwal' => null,
            ],
        ]);
    }
}