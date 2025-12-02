<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Profil Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Bagian Utama: Edit Data User & Data Pasien --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-2xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Informasi Akun dan Detail Pasien
                    </h3>
                    
                    {{-- Ganti @include('profile.partials.update-profile-information-form') --}}
                    {{-- Dengan form tunggal yang mencakup USER (Nama/Email) + PASIEN (Tgl Lahir/Jenis Kelamin/Alamat) --}}
                    
                    <form method="POST" action="{{ route('pasien.profile.update') }}" class="mt-6 space-y-6"> 
                        @csrf
                        @method('PUT') 

                        {{-- 1. DATA USER (Tabel 'users') --}}
                        
                        <div>
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $user->nama)" required autofocus autocomplete="nama" />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        
                        <div>
                            <x-input-label for="no_telp" :value="__('Nomor Telepon')" />
                            <x-text-input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full" :value="old('no_telp', $user->no_telp)" autocomplete="no_telp" />
                            <x-input-error class="mt-2" :messages="$errors->get('no_telp')" />
                        </div>
                        
                        <hr class="border-gray-700">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 pt-4">Detail Pasien</h4>
                        
                        {{-- 2. DATA PASIEN (Tabel 'pasiens') --}}
                        
                        @php
                            // Mengakses data relasi pasien. Gunakan optional() untuk mencegah error jika relasi belum ada.
                            $pasienProfile = optional($user->pasiens);
                        @endphp
                        
                        {{-- Input Tanggal Lahir (Menggunakan 'tanggal_lahir' sesuai database) --}}
                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" type="date" name="tanggal_lahir" 
                                          class="mt-1 block w-full"
                                          :value="old('tanggal_lahir', $pasienProfile->tanggal_lahir)" />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                        </div>

                        {{-- Input Jenis Kelamin (Menggunakan 'jenis_kelamin' sesuai database) --}}
                        <div>
                            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                            @php
                                $selectedGender = old('jenis_kelamin', $pasienProfile->jenis_kelamin);
                            @endphp
                            <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" @if($selectedGender == 'Laki-laki') selected @endif>Laki-laki</option>
                                <option value="Perempuan" @if($selectedGender == 'Perempuan') selected @endif>Perempuan</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                        </div>

                        {{-- Input Alamat (Menggunakan 'address' di form, yang dipetakan ke 'alamat' di Controller) --}}
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" />
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address', $pasienProfile->alamat) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                            @endif
                        </div>
                    </form>
                    
                </div>
            </div>

            {{-- Bagian Ubah Password (Dipertahankan) --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Bagian Hapus Akun (Dipertahankan) --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>