<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    /**
     * Tampilkan halaman komentar
     */
    public function index(Request $request)
    {
        // Ambil filter dari GET atau default ke 'pasien'
        $filter = $request->input('filter', 'pasien');
        
        // Validasi filter
        if (!in_array($filter, ['pasien', 'dokter'])) {
            $filter = 'pasien';
        }
        
        // Ambil data komentar berdasarkan filter
        if ($filter === 'pasien') {
            $komentarList = $this->getKomentarPasien();
        } else {
            // PENTING: Panggil method baru kita
            $komentarList = $this->getKomentarDokter(); 
        }
        
        // Hitung total komentar per kategori
        $totalPasien = $this->countKomentarPasien();
        $totalDokter = $this->countKomentarDokter();
        
        return view('admin.komentar.index', compact(
            'komentarList',
            'filter',
            'totalPasien',
            'totalDokter'
        ));
    }
    
    /**
     * Get detail komentar (AJAX API) - (Kode lama dipertahankan)
     */
    public function detail($id)
    {
        $komentar = $this->getKomentarById($id);
        
        if ($komentar) {
            $komentar['balasan'] = $this->getBalasanByKomentarId($id);
            
            return response()->json([
                'success' => true,
                'komentar' => $komentar,
                'balasan' => $komentar['balasan']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'error' => 'Komentar not found'
        ], 404);
    }
    
    /**
     * Hapus komentar - (Kode lama dipertahankan)
     */
    public function delete(Request $request, $id)
    {
        $result = $this->deleteKomentar($id);
        
        if ($result) {
            return redirect()
                ->route('admin.komentar', ['filter' => $request->input('filter', 'pasien')])
                ->with('success', 'Komentar berhasil dihapus');
        }
        
        return redirect()
            ->route('admin.komentar', ['filter' => $request->input('filter', 'pasien')])
            ->with('error', 'Gagal menghapus komentar');
    }
    
    /**
     * Tambah balasan komentar - (Kode lama dipertahankan)
     */
    public function addBalasan(Request $request)
    {
        $request->validate([
            'id_komentar' => 'required|integer',
            'balasan' => 'required|string'
        ]);
        
        $id_komentar = $request->input('id_komentar');
        $balasan = trim($request->input('balasan'));
        $id_admin = Auth::id();
        
        $result = $this->tambahBalasan($id_komentar, $id_admin, $balasan);
        
        if ($result) {
            return redirect()
                ->route('admin.komentar', ['filter' => $request->input('filter', 'pasien')])
                ->with('success', 'Balasan berhasil ditambahkan');
        }
        
        return redirect()
            ->route('admin.komentar', ['filter' => $request->input('filter', 'pasien')])
            ->with('error', 'Gagal menambahkan balasan');
    }
    
    // ==========================================
    // PRIVATE METHODS (Database Queries)
    // ==========================================
    
    /**
     * Get komentar dari pasien (Pasien -> Dokter)
     */
    private function getKomentarPasien()
    {
        // Query lama dipertahankan (komentars)
        return DB::table('komentars as k')
            ->join('pasiens as p', 'k.id_pasien', '=', 'p.id')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->join('dokters as d', 'k.id_dokter', '=', 'd.id')
            ->join('users as ud', 'd.user_id', '=', 'ud.id')
            ->select(
                'k.id',
                'k.komentar',
                'k.rating',
                'k.created_at',
                'u.nama as nama_pasien',
                'p.id_pasien',
                'ud.nama as nama_dokter',
                'd.id_dokter'
            )
            ->orderBy('k.created_at', 'DESC')
            ->get();
    }
    
    /**
     * Get komentar dari dokter (Dokter -> Pasien)
     * PENTING: Menggunakan tabel dokter_ulasans
     */
   private function getKomentarDokter()
    {
        return DB::table('dokter_ulasans as du')
            // Join ke users (pasien) untuk nama pasien
            ->join('users as up', 'du.user_id_pasien', '=', 'up.id') 
            // Join ke dokters
            ->join('dokters as d', 'du.dokter_id', '=', 'd.id')
            // Join ke users (dokter) untuk nama dokter
            ->join('users as ud', 'd.user_id', '=', 'ud.id') 
            ->select(
                'du.id',
                'du.komentar',
                'du.rating',
                'du.created_at',
                'up.nama as nama_pasien', // Pasien yang diulas
                'ud.nama as nama_dokter',  // Dokter yang mengulas
                
                // FIX 1: ID Pasien (agar konsisten)
                'du.user_id_pasien as id_pasien', 
                
                // FIX 2: MENAMBAHKAN ID DOKTER
                'du.dokter_id AS id_dokter' 
            )
            ->orderBy('du.created_at', 'DESC')
            ->get();
    }
    /**
     * Count komentar pasien
     */
    private function countKomentarPasien()
    {
        return DB::table('komentars')->count();
    }
    
    /**
     * Count komentar dokter
     * PENTING: Menggunakan tabel dokter_ulasans
     */
    private function countKomentarDokter()
    {
        return DB::table('dokter_ulasans')->count();
    }
    
    /**
     * Get komentar by ID - (Kode lama dipertahankan)
     */
    private function getKomentarById($id)
    {
        $komentar = DB::table('komentars as k')
            ->join('pasiens as p', 'k.id_pasien', '=', 'p.id')
            ->join('users as u', 'p.user_id', '=', 'u.id')
            ->join('dokters as d', 'k.id_dokter', '=', 'd.id')
            ->join('users as ud', 'd.user_id', '=', 'ud.id')
            ->select(
                'k.id',
                'k.komentar',
                'k.rating',
                'k.created_at',
                'u.nama as nama_pasien',
                'p.id_pasien',
                'ud.nama as nama_dokter',
                'd.id_dokter'
            )
            ->where('k.id', $id)
            ->first();
        
        return $komentar ? (array)$komentar : null;
    }
    
    /**
     * Get balasan by komentar ID - (Kode lama dipertahankan)
     */
    private function getBalasanByKomentarId($id_komentar)
    {
        return DB::table('komentar_balasans as kb')
            ->join('users as u', 'kb.id_admin', '=', 'u.id')
            ->select(
                'kb.id',
                'kb.balasan',
                'kb.created_at',
                'u.nama as nama_admin'
            )
            ->where('kb.id_komentar', $id_komentar)
            ->orderBy('kb.created_at', 'ASC')
            ->get()
            ->toArray();
    }
    
    /**
     * Delete komentar - (Kode lama dipertahankan)
     */
    private function deleteKomentar($id)
    {
        try {
            DB::table('komentar_balasans')->where('id_komentar', $id)->delete();
            
            $result = DB::table('komentars')->where('id', $id)->delete();
            
            return $result > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Tambah balasan - (Kode lama dipertahankan)
     */
    private function tambahBalasan($id_komentar, $id_admin, $balasan)
    {
        try {
            $result = DB::table('komentar_balasans')->insert([
                'id_komentar' => $id_komentar,
                'id_admin' => $id_admin,
                'balasan' => $balasan,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }
}