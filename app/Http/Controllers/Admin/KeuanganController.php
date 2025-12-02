<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    /**
     * Tampilkan halaman laporan keuangan
     */
    public function index(Request $request)
    {
        // Ambil bulan dari parameter GET atau gunakan bulan saat ini
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y')); // Bisa pilih tahun juga sekarang!
        
        // Ambil data dari database menggunakan Query Builder
        $dataLaporan = $this->getLaporanGabungan($bulan, $tahun);
        $totalPemasukan = $this->getTotalPemasukan($bulan, $tahun);
        $totalPengeluaran = $this->getTotalPengeluaran($bulan, $tahun);
        
        // DEBUG: Log data untuk cek
        \Log::info('Data Laporan:', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'jumlah_data' => count($dataLaporan)
        ]);
        
        // Nama bulan dalam Bahasa Indonesia
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        // Return view dengan data
        return view('admin.keuangan.index', compact(
            'bulan',
            'tahun',
            'dataLaporan',
            'totalPemasukan',
            'totalPengeluaran',
            'namaBulan'
        ));
    }
    
    /**
     * Get laporan pemasukan dari pembayaran pasien
     * Berdasarkan bulan dan tahun
     */
private function getLaporanPemasukan($bulan, $tahun)
{
    $results = DB::table('pembayarans as p')
        // Ganti join ke jadwal_konsultasis dengan join langsung ke pemesanans
        ->leftJoin('pemesanans as pm', 'p.id_pemesanan', '=', 'pm.id')
        
        ->selectRaw('
            DATE(pm.waktu_janji) as tanggal,
            p.nominal
        ') // Hapus komentar PHP di sini
        ->whereMonth('pm.waktu_janji', $bulan)
        ->whereYear('pm.waktu_janji', $tahun)
        ->orderBy('pm.waktu_janji', 'ASC')
        ->get();

    return $results;
}
    /**
     * Get laporan pengeluaran dari transaksi
     * Berdasarkan bulan dan tahun
     */
    private function getLaporanPengeluaran($bulan, $tahun)
    {
$results = DB::table('transaksis as t')
    ->selectRaw('DATE(t.tanggal) as tanggal, t.keterangan, t.nominal')
    ->where('t.jenis', 'keluar')
    ->whereNotNull('t.tanggal')
    ->whereMonth('t.tanggal', $bulan)
    ->whereYear('t.tanggal', $tahun)
    ->orderBy('t.tanggal', 'ASC')
    ->get();

        
        return $results;
    }
    
    /**
     * Get total pemasukan dari pembayaran
     */
  private function getTotalPemasukan($bulan, $tahun)
{
    $result = DB::table('pembayarans as p')
        // Join ke pemesanans
        ->join('pemesanans as pm', 'p.id_pemesanan', '=', 'pm.id')
        
        // Filter berdasarkan waktu_janji di pemesanans
        ->whereMonth('pm.waktu_janji', $bulan)
        ->whereYear('pm.waktu_janji', $tahun)
        ->sum('p.nominal');
    
    return $result ?? 0;
}
    
    /**
     * Get total pengeluaran dari transaksi
     */
    private function getTotalPengeluaran($bulan, $tahun)
    {
        $result = DB::table('transaksis')
            ->where('jenis', 'keluar')
            ->whereNotNull('tanggal')  // Filter NULL tanggal
            ->whereMonth('tanggal', $bulan)  // PAKAI KOLOM tanggal
            ->whereYear('tanggal', $tahun)   // PAKAI KOLOM tanggal
            ->sum('nominal');
        
        return $result ?? 0;
    }
    
    /**
     * Gabungkan data pemasukan dan pengeluaran untuk tabel
     */
    private function getLaporanGabungan($bulan, $tahun)
{
    $pemasukan = $this->getLaporanPemasukan($bulan, $tahun);
    $pengeluaran = $this->getLaporanPengeluaran($bulan, $tahun);
    
    // Gabungkan array
    $gabungan = [];
    
    foreach ($pemasukan as $item) {
        if (!isset($item->tanggal) || empty($item->tanggal)) {
            continue;
        }
        
        $gabungan[] = [
            'tanggal' => $item->tanggal,
            'keterangan' => 'Pemasukan dari Pembayaran Pemesanan', // <-- BERI KETERANGAN DEFAULT
            'pemasukan' => $item->nominal ?? 0,
            'pengeluaran' => 0
        ];
    }
        
        foreach ($pengeluaran as $item) {
            // Skip jika tanggal NULL
            if (!isset($item->tanggal) || empty($item->tanggal)) {
                continue;
            }
            
            $gabungan[] = [
                'tanggal' => $item->tanggal,
                'keterangan' => $item->keterangan ?? 'N/A',
                'pemasukan' => 0,
                'pengeluaran' => $item->nominal ?? 0
            ];
        }
        
        // DEBUG: Log jumlah data
        \Log::info('Gabungan Data:', [
            'pemasukan_count' => count($pemasukan),
            'pengeluaran_count' => count($pengeluaran),
            'total_gabungan' => count($gabungan)
        ]);
        
        // Urutkan berdasarkan tanggal
        usort($gabungan, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });
        
        return $gabungan;
    }
}