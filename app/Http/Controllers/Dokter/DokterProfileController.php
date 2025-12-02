<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DokterProfileController extends Controller
{
    /**
     * Menampilkan formulir profil Dokter.
     */
    public function show(Request $request): View
    {
        // ⚠️ KOREKSI: Gunakan $request->user() untuk User yang terautentikasi
        $user = $request->user();
        
        // Memuat relasi 'dokter' (asumsi relasi singular)
        $user->load('dokter'); 
        
        return view('dokter.profile.show', compact('user'));
    }

    /**
     * Menampilkan formulir untuk mengedit profil Dokter.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Memuat relasi 'dokter' untuk mengisi form.
        $user->load('dokter');
        
        return view('dokter.profile.edit', compact('user'));
    }


    /**
     * Update data profil User dan Dokter.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // ⚠️ LANGKAH BARU: Bersihkan input 'biaya' dari format mata uang (titik ribuan)
        if ($request->has('biaya')) {
            $request->merge([
                'biaya' => str_replace('.', '', $request->input('biaya'))
            ]);
        }
        
        // 2. Definisi Aturan Validasi
        // KOREKSI: Menggunakan 'name' dan 'gender' (sesuai input di View yang baru)
        $rules = [
            'nama' => 'required|string|max:255', 
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan', // KOREKSI: Menggunakan 'gender'

            // Aturan untuk tabel relasi dokters
            'spesialisasi' => 'required|string|max:255',
            'riwayat_pendidikan' => 'required|string',
            'no_str' => 'required|string|max:50',
            'biaya' => 'required|integer|min:0',
            'jadwal' => 'nullable|string',
        ];

        // 3. Lakukan Validasi
        $validatedData = $request->validate($rules);
        
        // 4. Pisahkan data untuk Users dan Dokters
        // KOREKSI: Menggunakan 'name' dan 'gender'
        $userData = [
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'Jenis_kelamin' => $validatedData['jenis_kelamin'],
        ];

        // Tambahkan password jika diisi
        if (!empty($validatedData['password'])) {
            $userData['password'] = Hash::make($validatedData['password']);
        }
        
        $dokterData = [
            'spesialisasi' => $validatedData['spesialisasi'],
            'riwayat_pendidikan' => $validatedData['riwayat_pendidikan'],
            'no_str' => $validatedData['no_str'],
            'biaya' => $validatedData['biaya'],
            'jadwal' => $validatedData['jadwal'],
        ];

        // 5. Update Data User (Tabel users)
        $user->update($userData);

        // 6. Update Data Relasi Dokter (Tabel dokters)
        // KOREKSI: Menggunakan $user->dokter (singular)
        if ($user->dokter) {
            $user->dokter->update($dokterData);
        } else {
            // Jika relasi belum ada 
            $user->dokter()->create($dokterData);
        }

        // 7. Redirect dengan pesan sukses
        return Redirect::route('dokter.profile.show')->with('status', 'Profil Dokter berhasil diperbarui!');
    }
}