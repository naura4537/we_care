@extends('layouts.pasien')

@section('content')
    <div class="custom-content-box profile-detail-box">
        {{-- FIX 1: Menggunakan $user->name, bukan $user->nama --}}
        <h3 class="box-title">Profil Pengguna: {{ $user->name ?? 'Pasien' }}</h3>

        @if (session('status')) 
            {{-- FIX 2: Menggunakan 'status' sesuai dengan Redirect di Controller --}}
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="profile-layout-wrapper">
            
            <div class="profile-left-actions">
                <div class="profile-avatar-img avatar-placeholder">
                    {{-- FIX 3: Menggunakan $user->name --}}
                    {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
                </div>
                
                <a href="{{ route('pasien.profile.edit') }}" class="btn profile-actions btn-primary">Edit Profil</a>
                
                {{-- FIX 4: Form Hapus harus menunjuk ke route DELETE Pasien (pasien.profile.destroy), BUKAN admin.users.destroy --}}
                <form action="{{ route('pasien.profile.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn profile-actions btn-danger">Hapus Profil</button>
                </form>
            </div>
            
            <div class="profile-right-details">
                {{-- FIX 5: Menggunakan $user->name --}}
                <p><strong>Nama:</strong> {{ $user->nama ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                
                {{-- FIX 6: Menggunakan relasi singular $user->pasien (jika relasi di model Anda singular) --}}
                <p><strong>Tanggal Lahir:</strong> {{ $user->pasien->tanggal_lahir ?? 'N/A' }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $user->pasien->jenis_kelamin ?? 'N/A' }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>
                
                {{-- FIX 6: Menggunakan relasi singular $user->pasien --}}
                <p><strong>Alamat:</strong> {{ $user->pasien->alamat ?? 'N/A' }}</p>
                
                <p><strong>Nomor Telepon:</strong> {{ $user->no_telp ?? 'N/A' }}</p>
            </div>
        </div>
        <a href="{{ route('pasien.dashboard') }}" class="btn btn-secondary" style="margin-top: 20px; text-decoration: underline;">
    Kembali ke Dashboard
</a>
    </div>
@endsection