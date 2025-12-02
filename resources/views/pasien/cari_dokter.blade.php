@extends('layouts.pasien')

@section('content')
<div style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    
    {{-- HEADER HALAMAN --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;">Temukan Dokter Spesialis</h2>
        <p style="color: #6b7280;">Pilih dokter terbaik untuk konsultasi kesehatan Anda</p>
    </div>

    {{-- LOGIKA WARNA TOMBOL (PHP Sederhana) --}}
    @php
        $kategori = request('kategori');
        // "Semua Dokter" aktif jika kategori kosong ATAU isinya 'Semua Dokter'
        $isSemua = !$kategori || $kategori == 'Semua Dokter';
        $isUmum  = $kategori == 'Dokter Umum';
        $isGigi  = $kategori == 'Dokter Gigi';
    @endphp

    {{-- FILTER KATEGORI --}}
    <div style="display: flex; justify-content: center; gap: 15px; margin-bottom: 40px; flex-wrap: wrap;">
        
        {{-- Tombol 1: Semua Dokter --}}
        <a href="{{ route('pasien.cari_dokter', ['kategori' => 'Semua Dokter', 'q' => request('q')]) }}" 
           style="padding: 10px 25px; border-radius: 50px; font-weight: 600; font-size: 14px; text-decoration: none; border: 2px solid #0d9488; transition: all 0.3s;
                  background-color: {{ $isSemua ? '#0d9488' : '#ffffff' }};
                  color: {{ $isSemua ? '#ffffff' : '#0d9488' }};">
            Semua Dokter
        </a>

        {{-- Tombol 2: Dokter Umum --}}
        <a href="{{ route('pasien.cari_dokter', ['kategori' => 'Dokter Umum', 'q' => request('q')]) }}" 
           style="padding: 10px 25px; border-radius: 50px; font-weight: 600; font-size: 14px; text-decoration: none; border: 2px solid #0d9488; transition: all 0.3s;
                  background-color: {{ $isUmum ? '#0d9488' : '#ffffff' }};
                  color: {{ $isUmum ? '#ffffff' : '#0d9488' }};">
            Dokter Umum
        </a>

        {{-- Tombol 3: Dokter Gigi --}}
        <a href="{{ route('pasien.cari_dokter', ['kategori' => 'Dokter Gigi', 'q' => request('q')]) }}" 
           style="padding: 10px 25px; border-radius: 50px; font-weight: 600; font-size: 14px; text-decoration: none; border: 2px solid #0d9488; transition: all 0.3s;
                  background-color: {{ $isGigi ? '#0d9488' : '#ffffff' }};
                  color: {{ $isGigi ? '#ffffff' : '#0d9488' }};">
            Dokter Gigi
        </a>

    </div>

    {{-- SEARCH BAR --}}
    <div style="max-width: 600px; margin: 0 auto 50px auto; position: relative;">
        <form action="{{ route('pasien.cari_dokter') }}" method="GET">
            {{-- Simpan filter kategori saat mencari nama --}}
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif

            <input type="text" name="q" value="{{ request('q') }}" 
                   placeholder="Cari nama dokter..." 
                   style="width: 100%; padding: 12px 20px 12px 50px; border-radius: 50px; border: 1px solid #d1d5db; outline: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            
            <button type="submit" style="position: absolute; left: 15px; top: 12px; background: none; border: none; cursor: pointer;">
                <svg style="width: 20px; height: 20px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </form>
    </div>

    {{-- GRID DOKTER --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
        
        @forelse($dokters as $dokter)
        
        {{-- KARTU DOKTER --}}
        <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #f3f4f6; display: flex; flex-direction: column;">
            
            {{-- Header Hijau --}}
            <div style="height: 80px; background-color: #0d9488;"></div>

            {{-- Foto Profil --}}
            <div style="margin-top: -40px; display: flex; justify-content: center;">
                <div style="width: 80px; height: 80px; background: white; padding: 4px; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 100%; height: 100%; background-color: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #9ca3af; overflow: hidden;">
                        <span style="font-size: 24px; font-weight: bold; color: #0d9488;">
                            {{ substr($dokter->user->name ?? $dokter->user->nama ?? 'D', 0, 1) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Info Dokter --}}
            <div style="padding: 15px 20px 20px; text-align: center; flex-grow: 1;">
                <h3 style="font-size: 18px; font-weight: 800; color: #000000; margin: 10px 0 5px 0;">
                    {{ $dokter->user->name ?? $dokter->user->nama ?? $dokter->nama_dokter ?? 'Dr. Tanpa Nama' }}
                </h3>
                
                <span style="display: inline-block; background-color: #f0fdfa; color: #0f766e; font-size: 12px; font-weight: bold; padding: 4px 10px; border-radius: 20px; border: 1px solid #ccfbf1;">
                    {{ $dokter->spesialisasi ?? 'Dokter Umum' }}
                </span>
                
                <div style="border-top: 1px dashed #e5e7eb; margin: 15px 0;"></div>

                <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px;">Biaya Konsultasi</p>
                <p style="font-size: 16px; font-weight: bold; color: #0d9488;">
                    Rp {{ number_format($dokter->harga ?? 100000, 0, ',', '.') }}
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div style="background-color: #f9fafb; padding: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; border-top: 1px solid #f3f4f6;">
                <a href="{{ route('pasien.dokter_detail', $dokter->id) }}" 
                   style="display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #0d9488; color: #0d9488; padding: 8px; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 13px;">
                   Chat
                </a>
                <a href="{{ route('pasien.komentar.create', $dokter->id) }}" 
                   style="display: flex; align-items: center; justify-content: center; background: #0d9488; color: white; padding: 8px; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 13px; box-shadow: 0 2px 4px rgba(13, 148, 136, 0.3);">
                   Beri Ulasan
                </a>
            </div>
        </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: white; border-radius: 12px; border: 1px solid #e5e7eb;">
                <svg style="width: 64px; height: 64px; color: #d1d5db; margin: 0 auto 20px auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 style="font-size: 18px; font-weight: 500; color: #374151;">Dokter tidak ditemukan</h3>
                <p style="color: #9ca3af;">Coba ubah filter atau kata kunci pencarian.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection