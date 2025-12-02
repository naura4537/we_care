<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokter_ulasans', function (Blueprint $table) {
            $table->id();

            // Kolom FK ke Dokter
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            
            // Kolom FK ke Pasien (Users)
            $table->foreignId('user_id_pasien')->constrained('users')->onDelete('cascade');
            
            // Kolom FK ke Pemesanan (dibuat nullable jika konsultasi bisa dihapus)
            $table->foreignId('pemesanan_id')->nullable()->constrained('pemesanans')->onDelete('set null');

            $table->unsignedTinyInteger('rating'); // Rating 1-5
            $table->text('komentar');
            $table->timestamps();
            
            // Mencegah dokter mengulas satu konsultasi lebih dari sekali
            $table->unique(['pemesanan_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokter_ulasans');
    }
};