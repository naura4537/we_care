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
    Schema::create('dokters', function (Blueprint $table) {
        $table->id();
        $table->string('id_dokter')->unique();
        
        // Ini adalah Foreign Key ke tabel 'users'
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
        $table->string('spesialisasi')->nullable();
        $table->text('riwayat_pendidikan')->nullable();
        $table->string('no_str')->nullable();
        $table->decimal('biaya', 10, 2)->nullable();
        $table->json('jadwal')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
