<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
{
    Schema::table('pembayarans', function (Blueprint $table) {
        // --- 1. CLEANUP (Hapus FK lama dan kolom lama) ---
        // $table->dropForeign(['id_jadwal_konsultasi']); // <--- NONAKTIFKAN BARIS INI
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
            // Balikkan perubahan
            $table->dropForeign(['pemesanan_id']);
            $table->dropColumn('pemesanan_id');
            
            // Tambahkan kembali kolom lama (sebagai BIGINT unsigned nullable)
            $table->bigInteger('id_jadwal_konsultasi')->unsigned()->nullable()->after('id'); 
            // Jika Anda ingin FK lama ada lagi, Anda harus menambahkannya di sini.
        });
    }
};