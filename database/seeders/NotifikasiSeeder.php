<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('notifikasis')->truncate();

        DB::table('notifikasis')->insert([
            [
                'id' => 1,
                'recipient_user_id' => 1,
                'message' => '🔔 Ada 5 komentar baru dari pasien yang perlu ditanggapi',
                'is_read' => 0,
                'created_at' => '2025-11-16 05:36:38',
                'updated_at' => '2025-11-16 05:36:38',
            ],
            [
                'id' => 2,
                'recipient_user_id' => 1,
                'message' => '💰 Pemasukan hari ini mencapai Rp 1.500.000',
                'is_read' => 0,
                'created_at' => '2025-11-16 03:36:38',
                'updated_at' => '2025-11-16 03:36:38',
            ],
            [
                'id' => 3,
                'recipient_user_id' => 1,
                'message' => '📅 Ada 3 jadwal konsultasi baru untuk besok',
                'is_read' => 0,
                'created_at' => '2025-11-16 01:36:38',
                'updated_at' => '2025-11-16 01:36:38',
            ],

            // ... (LANJUTKAN SISA DATA DARI .sql ANDA DI SINI) ...
            // sampai ID 20
        ]);
    }
}