@extends('layouts.pasien')

@section('title', 'Pembayaran Pemesanan #' . $pemesanan->id)

@section('content')

<div class="max-w-4xl mx-auto p-6 lg:p-10">
    <div class="bg-white p-8 rounded-xl shadow-2xl border-t-8 border-yellow-500">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
            Menunggu Pembayaran
        </h1>
        <p class="text-gray-600 mb-6">Pemesanan #{{ $pemesanan->id }} berhasil dibuat. Selesaikan pembayaran segera.</p>

        {{-- Batas Waktu --}}
        <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-6">
            <p class="font-bold text-red-700">Batas Waktu Pembayaran:</p>
            <p class="text-xl text-red-600 font-extrabold">
                {{ \Carbon\Carbon::parse($pemesanan->expired_at)->isoFormat('dddd, D MMMM YYYY | HH:mm') }} WIB
            </p>
        </div>

        {{-- Rincian Transaksi --}}
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="p-4 border rounded-lg bg-gray-50">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Rincian Transaksi</h3>
                <p><strong>Nominal:</strong> <span class="text-red-600 font-bold text-xl">Rp{{ number_format($pemesanan->nominal, 0, ',', '.') }}</span></p>
                <p><strong>Dokter:</strong> {{ $pemesanan->dokter->user->nama ?? 'N/A' }}</p>
                <p><strong>Waktu Janji:</strong> {{ $pemesanan->waktu_janji }}</p>
            </div>
            
            <div class="p-4 border rounded-lg bg-gray-50">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Instruksi Pembayaran</h3>
                <p><strong>Metode:</strong> {{ $instruksi_detail['metode'] }}</p>
                <p><strong>Akun Tujuan:</strong> {{ $instruksi_detail['akun'] }}</p>
                
                @if ($pemesanan->metode_pembayaran == 'QRIS')
                    <div class="mt-3 text-center p-3 bg-white border rounded-lg">
                        <p class="text-sm text-gray-500">Scan QRIS ini:</p>
                        <div class="w-24 h-24 bg-gray-300 mx-auto mt-2"></div>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6 bg-teal-50 border-l-4 border-teal-500 rounded-r-lg">
            <h3 class="text-xl font-bold text-teal-800 mb-2">Penting</h3>
            <p class="text-gray-700">Pastikan nominal transfer Anda **sama persis** dengan Nominal Konsultasi yang tertera.</p>
        </div>
        
    </div>
</div>

@endsection