<?php

// app/Http/Controllers/Pasien/ProfileController.php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Http\RedirectResponse;
// Ganti PasienProfileController menjadi ProfileController (standar Laravel Breeze)
class PasienProfileController extends Controller 
{
    // Gunakan nama standar 'show'
    public function show(Request $request): View
    {
        $user = $request->user(); 
        $user->load('pasien');
        return view('pasien.profile.show', compact('user'));
    }

    // Gunakan nama standar 'edit'
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('pasien'); 
        return view('pasien.profile.edit', compact('user'));
    }

    // WAJIB: Tambahkan kembali method update() yang hilang!
   public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // 1. Validasi Data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_telp' => 'nullable|string|max:20', 
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string', 
        ]);
        
        // 2. Update Data User (Tabel users)
        $user->fill($request->only('nama', 'email', 'no_telp'));
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 3. Update Data Pasien (Tabel pasiens)
        if ($user->pasien) {
            $user->pasien()->update($request->only('tanggal_lahir', 'jenis_kelamin', 'alamat'));
        }
        
        return Redirect::route('pasien.profile.show')->with('status', 'Profil berhasil diperbarui!');
    }
    
    // WAJIB: Implementasi method destroy()
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->pasien) {
             // Asumsi: relasi pasien memiliki cascade delete atau dihapus manual
            $user->pasien->delete(); 
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}