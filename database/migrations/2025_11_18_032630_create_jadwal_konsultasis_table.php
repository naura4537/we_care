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
    Schema::create('jadwal_konsultasis', function (Blueprint $table) {
        $table->id();
        
        // Foreign key ke tabel dokters (me-refer ke 'id' di tabel 'dokters')
        $table->foreignId('id_dokter')->constrained('dokters')->onDelete('cascade');
        
        // Foreign key ke tabel pasiens (me-refer ke 'id' di tabel 'pasiens')
        $table->foreignId('id_pasien')->constrained('pasiens')->onDelete('cascade');
        
        $table->dateTime('jadwal');
        $table->enum('status', ['konfirmasi', 'cancel', 'selesai'])->default('konfirmasi');
        
        $table->timestamps(); // Menambah created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_konsultasis');
    }
};
