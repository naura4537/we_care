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
    Schema::create('komentars', function (Blueprint $table) {
        $table->id();
        
        // Foreign key ke tabel pasiens
        $table->foreignId('id_pasien')->constrained('pasiens')->onDelete('cascade');
        
        // Foreign key ke tabel dokters
        $table->foreignId('id_dokter')->constrained('dokters')->onDelete('cascade');
        
        $table->text('komentar')->nullable();
        $table->integer('rating')->nullable(); // Validasi (1-5) akan kita lakukan di Controller, bukan di DB
        
        // Kolom 'tanggal_komentar' dari SQL kita ganti dengan
        // created_at dan updated_at bawaan Laravel
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
