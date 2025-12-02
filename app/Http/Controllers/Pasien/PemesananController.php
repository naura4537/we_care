<?php

namespace App\Http\Controllers\Pasien;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pembayaran; // <-- Pastikan baris ini ada
class PemesananController extends Controller
{
    /**
     * Menyimpan data pemesanan (Route POST).
     */
    public function buatPesanan(Request $request, Dokter $dokter)
    {
        // 1. Validasi
        $request->validate([
            'waktu_janji' => 'required|date_format:H:i:s', 
            'metode_pembayaran' => 'required|string',
            'keluhan_pasien' => 'required|string|max:1000',
        ]);

        // --- LOGIKA WAKTU & STATUS ---
        $jam_diminta = $request->waktu_janji; 
        $tanggal_janji = \Carbon\Carbon::today()->setTimeFromTimeString($jam_diminta); 
        
        if ($tanggal_janji->isPast()) {
            $tanggal_janji->addDay();
        }
        
        $waktu_janji_final = $tanggal_janji->toDateTimeString();
        $waktu_kedaluwarsa = \Carbon\Carbon::now()->addHours(2); 
        $nominal = $dokter->biaya;
        
        // Bypass untuk local
        $initialStatus = (app()->environment('local') || str_contains(request()->getHost(), '127.0.0.1')) ? 'Menunggu Balasan' : 'Menunggu Pembayaran';

        // 2. Simpan Pemesanan (dapatkan ID)
        $pemesanans = \App\Models\Pemesanan::create([
            'user_id' => Auth::id(),
            'dokter_id' => $dokter->id,
            'keluhan_pasien' => $request->keluhan_pasien, 
            'waktu_janji' => $waktu_janji_final, 
            'metode_pembayaran' => $request->metode_pembayaran,
            'nominal' => $nominal,
            'status' => $initialStatus,
            'expired_at' => $waktu_kedaluwarsa,
        ]);
        
        // 3. BUAT RECORD TRANSAKSI/PEMBAYARAN
        // Logic JadwalKonsultasi::create() DIHAPUS TOTAL
        \App\Models\Pembayaran::create([
            'id_pemesanan' => $pemesanans->id, // FIX: Menggunakan ID Pemesanan yang baru
            'id_dokter' => $dokter->id, 
            'nominal' => $nominal,
            'metode' => $request->metode_pembayaran, 
        ]);

        // 4. Redirect
        return redirect()->route('pasien.riwayat')
            ->with('success', 'Pemesanan berhasil dibuat. Status saat ini adalah: ' . $initialStatus);
    }
    public function index()
{
    $id_pasien = Auth::id(); 
    
    // Ambil semua riwayat pemesanan untuk pasien yang login
    // Termasuk yang statusnya 'Menunggu Pembayaran'
    $riwayats = Pemesanan::with('dokter.user')
                         ->where('user_id', $id_pasien) // Sesuaikan dengan kolom Pasien ID di tabel Pemesanan
                         ->orderBy('created_at', 'desc')
                         ->get();

    // Arahkan ke view riwayat
    return view('pasien.riwayat.index', compact('riwayats'));
}
    /**
     * Menampilkan halaman instruksi pembayaran (Route GET).
     */
    public function showPembayaran(Pemesanan $pemesanan) 
    {
        // ... (Kode ini sudah benar) ...
        if ($pemesanan->user_id !== Auth::id()) {
            return redirect()->route('pasien.riwayat')->with('error', 'Akses ditolak.'); 
        }
        
        $instruksi = [
            'QRIS' => ['metode' => 'QRIS', 'akun' => 'PT WE CARE - Payment Gateway'],
            'Bank Lainnya' => ['metode' => 'Transfer Bank (BCA)', 'akun' => 'BCA VA: 898912345678'],
        ];
        
        $pemesanan->load('dokter.user'); 

        return view('pasien.pembayaran', [
            'pemesanan' => $pemesanan,
            'instruksi_detail' => $instruksi[$pemesanan->metode_pembayaran] ?? ['metode' => 'N/A', 'akun' => 'N/A'],
        ]);
    }
    // ===============================================
    //           START: METODE KONSULTASI BARU
    // ===============================================

    /**
     * Menampilkan antarmuka chat untuk konsultasi yang sudah dikonfirmasi.
     * Route yang terkait: pasien.konsultasi.chat
     */

    // // 2. Menampilkan form Edit
    // public function edit(Pemesanan $pemesanan)
    // {
    //     // Pastikan pasien yang login berhak mengedit pemesanan ini
    //     if ($pemesanan->user_id !== auth()->id()) {
    //         return redirect()->route('pasien.riwayat.index')->with('error', 'Anda tidak memiliki akses.');
    //     }

    //     // Contoh batasan: Hanya bisa mengedit jika status masih Menunggu Pembayaran
    //     if ($pemesanan->status != 'Menunggu Pembayaran') {
    //          return redirect()->route('pasien.riwayat.index')->with('error', 'Pemesanan tidak dapat diubah saat status sudah diproses.');
    //     }

    //     return view('pasien.riwayat.edit', compact('pemesanan'));
    // }

    // // 3. Menyimpan data yang diupdate
    // public function update(Request $request, Pemesanan $pemesanan)
    // {
    //     // Validasi input di sini (misalnya validasi waktu_janji baru)
    //     // $request->validate([...]);

    //     // ... update logika Pemesanan ...
    //     $pemesanan->update([
    //         // 'waktu_janji' => $request->waktu_janji,
    //         // 'keluhan_pasien' => $request->keluhan_pasien,
    //         // ...
    //     ]);

