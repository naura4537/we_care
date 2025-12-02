<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\Dokter;
use App\Models\User;
use App\Models\DokterUlasan;

class UlasanPasienController extends Controller 
{
    /**
     * Helper untuk validasi keamanan dan mengambil data utama.
     * Termasuk memverifikasi status Pemesanan harus 'Selesai'.
     * @return array[\App\Models\Dokter, \App\Models\Pemesanan]
     */
    private function checkAuthorization($pemesanan_id)
    {
        $user = Auth::user();
        
        // 1. Dapatkan objek Dokter yang sedang login
        $dokter = Dokter::where('user_id', $user->id)->firstOrFail();
        
        // 2. Dapatkan objek Pemesanan berdasarkan ID dan Dokter yang bersangkutan
        $konsultasi = Pemesanan::where('dokter_id', $dokter->id)
                                 ->findOrFail($pemesanan_id);
        
        // 3. Pengecekan Status: Wajib 'Selesai' untuk membuat/mengedit ulasan.
        if ($konsultasi->status !== 'Selesai') {
            abort(403, 'Akses Ditolak. Ulasan hanya bisa diberikan pada konsultasi yang sudah Selesai.');
        }
        
        return [$dokter, $konsultasi];
    }
    
    // --- Index Method ---

    /**
     * Menampilkan daftar semua pasien yang pernah berkonsultasi dengan dokter ini (Index).
     */
    public function index()
    {
        $dokter = Dokter::where('user_id', Auth::id())->first();

        if (!$dokter) {
            abort(403, 'Akses Ditolak. Akun Dokter tidak ditemukan.');
        }

        // Ambil semua user_id pasien yang pernah dilayani oleh dokter ini
        $patientIds = Pemesanan::where('dokter_id', $dokter->id)
                              ->pluck('user_id')
                              ->unique();
        
        // Ambil data User (Pasien) berdasarkan ID yang dikumpulkan
        $pasiens = User::whereIn('id', $patientIds)->get();
        
        return view('dokter.ulasan.index', compact('pasiens', 'dokter'));
    }

    // --- CRUD Methods (Create, Store, Edit, Update, Destroy) ---
    
    /**
     * 1. CREATE (GET): Menampilkan Form Kosong untuk Ulasan Baru.
     */
    public function create($pemesanan_id)
    {
        // Pengecekan Otorisasi dan Status Selesai
        list($dokter, $konsultasi) = $this->checkAuthorization($pemesanan_id);
        
        // Jika ulasan sudah ada, redirect ke halaman edit
        if (DokterUlasan::where('pemesanan_id', $pemesanan_id)->exists()) {
            return redirect()->route('dokter.ulasan.pasien.edit', $pemesanan_id)
                             ->with('warning', 'Ulasan sudah ada, silakan edit.');
        }
        
        $pasien = User::findOrFail($konsultasi->user_id);
        $ulasan = new DokterUlasan();
        
        return view('dokter.ulasan.form', compact('konsultasi', 'ulasan', 'pasien'));
    }
    
    /**
     * 2. STORE (POST): Menyimpan Ulasan Baru.
     */
    public function store(Request $request, $pemesanan_id)
    {
        // Pengecekan Otorisasi dan Status Selesai
        list($dokter, $konsultasi) = $this->checkAuthorization($pemesanan_id);
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ]);
        
        // Cek duplikasi sebelum menyimpan
        if (DokterUlasan::where('pemesanan_id', $pemesanan_id)->exists()) {
            return redirect()->back()->with('error', 'Ulasan sudah pernah dibuat untuk konsultasi ini.');
        }
        
        DokterUlasan::create([
            'dokter_id' => $dokter->id,
            'user_id_pasien' => $konsultasi->user_id,
            'pemesanan_id' => $pemesanan_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);
        
        return redirect()->route('dokter.ulasan.index')->with('success', 'Ulasan pasien berhasil disimpan.');
    }

    /**
     * 3. EDIT (GET): Menampilkan Form Ulasan yang Sudah Ada.
     */
    public function edit($pemesanan_id)
    {
        // Pengecekan Otorisasi dan Status Selesai
        list($dokter, $konsultasi) = $this->checkAuthorization($pemesanan_id);
        
        // Cari ulasan yang akan diedit
        $ulasan = DokterUlasan::where('pemesanan_id', $pemesanan_id)->firstOrFail();
        $pasien = User::findOrFail($konsultasi->user_id);
        
        return view('dokter.ulasan.form', compact('konsultasi', 'ulasan', 'pasien'));
    }
    
    /**
     * 4. UPDATE (PUT/PATCH): Menyimpan Perubahan Ulasan.
     */
    public function update(Request $request, $pemesanan_id)
    {
        // Pengecekan Otorisasi dan Status Selesai
        list($dokter, $konsultasi) = $this->checkAuthorization($pemesanan_id);
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ]);
        
        // Cari ulasan untuk diupdate
        $ulasan = DokterUlasan::where('pemesanan_id', $pemesanan_id)->firstOrFail();
        
        $ulasan->fill([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ])->save();
        
        return redirect()->route('dokter.ulasan.index')->with('success', 'Perubahan ulasan berhasil disimpan.');
    }

    /**
     * 5. DELETE (Hapus Ulasan).
     */
    public function destroy($pemesanan_id)
    {
        // Pengecekan Otorisasi dan Status Selesai
        list($dokter, $konsultasi) = $this->checkAuthorization($pemesanan_id);
        
        // Melanjutkan logika delete yang terpotong
        DokterUlasan::where('pemesanan_id', $pemesanan_id)->delete();
        
        return redirect()->route('dokter.ulasan.index')->with('success', 'Ulasan pasien berhasil dihapus.');
    }
    
}