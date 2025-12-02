<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('komentar_balasans', function (Blueprint $table) {
        $table->id();
        
        // Foreign key ke tabel komentars
        $table->foreignId('id_komentar')->constrained('komentars')->onDelete('cascade');
        
        // Foreign key ke tabel users (untuk admin yang membalas)
        // Kita beri nama 'id_admin' tapi merujuk ke 'users.id'
        $table->foreignId('id_admin')->constrained('users')->onDelete('cascade');
        
        $table->text('balasan');
        
        // 'tanggal_balasan' kita ganti dengan timestamps
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_balasans');
    }
};
