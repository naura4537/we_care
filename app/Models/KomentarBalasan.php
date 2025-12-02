<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarBalasan extends Model
{
    use HasFactory;
    
    // Ganti nama tabel default
    protected $table = 'komentar_balasans';

    /**
     * Mendapatkan komentar (induk) dari balasan ini.
     */
    public function komentar()
    {
        return $this->belongsTo(Komentar::class, 'id_komentar');
    }

    /**
     * Mendapatkan user (admin) yang membuat balasan ini.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}