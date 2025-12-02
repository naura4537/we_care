@extends('layouts.admin')

@section('content')
    <div class="custom-content-box">
        <h3 class="box-title">Edit Pengguna: {{ $user->name ?? $user->email }}</h3> 

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- FIELD INTI (Wajib Ada untuk Semua Role) --}}
            
            <div class="form-group">
                <label for="nama">Nama</label>
                {{-- ⚠️ PERBAIKAN KRUSIAL: name harus "name" dan value harus $user->name --}}
                <input type="text" class="form-input" id="nama" name="nama" value="{{ old('name', $user->nama) }}" required>
                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-input" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- ... (Bagian Role tetap) ... --}}
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-input" id="role" name="role" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pasien" {{ old('role', $user->role) == 'pasien' ? 'selected' : '' }}>Pasien</option>
                    <option value="dokter" {{ old('role', $user->role) == 'dokter' ? 'selected' : '' }}>Dokter</option>
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- DEFENISI DATA RELASI --}}
            @php
                // FIX: Relasi harus singular
                $pasienProfile = $user->pasien ?? null; 
                $dokterProfile = $user->dokter ?? null; 
                $isPasien = $user->role === 'pasien';
                $isDokter = $user->role === 'dokter';
            @endphp
            
            <hr>
            <h4>Data Profil Tambahan ({{ ucfirst($user->role) }})</h4>

            
            {{-- ====================================== --}}
            {{-- BLOK PASIEN --}}
            {{-- ====================================== --}}
            @if ($isPasien)
                
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-input" id="tanggal_lahir" name="tanggal_lahir" 
                           value="{{ old('tanggal_lahir', $pasienProfile->tanggal_lahir ?? '') }}">
                    @error('tanggal_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-input" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasienProfile->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pasienProfile->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-input" id="alamat" name="alamat">{{ old('alamat', $pasienProfile->alamat ?? '') }}</textarea>
                    @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label for="no_telp">Nomor Telepon</label>
                    <input type="text" class="form-input" id="no_telp" name="no_telp" 
                           value="{{ old('no_telp', $user->no_telp ?? '') }}">
                    @error('no_telp') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

            {{-- ====================================== --}}
            {{-- BLOK DOKTER --}}
            {{-- ====================================== --}}
            @elseif ($isDokter)
                
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-input" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $dokterProfile->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $dokterProfile->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="spesialisasi">Spesialisasi</label>
                    <input type="text" class="form-input" id="spesialisasi" name="spesialisasi" 
                           value="{{ old('spesialisasi', $dokterProfile->spesialisasi ?? '') }}" required>
                    @error('spesialisasi') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label for="riwayat_pendidikan">Riwayat Pendidikan</label>
                    <input type="text" class="form-input" id="riwayat_pendidikan" name="riwayat_pendidikan" 
                           value="{{ old('riwayat_pendidikan', $dokterProfile->riwayat_pendidikan ?? '') }}" required>
                    @error('riwayat_pendidikan') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="no_str">Nomor STR</label>
                    <input type="text" class="form-input" id="no_str" name="no_str" 
                           value="{{ old('no_str', $dokterProfile->no_str ?? '') }}" required>
                    @error('no_str') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="biaya">Tarif per Jam (Rp)</label>
                    <input type="number" class="form-input" id="biaya" name="biaya" 
                           value="{{ old('biaya', $dokterProfile->biaya ?? '') }}" required>
                    @error('biaya') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="jadwal">Jadwal Praktik</label>
                    <textarea class="form-input" id="jadwal" name="jadwal">{{ old('jadwal', $dokterProfile->jadwal ?? '') }}</textarea>
                    @error('jadwal') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            @endif
            
            {{-- PASSWORD (SELALU ADA) --}}
            <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-input" id="password" name="password">
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="form-button">Simpan Perubahan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection