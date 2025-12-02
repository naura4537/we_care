<x-guest-layout>
    <h2>Selamat Datang Kembali</h2>

    <p class="auth-sub-text">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="auth-link">Registrasi disini</a>
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if($errors->any())
        <div class="auth-error" style="margin-bottom: 16px;">
            Email atau Password salah.
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <button type="submit" class="form-button">
            Login
        </button>
    </form>
</x-guest-layout>