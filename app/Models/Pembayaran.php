<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // --- FIX: TAMBAHKAN PROPERTI $fillable ---
    protected $fillable = [
    'id_pemesanan', // FIX: Kolom baru
    'id_dokter',
    'nominal',
    'metode'
];

// Ganti relasi lama
public function pemesanan()
{
    return $this->belongsTo(\App\Models\Pemesanan::class, 'id_pemesanan');
}

   
    /**
     * Mendapatkan dokter yang terkait pembayaran ini.
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }
}