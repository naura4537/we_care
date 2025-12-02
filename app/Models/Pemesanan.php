<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan Model.
     * Secara default Laravel akan menggunakan bentuk jamak dari nama Model (pemesanans).
     *
     * @var string
     */
    protected $table = 'pemesanans';

    /**
     * Atribut yang dapat diisi (mass assignable).
     * Atribut ini harus dicantumkan agar Pemesanan::create() di Controller dapat berfungsi.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'dokter_id',
        'waktu_janji', // Disimpan sebagai TIMESTAMP
        'keluhan_pasien',
        'metode_pembayaran',
        'nominal',
        'status',      // Contoh: 'Menunggu Pembayaran', 'Dikonfirmasi', 'Selesai'
        'expired_at',  // Waktu kedaluwarsa pembayaran
        'diagnosa', // WAJIB ADA
        'resep',    // WAJIB ADA
        'status',
    ];

    /**
     * Atribut yang harus diubah ke tipe data tertentu (Casting).
     * Memastikan kolom tanggal/waktu diolah oleh Carbon.
     *
     * @var array
     */
    protected $casts = [
        'waktu_janji' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi (Relationships)
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Model User (Pasien)
     * Pemesanan dimiliki oleh satu User (Pasien).
     */
    public function user()
    {
        // Asumsi: Model User berada di App\Models\User
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Model Dokter
     * Pemesanan dimiliki oleh satu Dokter.
     */
    public function dokter()
    {
        // Asumsi: Model Dokter berada di App\Models\Dokter
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function pasien()
    {
        // foreign key di Pemesanan adalah 'user_id' (ID user pasien)
        // local key di Pasien adalah 'user_id'
        return $this->belongsTo(Pasien::class, 'user_id', 'user_id'); 
    }
    
}