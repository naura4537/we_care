<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Komentar;
use App\Models\Pasien; // <--- PENTING: Jangan sampai hilang
use Illuminate\Support\Facades\Auth;

class PasienKomentarController extends Controller
{
    /**
     * Menampilkan daftar ulasan saya
     */
    public function index()
    {
        // 1. Cari Data Pasien berdasarkan User yang login (ID: 4)
        $dataPasien = Pasien::where('user_id', Auth::id())->first();

        // Jika data pasien belum ada, kita set null biar tidak error
        $id_pasien = $dataPasien ? $dataPasien->id : null; 
        
        // 2. Ambil komentar berdasarkan ID Pasien tersebut
        $komentars = Komentar::with('dokter.user')
                             ->where('id_pasien', $id_pasien)
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('pasien.komentar.index', compact('komentars'));
    }

    /**
     * Form Ulasan
     */
    public function create($id_dokter)
    {
        $dokter = Dokter::with('user')->findOrFail($id_dokter);
        return view('pasien.komentar.create', compact('dokter'));
    }
    
    /**
     * Simpan Ulasan
     */
    public function store(Request $request, $id_dokter)
    {
        $request->validate([
            'komentar' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // 1. Cari ID Pasien yang Asli (karena User ID beda dengan Pasien ID)
        $dataPasien = Pasien::where('user_id', Auth::id())->first();

        // Jaga-jaga kalau user belum melengkapi profil
        if (!$dataPasien) {
            return redirect()->back()->with('error', 'Gagal: Profil pasien tidak ditemukan. Silakan lengkapi data diri dulu.');
        }

        try {
            // 2. Simpan ke Database
            Komentar::create([
                'id_pasien' => $dataPasien->id, // <--- Pakai ID Pasien (bukan Auth::id)
                'id_dokter' => $id_dokter,
                'komentar' => $request->komentar,
                'rating' => $request->rating,
            ]);

        } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }

        return redirect()->route('pasien.komentar')->with('success', 'Ulasan Anda berhasil disimpan. Terima kasih!');
    }public function edit($id)
    {
        // Cari komentar berdasarkan ID
        $komentar = Komentar::with('dokter')->findOrFail($id);

        // Validasi keamanan: Pastikan yang edit adalah pemilik komentar itu sendiri
        $dataPasien = Pasien::where('user_id', Auth::id())->first();
        if ($komentar->id_pasien != $dataPasien->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit ulasan ini.');
        }

        return view('pasien.komentar.edit', compact('komentar'));
    }

    /**
     * Menyimpan Perubahan (Update)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $komentar = Komentar::findOrFail($id);

        // Update data
        $komentar->update([
            'komentar' => $request->komentar,
            'rating' => $request->rating,
        ]);

        return redirect()->route('pasien.komentar')->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Menghapus Ulasan
     */
    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);
        
        // Validasi keamanan lagi (opsional tapi bagus)
        $dataPasien = Pasien::where('user_id', Auth::id())->first();
        if ($komentar->id_pasien != $dataPasien->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus ulasan ini.');
        }

        $komentar->delete();

        return redirect()->route('pasien.komentar')->with('success', 'Ulasan berhasil dihapus.');
    }
}