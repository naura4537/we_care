<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksiMasuk = $this->getTransaksiMasuk();
        $transaksiKeluar = $this->getTransaksiKeluar();
        $saldo = $this->getTotalSaldo();
        
        return view('admin.transaksi.index', [
            'transaksiMasuk' => $transaksiMasuk,
            'transaksiKeluar' => $transaksiKeluar,
            'totalMasuk' => $saldo['total_masuk'],
            'totalKeluar' => $saldo['total_keluar'],
            'totalSaldo' => $saldo['saldo']
        ]);
    }
    
    /**
     * Tambah transaksi pengeluaran (Kode lama dipertahankan)
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'bank_tujuan' => 'required|string'
        ]);
        
        try {
            DB::table('transaksis')->insert([
                'jenis' => 'keluar',
                'keterangan' => $request->keterangan,
                'nominal' => $request->nominal,
                'tanggal' => $request->tanggal,
                'bank_tujuan' => $request->bank_tujuan,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return redirect()->route('admin.transaksi')
                ->with('success', "✅ Transaksi berhasil ditambahkan ke {$request->bank_tujuan}");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.transaksi')
                ->with('error', '❌ Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Update transaksi (Kode lama dipertahankan)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'bank_tujuan' => 'required|string'
        ]);
        
        try {
            DB::table('transaksis')
                ->where('id', $id)
                ->update([
                    'keterangan' => $request->keterangan,
                    'nominal' => $request->nominal,
                    'tanggal' => $request->tanggal,
                    'bank_tujuan' => $request->bank_tujuan,
                    'updated_at' => now()
                ]);
            
            return redirect()->route('admin.transaksi')
                ->with('success', '✅ Transaksi berhasil diupdate');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.transaksi')
                ->with('error', '❌ Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Hapus transaksi (Kode lama dipertahankan)
     */
    public function destroy($id)
    {
        try {
            DB::table('transaksis')
                ->where('id', $id)
                ->delete();
            
            return redirect()->route('admin.transaksi')
                ->with('success', '✅ Transaksi berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.transaksi')
                ->with('error', '❌ Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Get transaksi masuk (dari pembayaran) - FIX
     */
    private function getTransaksiMasuk()
    {
        return DB::table('pembayarans as p')
            // FIX 1: Join ke tabel Pemesanan menggunakan FK yang benar (pemesanan_id)
            ->join('pemesanans as pem', 'p.id_pemesanan', '=', 'pem.id') 
            // FIX 2: Join ke tabel Users untuk mendapatkan nama pasien
            ->join('users as u', 'pem.user_id', '=', 'u.id') 
            ->select(
                // FIX 3: Ambil tanggal dari Pemesanan
                DB::raw('DATE(pem.waktu_janji) as tanggal'),
                // FIX 4: Keterangan menggunakan nama Pasien (dari tabel users)
                DB::raw("CONCAT('Pembayaran konsultasi dari ', u.nama) as keterangan"),
                'p.nominal'
            )
            // FIX 5: Urutkan berdasarkan waktu_janji
            ->orderBy('pem.waktu_janji', 'DESC') 
            ->get();

    }
    
    /**
     * Get transaksi keluar (Kode lama dipertahankan)
     */
    private function getTransaksiKeluar()
    {
        return DB::table('transaksis')
            ->select('id', 'tanggal', 'keterangan', 'nominal', 'bank_tujuan')
            ->where('jenis', 'keluar')
            ->whereNotNull('tanggal') 
            ->orderBy('tanggal', 'DESC')
            ->get();
    }
    
    /**
     * Get total saldo (Kode lama dipertahankan)
     */
    private function getTotalSaldo()
    {
        // Total pemasukan dari pembayaran
        $totalMasuk = DB::table('pembayarans')->sum('nominal') ?? 0;
        
        // Total pengeluaran dari transaksi
        $totalKeluar = DB::table('transaksis')
            ->where('jenis', 'keluar')
            ->sum('nominal') ?? 0;
        
        return [
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo' => $totalMasuk - $totalKeluar
        ];
    }
}