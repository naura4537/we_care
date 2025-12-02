@extends('layouts.admin')

@section('content')
    <div class="custom-content-box">
        <h3 class="box-title">Tambah Pengguna Baru</h3>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            {{-- PERBAIKAN: name="nama" dan @error('nama') --}}
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required>
                @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            {{-- FIELD LAINNYA (TIDAK PERLU DIUBAH) --}}
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-input" required>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="gender">Jenis Kelamin:</label>
                <select id="gender" name="gender" class="form-input">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-input">
                    <option value="pasien" {{ old('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                </select>
                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="form-button">Tambah Pengguna</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="margin-top: 10px; display: block; text-align: center;">Batal</a>
        </form>
    </div>
@endsection