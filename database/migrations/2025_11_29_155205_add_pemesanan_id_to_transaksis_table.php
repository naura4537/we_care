<?php

// database/migrations/..._add_pemesanan_id_to_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Kolom Foreign Key (harus UNSIGNED BIGINT, sama dengan ID di tabel 'pemesanans')
            $table->foreignId('pemesanan_id') 
                  ->nullable() // Tergantung kebutuhan, tapi biasanya transaksi terkait pemesanan
                  ->constrained('pemesanans') // Menghubungkan ke tabel 'pemesanans'
                  ->after('id'); // Opsional: atur posisi
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus foreign key dan kolom saat rollback
            $table->dropForeign(['pemesanan_id']); 
            $table->dropColumn('pemesanan_id');
        });
    }
};