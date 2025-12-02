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
    Schema::create('riwayats', function (Blueprint $table) {
        $table->id();
        
        // Foreign key ke tabel jadwal_konsultasis
        $table->foreignId('id_jadwal_konsultasi')->constrained('jadwal_konsultasis')->onDelete('cascade');
        
        $table->text('diagnosis')->nullable();
        $table->text('resep')->nullable(); // Kolom resep lama, mungkin tidak terpakai
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
