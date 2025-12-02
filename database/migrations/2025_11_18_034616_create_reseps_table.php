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
    Schema::create('reseps', function (Blueprint $table) {
        $table->id();
        
        // Foreign key ke tabel riwayats
        $table->foreignId('id_riwayat')->constrained('riwayats')->onDelete('cascade');
        
        $table->string('nama_obat')->nullable();
        $table->string('dosis')->nullable();
        $table->text('instruksi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
