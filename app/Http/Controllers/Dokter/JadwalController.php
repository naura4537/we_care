<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\Dokter;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar konsultasi / jadwal dokter
     */
    public function index()
{
    $user = Auth::user();
    $dokter = Dokter::where('user_id', $user->id)->first();

    if (!$dokter) {
        return abort(403, 'Akses Ditolak. Akun Anda tidak terdaftar sebagai Dokter.');
    }

    // 2. Ambil data Pemesanan, EAGER LOAD relasi USER (Pasien)
    $konsultasi = Pemesanan::with('user') // <--- DITAMBAHKAN
                    ->where('dokter_id', $dokter->id)
                    ->orderBy('waktu_janji', 'desc')
                    ->get();

    return view('dokter.jadwal.index', compact('konsultasi'));
}

    /**
     * Menampilkan Form Balasan (Mengambil Data Lama jika ada)
     */
    public function showBalas($id)
    {
        // Cari pemesanan berdasarkan ID
        $konsultasi = \App\Models\Pemesanan::findOrFail($id);

        // Validasi keamanan: Pastikan ini milik dokter yang sedang login
        $dokter = \App\Models\Dokter::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
        if ($konsultasi->dokter_id != $dokter->id) {
            return abort(403, 'Anda tidak berhak mengakses data ini.');
        }

        return view('dokter.jadwal.balas', compact('konsultasi'));
    }

    /**
     * Menyimpan Balasan ke Database
     */
    /**
     * Menyimpan Balasan (Diagnosa & Resep) ke Database
     */
    public function storeBalas(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'diagnosa' => 'required|string',
            'resep'    => 'required|string',
        ]);

        // 2. Ambil data lama
        $konsultasi = \App\Models\Pemesanan::findOrFail($id);

        // 3. Validasi keamanan: Pastikan yang update adalah dokter pemilik jadwal
        $dokter = \App\Models\Dokter::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
        if ($konsultasi->dokter_id != $dokter->id) {
            return redirect()->route('dokter.jadwal.index')->with('error', 'Akses Ditolak: Ini bukan jadwal Anda.');
        }

        // 4. Update data dan ubah status menjadi Selesai
        $konsultasi->update([
            'diagnosa' => $request->diagnosa,
            'resep'    => $request->resep,
            'status'   => 'Selesai', 
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Konsultasi selesai! Diagnosa & Resep berhasil disimpan.');
    }
}