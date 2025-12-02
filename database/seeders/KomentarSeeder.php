<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('komentars')->truncate();
        
        DB::table('komentars')->insert([
            [
                'id' => 1,
                'id_pasien' => 1,
                'id_dokter' => 1,
                'komentar' => 'Dokter sangat ramah dan penjelasannya mudah dipahami. Terima kasih banyak atas pelayanannya!',
                'rating' => 5,
                'created_at' => '2025-11-10 10:30:00', // Kita set manual
                'updated_at' => '2025-11-10 10:30:00', // Kita set manual
            ],
            [
                'id' => 2,
                'id_pasien' => 2,
                'id_dokter' => 1,
                'komentar' => 'Pelayanan cepat dan dokternya profesional. Sangat memuaskan!',
                'rating' => 5,
                'created_at' => '2025-11-10 14:15:00',
                'updated_at' => '2025-11-10 14:15:00',
            ],
            [
                'id' => 3,
                'id_pasien' => 3,
                'id_dokter' => 1,
                'komentar' => 'Dokter sangat sabar dalam menjelaskan kondisi kesehatan saya. Recommended!',
                'rating' => 5,
                'created_at' => '2025-11-11 09:20:00',
                'updated_at' => '2025-11-11 09:20:00',
            ],
            
            // ... (LANJUTKAN SISA DATA DARI .sql ANDA DI SINI) ...
            // sampai ID 37
            
        ]);
    }
}