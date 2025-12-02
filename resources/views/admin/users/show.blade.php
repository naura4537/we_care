@extends('layouts.admin')

@section('content')
    <div class="custom-content-box profile-detail-box">
        <h3 class="box-title">Profil Pengguna: {{ $user->nama ?? 'Pengguna' }}</h3> 

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-layout-wrapper">
            
            <div class="profile-left-actions">
                <div class="profile-avatar-img avatar-placeholder">
                    {{-- Avatar: Menggunakan $user->nama --}}
                    {{ strtoupper(substr($user->nama ?? '?', 0, 1)) }} 
                </div>
                
                {{-- Tombol Aksi (CRUD Admin) --}}
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn profile-actions btn-primary">Edit Profil</a>
                
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn profile-actions btn-danger">Hapus Profil</button>
                </form>
            </div>
            
            <div class="profile-right-details">
                {{-- Data Inti --}}
                <p><strong>Nama:</strong> {{ $user->nama ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>

                {{-- LOGIKA DATA PROFIL BERDASARKAN ROLE --}}
                
                @if ($user->role === 'admin')
                
                @elseif ($user->role === 'pasien' && $user->pasien)
                    <hr>
                    <h4>Detail Profil Pasien</h4>
                    <p><strong>Tanggal Lahir:</strong> {{ $user->pasiens->tanggal_lahir ?? 'N/A' }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $user->pasiens->jenis_kelamin ?? 'N/A' }}</p>
            <p><strong>Alamat:</strong> {{ $user->pasiens->alamat ?? 'N/A' }}</p>
            {{-- PERBAIKAN KRITIS: Mengambil Nomor Telepon dari tabel users ($user) --}}
            <p><strong>Nomor Telepon:</strong> {{ $user->no_telp ?? 'N/A' }}</p>
                    
                @elseif ($user->role === 'dokter' && $user->dokters)
                    <hr>
                    <h4>Detail Profil Dokter</h4>
                    <p><strong>Spesialisasi:</strong> {{ $user->dokters->spesialisasi ?? 'N/A' }}</p>
                    <// --- resources/views/admin/users/show.blade.php ---
                    <p><strong>Pendidikan:</strong> {{ $user->dokters->riwayat_pendidikan ?? 'N/A' }}</p>
                    <p><strong>Nomor STR:</strong> {{ $user->dokters->no_str ?? 'N/A' }}</p>
                    <p><strong>Jadwal Praktik:</strong> {{ $user->dokters->jadwal ?? 'N/A' }}</p>

                @else
                    <hr>
                    <p>Data profil spesifik belum diisi.</p>
                @endif
                
            </div>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="margin-top: 20px;">Kembali ke Daftar Pengguna</a>
    </div>
@endsection