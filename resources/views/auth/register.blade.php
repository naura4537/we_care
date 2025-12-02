<x-guest-layout>
    <h2>Registrasi</h2>

    <p class="auth-sub-text">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="auth-link">Login disini</a>
    </p>

    <x-input-error :messages="$errors->get('nama')" class="auth-error" />
    <x-input-error :messages="$errors->get('email')" class="auth-error" />
    <x-input-error :messages="$errors->get('password')" class="auth-error" />
    <x-input-error :messages="$errors->get('role')" class="auth-error" />
    <x-input-error :messages="$errors->get('no_telp')" class="auth-error" />

    <form method="POST" action="{{ route('register') }}" style="margin-top: 16px;">
        @csrf

        <div class="form-group">
            <label for="nama">Username</label>
            <input id="nama" class="form-input" type="text" name="nama" value="{{ old('nama') }}" required autofocus autocomplete="name" />
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" class="form-input"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="form-group">
            <label for="role">Login Sebagai</label>
            <select id="role" name="role" class="form-input" required>
                <option value="pasien" {{ old('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                </select>
        </div>

        <div class="form-group">
            <label for="no_telp">Nomor Telepon</label>
            <input id="no_telp" class="form-input" type="text" name="no_telp" value="{{ old('no_telp') }}" autocomplete="tel" />
        </div>

        <button type="submit" class="form-button">
            Registrasi
        </button>
    </form>
</x-guest-layout>