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
        Schema::table('dokters', function (Blueprint $table) {
            // Tambahkan kolom yang dibutuhkan untuk tampilan detail dokter
            //$table->string('spesialisasi')->nullable();
            $table->string('pendidikan')->nullable();
            $table->integer('tarif_per_jam')->nullable();
            $table->text('jadwal_praktik')->nullable(); // Senin-Jumat: 08.00, 13.00, dst.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            //
        });
    }
};
