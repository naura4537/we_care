<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pemesanan; // Kita akan gunakan Model Pemesanan

class RiwayatController extends Controller
{
    /**
     * Tampilkan daftar riwayat pasien yang sudah selesai (Diagnosa & Resep sudah terisi).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Ganti DB::table menjadi Model Pemesanan (karena data ada di sini)
        $query = Pemesanan::query()
            // Kita load relasi dokter (yang punya relasi ke user untuk ambil nama dokter) dan user (pasien)
            ->with(['dokter.user', 'user']); 

        // FILTER UTAMA: Hanya tampilkan yang statusnya Selesai DAN kolom diagnosa tidak kosong
        $query->where('status', 'Selesai')
              ->whereNotNull('diagnosa'); // Hanya tampilkan jika diagnosa sudah diisi

        // Logika Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Nama Pasien (melalui relasi user)
                $q->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('nama', 'LIKE', "%{$search}%"); // Asumsi nama user ada di kolom 'name'
                })
                // Cari berdasarkan Nama Dokter (melalui relasi dokter -> user)
                ->orWhereHas('dokter.user', function($dokterUserQuery) use ($search) {
                    $dokterUserQuery->where('nama', 'LIKE', "%{$search}%");
                });
            });
        }
        
        $riwayatList = $query->orderBy('created_at', 'DESC')->paginate(15);
        
        // Kirim data yang sudah difilter ke view
        return view('admin.riwayat.index', compact('riwayatList', 'search'));
    }
    public function show($id)
    {
        // Cari Pemesanan berdasarkan ID dan load semua relasi yang diperlukan
        $riwayat = \App\Models\Pemesanan::with(['user', 'dokter.user'])
            ->findOrFail($id);

        // Jika diagnosa belum terisi, anggap belum selesai
        if (empty($riwayat->diagnosa)) {
            return redirect()->route('admin.riwayat')
                ->with('error', 'Riwayat belum selesai diproses oleh dokter.');
        }

        // Pass data ke view
        return view('admin.riwayat.show', compact('riwayat'));
    }
    /**
     * Detail riwayat pasien
     * ... (Metode show() di sini akan menggunakan Model Pemesanan juga)
     */
     // ...
}