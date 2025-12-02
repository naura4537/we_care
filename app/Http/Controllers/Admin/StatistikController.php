<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    /**
     * Tampilkan halaman statistik
     */
    public function index(Request $request)
    {
        // Ambil tanggal dari GET atau gunakan minggu ini
        $mingguIni = $this->getMingguIni();
        
        $startDate = $request->input('start_date', $mingguIni['start']);
        $endDate = $request->input('end_date', $mingguIni['end']);
        
        // Ambil data kunjungan per hari
        $kunjunganPerHari = $this->getDetailKunjunganHarian($startDate, $endDate);
        
        // Ambil total kunjungan
        $totalKunjungan = $this->getTotalKunjungan($startDate, $endDate);
        
        // Format tanggal untuk display
        $startDateDisplay = Carbon::parse($startDate)->locale('id')->translatedFormat('d F Y');
        $endDateDisplay = Carbon::parse($endDate)->locale('id')->translatedFormat('d F Y');
        
        // Return view
        return view('admin.statistik.index', compact(
            'kunjunganPerHari',
            'totalKunjungan',
            'startDate',
            'endDate',
            'startDateDisplay',
            'endDateDisplay'
        ));
    }
    
    /**
     * API Endpoint untuk AJAX Real-time Update
     */
    public function getData(Request $request)
    {
        // Ambil parameter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Validasi parameter
        if (!$startDate || !$endDate) {
            $mingguIni = $this->getMingguIni();
            $startDate = $mingguIni['start'];
            $endDate = $mingguIni['end'];
        }
        
        // Ambil data
        $kunjunganPerHari = $this->getDetailKunjunganHarian($startDate, $endDate);
        $totalKunjungan = $this->getTotalKunjungan($startDate, $endDate);
        
        // Return JSON
        return response()->json([
            'success' => true,
            'data' => [
                'kunjunganPerHari' => $kunjunganPerHari,
                'totalKunjungan' => $totalKunjungan,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
    
    /**
     * Get minggu ini (Senin - Minggu)
     */
    private function getMingguIni()
    {
        $now = Carbon::now();
        
        $start = $now->copy()->startOfWeek(Carbon::MONDAY);
        $end = $now->copy()->endOfWeek(Carbon::SUNDAY);
        
        return [
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d')
        ];
    }
    
    // ==========================================================
    // LOGIC PERBAIKAN: MENARGETKAN TABEL 'pemesanans' DAN STATUS 'Selesai'
    // ==========================================================
    
    /**
     * Get detail kunjungan harian
     * Mengembalikan array dengan hari sebagai key
     */
    private function getDetailKunjunganHarian($startDate, $endDate)
    {
        // Query kunjungan per hari dari tabel pemesanans (hanya yang sudah Selesai)
        $results = DB::table('pemesanans')
            ->selectRaw('DATE(waktu_janji) as tanggal, COUNT(*) as jumlah')
            ->where('status', 'Selesai') // Filter 1: Harus selesai
            ->whereNotNull('diagnosa')     // Filter 2: Harus ada hasil diagnosa
            ->whereBetween(DB::raw('DATE(waktu_janji)'), [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(waktu_janji)'))
            ->orderBy('tanggal', 'ASC')
            ->get();
        
        // Buat array kosong untuk semua hari dalam range
        $kunjungan = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Inisialisasi semua hari dengan 0
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $hari = $date->locale('id')->translatedFormat('l'); // Nama hari dalam bahasa Indonesia
            $kunjungan[$hari] = 0;
        }
        
        // Isi data dari database
        foreach ($results as $row) {
            $tanggal = Carbon::parse($row->tanggal);
            $hari = $tanggal->locale('id')->translatedFormat('l');
            $kunjungan[$hari] = (int)$row->jumlah;
        }
        
        return $kunjungan;
    }
    
    /**
     * Get total kunjungan dalam periode
     */
    private function getTotalKunjungan($startDate, $endDate)
    {
        // Query total dari tabel pemesanans (hanya yang sudah Selesai)
        $total = DB::table('pemesanans')
            ->where('status', 'Selesai') // Filter 1
            ->whereNotNull('diagnosa')     // Filter 2
            ->whereBetween(DB::raw('DATE(waktu_janji)'), [$startDate, $endDate])
            ->count();
        
        return $total;
    }
}