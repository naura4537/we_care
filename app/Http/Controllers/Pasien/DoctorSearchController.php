<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;

class DoctorSearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input dari URL
        $keyword = $request->input('q');       // Untuk search nama
        $kategori = $request->input('kategori'); // Untuk filter spesialisasi

        // 2. Query Dasar
        $query = Dokter::with('user');

        // 3. Logika FILTER KATEGORI (Dokter Umum / Dokter Gigi)
        if (!empty($kategori) && $kategori !== 'Semua Dokter') {
            $query->where('spesialisasi', $kategori);
        }

        // 4. Logika SEARCH (Nama / Spesialisasi)
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('spesialisasi', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function($userQuery) use ($keyword) {
                      $userQuery->where('nama', 'like', "%{$keyword}%");
                  });
            });
        }

        // 5. Ambil Data
        $dokters = $query->paginate(9);

        // 6. Kirim ke View (sertakan $kategori agar tombol bisa berubah warna)
        return view('pasien.cari_dokter', compact('dokters', 'keyword', 'kategori'));
    }
}