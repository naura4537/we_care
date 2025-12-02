
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil Pasien') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi akun, nomor telepon, dan detail pasien Anda.") }}
        </p>
    </header>

    {{-- Form Verifikasi Email (dibiarkan jika Anda masih menggunakannya) --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- PERBAIKAN: Mengarahkan ke route update Pasien --}}
    <form method="post" action="{{ route('pasien.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        {{-- PERBAIKAN: Menggunakan method PUT/PATCH yang sesuai dengan UserController --}}
        @method('PUT') 

        {{-- 1. FIELD DARI TABEL USERS (Nama, Email, No. Telp) --}}
        <div>
            <x-input-label for="nama" :value="__('Nama')" />
            {{-- PERBAIKAN: Menggunakan 'nama' untuk field input --}}
            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $user->nama)" required autofocus autocomplete="nama" />
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            
            {{-- Bagian Verifikasi Email (dibiarkan) --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                {{-- ... (kode verifikasi email) ... --}}
            @endif
        </div>
        
        <div>
            <x-input-label for="no_telp" :value="__('Nomor Telepon')" />
            <x-text-input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full" :value="old('no_telp', $user->no_telp)" autocomplete="no_telp" />
            <x-input-error class="mt-2" :messages="$errors->get('no_telp')" />
        </div>
        
        <hr class="border-gray-700">
        <h4 class="font-medium text-gray-900 dark:text-gray-100 pt-4">Detail Pasien</h4>

        {{-- 2. FIELD DARI TABEL PASIENS (Tanggal Lahir, Jenis Kelamin, Alamat) --}}
        
        @php
            // Memastikan data relasi pasiens tersedia untuk menghindari error
            $pasienProfile = optional($user->pasien);
        @endphp
        
       {{-- Input Tanggal Lahir --}}
<div>
    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
    <x-text-input id="tanggal_lahir" type="date" name="tanggal_lahir" 
                  class="mt-1 block w-full"
                  {{-- KUNCI PERBAIKAN: Harus memanggil $pasienProfile->tanggal_lahir --}}
                  :value="old('tanggal_lahir', $pasienProfile->tanggal_lahir)" />
    <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
</div>

{{-- Input Jenis Kelamin (Dropdown/Select) --}}
<div>
    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
    @php
        // KUNCI PERBAIKAN: Harus memanggil $pasienProfile->jenis_kelamin
        $selectedGender = old('jenis_kelamin', $pasienProfile->jenis_kelamin); 
    @endphp
    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki" @if($selectedGender == 'Laki-laki') selected @endif>Laki-laki</option>
        <option value="Perempuan" @if($selectedGender == 'Perempuan') selected @endif>Perempuan</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
</div>

{{-- Untuk Alamat --}}
<div>
    <x-input-label for="address" :value="__('Alamat')" />
    {{-- KUNCI PERBAIKAN: Harus memanggil $pasienProfile->alamat --}}
    <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address', $pasienProfile->alamat) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('address')" />
</div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>