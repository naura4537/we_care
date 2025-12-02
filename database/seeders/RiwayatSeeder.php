<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatSeeder extends Seeder
{
    public function run()
    {
        DB::table('riwayats')->truncate();
        // Tidak ada data INSERT, jadi biarkan kosong
    }
}