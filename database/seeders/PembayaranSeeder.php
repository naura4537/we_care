<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembayarans')->truncate();
        
        DB::table('pembayarans')->insert([
            [
                'id' => 1,
                'id_jadwal_konsultasi' => 235,
                'id_dokter' => 1,
                'nominal' => 100000.00,
                'metode' => 'cash',
            ],
            [
                'id' => 2,
                'id_jadwal_konsultasi' => 236,
                'id_dokter' => 1,
                'nominal' => 100000.00,
                'metode' => 'transfer',
            ],
            [
                'id' => 3,
                'id_jadwal_konsultasi' => 237,
                'id_dokter' => 1,
                'nominal' => 100000.00,
                'metode' => 'ewallet',
            ],
            [
                'id' => 4,
                'id_jadwal_konsultasi' => 238,
                'id_dokter' => 1,
                'nominal' => 100000.00,
                'metode' => 'ewallet',
            ],
            [
                'id' => 5,
                'id_jadwal_konsultasi' => 239,
                'id_dokter' => 1,
                'nominal' => 100000.00,
                'metode' => 'transfer',
            ],

            // ... (LANJUTKAN SISA DATA DARI .sql ANDA DI SINI) ...
            // sampai ID 56
            
        ]);
    }
}