<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Menambahkan kolom id_jadwal_konsultasi sebagai Foreign Key
            $table->foreignId('id_jadwal_konsultasi') 
                  ->nullable() // Mengizinkan NULL jika transaksi tidak selalu memiliki jadwal konsultasi
                  ->constrained('jadwal_konsultasis') // Merujuk ke tabel jadwal_konsultasis
                  ->after('nominal'); // Posisikan setelah kolom nominal (sesuaikan jika perlu)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['id_jadwal_konsultasi']); 
            // Hapus kolom
            $table->dropColumn('id_jadwal_konsultasi');
        });
    }
};