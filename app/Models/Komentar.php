<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    // Asumsi nama tabel adalah 'komentar' (dari gambar sebelumnya)
    protected $table = 'komentars';

    /**
     * Atribut yang dapat diisi (mass assignable).
     */
    protected $fillable = [
        'id_pasien', // ID Pasien
        'id_dokter', // ID Dokter yang dikomentari
        'komentar',
        'rating',
        // Jika ada kolom lain, tambahkan di sini (misal: 'status')
    ];

    /**
     * Mendapatkan data pasien yang membuat komentar ini.
     */
    public function pasien()
    {
        // Asumsi: Anda memiliki Model Pasien
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    /**
     * Mendapatkan data dokter yang menerima komentar ini.
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }
    public function balasans()
    {
        return $this->hasMany(KomentarBalasan::class, 'id_komentar');
    }
    public function user()
{
    // Karena nama kolomnya 'id_pasien', kita harus sebutkan secara spesifik
    return $this->belongsTo(User::class, 'id_pasien');
}
}