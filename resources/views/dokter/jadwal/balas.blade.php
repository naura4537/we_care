@extends('layouts.dokter')

@section('content')
@php
    // --- LOGIKA DIFFERENSIASI ---
    $isEditMode = !empty($konsultasi->diagnosa) || !empty($konsultasi->resep);
    
    // Warna & Teks Didefinisikan Di Sini
    $headerBg = $isEditMode ? '#FBBF24' : '#0d9488'; // Amber/Yellow for Edit, Teal for Create
    $buttonColor = $isEditMode ? '#D97706' : '#0d9488'; // Darker Orange/Teal
    $buttonText = $isEditMode ? 'Simpan Perubahan' : 'Kirim & Selesaikan';
    $title = $isEditMode ? 'Edit Balasan Konsultasi' : 'Buat Diagnosa Baru';
@endphp

<div style="padding: 40px 20px;">
    {{-- KARTU UTAMA --}}
    <div style="max-width: 900px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;">
        
        {{-- HEADER BERWARNA --}}
        <div style="padding: 15px 25px; background-color: {{ $headerBg }}; border-bottom: 1px solid #d1d5db;">
            <h2 style="font-size: 20px; font-weight: bold; color: white; margin: 0;">{{ $title }}</h2>
            <p style="color: #f3f4f6; font-size: 13px;">Silakan isi hasil pemeriksaan untuk pasien ini.</p>
        </div>

        <div style="padding: 30px;">
            {{-- DATA PASIEN --}}
            <div style="background-color: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #f3f4f6; margin-bottom: 30px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="font-size: 11px; font-weight: bold; color: #6b7280; text-transform: uppercase;">Nama Pasien</label>
                        <p style="font-size: 16px; font-weight: bold; color: #1f2937; margin: 5px 0 0 0;">
                            {{ \App\Models\User::find($konsultasi->user_id)->name ?? 'Pasien' }}
                        </p>
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: bold; color: #6b7280; text-transform: uppercase;">Keluhan Utama</label>
                        <p style="font-size: 16px; color: #1f2937; margin: 5px 0 0 0; font-style: italic;">"{{ $konsultasi->keluhan_pasien }}"</p>
                    </div>
                    <div>
                        <label style="font-size: 11px; font-weight: bold; color: #6b7280; text-transform: uppercase;">Waktu Konsultasi</label>
                        <p style="font-size: 16px; color: #1f2937; margin: 5px 0 0 0;">
                            {{ \Carbon\Carbon::parse($konsultasi->waktu_janji)->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- FORM BALASAN --}}
            <form action="{{ route('dokter.balas.store', $konsultasi->id) }}" method="POST">
                @csrf
                
                {{-- Input Diagnosa --}}
                <div style="margin-bottom: 25px;">
                    {{-- FIX: Label menjadi block dan input menjadi 100% width --}}
                    <label style="display: block; color: #374151; font-weight: bold; margin-bottom: 8px;">Diagnosa Dokter</label>
                    <textarea name="diagnosa" rows="4" 
                        style="display: block; width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; transition: border 0.3s; resize: vertical;" 
                        placeholder="Contoh: Flu berat disertai demam..." required>{{ old('diagnosa', $konsultasi->diagnosa) }}</textarea>
                </div>

                {{-- Input Resep --}}
                <div style="margin-bottom: 30px;">
                    <label style="display: block; color: #374151; font-weight: bold; margin-bottom: 8px;">Resep Obat / Saran</label>
                    <textarea name="resep" rows="4" 
                        style="display: block; width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; transition: border 0.3s; resize: vertical;" 
                        placeholder="Contoh: Paracetamol 3x1, Istirahat cukup..." required>{{ old('resep', $konsultasi->resep) }}</textarea>
                </div>

                {{-- Tombol --}}
                <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                    <a href="{{ route('dokter.jadwal.index') }}" 
                       style="padding: 10px 20px; background-color: #e5e7eb; color: #4b5563; border-radius: 6px; font-weight: bold; text-decoration: none;">Batal</a>
                    
                    <button type="submit" 
                            style="padding: 10px 20px; background-color: {{ $buttonColor }}; color: white; border: none; border-radius: 6px; font-weight: bold; box-shadow: 0 1px 3px rgba(0,0,0,0.2); cursor: pointer;">
                        {{ $buttonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection