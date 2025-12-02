<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKonsultasi extends Model
{
    use HasFactory;
    
    // Ganti nama tabel default 'jadwalkonsultasis' menjadi 'jadwal_konsultasis'
    protected $table = 'jadwal_konsultasis'; 

    /**
     * Kolom yang bisa diisi menggunakan Mass Assignment.
     */
    protected $fillable = [
        'id_dokter',
        'id_pasien',
        'jadwal',
        'status',
        // Tambahkan kolom lain yang relevan di tabel jika ada (misal: 'id_pemesanan')
    ];

    /**
     * Mendapatkan data dokter yang memiliki jadwal ini.
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    /**
     * Mendapatkan data pasien yang memiliki jadwal ini.
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
    
    public function pembayaran()
    {
        // Asumsinya satu jadwal hanya punya satu pembayaran
        return $this->hasOne(Pembayaran::class, 'id_jadwal_konsultasi');
    }
    
    public function riwayat()
    {
        return $this->hasOne(Riwayat::class, 'id_jadwal_konsultasi');
    }
}