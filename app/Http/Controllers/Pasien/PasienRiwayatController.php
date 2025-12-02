<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan; // Asumsi Anda menggunakan model Pemesanan
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class PasienRiwayatController extends Controller
{
    // 1. Menampilkan daftar riwayat (sudah ada)
    public function index()
    {
        $riwayats = Pemesanan::where('user_id', auth()->id())->latest()->get();
        return view('pasien.riwayat.index', compact('riwayats'));
    }

    // 2. Menampilkan form Edit
    public function edit(Pemesanan $pemesanan)
    {
        // Pastikan pasien yang login berhak mengedit pemesanan ini
        if ($pemesanan->user_id !== auth()->id()) {
            return redirect()->route('pasien.riwayat.index')->with('error', 'Anda tidak memiliki akses.');
        }

        // Contoh batasan: Hanya bisa mengedit jika status masih Menunggu Pembayaran
        if ($pemesanan->status != 'Menunggu Pembayaran') {
             return redirect()->route('pasien.riwayat.index')->with('error', 'Pemesanan tidak dapat diubah saat status sudah diproses.');
        }

        return view('pasien.riwayat.edit', compact('pemesanan'));
    }

    // 3. Menyimpan data yang diupdate
    public function update(Request $request, Pemesanan $pemesanan)
    {
        // Validasi input di sini (misalnya validasi waktu_janji baru)
        // $request->validate([...]);

        // ... update logika Pemesanan ...
        $pemesanan->update([
            // 'waktu_janji' => $request->waktu_janji,
            // 'keluhan_pasien' => $request->keluhan_pasien,
            // ...
        ]);

        return redirect()->route('pasien.riwayat.index')->with('success', 'Pemesanan berhasil diperbarui.');
    }

    // 4. Menghapus data
    public function destroy(Pemesanan $pemesanan)
    {
        // Pastikan pasien yang login berhak menghapus pemesanan ini
        if ($pemesanan->user_id !== auth()->id()) {
            return redirect()->route('pasien.riwayat.index')->with('error', 'Anda tidak memiliki akses.');
        }
        
        // Hapus Pemesanan
        $pemesanan->delete();

        return redirect()->route('pasien.riwayat.index')->with('success', 'Pemesanan berhasil dihapus.');
    }

    public function showBalasan($pemesanan_id)
    {
        // Gunakan Route Model Binding di sini jika Anda bisa.
        // Jika tidak, kode ini sudah benar untuk mengambil data dengan ID
        $pemesanan = Pemesanan::where('id', $pemesanan_id)
                             //->where('user_id', Auth::id())
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
    // Cek kepemilikan
    if ($pemesanan->user_id !== Auth::id()) { 
        abort(403, 'Akses Ditolak.');
    }

    // FIX 1: Definisikan variabel $tanggal
    $tanggalCetak = Carbon::now()->isoFormat('D MMMM YYYY'); 
    
    // FIX 2: Perbaiki nama view PDF sesuai struktur folder: pasien/riwayat/balasan_pdf.blade.php
    $pdf = Pdf::loadView('pasien.riwayat.balasan_pdf', [ 
        'pemesanan' => $pemesanan,
        'tanggal' => $tanggalCetak, // <-- Kirim variabel $tanggal
    ]);
    
    $fileName = 'balasan_konsultasi_' . $pemesanan->id . '.pdf';

    return $pdf->download($fileName);
}
}