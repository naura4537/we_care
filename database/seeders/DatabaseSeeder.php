<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. MATIKAN foreign key (untuk SQLite)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Panggil SEMUA seeder (cukup SATU KALI)
        $this->call([
            UserSeeder::class,    
            DokterSeeder::class,  
            PasienSeeder::class,  
            JadwalKonsultasiSeeder::class,
            KomentarSeeder::class,
            KomentarBalasanSeeder::class,
            PembayaranSeeder::class,
            RiwayatSeeder::class,
            ResepSeeder::class,
            TransaksiSeeder::class,
            NotifikasiSeeder::class,
        ]);
        
        // 3. NYALAKAN KEMBALI foreign key (untuk SQLite)
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}