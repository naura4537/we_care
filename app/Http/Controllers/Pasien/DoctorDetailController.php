<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter; 
use Carbon\Carbon; // <-- PENTING: Class Carbon harus di-use

class DoctorDetailController extends Controller
{
    /**
     * Menampilkan halaman detail dokter dengan penjadwalan yang diformat.
     */
    public function detail($id = null)
    {
        // 1. Guard Clause: Jika ID tidak ada atau dokter tidak ditemukan
        $dokter = Dokter::with('user')->find($id);
        if (!$dokter) {
            // Jika dokter tidak ditemukan, redirect atau tampilkan halaman error yang sesuai
            return redirect()->route('pasien.cari_dokter')->with('error', 'Dokter tidak ditemukan.');
        }

        // 2. Persiapan Data Jadwal
        // Mengambil string jadwal dari kolom 'jadwal_praktik'
        $range_waktu = $dokter->jadwal_praktik ?? null; 
        $jadwal_tersedia = [];

        // Hapus strtolower($range_waktu) !== 'null' karena operator ?? null sudah mencakupnya
        if ($range_waktu) { 
            
            // Coba pisahkan range waktu (misal: "09.00-16.00")
            if (preg_match('/^(\d{2}\.\d{2})-(\d{2}\.\d{2})$/', $range_waktu, $matches)) {
                
                // Konversi string "HH.MM" ke objek Carbon untuk perhitungan akurat
                // Pastikan format di DB menggunakan titik (.) agar sesuai dengan 'H.i'
                $start_time = Carbon::createFromFormat('H.i', $matches[1]);
                $end_time = Carbon::createFromFormat('H.i', $matches[2]);
                
                $interval = 30; // Slot 30 menit

                while ($start_time->lt($end_time)) {
                    // Simpan jam dalam format "HH.MM"
                    $jadwal_tersedia[] = $start_time->format('H.i'); 
                    $start_time->addMinutes($interval);
                }
            } elseif (preg_match('/^\d{2}\.\d{2}$/', $range_waktu)) { 
                // Jika formatnya hanya satu jam ("14.00")
                $jadwal_tersedia[] = $range_waktu;
            }
        }
        
        // Bersihkan dan Urutkan slot jam
        $jadwal_tersedia = array_unique($jadwal_tersedia); 
        sort($jadwal_tersedia); 

        // 3. Kirim ke View
        return view('pasien.dokter_detail', [
            'dokter' => $dokter,
            // Variabel $hari_praktik dan $hari_aktif dihapus
            'jadwal_tersedia' => $jadwal_tersedia, 
        ]);
    }
}