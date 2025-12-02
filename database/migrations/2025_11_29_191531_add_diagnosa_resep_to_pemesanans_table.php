<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ... di dalam method up()

public function up()
{
    Schema::table('pemesanans', function (Blueprint $table) {
        $table->text('diagnosa')->nullable();
        $table->text('resep')->nullable();
    });
}

// ... di dalam method down()

public function down()
{
    Schema::table('pemesanans', function (Blueprint $table) {
        $table->dropColumn('diagnosa');
        $table->dropColumn('resep');
    });
}
};
