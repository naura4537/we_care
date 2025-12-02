@extends('layouts.dokter')

@section('content')
@php
    // --- LOGIKA DIFFERENSIASI ---
    $isEditMode = $ulasan->exists; // true jika objek ulasan sudah ada
    $headerColor = $isEditMode ? '#FBBF24' : '#0d9488'; // Yellow/Amber for Edit, Teal for Create
    $title = $isEditMode ? 'Edit Ulasan Pasien' : 'Nilai Pasien Baru';
    $buttonText = $isEditMode ? 'Simpan Perubahan' : 'Kirim Ulasan';
    
    // Penentuan Route Action
    $actionRoute = $isEditMode 
        ? route('dokter.ulasan.pasien.update', $konsultasi->id) 
        : route('dokter.ulasan.pasien.store', $konsultasi->id);
    
    // Fallback Nama Pasien
    $patientName = $pasien->name ?? 'Pasien: ' . $pasien->id;
@endphp

<div style="padding: 40px 20px;">
    {{-- KARTU UTAMA --}}
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;">
        
        {{-- HEADER BERWARNA DINAMIS --}}
        <div style="padding: 15px 25px; background-color: {{ $headerColor }}; border-bottom: 1px solid #d1d5db;">
            <h2 style="font-size: 20px; font-weight: bold; color: white; margin: 0;">{{ $title }}</h2>
            <p style="color: #f3f4f6; font-size: 13px;">Ulasan ini akan masuk ke riwayat pasien.</p>
        </div>

        <div style="padding: 30px;">
            
            {{-- INFO PASIEN (Menggunakan Fallback Nama) --}}
            <div style="background-color: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #f3f4f6; margin-bottom: 30px;">
                <label style="font-size: 11px; font-weight: bold; color: #6b7280; text-transform: uppercase;">Pasien yang dinilai</label>
                <p style="font-size: 18px; font-weight: bold; color: #1f2937; margin: 5px 0 0 0;">
                    {{ $patientName }}
                </p>
                <p style="font-size: 12px; color: #9ca3af;">Konsultasi: #{{ $konsultasi->id }} - {{ \Carbon\Carbon::parse($konsultasi->waktu_janji)->format('d M Y') }}</p>
            </div>

            {{-- FORM SUBMISSION --}}
            <form action="{{ $actionRoute }}" method="POST">
                @csrf
                @if ($isEditMode)
                    @method('PUT') {{-- PENTING: Method Spoofing untuk UPDATE --}}
                @endif

              {{-- 1. INPUT RATING (BINTANG) --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; color: #374151; font-weight: bold; margin-bottom: 10px;">Berikan Rating Layanan Pasien (1-5)</label>
                
                <div style="display: flex; justify-content: flex-start;">
                    
                    {{-- KONTEN BINTANG (Flex Reverse) --}}
                    <div style="display: flex; flex-direction: row-reverse; gap: 5px;">
                        @for ($i = 5; $i >= 1; $i--)
                            {{-- FIX: Radio Input dibuat transparan dan kecil, bukan display:none --}}
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                class="rating-input" 
                                {{ (old('rating', $ulasan->rating ?? '') == $i) ? 'checked' : '' }} required>
                            
                            <label for="star{{ $i }}" 
                                class="rating-star"
                                style="cursor: pointer; font-size: 36px; color: #d1d5db; transition: color 0.3s;">
                                ★
                            </label>
                        @endfor
                    </div>
                </div>
            </div>
    {{-- 2. INPUT KOMENTAR --}}
                <div style="margin-bottom: 30px;">
                    <label style="display: block; color: #374151; font-weight: bold; margin-bottom: 8px;">Komentar Dokter tentang Pasien</label>
                    <textarea name="komentar" rows="4" 
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; transition: border 0.3s; resize: vertical;" 
                        placeholder="Contoh: Pasien kooperatif, memberikan informasi jelas, mengikuti anjuran..." required>{{ old('komentar', $ulasan->komentar ?? '') }}</textarea>
                </div>

                {{-- Tombol --}}
                <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                    <a href="{{ route('dokter.ulasan.index') }}" 
                        style="padding: 10px 20px; background-color: #e5e7eb; color: #4b5563; border-radius: 6px; font-weight: bold; text-decoration: none;">Batal</a>
                    
                    <button type="submit" 
                            style="padding: 10px 20px; background-color: {{ $headerColor }}; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                        {{ $buttonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CSS Tambahan agar Bintang Berwarna Kuning --}}
<style>
    /* 1. Kunci agar input radio benar-benar tersembunyi tanpa merusak fungsi */
    .rating-input {
        opacity: 0;
        position: absolute;
        width: 1px;
        height: 1px;
        margin: 0;
        /* Tambahkan z-index tinggi agar bisa menerima klik */
        z-index: 1; 
    }
    
    /* 2. Selektor Anti-Gagal (Mewarnai bintang yang diklik & semua bintang setelahnya di HTML) */
    .rating-input:checked + .rating-star,
    .rating-input:checked ~ .rating-star,
    .rating-input:hover ~ .rating-star { 
        color: #FACC15 !important; /* Kuning Emas */
        cursor: pointer;
    }
    
    /* 3. Efek hover saat mouse bergerak di atas bintang yang belum dicentang */
    .rating-input:hover + .rating-star {
         color: #FACC15;
    }

    /* Memastikan bintang tetap abu-abu saat tidak dipilih */
    .rating-star {
        color: #d1d5db;
        transition: color 0.3s;
    }
</style>
@endsection