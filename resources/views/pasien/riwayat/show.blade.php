@extends('layouts.app') {{-- Sesuaikan dengan layout utamamu --}}

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-bold mb-4">Detail Konsultasi</h2>

{{-- HEADER: Judul & Status --}}
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-teal-600">Laporan Konsultasi</h3>
                        <p class="text-gray-500 text-sm">No. Transaksi: #{{ $pemesanan->id }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $pemesanan->status == 'Selesai' || $pemesanan->status == 'Lihat Balasan' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $pemesanan->status }}
                        </span>
                    </div>
                </div>

                {{-- GRID INFO: Dokter, Waktu, Pasien --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Dokter Pemeriksa</label>
                            <div class="text-lg font-medium text-gray-900">
                                {{ optional($pemesanan->dokter)->nama_dokter ?? 'Dokter Umum' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Waktu Konsultasi</label>
                            <div class="text-gray-900">
                                {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->isoFormat('D MMMM Y, HH:mm') }} WIB
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-4 md:text-right">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Nama Pasien</label>
                            <div class="text-lg font-medium text-gray-900">
                                <td>{{ $pemesanan->pasien->name ?? $pemesanan->user->name ?? 'N/A' }}</td>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase">Metode Pembayaran</label>
                            <div class="text-gray-900">
                                {{ $pemesanan->metode_pembayaran ?? 'Manual' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOTAK INFORMASI UTAMA --}}
                <div class="space-y-6">
                    
                    {{-- 1. Keluhan --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-bold text-teal-700 mb-2 border-b border-gray-300 pb-1">Keluhan Pasien</h4>
                        <p class="text-gray-800">{{ $pemesanan->keluhan_pasien ?? '-' }}</p>
                    </div>

                    {{-- 2. Diagnosa --}}
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h4 class="font-bold text-blue-700 mb-2 border-b border-blue-200 pb-1">Diagnosa Dokter</h4>
                        <p class="text-gray-800">{{ $pemesanan->diagnosa ?? 'Belum ada diagnosa' }}</p>
                    </div>

                    {{-- 3. Resep --}}
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <h4 class="font-bold text-green-700 mb-2 border-b border-green-200 pb-1">Resep & Catatan Obat</h4>
                        <p class="text-gray-800">{{ $pemesanan->resep ?? 'Tidak ada resep obat' }}</p>
                    </div>

                </div>

                {{-- TOTAL BIAYA --}}
                <div class="mt-8 text-right border-t pt-4">
                    <span class="text-gray-600 font-bold text-lg">Total Biaya:</span>
                    <span class="text-3xl font-bold text-red-600 ml-2">
                        Rp {{ number_format($pemesanan->nominal, 0, ',', '.') }}
                    </span>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex items-center justify-between mt-8 pt-4 border-t border-gray-100">
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('pasien.riwayat') }}" 
                       class="flex items-center text-gray-600 hover:text-gray-900 font-semibold transition">
                        &larr; Kembali
                    </a>
            
            {{-- Tombol Download PDF --}}
            <a href="{{ route('pasien.riwayat.pdf', $pemesanan->id) }}" 
               class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
               <i class="fas fa-file-pdf mr-2"></i> Download PDF
            </a>
        </div>
    </div>
</div>
@endsection