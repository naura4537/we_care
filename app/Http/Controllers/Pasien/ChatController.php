<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Logika untuk memulai chat/pemesanan konsultasi.
     * Ini harus mencakup validasi pembayaran atau pembuatan sesi.
     */
    public function index($doctor_id)
    {
        // Cari data dokter
        $dokter = Dokter::with('user')->findOrFail($doctor_id);
        $user = Auth::user();

        // --- Logika Pemesanan Konsultasi / Pembayaran ---
        
        // Contoh Sederhana:
        // 1. Cek Saldo/Status Pembayaran (Implementasi nyata memerlukan model Transaksi/Pembayaran)
        // if (!$user->hasSufficientBalance() || !Pembayaran::isPaidForSession($user->id, $doctor_id)) {
        //     return redirect()->route('pasien.pembayaran.index', ['dokter_id' => $doctor_id])
        //                      ->with('error', 'Anda harus membayar biaya konsultasi terlebih dahulu.');
        // }

        // 2. Jika sudah lolos validasi, arahkan ke tampilan chat
        // (Anda harus membuat view ini)
        return view('pasien.chat.index', [
            'dokter' => $dokter,
            'message' => 'Selamat datang di sesi konsultasi. Biaya sudah terbayar.'
        ]);
        
        // Jika Anda ingin langsung redirect ke halaman pembayaran:
        // return redirect()->route('pasien.pembayaran.create', $doctor_id); 
    }
}