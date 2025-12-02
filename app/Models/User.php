<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public function pasien()
{
    return $this->hasOne(\App\Models\Pasien::class, 'user_id');
}

/**
 * Mendapatkan data dokter yang terkait dengan user ini.
 */
public function komentarBalasans()
    {
        return $this->hasMany(KomentarBalasan::class, 'id_admin');
    }
public function dokter()
{
    return $this->hasOne(Dokter::class);
}
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'nama',          // Menggunakan nama
    'email',
    'password',
    'role',          // Role
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'recipient_user_id');
    }

/**
     * Mendapatkan record Pasien yang terkait dengan user ini.
     */
    public function dokters() // Relasi ke Dokter (untuk user dengan role 'dokter')
    {
        // Asumsi: foreign key di tabel 'dokters' adalah 'user_id'
        return $this->hasOne(Dokter::class, 'user_id'); 
    }

    public function pasiens() // Relasi ke Pasien (untuk user dengan role 'pasien')
    {
        // Asumsi: foreign key di tabel 'pasiens' adalah 'user_id'
        return $this->hasOne(Pasien::class, 'user_id'); 
    }
}


