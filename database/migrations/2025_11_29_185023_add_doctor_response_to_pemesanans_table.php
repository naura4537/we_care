<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            // Tambahkan kolom TEXT untuk menyimpan Diagnosa/Resep
            $table->text('balasan_dokter')->nullable()->after('keluhan_pasien'); 

            // Tambahkan nilai 'Lihat Balasan' ke kolom status (jika belum ada)
            // Hanya jalankan ini jika kolom status adalah enum dan Anda perlu menambahkannya
            // $table->enum('status', ['Menunggu Pembayaran', 'Menunggu Balasan', 'Lihat Balasan', ...])->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropColumn('balasan_dokter');
        });
    }
};