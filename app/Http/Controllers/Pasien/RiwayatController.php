<?php
/*
// app/Http/Controllers/Pasien/RiwayatController.php

use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
// ... (import lainnya)

class RiwayatController extends Controller
{
    // ... (fungsi index riwayat pasien)

    public function showBalasan($pemesanan_id)
    {
        // Gunakan Route Model Binding di sini jika Anda bisa.
        // Jika tidak, kode ini sudah benar untuk mengambil data dengan ID
        $pemesanan = Pemesanan::where('id', $pemesanan_id)
                             ->where('user_id', Auth::id())
                             ->firstOrFail();

        // Ganti logika pemecahan string, karena data sudah terpisah di DB:
        $diagnosa = $pemesanan->diagnosa;
        $resep = $pemesanan->resep;

        // Pastikan view Anda (detail_balasan) menerima variabel yang benar.
        // Berdasarkan screenshot Anda, view yang Anda gunakan adalah:
        // resources/views/pasien/riwayat/balasan.blade.php
        return view('pasien.riwayat.balasan', compact('pemesanan', 'diagnosa', 'resep')); 
        // Ganti 'detail_balasan' menjadi 'balasan' jika itu nama file view Anda.
    }

    public function downloadBalasan(Pemesanan $pemesanan)
    {
        // Pastikan pemesanan milik user yang sedang login
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        // Load view PDF yang akan Anda buat (misalnya: 'pdf.balasan')
        $pdf = Pdf::loadView('pasien.riwayat.pdf_balasan', compact('pemesanan'));

        // Nama file PDF
        $filename = 'Riwayat_Konsultasi_' . $pemesanan->id . '.pdf';

        return $pdf->download($filename);
    }
}
*/