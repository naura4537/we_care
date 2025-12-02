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
        Schema::table('pemesanans', function (Blueprint $table) {
            // Tambahkan kolom 'keluhan_pasien' dengan tipe TEXT
            $table->text('keluhan_pasien')->after('waktu_janji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn('keluhan_pasien');
        });
    }
};