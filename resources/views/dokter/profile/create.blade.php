@extends('layouts.dokter')

@section('content')
    <div class="custom-content-box">
        <h3 class="box-title">Tambah Pengguna Baru</h3>

        <form action="{{ route('pasien.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

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
                <label for="birth_date">Tanggal Lahir:</label>
                <input type="date" id="birth_date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
                @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
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
                </select>
                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="address">Alamat:</label>
                <textarea id="address" name="address" class="form-input">{{ old('address') }}</textarea>
                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="phone_number">Nomor Telepon:</label>
                <input type="text" id="phone_number" name="phone_number" class="form-input" value="{{ old('phone_number') }}">
                @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="form-button">Tambah Pengguna</button>
            <a href="{{ route('pasien.users.index') }}" class="btn btn-secondary" style="margin-top: 10px; display: block; text-align: center;">Batal</a>
        </form>
    </div>
@endsection