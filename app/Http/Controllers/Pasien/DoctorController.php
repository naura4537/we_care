<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🛑 WAJIB DITAMBAHKAN
use App\Models\JadwalKonsultasi;

class DoctorController extends Controller
{
    // Ini adalah tempat yang benar untuk menerapkan middleware
    public function __construct()
    {
        // KAMI HAPUS 'parent::__construct();' KARENA MENYEBABKAN ERROR
        // Cukup panggil middleware, ini akan berjalan dengan benar
        $this->middleware('auth'); 
    }

    public function index(Request $request)
    {
        // 1. Ambil semua spesialisasi unik untuk filter tabs (Kolom: 'spesialisasi')
        $specialties = Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');

        $query = Dokter::query();

        // 2. Terapkan Filter Spesialisasi
        if ($request->has('specialty') && $request->specialty != '') {
            $query->where('spesialisasi', $request->specialty);
        }

        // 3. Terapkan Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('spesialisasi', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function ($r) use ($searchTerm) {
                      $r->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // 4. Gunakan pagination untuk menghindari error timeout
        $doctors = $query->orderBy('spesialisasi')->paginate(15); 

        // 5. Kirim data ke view
        return view('pasien.doctor_search', compact('doctors', 'specialties'));
    }

        public function jadwal()
    {
        // 1. Ambil ID User yang sedang login
        $user_id = Auth::id();
        
        // 2. Cari ID Dokter yang terkait dengan User ini
        // Asumsi: Model Dokter memiliki relasi hasOne(User)
        $dokter = Auth::user()->dokters; // Menggunakan relasi dokters() di Model User

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data Dokter tidak ditemukan.');
        }

        $id_dokter = $dokter->id_dokter; // Ambil kolom 'id_dokter' dari tabel dokters

        // 3. Ambil semua Jadwal Konsultasi untuk dokter ini
        $jadwal_konsultasi = JadwalKonsultasi::with('pasien.user') // Load relasi Pasien dan User-nya
                                            ->where('id_dokter', $id_dokter) // Gunakan kolom id_dokter di tabel jadwal_konsultasi
                                            ->orderBy('jadwal', 'asc')
                                            ->get();

        // 4. Kirim data ke View
        return view('dokter.jadwal.index', compact('jadwal_konsultasi'));
    }
}