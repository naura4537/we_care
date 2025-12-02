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
    Schema::create('notifikasis', function (Blueprint $table) {
        $table->id();
        
        // Foreign key ke tabel users (untuk penerima notif)
        $table->foreignId('recipient_user_id')->constrained('users')->onDelete('cascade');
        
        $table->text('message');
        $table->boolean('is_read')->default(0);
        
        // 'created_at' bawaan Laravel akan menggantikan 'created_at' di SQL Anda
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
