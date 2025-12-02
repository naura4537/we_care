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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->enum('jenis', ['masuk', 'keluar'])->nullable();
        $table->string('keterangan')->nullable();
        $table->decimal('nominal', 12, 2)->nullable();
        $table->string('bank_tujuan')->nullable();
        
        // Kita gunakan 'created_at' bawaan Laravel untuk menggantikan 'tanggal'
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
