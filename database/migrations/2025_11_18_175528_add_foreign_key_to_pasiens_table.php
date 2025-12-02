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
    Schema::table('pasiens', function (Blueprint $table) {
    // 1. HAPUS KUNCI ASING LAMA (Jika ada, ini mencegah Error 1005)
    // Coba hapus kunci asing lama jika ada (nama defaultnya: [nama_tabel]_[nama_kolom]_foreign)
    // Nama yang umum digunakan Laravel adalah: pasiens_user_id_foreign
    
    $table->dropForeign(['user_id']); // Menghapus constraint lama

    // 2. Tambahkan Kunci Asing baru dengan aturan CASCADE
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');
    
    // 3. Pastikan kolom user_id adalah tipe data yang benar (hanya jika Anda tidak yakin)
    // Jika Anda membuat kolom user_id secara manual, tambahkan baris ini (jika belum):
    // $table->unsignedBigInteger('user_id')->change(); 
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            //
        });
    }
};
