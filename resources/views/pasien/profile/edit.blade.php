@extends('layouts.pasien')

@section('content')
    <div class="custom-content-box">
        <h3 class="box-title">Edit Profil Pengguna: {{ $user->nama }}</h3>

        <form action="{{ route('pasien.profile.update', $user->id) }}" method="POST">
        {{-- Kita biarkan admin.users.update karena controller update-nya memang ada di Admin Controller --}}
            @csrf
            @method('PATCH') {{-- Atau PUT --}}

            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="nama" class="form-input" value="{{ old('nama', $user->nama) }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password (kosongkan jika tidak ingin mengubah):</label>
                <input type="password" id="password" name="password" class="form-input">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}">
                @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-input">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-input">
                    <option value="pasien" {{ old('role', $user->role) == 'pasien' ? 'selected' : '' }}>Pasien</option>
                </select>
                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" class="form-input">{{ old('alamat', $user->alamat) }}</textarea>
                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_telp">Nomor Telepon:</label>
                <input type="text" id="no_telp" name="no_telp" class="form-input" value="{{ old('no_telp', $user->no_telp) }}">
                @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="form-button">Simpan Perubahan</button>
            <a href="{{ route('pasien.profile.show') }}" class="btn btn-secondary" style="margin-top: 10px; display: block; text-align: center;">Batal</a>
            </form>
    </div>
@endsection