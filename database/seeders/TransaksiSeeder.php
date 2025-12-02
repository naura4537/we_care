<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        DB::table('transaksis')->truncate();

        DB::table('transaksis')->insert([
            [
                'id' => 3,
                'jenis' => 'keluar',
                'keterangan' => 'Pembelian Obat',
                'nominal' => 2000000.00,
                'bank_tujuan' => 'BRI',
                'created_at' => '2025-11-15 22:00:00',
                'updated_at' => '2025-11-15 22:00:00',
            ],
            [
                'id' => 38,
                'jenis' => 'keluar',
                'keterangan' => 'Pembelian Obat-obatan',
                'nominal' => 2000000.00,
                'bank_tujuan' => 'BRI',
                'created_at' => '2025-11-01 14:00:00',
                'updated_at' => '2025-11-01 14:00:00',
            ],
            [
                'id' => 39,
                'jenis' => 'keluar',
                'keterangan' => 'Bayar Listrik Klinik',
                'nominal' => 850000.00,
                'bank_tujuan' => 'BCA',
                'created_at' => '2025-11-02 10:30:00',
                'updated_at' => '2025-11-02 10:30:00',
            ],

            // ... (LANJUTKAN SISA DATA DARI .sql ANDA DI SINI) ...
            // sampai ID 87
        ]);
    }
}