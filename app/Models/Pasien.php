<?php
// --- app/Models/Pasien.php ---

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',       // Kunci asing yang menghubungkan ke tabel users
        'id_pasien',     // <-- Tambahkan ini
        'tanggal_lahir',    // Tanggal Lahir
        'jenis_kelamin',        // Jenis Kelamin
        'alamat',       // Alamat
    ];

    // Tambahkan relasi kembali ke User
    public function user()
    {
        // foreign key di Pasien adalah 'user_id'
        // local key di User adalah 'id'
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}