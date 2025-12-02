<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomentarBalasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('komentar_balasans')->truncate();
        
        DB::table('komentar_balasans')->insert([
            [
                'id' => 1,
                'id_komentar' => 1,
                'id_admin' => 1, // 'james'
                'balasan' => 'Terima kasih atas feedback positifnya! Kami akan terus meningkatkan pelayanan untuk Anda.',
                'created_at' => '2025-11-10 11:00:00',
                'updated_at' => '2025-11-10 11:00:00',
            ],
            [
                'id' => 2,
                'id_komentar' => 3,
                'id_admin' => 1, // 'james'
                'balasan' => 'Senang mendengar Anda puas dengan pelayanan kami. Semoga lekas sembuh!',
                'created_at' => '2025-11-11 10:00:00',
                'updated_at' => '2025-11-11 10:00:00',
            ],
            [
                'id' => 3,
                'id_komentar' => 5,
                'id_admin' => 1, // 'james'
                'balasan' => 'Mohon maaf atas ketidaknyamanan waktu tunggu. Kami akan berusaha memperbaiki sistem antrian kami.',
                'created_at' => '2025-11-11 16:00:00',
                'updated_at' => '2025-11-11 16:00:00',
            ],
            [
                'id' => 4,
                'id_komentar' => 9,
                'id_admin' => 1, // 'james'
                'balasan' => 'Terima kasih atas masukannya. Kami akan segera melakukan perbaikan ruang praktek untuk kenyamanan pasien.',
                'created_at' => '2025-11-13 10:00:00',
                'updated_at' => '2025-11-13 10:00:00',
            ],
            [
                'id' => 5,
                'id_komentar' => 17,
                'id_admin' => 1, // 'james'
                'balasan' => 'Terima kasih atas feedbacknya. Kami akan review kembali struktur biaya konsultasi kami.',
                'created_at' => '2025-11-15 10:00:00',
                'updated_at' => '2025-11-15 10:00:00',
            ],
            [
                'id' => 6,
                'id_komentar' => 24,
                'id_admin' => 3, // 'James' (adminwecare@gmail.com)
                'balasan' => 'Terima kasih telah mempercayai WeCare sebagai klinik kesehatan anda. Semoga anda puas dengan pelayanan kami. Semoga cepat sembuh. Salam sehat',
                'created_at' => '2025-11-16 05:10:54',
                'updated_at' => '2025-11-16 05:10:54',
            ],
        ]);
    }
}