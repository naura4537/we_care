@extends('layouts.dokter')

@section('content')
    {{-- Memuat relasi dokter agar data spesifik terisi --}}
    @php
        $user->load('dokters');
        $dokter = $user->dokters; // Ambil object Dokter yang terkait
    @endphp

    <div class="custom-content-box profile-detail-box">
        <h3 class="box-title">Profil Dokter: {{ $user->nama ?? 'Dokter' }}</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="profile-layout-wrapper">
            
            <div class="profile-left-actions">
                <div class="profile-avatar-img avatar-placeholder">
                    {{ strtoupper(substr($user->nama ?? 'D', 0, 1)) }} 
                </div>
                
                {{-- Tautan Edit dan Hapus --}}
                <a href="{{ route('dokter.profile.edit') }}" class="btn profile-actions btn-primary">Edit Profil</a>
                
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus profil ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn profile-actions btn-danger">Hapus Profil</button>
                </form>
            </div>
            
            <div class="profile-right-details">
            <p><strong>Nama:</strong> {{ $user->nama ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <hr>

            {{-- Ambil objek dokter untuk mempersingkat penulisan --}}
            @php
                $dokter = $user->dokters; 
            @endphp

            @if ($dokter)
                <h4 style="margin-top: 15px; color: var(--color-dark);">Detail Dokter</h4>
                
                <p><strong>Spesialisasi:</strong> {{ $dokter->spesialisasi ?? 'N/A' }}</p>
                <p><strong>Pendidikan:</strong> {{ $dokter->riwayat_pendidikan ?? 'N/A' }}</p>
                <p><strong>Nomor STR:</strong> {{ $dokter->no_str ?? 'N/A' }}</p>
                <p><strong>Tarif / Jam:</strong> Rp {{ number_format($dokter->biaya ?? 0, 0, ',', '.') }}</p>
                <p><strong>Jadwal Praktik:</strong> {{ $dokter->jadwal ?? 'N/A' }}</p>
            @else
                <p>Detail profil dokter belum lengkap. Silakan klik "Edit Profil" untuk mengisi data profesional.</p>
            @endif
        </div>
        </div>
        
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary" style="margin-top: 20px;">Kembali ke Dashboard</a>
    </div>
@endsection