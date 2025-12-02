<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResepSeeder extends Seeder
{
    public function run()
    {
        DB::table('reseps')->truncate();
        // Tidak ada data INSERT, jadi biarkan kosong
    }
}