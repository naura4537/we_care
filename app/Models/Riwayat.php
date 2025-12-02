<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    
    // Ganti nama tabel default
    protected $table = 'riwayats';

    /**
     * Mendapatkan jadwal konsultasi (induk) dari riwayat ini.
     */
    public function jadwalKonsultasi()
    {
        return $this->belongsTo(JadwalKonsultasi::class, 'id_jadwal_konsultasi');
    }

    /**
     * Mendapatkan semua resep obat untuk riwayat ini.
     */
    public function reseps()
    {
        return $this->hasMany(Resep::class, 'id_riwayat');
    }
}