<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    /**
     * Mendapatkan user (penerima) notifikasi ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}