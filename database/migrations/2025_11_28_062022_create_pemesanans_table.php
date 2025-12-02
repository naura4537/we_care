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
    Schema::create('pemesanans', function (Blueprint $table) {
        $table->id();
        // Kolom wajib sesuai PemesananController dan Model Pemesanan:
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
        $table->dateTime('waktu_janji');
        $table->string('metode_pembayaran');
        $table->unsignedInteger('nominal'); // Pastikan tipe data sesuai biaya
        $table->string('status')->default('Menunggu Pembayaran');
        $table->dateTime('expired_at');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
