<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gunakan nama tabel yang kita tentukan di migrasi
        DB::table('jadwal_konsultasis')->truncate();
        
        DB::table('jadwal_konsultasis')->insert([
            [
                'id' => 235,
                'id_dokter' => 1,
                'id_pasien' => 1,
                'jadwal' => '2025-11-10 09:00:00',
                'status' => 'selesai',
            ],
            [
                'id' => 236,
                'id_dokter' => 1,
                'id_pasien' => 2,
                'jadwal' => '2025-11-10 09:00:00',
                'status' => 'selesai',
            ],
            [
                'id' => 237,
                'id_dokter' => 1,
                'id_pasien' => 3,
                'jadwal' => '2025-11-10 09:00:00',
                'status' => 'selesai',
            ],
            [
                'id' => 238,
                'id_dokter' => 1,
                'id_pasien' => 4,
                'jadwal' => '2025-11-10 09:00:00',
                'status' => 'selesai',
            ],
            [
                'id' => 239,
                'id_dokter' => 1,
                'id_pasien' => 5,
                'jadwal' => '2025-11-10 09:00:00',
                'status' => 'selesai',
            ],

            // ... (LANJUTKAN SISA DATA DARI .sql ANDA DI SINI) ...
            // sampai ID 290
            
        ]);
    }
}