    //     return redirect()->route('pasien.riwayat.index')->with('success', 'Pemesanan berhasil diperbarui.');
    // }

    // // 4. Menghapus data
    // public function destroy(Pemesanan $pemesanan)
    // {
    //     // Pastikan pasien yang login berhak menghapus pemesanan ini
    //     if ($pemesanan->user_id !== auth()->id()) {
    //         return redirect()->route('pasien.riwayat.index')->with('error', 'Anda tidak memiliki akses.');
    //     }
        
    //     // Hapus Pemesanan
    //     $pemesanan->delete();

    //     return redirect()->route('pasien.riwayat.index')->with('success', 'Pemesanan berhasil dihapus.');
    // }

    public function showHasil(Pemesanan $pemesanan)
    {
        // 1. Otorisasi: Pastikan pasien yang login adalah pemilik pemesanan
        if ($pemesanan->user_id !== Auth::id()) {
            return redirect()->route('pasien.riwayat.index')->with('error', 'Akses ditolak.');
        }

        // 2. Cek Status: Hanya status SELESAI yang dapat melihat hasil
        if ($pemesanan->status !== 'SELESAI') {
            return redirect()->route('pasien.riwayat.index')->with('error', 'Hasil konsultasi belum tersedia. Status saat ini: ' . $pemesanan->status);
        }

        // 3. Load relasi (Jika Diagnosa/Resep adalah relasi di model Pemesanan)
        $pemesanan->load(['dokter.user', 'diagnosa', 'resep']); 

        return view('pasien.hasil.show', compact('pemesanan'));
    }

    /**
     * Metode untuk mengunduh file resep (PDF/document).
     * Route yang terkait: pasien.resep.download
     */
    public function downloadResep(Pemesanan $pemesanan)
    {
        // 1. Otorisasi & Cek Status
        if ($pemesanan->user_id !== Auth::id() || $pemesanan->status !== 'SELESAI') {
            return redirect()->route('pasien.riwayat.index')->with('error', 'Anda tidak diizinkan mengunduh resep ini.');
        }
        
        // 2. Dapatkan path ke file resep
        // Asumsi: path file resep tersimpan di kolom 'resep_path' di model Pemesanan
        $filePath = storage_path('app/public/' . $pemesanan->resep_path);

        if (empty($pemesanan->resep_path) || !file_exists($filePath)) {
            return redirect()->back()->with('error', 'File resep tidak ditemukan atau belum diunggah dokter.');
        }

        // 3. Lakukan proses download
        $fileName = 'Resep_Konsultasi_' . $pemesanan->id . '_' . date('Ymd') . '.pdf';

        return response()->download($filePath, $fileName);
    }
    
    // ===============================================
    //              END: METODE KONSULTASI BARU
    // ===============================================
    public function showBalasan(Pemesanan $pemesanan) 
    {
        // 1. Pastikan pemesanan ini milik Pasien yang sedang login
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        // 2. Pastikan pemesanan sudah dibalas (statusnya 'Lihat Balasan')
        if ($pemesanan->status !== 'Lihat Balasan') {
            // Bisa diarahkan kembali dengan pesan error
            return redirect()->route('pasien.riwayat')->with('error', 'Balasan Dokter belum tersedia.');
        }

        // 3. Ambil data balasan (resep) yang terkait
        // ASUMSI: Balasan/Resep disimpan di model terpisah (misal: Resep)
        // Jika data balasan dan resep ada langsung di model Pemesanan:
        
        $balasan = [
            'diagnosa' => $pemesanan->diagnosa, // Anda perlu menambahkan kolom ini ke tabel pemesanans
            'resep' => $pemesanan->resep,       // Anda perlu menambahkan kolom ini ke tabel pemesanans
            'keluhan_pasien' => $pemesanan->keluhan_pasien
        ];
        
        return view('pasien.riwayat.balasan', compact('pemesanan', 'balasan'));
    }

    public function downloadBalasan(Pemesanan $pemesanan)
    {
        // 1. Otorisasi: Pastikan Pasien yang login adalah pemilik Pemesanan ini
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak. Anda tidak berhak mengunduh riwayat ini.');
        }

        // 2. Memastikan relasi Dokter dan User di-load
        $pemesanan->load('dokter.user', 'pasien.user');

        // 3. Mengambil data untuk PDF
        $data = [
            'pemesanan' => $pemesanan,
            'tanggal_cetak' => now()->format('d F Y H:i:s'),
        ];
        
        // 4. Memuat view untuk PDF
        // Kita akan membuat view baru: 'pasien.balasan_pdf'
        $pdf = PDF::loadView('pasien.balasan_pdf', $data);

        // 5. Mengunduh file
        $nama_file = 'Riwayat_Konsultasi_' . $pemesanan->id . '_' . now()->format('Ymd') . '.pdf';
        
        return $pdf->download($nama_file);
    }

    public function show($id)
{
    // HAPUS 'resep' dan 'diagnosa' dari sini
    $pemesanan = Pemesanan::with('dokter') 
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

    return view('pasien.riwayat.show', compact('pemesanan'));
}

// LAKUKAN HAL SAMA UNTUK method cetakPdf() DI BAWAHNYA
public function cetakPdf($id)
{
    $pemesanan = Pemesanan::with(['dokter'])
                ->where('id', $id)
                ->where('user_id', auth()->id()) // <--- GUNAKAN 'user_id'
                ->firstOrFail();

    $pdf = Pdf::loadView('pasien.riwayat.pdf_template', compact('pemesanan'));
    
    // Download file dengan nama khusus
    return $pdf->download('laporan-medis-'.$pemesanan->id.'.pdf');
}
}