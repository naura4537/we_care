<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class Dokter extends Model
{
    use HasFactory;
    /**
     * Mendapatkan semua jadwal konsultasi untuk dokter ini.
     */
    protected $fillable = [
    'user_id',
    'id_dokter',
    'jenis_kelamin',         // Menggunakan nama dari DB
    'spesialisasi',
    'riwayat_pendidikan',
    'no_str',
    'biaya',
    'jadwal',
];
    public function jadwalKonsultasis()
    {
        return $this->hasMany(JadwalKonsultasi::class, 'id_dokter');
    }

    /**
     * Mendapatkan semua komentar untuk dokter ini.
     */
    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'id_dokter');
    }
    /**
     * Mendapatkan data user (induk) dari dokter ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_dokter', 'user_id');
    }
    public function komentar()
    {
        // Dokter memiliki banyak Komentar/Ulasan
        return $this->hasMany(Komentar::class, 'dokter_id'); 
    }
}
