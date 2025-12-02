@extends('layouts.admin')

@section('title', 'Detail Riwayat - ' . $riwayat->user->name ?? 'N/A')

@section('content')
{{-- Kontainer Utama --}}
<div style="background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%); color: white; padding: 35px 40px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 8px 30px rgba(1, 107, 97, 0.3);">
    
    {{-- Flex utama: Mengatur posisi Arrow dan Text Block --}}
    <div style="display: flex; align-items: center; gap: 20px;">
        
        {{-- PANAH KEMBALI (Element pertama) --}}
        <a href="{{ route('admin.riwayat') }}" 
           style="color: white; 
                  text-decoration: none; 
                  font-size: 24px; 
                  padding-right: 20px;
                  border-right: 1px solid rgba(255, 255, 255, 0.3); 
                  line-height: 1;
                  flex-shrink: 0;">
            &larr;
        </a>
        
        {{-- TEXT BLOCK (Judul dan Subjudul Disusun Vertikal) --}}
        <div style="display: flex; flex-direction: column; justify-content: center; flex-grow: 1;">
            
            {{-- JUDUL UTAMA --}}
            <h2 style="font-size: 28px; font-weight: 700; margin: 0 0 3px 0;">
                Detail Konsultasi #{{ $riwayat->id }}
            </h2>
            
            {{-- SUBJUDUL (Tepat di bawah judul) --}}
            <p style="opacity: 0.95; font-size: 15px; font-weight: 400; margin: 0;">
                Lihat hasil diagnosa, resep, dan data lengkap pemesanan.
            </p>
        </div>
    </div>
    
</div>

    <div style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); padding: 30px; border: 1px solid #f0f0f0;">
        
        <h3 style="font-size: 20px; font-weight: 700; color: #016B61; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">
            Informasi Pasien & Dokter
        </h3>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <tbody>
                <tr style="border-bottom: 1px solid #f9f9f9;">
                    <td style="width: 25%; font-weight: 600; color: #333; padding: 10px 0;">Nama Pasien</td>
                    <td style="width: 25%; color: #333; padding: 10px 0;">
                        <strong>{{ $riwayat->user->name ?? 'N/A' }}</strong> 
                        <span style="background: #e3f2fd; color: #1976d2; padding: 3px 8px; border-radius: 10px; font-size: 12px; font-weight: bold;">USER ID: {{ $riwayat->user_id }}</span>
                    </td>
                    <td style="width: 25%; font-weight: 600; color: #333; padding: 10px 0;">Nama Dokter</td>
                    <td style="width: 25%; color: #333; padding: 10px 0;">
                        <strong>{{ $riwayat->dokter->user->name ?? 'N/A' }}</strong> 
                        <span style="background: #f3e5f5; color: #7b1fa2; padding: 3px 8px; border-radius: 10px; font-size: 12px; font-weight: bold;">SPESIALIS: {{ $riwayat->dokter->spesialisasi ?? 'N/A' }}</span>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #f9f9f9;">
                    <td style="font-weight: 600; color: #333; padding: 10px 0;">Tanggal Konsultasi</td>
                    <td style="color: #333; padding: 10px 0;">{{ \Carbon\Carbon::parse($riwayat->waktu_janji)->locale('id')->translatedFormat('d M Y, H:i') }}</td>
                    <td style="font-weight: 600; color: #333; padding: 10px 0;">Status</td>
                    <td style="color: #333; padding: 10px 0;"><span style="background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">{{ ucfirst($riwayat->status) }}</span></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #333; padding: 10px 0;">Keluhan Awal</td>
                    <td colspan="3" style="color: #333; font-style: italic; padding: 10px 0;">{{ $riwayat->keluhan_pasien ?? 'Tidak ada keluhan tercatat.' }}</td>
                </tr>
            </tbody>
        </table>
        
        <h3 style="font-size: 20px; font-weight: 700; color: #016B61; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">
            Hasil Pemeriksaan Dokter
        </h3>

        <div style="margin-bottom: 25px; background: #f8fffe; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px;">
            <h4 style="font-size: 16px; font-weight: 700; color: #155724; margin-bottom: 10px;">Diagnosis:</h4>
            <p style="color: #333; white-space: pre-wrap; line-height: 1.6;">{{ $riwayat->diagnosa }}</p>
        </div>

        <div style="margin-bottom: 30px; background: #f3e5f5; border: 1px solid #e1bee7; padding: 20px; border-radius: 8px;">
            <h4 style="font-size: 16px; font-weight: 700; color: #7b1fa2; margin-bottom: 10px;">Resep & Saran:</h4>
            <p style="color: #333; white-space: pre-wrap; line-height: 1.6;">{{ $riwayat->resep }}</p>
        </div>


    </div>
</div>
@endsection