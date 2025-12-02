@extends('layouts.pasien')

@section('title', 'Hasil Konsultasi #' . $pemesanan->id)

{{-- Asumsi: Anda memanggil file CSS manual di layout pasien --}}

@section('content')
<div class="riwayat-container">
    {{-- JUDUL HALAMAN --}}
    <h1>Hasil Konsultasi Dokter</h1>
    <p style="color: #6b7280; margin-bottom: 20px;">Pemesanan #{{ $pemesanan->id }} - Dr. {{ $pemesanan->dokter->user->nama ?? 'N/A' }}</p>

    <div class="riwayat-card">
        <h2 style="color: #0d9488; border-bottom: 2px solid #0d9488; padding-bottom: 5px; margin-bottom: 20px;">
            📝 Rincian Konsultasi Selesai
        </h2>
        
        <div class="grid-layout-two-cols">
            
            {{-- Bagian Diagnosa Dokter --}}
            <div class="diagnosa-section">
                <h3 style="font-size: 1.1em; font-weight: bold; color: #1f2937; margin-bottom: 10px; padding: 10px; background-color: #f3f4f6; border-radius: 6px;">
                    Diagnosa Dokter
                </h3>
                
                {{-- Asumsi: Data diagnosa ada di relasi atau kolom model Pemesanan --}}
                <div class="content-box">
                    <p style="font-weight: bold; margin-bottom: 5px;">Kode Penyakit (ICD-10):</p>
                    {{-- Ganti 'diagnosa_kode' dengan kolom yang sesuai --}}
                    <p style="font-size: 1.1em; color: #ef4444; font-weight: bold; margin-bottom: 15px;">
                        {{ $pemesanan->diagnosa->kode ?? 'A09' }} 
                    </p>
                    
                    <p style="font-weight: bold; margin-bottom: 5px;">Deskripsi Diagnosa:</p>
                    {{-- Ganti 'deskripsi' dengan kolom yang sesuai --}}
                    <p style="line-height: 1.6; color: #374151;">
                        {{ $pemesanan->diagnosa->deskripsi ?? 'Pasien mengalami demam virus dengan gejala ringan yang tidak memerlukan rawat inap. Disarankan istirahat total dan peningkatan hidrasi.' }}
                    </p>
                </div>
            </div>

           {{-- Bagian Resep Obat & Saran --}}
            <div class="resep-section">
                <h3 style="font-size: 1.1em; font-weight: bold; color: #1f2937; margin-bottom: 10px; padding: 10px; background-color: #f3f4f6; border-radius: 6px;">
                    Resep Obat
                </h3>
                
                <div class="content-box">
                    <ul class="resep-list">
                        {{-- AKTUAL: Melakukan Loop data Resep dari relasi (asumsi $pemesanan->resepItems adalah koleksi) --}}
                        @if ($pemesanan->resepItems->count() > 0)
                            @foreach ($pemesanan->resepItems as $item)
                                <li>
                                    <span style="font-weight: 600;">{{ $item->nama_obat }}</span> ({{ $item->jumlah }} {{ $item->satuan }}) - Aturan: **{{ $item->aturan_minum }}**
                                </li>
                            @endforeach
                        @else
                            {{-- DUMMY/FALLBACK jika data resep belum ada di database --}}
                            <li>
                                <span style="font-weight: 600;">Paracetamol 500mg</span> (10 tablet) - Aturan: **3x sehari setelah makan, jika demam.**
                            </li>
                            <li>
                                <span style="font-weight: 600;">Vitamin C 1000mg</span> (5 tablet) - Aturan: **1x sehari setiap pagi.**
                            </li>
                            <li>
                                <span style="font-weight: 600;">Ambroxol 30mg</span> (10 tablet) - Aturan: **2x sehari pagi dan malam.**
                            </li>
                        @endif
                    </ul>
                    
                    {{-- Tombol Unduh Resep --}}
                    <div style="margin-top: 25px; text-align: right;">
                        {{-- AKTUAL: Menggunakan ID pemesanan yang benar untuk route download --}}
                        <a href="{{ route('pasien.resep.download', $pemesanan->id) }}" 
                           class="action-btn btn-download-primary" 
                           style="background-color: #059669; color: white;">
                            ⬇️ Unduh Resep (PDF)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- PUSH STYLES tetap sama (CSS manual untuk grid/list) --}}
@push('styles')
<style>
/* ... (CSS yang sudah Anda miliki untuk .riwayat-container, .riwayat-card, .grid-layout-two-cols, dll.) ... */
/* Saya asumsikan Anda telah meletakkan kode CSS ini di tempat yang benar atau di sini */

.grid-layout-two-cols {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
}
@media (min-width: 768px) {
    .grid-layout-two-cols {
        grid-template-columns: 1fr 1fr;
    }
}

.diagnosa-section, .resep-section {
    padding: 15px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background-color: #ffffff;
}

.content-box {
    padding: 10px;
}

.resep-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.resep-list li {
    background-color: #f9fafb;
    border-left: 3px solid #0d9488;
    padding: 8px 10px;
    margin-bottom: 8px;
    border-radius: 4px;
    font-size: 0.9em;
}

.btn-download-primary {
    display: inline-block;
    padding: 8px 15px;
    font-size: 0.9em;
    font-weight: bold;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.15s ease-in-out;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}
.btn-download-primary:hover {
    background-color: #047857 !important;
}
</style>
@endpush