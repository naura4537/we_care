@extends('layouts.pasien')

@section('content')
{{-- Kontainer Utama --}}
<div class="max-w-4xl mx-auto p-6 lg:p-10">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('pasien.cari_dokter') }}" class="text-teal-600 hover:text-teal-800 font-semibold mb-6 inline-flex items-center">
        <i class="fas fa-chevron-left mr-2 text-sm"></i> Kembali
    </a>

    {{-- CARD UTAMA --}}
    <div class="card-utama">
        
        {{-- JUDUL HALAMAN BARU --}}
        <h1 class="judul-halaman">Buat Pesanan Konsultasi</h1>
        <hr class="divider-line">
        
        {{-- Bagian 1: Profil Dokter & Riwayat --}}
        <div class="detail-dokter">
            
            {{-- DETAIL DOKTER/TEKS --}}
            <div class="detail-header">
                <div>
                    {{-- NAMA DOKTER --}}
                    <h2 class="nama-dokter">{{ $dokter->user->nama ?? 'Dr. Incognito' }}</h2>
                    {{-- SPESIALISASI --}}
                    <p class="spesialisasi">{{ $dokter->spesialisasi }}</p>
                </div>
                
                {{-- Riwayat Pendidikan --}}
                <div class="detail-box">
                    <h3 class="detail-title">Riwayat Pendidikan</h3>
                    <p class="detail-content">{{ $dokter->riwayat_pendidikan ?? 'Riwayat pendidikan belum tersedia.' }}</p>
                </div>
                
                {{-- No STR --}}
                <div class="detail-box">
                    <h3 class="detail-title">No STR</h3>
                    <p class="detail-content">{{ $dokter->no_str ?? 'Belum Terdaftar' }}</p>
                </div>
            </div>
        </div> 

        {{-- Bagian 2: Form Pemesanan --}}
        <form action="{{ route('pasien.buat_pesanan', ['dokter' => $dokter->id]) }}" method="POST" class="form-pesanan">
            @csrf
            
            {{-- INPUT KELUHAN PASIEN (BARU) --}}
            <div class="form-group">
                <h3 class="form-title">Keluhan Utama Anda</h3>
                <textarea name="keluhan_pasien" 
                          id="keluhan_pasien" 
                          rows="4" 
                          required 
                          placeholder="Jelaskan keluhan Anda secara singkat, misal: Demam tinggi sejak 3 hari, disertai batuk kering."
                          class="input-field textarea-field"></textarea>
                @error('keluhan_pasien')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- JADWAL PRAKTIK (Jam Saja) --}}
            <div class="form-group">
                <h3 class="form-title">Pilih Jam Konsultasi</h3>
                
                {{-- Pemilihan Jam Praktik --}}
                <div class="slot-container">
                    @forelse ($jadwal_tersedia as $jam)
                    <label class="slot-label">
                        @php
                            $jam_value = str_replace('.', ':', $jam) . ':00';
                        @endphp
                        
                        <input type="radio" name="waktu_janji" value="{{ $jam_value }}" class="hidden-radio" required>
                        <span class="slot-item">
                            {{ $jam }}
                        </span>
                    </label>
                    @empty
                        <p class="no-slot-message">Tidak ada slot jam yang tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- Nominal Konsultasi --}}
            <div class="nominal-box">
                <h3 class="nominal-title">Nominal Konsultasi</h3>
                <p class="nominal-amount">
                    <span>Biaya:</span>
                    Rp{{ number_format($dokter->biaya ?? 0, 0, ',', '.') }}
                </p>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="form-group payment-group">
                <h3 class="form-title">Metode Pembayaran</h3>
                <div class="payment-options">
                    <label class="payment-label">
                        <input type="radio" name="metode_pembayaran" value="QRIS" class="radio-button" checked>
                        <span class="payment-text">QRIS</span>
                    </label>
                    <label class="payment-label">
                        <input type="radio" name="metode_pembayaran" value="Bank Lainnya" class="radio-button">
                        <span class="payment-text">Transfer Bank</span>
                    </label>
                </div>
            </div>

            {{-- Tombol Final --}}
            <button type="submit" class="btn-submit">
                Buat Pesanan
            </button>
        </form>
    </div> 
</div>
@endsection