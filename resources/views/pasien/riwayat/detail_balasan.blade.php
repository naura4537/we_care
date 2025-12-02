@extends('layouts.pasien')

@section('title', 'Detail Balasan Konsultasi')

{{-- Tambahkan style kustom untuk tampilan bersih, jika Bootstrap kustom Anda tidak menimpa warna hijau --}}
@section('styles')
<style>
    /* Menghapus atau menimpa background hijau muda yang mungkin datang dari layout utama */
    body {
        background-color: #f8f9fa !important; /* Warna putih atau abu-abu muda */
    }
    .diagnosa-box {
        border-left: 5px solid #198754 !important; /* Hijau Sukses */
        background-color: #f6fff9 !important;
    }
    .resep-box {
        border-left: 5px solid #dc3545 !important; /* Merah Bahaya */
        background-color: #fff6f8 !important;
    }
    /* Pastikan .pasien-info menggunakan border warna yang sesuai */
    .pasien-info {
        border-left: 5px solid #0dcaf0 !important; /* Biru Info */
        background-color: #e9f9ff !important;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <h2 class="mb-4 text-primary fw-bold border-bottom pb-2">
                <i class="fas fa-comment-dots me-2"></i> Detail Balasan Konsultasi #{{ $pemesanan->id }}
            </h2>

            {{-- INFORMASI DASAR PASIEN & DOKTER --}}
            <div class="card shadow-sm mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pemesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-user-injured me-2"></i> Pasien:</strong> 
                            {{ $pemesanan->pasien->user->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-user-md me-2"></i> Dokter:</strong> 
                            Dr. {{ $pemesanan->balasanUser->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="far fa-clock me-2"></i> Waktu Janji:</strong> 
                            {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->format('d F Y, H:i') }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-tag me-2"></i> Status:</strong> 
                            <span class="badge bg-success">{{ $pemesanan->status ?? 'Selesai' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KELUHAN PASIEN --}}
            <div class="p-3 border rounded mb-4 pasien-info">
                <h5 class="text-info fw-bold"><i class="fas fa-notes-medical me-2"></i> Keluhan Utama:</h5>
                <p class="mb-0" style="white-space: pre-wrap;">{{ $pemesanan->keluhan_pasien }}</p>
            </div>
            
            <h4 class="mt-5 mb-3 text-success border-bottom pb-2">Hasil Balasan Dokter</h4>
            
            <div class="row">
                
                {{-- Kolom 1: Diagnosa Medis --}}
                <div class="col-md-6 mb-4">
                    <div class="p-3 border rounded h-100 shadow-sm diagnosa-box">
                        <h6 class="text-success fw-bold">🩺 Diagnosa Medis:</h6>
                        <hr class="my-2">
                        @if ($pemesanan->diagnosa)
                            <p style="white-space: pre-wrap; margin-bottom: 0;">{{ $pemesanan->diagnosa }}</p>
                        @else
                            <p class="text-muted fst-italic">Diagnosa Belum Ditambahkan.</p>
                        @endif
                    </div>
                </div>

                {{-- Kolom 2: Resep Dokter --}}
                <div class="col-md-6 mb-4">
                    <div class="p-3 border rounded h-100 shadow-sm resep-box">
                        <h6 class="text-danger fw-bold">💊 Resep Obat dan Tindakan:</h6>
                        <hr class="my-2">
                        @if ($pemesanan->resep)
                            <p style="white-space: pre-wrap; margin-bottom: 0;">{{ $pemesanan->resep }}</p>
                        @else
                            <p class="text-muted fst-italic">Resep Obat/Tindakan Belum Ditambahkan.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- DETAIL TRANSAKSI (Opsional, jika ingin ditampilkan) --}}
            <h4 class="mt-4 mb-3 text-warning border-bottom pb-2">Detail Transaksi</h4>
            <ul class="list-group list-group-flush shadow-sm mb-5">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Nominal Biaya
                    <span class="fw-bold text-dark">Rp{{ number_format($pemesanan->nominal ?? 0, 0, ',', '.') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Metode Pembayaran
                    <span class="badge bg-primary rounded-pill">{{ $pemesanan->metode_pembayaran ?? 'N/A' }}</span>
                </li>
            </ul>

            {{-- TOMBOL AKSI --}}
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('pasien.riwayat') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
                {{-- TOMBOL AKSI di pasien/balasan.blade.php --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('pasien.riwayat') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
                    </a>
                    
                    {{-- Tombol Unduh PDF --}}
                    @if ($pemesanan->diagnosa || $pemesanan->resep)
                    <a href="{{ route('pasien.balasan.download', $pemesanan->id) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-1"></i> Unduh Riwayat PDF
                    </a>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection