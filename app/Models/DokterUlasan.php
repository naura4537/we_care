<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterUlasan extends Model
{
    use HasFactory;

    protected $table = 'dokter_ulasans'; // Pastikan Anda buat tabel ini di database!

    protected $fillable = [
        'dokter_id',
        'user_id_pasien', // User ID Pasien yang diulas
        'pemesanan_id',   // Opsional: Jika ingin dikaitkan ke konsultasi tertentu
        'rating',
        'komentar',
    ];

    // Relasi untuk mengetahui siapa dokter yang mengulas
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    // Relasi ke User Pasien
    public function pasien()
    {
        return $this->belongsTo(User::class, 'user_id_pasien');
    }
    
}