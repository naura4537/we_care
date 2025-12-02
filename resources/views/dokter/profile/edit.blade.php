@extends('layouts.dokter') {{-- Sesuaikan dengan layout Anda --}}

@section('content')
    <div class="custom-content-box profile-detail-box">
        <h3 class="box-title">Edit Profil Dokter: {{ $user->nama ?? 'Dokter' }}</h3>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        
        {{-- PASTIKAN ROUTE DI routes/web.php MENGGUNAKAN PATCH ATAU PUT --}}
        <form action="{{ route('dokter.profile.update') }}" method="POST"> 
            @csrf
            @method('PATCH') 
            
            @php
                // ⚠️ KOREKSI: Relasi yang dipanggil harusnya 'dokter' (singular) 
                // untuk konsistensi dengan Controller dan konvensi HasOne.
                // Jika DB Anda memaksa 'dokters', ubah juga di Controller.
                $dokter = $user->dokter; 
            @endphp

            {{-- =================================== --}}
            {{-- BAGIAN INFORMASI AKUN (USER FIELDS) --}}
            {{-- =================================== --}}
            <h4 style="margin-top: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Informasi Akun</h4>
            
            <div class="form-group">
                <label for="nama">Nama:</label>
                {{-- ⚠️ KOREKSI: name="name" (Sesuai validasi Laravel/DB) --}}
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    class="form-input @error('name') is-invalid @enderror" 
                    value="{{ old('nama', $user->nama ?? $user->nama) }}" 
                    required
                >
                {{-- ⚠️ KOREKSI: @error('name') --}}
                @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input @error('email') is-invalid @enderror" 
                    value="{{ old('email', $user->email) }}" 
                    required
                >
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                {{-- ⚠️ KOREKSI: name="gender" (Sesuai DB/Controller) --}}
                <select type="enum" id="jenis_kelamin" name="jenis_kelamin" class="form-input @error('jenis_kelamin') is-invalid @enderror">
                    <option value="">Pilih Jenis Kelamin</option>
                    {{-- Menggunakan $user->gender sesuai DB --}}
                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                {{-- ⚠️ KOREKSI: @error('gender') --}}
                @error('jenis_kelamin') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            {{-- Password --}}
            <div class="form-group">
                <label for="password">Password (kosongkan jika tidak ingin mengubah):</label>
                <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
            </div>

            {{-- =================================== --}}
            {{-- BAGIAN DETAIL DOKTER (DOKTER FIELDS) --}}
            {{-- =================================== --}}
            <hr>
            <h4 style="margin-top: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Detail Profesional</h4>

            <div class="form-group">
                <label for="spesialisasi">Spesialisasi</label>
                <input type="text" class="form-input @error('spesialisasi') is-invalid @enderror" id="spesialisasi" name="spesialisasi" 
                    value="{{ old('spesialisasi', $dokter->spesialisasi ?? '') }}" required>
                @error('spesialisasi') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="riwayat_pendidikan">Riwayat Pendidikan</label>
                <input type="text" class="form-input @error('riwayat_pendidikan') is-invalid @enderror" id="riwayat_pendidikan" name="riwayat_pendidikan" 
                    value="{{ old('riwayat_pendidikan', $dokter->riwayat_pendidikan ?? '') }}" required>
                @error('riwayat_pendidikan') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_str">Nomor STR</label>
                <input type="text" class="form-input @error('no_str') is-invalid @enderror" id="no_str" name="no_str" 
                    value="{{ old('no_str', $dokter->no_str ?? '') }}" required>
                @error('no_str') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="biaya">Tarif per Jam (Rp)</label>
                <input 
                    type="decimal" 
                    class="form-input @error('biaya') is-invalid @enderror" 
                    id="biaya" 
                    name="biaya" 
                    value="{{ old('biaya', number_format($dokter->biaya ?? 0, 0, ',', '.')) }}" 
                    required
                >
                @error('biaya') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
    <label for="jadwal">Jadwal Praktik</label>
    {{-- ⚠️ Atribut type="text" dihapus karena tidak relevan untuk <textarea> --}}
    <textarea 
        class="form-input @error('jadwal') is-invalid @enderror" 
        id="jadwal" 
        name="jadwal"
    >{{ old('jadwal', $dokter->jadwal ?? '') }}</textarea>
    @error('jadwal') <span class="text-danger">{{ $message }}</span> @enderror
</div>

            <button type="submit" class="btn profile-actions btn-primary" style="margin-top: 20px;">Simpan Perubahan</button>
            <a href="{{ route('dokter.profile.show') }}" class="btn profile-actions btn-secondary">Batal</a>
        </form>
    </div>
@endsection