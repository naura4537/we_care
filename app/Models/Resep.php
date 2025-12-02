<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    /**
     * Mendapatkan riwayat (induk) dari resep ini.
     */
    public function riwayat()
    {
        return $this->belongsTo(Riwayat::class, 'id_riwayat');
    }
}