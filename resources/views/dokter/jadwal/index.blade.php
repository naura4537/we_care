@extends('layouts.dokter')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Daftar Jadwal Konsultasi</h2>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- KARTU TABEL UTAMA (FORCED INLINE STYLE) --}}
    <div style="background: white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
        
        <table style="min-width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Waktu Konsultasi
                    </th>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Nama Pasien
                    </th>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Keluhan
                    </th>
                    <th style="background-color: #f3f4f6; padding: 12px 15px; text-align: center; font-weight: bold; color: #4b5563; font-size: 12px; text-transform: uppercase;">
                        Status & Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($konsultasi as $item)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    {{-- WAKTU --}}
                    <td style="padding: 10px 15px; font-size: 14px;">
                        <p style="font-weight: bold; margin: 0;">{{ \Carbon\Carbon::parse($item->waktu_janji)->format('d M Y') }}</p>
                        <p style="color: #6b7280; font-size: 11px; margin: 0;">{{ \Carbon\Carbon::parse($item->waktu_janji)->format('H:i') }} WIB</p>
                    </td>

                    {{-- PASIEN --}}
                    <td style="padding: 10px 15px; font-size: 14px;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #bfdbfe; display: flex; align-items: center; justify-content: center; color: #2563eb; font-weight: bold; font-size: 14px;">
                                {{ substr(\App\Models\User::find($item->user_id)->nama ?? 'P', 0, 1) }}
                            </div>
                            <div style="margin-left: 10px;">
                                <p style="font-weight: 500; margin: 0;">
                                    {{ \App\Models\User::find($item->user_id)->nama ?? 'Pasien #'.$item->user_id }}
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- KELUHAN --}}
                    <td style="padding: 10px 15px; font-size: 14px;">
                        <p style="color: #6b7280; font-style: italic;">"{{ Str::limit($item->keluhan_pasien, 50) }}"</p>
                    </td>

                    {{-- STATUS & AKSI (DIGABUNG) --}}
                    <td style="padding: 10px 15px; font-size: 14px; text-align: center;">
                        @php
                            $status = strtolower($item->status);
                            $isPaymentPending = str_contains($status, 'bayar');
                            $isCompleted = str_contains($status, 'selesai') || str_contains($status, 'lihat balasan');
                            $isActionable = str_contains($status, 'periksa') || str_contains($status, 'sudah bayar') || str_contains($status, 'menunggu balasan');
                        @endphp
                        
                        @if($isPaymentPending)
                            <span style="background-color: #fca5a5; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 12px; color: #991b1b; display: inline-block;">
                                Belum Bayar
                            </span>
                        @elseif($isActionable)
                            {{-- AKSI: Buat Balasan (BIRU SESUAI PERMINTAAN USER) --}}
                            <a href="{{ route('dokter.balas', $item->id) }}" 
                               style="background-color: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px; text-decoration: none; display: inline-block; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                Buat Balasan
                            </a>
                        @elseif($isCompleted)
                            {{-- AKSI: Edit Balasan (Hijau) --}}
                            <a href="{{ route('dokter.balas', $item->id) }}" 
                               style="background-color: #d1fae5; color: #065f46; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px; text-decoration: none; display: inline-block; border: 1px solid #a7f3d0;">
                                Edit Balasan
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: #6b7280; font-size: 14px;">
                        Tidak ada jadwal konsultasi yang perlu diperiksa saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection