@extends('layouts.pasien')

@section('title', 'Detail Balasan Konsultasi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <h2 class="mb-4 text-primary fw-bold border-bottom pb-2">
                <i class="fas fa-comment-dots me-2"></i> Detail Konsultasi #{{ $pemesanan->id }}
            </h2>

            {{-- INFORMASI PEMESANAN (KELUHAN DAN DOKTER) --}}
            <div class="card shadow-sm mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pemesanan & Keluhan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-user-md me-2"></i> Dokter:</strong> 
                            Dr. {{ $pemesanan->dokter->user->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="far fa-clock me-2"></i> Waktu Janji:</strong> 
                            {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->format('d F Y, H:i') }}
                        </div>
                        <div class="col-12">
                            <strong><i class="fas fa-notes-medical me-2"></i> Keluhan Anda:</strong>
                            <p class="alert alert-light border-start border-info border-4 p-2 mt-1">{{ $pemesanan->keluhan_pasien }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- HASIL DIAGNOSA DAN RESEP (KONTEN UTAMA) --}}
            <div class="card shadow-lg mb-5 border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-file-medical me-2"></i> Hasil Balasan Dokter</h4>
                </div>
                <div class="card-body p-4">

                    {{-- DIAGNOSA --}}
                    <div class="mb-4 p-3 border rounded" style="border-left: 5px solid #198754; background-color: #f6fff9;">
                        <h5 class="text-success fw-bold">🩺 Diagnosa Medis:</h5>
                        @if ($pemesanan->diagnosa)
                            <p style="white-space: pre-wrap; margin-bottom: 0;">{{ $pemesanan->diagnosa }}</p>
                        @else
                            <p class="text-muted fst-italic">Diagnosa Belum Ditambahkan.</p>
                        @endif
                    </div>
                    
                    {{-- RESEP --}}
                    <div class="p-3 border rounded" style="border-left: 5px solid #dc3545; background-color: #fff6f8;">
                        <h5 class="text-danger fw-bold">💊 Resep Obat dan Tindakan:</h5>
                        @if ($pemesanan->resep)
                            <p style="white-space: pre-wrap; margin-bottom: 0;">{{ $pemesanan->resep }}</p>
                        @else
                            <p class="text-muted fst-italic">Resep Obat/Tindakan Belum Ditambahkan.</p>
                        @endif
                    </div>

                </div>
            </div>

            {{-- DETAIL TRANSAKSI --}}
            <div class="card shadow-sm mb-4 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Detail Transaksi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Nominal Biaya
                            <span class="fw-bold">Rp{{ number_format($pemesanan->nominal ?? 0, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Metode Pembayaran
                            <span class="badge bg-primary">{{ $pemesanan->metode_pembayaran ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Status Konsultasi
                            <span class="badge bg-success">{{ $pemesanan->status ?? 'Selesai' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- TOMBOL AKSI (Bagian yang sudah dibenahi) --}}
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('pasien.riwayat') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
                
                {{-- Tombol Unduh PDF (hanya muncul jika ada diagnosa atau resep) --}}
                @if ($pemesanan->diagnosa || $pemesanan->resep)
                <a href="{{ route('pasien.balasan.download', $pemesanan->id) }}" class="btn btn-primary">Unduh PDF</a>
                @endif
            </div>
            
        </div>
    </div>
</div>
@endsection