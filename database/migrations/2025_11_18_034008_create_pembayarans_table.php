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
    Schema::table('pembayarans', function (Blueprint $table) {
        // --- 1. CLEANUP OLD COLUMN (Ini yang menyebabkan error 1091) ---
        // $table->dropForeign(['id_jadwal_konsultasi']); // <--- BARIS INI DINONAKTIFKAN (DIHAPUS ATAU DIKOMENTARI)
        $table->dropColumn('id_jadwal_konsultasi'); // Hapus kolomnya

        // --- 2. ADD NEW FK COLUMN (NULLABLE) ---
        $table->foreignId('pemesanan_id')
              ->after('id')
              ->nullable()
              ->constrained('pemesanans')
              ->cascadeOnDelete();
    });
}

/**
 * Balikkan migrasi (Rollback).
 */
public function down(): void
{
    Schema::table('pembayarans', function (Blueprint $table) {
        // Balikkan perubahan (Hapus FK baru, tambahkan kolom lama)
        $table->dropForeign(['pemesanan_id']);
        $table->dropColumn('pemesanan_id');
        
        // Tambahkan kolom lama (asumsi tipe data adalah bigint)
        $table->bigInteger('id_jadwal_konsultasi')->unsigned()->nullable()->after('id'); 
    });
}
};
