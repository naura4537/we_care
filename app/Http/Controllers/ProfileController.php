<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Requests\ProfileUpdateRequest; // Digunakan untuk validasi data user utama
use App\Http\Controllers\Controller; // Pastikan Anda mengimpor base Controller
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule; // Diperlukan untuk validasi yang lebih spesifik
use Illuminate\Support\Facades\Hash; // Diperlukan untuk menghapus akun

class ProfileController extends Controller // <-- Pastikan extends Controller
{
    /**
     * Menampilkan form edit profil pasien.
     * Muat data relasi pasien.
     */
    public function edit(Request $request): View
    {
        // Muat relasi 'pasien' untuk mengisi form edit
        $user = $request->user();
        $user->load('pasien'); 
        
        // Asumsi: View edit profil pasien berada di 'pasien.profile.edit'
        return view('pasien.profile.edit', compact('user'));
    }

    /**
     * Update informasi profil Pasien (tabel users dan pasiens).
     */
    public function update(Request $request): RedirectResponse // Ganti ProfileUpdateRequest dengan Request
    {
        $user = $request->user();
        
        // 1. Validasi Data
        $request->validate([
            'nama' => 'required|string|max:255', // Menggunakan 'name' standar Laravel
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_telp' => 'nullable|string|max:20', 
            'password' => 'nullable|confirmed|min:8',
            
            // Validasi data spesifik pasien
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string', 
        ]);
        
        // 2. Update Data User (Tabel users)
        $user->fill([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            // JANGAN UBAH ROLE DI SINI
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        // Logika update password:
if ($request->filled('password')) {
    $user->password = Hash::make($request->password);
}
        $user->save();

        // 3. Update Data Pasien (Tabel pasiens)
        if ($user->pasien) { // Cek relasi sudah ada
            $user->pasien()->update([
                'tanggal_lahir' => $request->tanggal_lahir, 
                'jenis_kelamin' => $request->jenis_kelamin, 
                'alamat' => $request->alamat,
            ]);
        } else {
             // Opsional: Buat record Pasien baru jika belum ada (misal setelah pendaftaran cepat)
             $user->pasien()->create([
                 'tanggal_lahir' => $request->tanggal_lahir, 
                 'jenis_kelamin' => $request->jenis_kelamin, 
                 'alamat' => $request->alamat,
                 'id_pasien' => 'P' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
             ]);
        }
        
        // 4. Redirect kembali ke halaman profil Pasien
        // Asumsi: Rute profil pasien adalah 'pasien.profile.show'
        return Redirect::route('pasien.profile.show')->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Menghapus akun Pasien (tabel users dan pasiens).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $user_id = $user->id;

        Auth::logout();

        // 1. Hapus data Pasien terkait sebelum menghapus User
        // Asumsi: Relasi 'pasien' sudah benar dan relasi memiliki cascade delete
        if ($user->pasien) {
            $user->pasien->delete(); 
        }

        // 2. Hapus User
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return Redirect::to('/');
    }
}