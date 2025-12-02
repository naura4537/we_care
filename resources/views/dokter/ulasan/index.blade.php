@extends('layouts.dokter')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Ulasan Pasien Saya</h2>
    <p class="text-gray-600 mb-8">Daftar pasien yang bisa Anda berikan penilaian layanan.</p>

    {{-- KARTU TABEL UTAMA --}}
    <div style="background: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
        <table style="min-width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Nama Pasien
                    </th>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Terakhir Konsultasi
                    </th>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Ulasan Anda
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $pasien)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    
                    {{-- NAMA PASIEN --}}
                    <td style="padding: 15px; font-size: 14px;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #bfdbfe; display: flex; align-items: center; justify-content: center; color: #2563eb; font-weight: bold; font-size: 14px; margin-right: 10px;">
                                {{ substr($pasien->nama ?? 'P', 0, 1) }}
                            </div>
                            <p style="font-weight: bold; margin: 0;">{{ $pasien->nama ?? 'Pasien #'.$pasien->id }}</p>
                        </div>
                    </td>

                    {{-- TERAKHIR KONSEL --}}
                    <td style="padding: 15px; font-size: 14px;">
                        @php
                            // Mencari data konsultasi terakhir
                            $lastConsult = \App\Models\Pemesanan::where('dokter_id', $dokter->id)
                                                                 ->where('user_id', $pasien->id)
                                                                 ->latest('created_at')
                                                                 ->first();
                        @endphp
                        @if($lastConsult)
                            <p style="margin: 0;">{{ \Carbon\Carbon::parse($lastConsult->created_at)->format('d M Y') }}</p>
                            <span style="color: #6b7280; font-size: 11px;">Status: {{ $lastConsult->status }}</span>
                        @else
                            <span style="color: #9ca3af;">Belum ada riwayat tercatat.</span>
                        @endif
                    </td>

                    {{-- AKSI / ULASAN DOKTER KE PASIEN --}}
                    <td style="padding: 15px; font-size: 14px;">
                        @php
                            $review = \App\Models\DokterUlasan::where('pemesanan_id', optional($lastConsult)->id)->first();
                            $routeId = optional($lastConsult)->id;
                        @endphp

                        @if ($lastConsult && $lastConsult->status == 'Selesai')
                        @if ($review)
                            {{-- KONDISI 1: EDIT (Ulasan sudah ada) --}}
                            <a href="{{ route('dokter.ulasan.pasien.edit', $lastConsult->id) }}" style="background-color: #fef3c7; color: #92400e; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px; text-decoration: none;">
                                Edit Ulasan
                            </a>
                        @else
                            {{-- KONDISI 2: CREATE (Ulasan belum ada) --}}
                            <a href="{{ route('dokter.ulasan.pasien.create', $lastConsult->id) }}" style="background-color: #34d399; color: white; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px; text-decoration: none;">
                                Beri Ulasan
                            </a>
                        @endif
                    @else
                            <span style="color: #9ca3af; font-size: 11px;">Menunggu Konsultasi Selesai.</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 20px; text-align: center; color: #6b7280; font-size: 14px;">
                        Anda belum memiliki riwayat pasien.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection