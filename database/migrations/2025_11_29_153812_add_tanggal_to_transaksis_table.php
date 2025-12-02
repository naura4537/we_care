<?php

// database/migrations/YYYY_MM_DD_HHMMSS_add_tanggal_to_transaksis_table.php

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
            // Menambahkan kolom 'tanggal' bertipe Date
            // Anda bisa menggunakan ->after('kolom_sebelumnya') untuk menentukan posisinya
            $table->date('tanggal')->nullable();
            
            // Atau jika Anda ingin menggunakan waktu dan tanggal:
            // $table->timestamp('tanggal')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Menghapus kolom 'tanggal' saat rollback
            $table->dropColumn('tanggal');
        });
    }
};