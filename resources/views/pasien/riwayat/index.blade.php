@extends('layouts.pasien')

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="riwayat-container">
    {{-- JUDUL HALAMAN --}}
    <h1>Riwayat Pemesanan Konsultasi</h1>

    {{-- Pesan Pemberitahuan (Success/Error) --}}
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- (Tambahkan alert-error jika diperlukan) --}}

    @if ($riwayats->isEmpty())
        <div class="empty-state">
            <p>Anda belum memiliki riwayat pemesanan.</p>
        </div>
    @else
        {{-- START: CARD PEMBUNGKUS TABEL --}}
        <div class="riwayat-card">
            <h2>Daftar Transaksi Anda</h2>
            
            <div class="riwayat-table-wrapper">
                <table class="riwayat-table">
                    <thead>
                        <tr>
                            <th scope="col">No Pemesanan</th>
                            <th scope="col">Dokter</th>
                            <th scope="col">Waktu Janji</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayats as $riwayat)
                            <tr>
                            <td>#{{ $riwayat->id }}</td>
                            <td>Dr. {{ $riwayat->dokter->user->nama ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($riwayat->waktu_janji)->format('d M Y, H:i') }}</td>
                            <td class="nominal-text">Rp{{ number_format($riwayat->nominal, 0, ',', '.') }}</td>

                        {{-- Kolom Status dengan Kelas Kondisional --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                // Normalisasi teks agar kebal spasi/huruf besar-kecil
                                $statusCek = strtolower(trim($riwayat->status));
                            @endphp

                            @if($statusCek == 'selesai' || $statusCek == 'lihat balasan')
                                {{-- TOMBOL LIHAT BALASAN --}}
                                {{-- Kita pakai style="..." manual agar warnanya PASTI keluar --}}
                                <a href="{{ route('pasien.riwayat.show', $riwayat->id) }}" 
                                style="background-color: #10B981; color: white; padding: 5px 15px; border-radius: 5px; font-weight: bold; text-decoration: none; display: inline-block;">
                                Lihat Balasan
                                </a>
                            @else
                                {{-- STATUS LAIN (Menunggu, dll) --}}
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $riwayat->status }}
                                </span>
                            @endif
                        </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- END: CARD PEMBUNGKUS TABEL --}}
    @endif
</div>
@endsection