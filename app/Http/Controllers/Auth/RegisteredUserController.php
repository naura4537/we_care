<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Pasien;
use App\Models\Dokter;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // --- app/Http/Controllers/Auth/RegisteredUserController.php ---

public function store(Request $request): RedirectResponse
{
    // 1. VALIDASI DATA
    $request->validate([
        'nama' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'string', 'in:pasien,dokter'], 
        
        // Validasi data yang hanya untuk tabel Pasien/Dokter
        'birth_date' => 'nullable|date',
        'gender' => 'nullable|string|in:Laki-laki,Perempuan',
        'address' => 'nullable|string',
        'no_telp' => ['nullable', 'string', 'max:20'],

        // <-- TAMBAHAN VALIDASI DOKTER -->
        'spesialisasi' => 'nullable|string|max:100',
        'riwayat_pendidikan' => 'nullable|string|max:255',
        'no_str' => 'nullable|string|max:20',
        'biaya' => 'nullable|numeric',
        'jadwal' => 'nullable|string',
    ]);

    // 2. BUAT USER BARU (Hanya data users: nama, email, password, role)
    $user = User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'no_telp' => $request->no_telp, // phone_number tetap di users
    ]);

    $redirectTo = route('dashboard'); 

    // 3. BUAT RECORD PROFIL BERDASARKAN ROLE
    if ($user->role === 'pasien') {
        // Data profil yang DIPINDAHKAN dari tabel users kini disimpan di tabel pasiens
        $user->pasiens()->create([
            'id_pasien' => 'P' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
            'birth_date' => $request->birth_date, // Kolom yang dipindah
            'gender' => $request->gender,         // Kolom yang dipindah
            'address' => $request->address,       // Kolom yang dipindah
        ]);
        $redirectTo = route('pasien.dashboard');
        
    } elseif ($user->role === 'dokter') {
    $user->dokters()->create([
        'id_dokter' => 'D' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
        
        // Data yang Dipetakan (Sesuai dengan nama kolom DB)
        'gender' => $request->gender, // Mapping dari 'gender' ke 'jenis_kelamin'
        'spesialisasi' => $request->spesialisasi,
        'riwayat_pendidikan' => $request->riwayat_pendidikan,
        'no_str' => $request->no_str,
        'biaya' => $request->biaya,
        'jadwal' => $request->jadwal,
        
        // Field lain yang dibutuhkan...
        // ...
    ]);
    $redirectTo = route('dokter.dashboard');
}

    event(new Registered($user));
    return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');

}
}