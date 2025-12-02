<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// PENTING: Pastikan semua Model yang direlasikan sudah di-import
use App\Models\Pasien; 
use App\Models\Dokter;
use App\Models\JadwalKonsultasi; 
use App\Models\Pemesanan; // <<< INI YANG HILANG DAN MUNGKIN MENYEBABKAN ERROR

class Transaksi extends Model
{
    use HasFactory;
    
    // Ganti nama tabel default
    protected $table = 'transaksis';

    // Kolom yang dapat diisi (optional, tapi disarankan)
    protected $fillable = [
        'pemesanan_id', 
        'id_jadwal_konsultasi', 
        'jenis', 
        'keterangan', 
        'nominal', 
        'bank_tujuan', 
        'tanggal',
        // Tambahkan semua kolom lain dari tabel transaksis di sini
    ];

    /**
     * Relasi ke model Pasien (jika Transaksi langsung terkait Pasien)
     * Catatan: Relasi hasOne ini hanya berfungsi jika ada kolom user_id di tabel 'transaksis'.
     */
    public function pasien() 
    {
        return $this->hasOne(Pasien::class, 'user_id'); 
    }

    /**
     * Relasi ke model Dokter
     * Catatan: Relasi hasOne ini hanya berfungsi jika ada kolom user_id di tabel 'transaksis'.
     */
    public function dokter() 
    {
        return $this->hasOne(Dokter::class, 'user_id'); 
    }

    /**
     * Relasi ke model JadwalKonsultasi
     */
    public function jadwalKonsultasi()
    {
        return $this->belongsTo(JadwalKonsultasi::class, 'id_jadwal_konsultasi');
    }
    
    /**
     * Relasi ke model Pemesanan
     */
    public function pemesanan()
    {
        // Pastikan kolom 'pemesanan_id' sudah ada di tabel 'transaksis'
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}