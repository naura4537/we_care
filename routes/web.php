<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- IMPORT CONTROLLER ADMIN KITA ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\KomentarController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\UserController;
// (Tambahkan controller admin lainnya di sini saat kita membuatnya)
// Controller PASIEN---
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\PasienProfileController;
use App\Http\Controllers\Pasien\DoctorController; 
use App\Http\Controllers\Pasien\DoctorSearchController;
use App\Http\Controllers\Pasien\DoctorDetailController;
use App\Http\Controllers\Pasien\PemesananController;
use App\Http\Controllers\Pasien\PasienKomentarController;
use App\Http\Controllers\Pasien\PasienRiwayatController;
// Controller DOKTER -----
use App\Http\Controllers\Dokter\JadwalController; 
use App\Http\Controllers\Dokter\UlasanPasienController; 
use App\Http\Controllers\Dokter\DokterProfileController;
/*
/*
|--------------------------------------------------------------------------
| Rute Utama (Publik)
|--------------------------------------------------------------------------
*/

// Di file routes/web.php

// Di file routes/web.php
Route::get('/', function () {
    // Langsung tampilkan view 'welcome'
    return view('welcome'); 
})->name('welcome'); // Tambahkan nama rute agar bisa dipanggil dari tombol Login

/*
|--------------------------------------------------------------------------
| Rute Bawaan Breeze (Biarkan Saja)
|--------------------------------------------------------------------------
*/

// Ini adalah halaman /dashboard Bawaan Breeze yang salah
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ini adalah rute untuk halaman profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| GRUP RUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Rute Dashboard & Statis (WIP)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // === RUTE KEUANGAN (LAPORAN PEMASUKAN & PENGELUARAN) ===
    Route::get('/keuangan', [KeuanganController::class, 'index'])
        ->name('keuangan');  

        // === RUTE STATISTIK ===
    Route::get('/statistik', [StatistikController::class, 'index'])
        ->name('statistik');
    
    // API Endpoint untuk AJAX (real-time update)
    Route::get('/statistik/data', [StatistikController::class, 'getData'])
        ->name('statistik.data');
    
    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('transaksi');
    
    Route::post('/transaksi', [TransaksiController::class, 'store'])
        ->name('transaksi.store');
    
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])
        ->name('transaksi.update');
    
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])
        ->name('transaksi.destroy');
    // === RUTE KOMENTAR ===
    Route::get('/komentar', [KomentarController::class, 'index'])
        ->name('komentar');
    
    // API Detail Komentar (AJAX)
    Route::get('/komentar/detail/{id}', [KomentarController::class, 'detail'])
        ->name('komentar.detail');
    
    // Hapus Komentar
    Route::get('/komentar/delete/{id}', [KomentarController::class, 'delete'])
        ->name('komentar.delete');
    
    // Tambah Balasan
    Route::post('/komentar/balasan', [KomentarController::class, 'addBalasan'])
        ->name('komentar.balasan');

    // === RUTE RIWAYAT PASIEN ===
    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])
        ->name('riwayat.show');
    
    // === NOTIFIKASI ===
    Route::get('/notifikasi', [NotifikasiController::class, 'list'])
        ->name('notifikasi.list');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])
        ->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])
        ->name('notifikasi.readAll');

    // Rute CRUD Admin/User (Didefinisikan sekali di sini)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    // Contoh di routes/web.php (Di dalam middleware 'admin')

// Route untuk menampilkan form edit
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// Route untuk menyimpan perubahan
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update'); 
// ATAU Route::patch('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});


/*
|--------------------------------------------------------------------------
| Rute Bawaan Breeze (Modifikasi Profil)
|--------------------------------------------------------------------------
*/
// Rute profil ini harus berada di LUAR grup 'admin'
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Anda TIDAK perlu rute profil edit/update ini di sini,
    // karena sudah diurus oleh Route::resource('users', ...) di atas.
    // HAPUS Rute ini agar tidak konflik:
    // Route::get('/profile/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| GRUP RUTE PASIEN (VERSI BERSIH & FIX)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('pasien')
    ->name('pasien.')
    ->group(function () {

    // --- 1. DASHBOARD ---
    Route::get('/dashboard', [PasienDashboardController::class, 'index'])
        ->name('dashboard');

    // --- 2. FITUR DOKTER (Cari & Pesan) ---
    Route::get('/cari_dokter', [DoctorSearchController::class, 'index'])
        ->name('cari_dokter');
    
    Route::get('/dokter/{id}', [DoctorDetailController::class, 'detail'])
        ->name('dokter_detail');
        
    Route::post('pesanan/buat/{dokter}', [PemesananController::class, 'buatPesanan'])
        ->name('buat_pesanan');

    // --- 3. PEMBAYARAN & KONSULTASI ---
    Route::get('/pembayaran/{pemesanan}', [PemesananController::class, 'showPembayaran'])
        ->name('pembayaran');
        
    Route::post('/konsultasi/{pemesanan}/akhiri', [PemesananController::class, 'endConsultation'])
        ->name('konsultasi.akhiri');

    // --- 4. RIWAYAT & PDF (INI YANG KITA PERBAIKI) ---
    // URL: /pasien/riwayat
    Route::get('/riwayat', [PemesananController::class, 'index'])
        ->name('riwayat'); 

    // URL: /pasien/riwayat/{id}  -> Nama Rute: pasien.riwayat.show
    Route::get('/riwayat/{id}', [PemesananController::class, 'show'])
        ->name('riwayat.show'); 

    // URL: /pasien/riwayat/{id}/pdf -> Nama Rute: pasien.riwayat.pdf
    Route::get('/riwayat/{id}/pdf', [PemesananController::class, 'cetakPdf'])
        ->name('riwayat.pdf');

    // --- 5. BALASAN & RESEP ---
    Route::get('/balasan/{pemesanan}', [PasienRiwayatController::class, 'showBalasan'])
        ->name('balasan.show');
        
    Route::get('/balasan/{pemesanan}/download', [PasienRiwayatController::class, 'downloadBalasan'])
        ->name('balasan.download');

    Route::get('/resep/unduh/{pemesanan}', [PemesananController::class, 'downloadResep'])
        ->name('resep.download');

    // --- 6. KOMENTAR / ULASAN ---
    Route::get('/komentar', [PasienKomentarController::class, 'index'])->name('komentar'); // List komentar saya
    Route::get('/ulasan/beri/{id_dokter}', [PasienKomentarController::class, 'create'])->name('komentar.create'); // Form beri ulasan
    Route::post('/ulasan/simpan/{id_dokter}', [PasienKomentarController::class, 'store'])->name('komentar.store'); // Simpan ulasan

    // 2. TAMBAHKAN RUTE BARU INI (Edit & Hapus) 👇
    Route::get('/ulasan/edit/{id}', [PasienKomentarController::class, 'edit'])->name('komentar.edit');
    Route::put('/ulasan/update/{id}', [PasienKomentarController::class, 'update'])->name('komentar.update');
    Route::delete('/ulasan/hapus/{id}', [PasienKomentarController::class, 'destroy'])->name('komentar.destroy');

    // --- 7. PROFILE ---
    Route::get('/profile/show', [PasienProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [PasienProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/pasien/profile', [PasienProfileController::class, 'update'])->name('profile.update');
     Route::patch('/profile/destroy', [PasienProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| GRUP RUTE DOKTER (VERSI BERSIH FINAL)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {
        
        // Rute DASHBOARD
        Route::get('/dashboard', [\App\Http\Controllers\Dokter\DashboardController::class, 'index'])->name('dashboard');
        
        // --- JADWAL & KONSULTASI ---
        // Anda perlu mengimpor JadwalController di bagian atas file
        Route::get('/jadwal', [\App\Http\Controllers\Dokter\JadwalController::class, 'index'])->name('jadwal.index');
        
        // RUTE BALASAN (Diagnosa & Resep)
        Route::get('/balas/{id}', [\App\Http\Controllers\Dokter\JadwalController::class, 'showBalas'])->name('balas'); 
        Route::post('/balas/{id}', [\App\Http\Controllers\Dokter\JadwalController::class, 'storeBalas'])->name('balas.store'); 

        // --- PROFIL DOKTER ---
        // Anda perlu mengimpor DokterProfileController di bagian atas file
        Route::get('/profile/show', [\App\Http\Controllers\Dokter\DokterProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [\App\Http\Controllers\Dokter\DokterProfileController::class, 'edit'])->name('profile.edit');
        
        // KOREKSI UTAMA: Update harus menggunakan PUT/PATCH, bukan POST. 
        // Jika Anda menggunakan POST di form, ganti method di sini, tapi standar RESTful adalah PUT/PATCH.
        Route::patch('/profile/update', [\App\Http\Controllers\Dokter\DokterProfileController::class, 'update'])->name('profile.update'); 
        
        // --- ULASAN DOKTER KE PASIEN (CRUD) ---
        // Jika UlasanPasienController tidak di-import, tambahkan namespace penuh
        Route::get('/ulasan-pasien', [\App\Http\Controllers\Dokter\UlasanPasienController::class, 'index'])->name('ulasan.index');

        // PENGGUNAAN {pemesanan_id} yang baik
        Route::get('/ulasan-pasien/{pemesanan_id}/create', [\App\Http\Controllers\Dokter\UlasanPasienController::class, 'create'])->name('ulasan.pasien.create');
        Route::post('/ulasan-pasien/{pemesanan_id}', [\App\Http\Controllers\Dokter\UlasanPasienController::class, 'store'])->name('ulasan.pasien.store');
        
        Route::get('/ulasan-pasien/{pemesanan_id}/edit', [\App\Http\Controllers\Dokter\UlasanPasienController::class, 'edit'])->name('ulasan.pasien.edit');
        
        // KOREKSI: Update harus menggunakan PUT/PATCH
        Route::put('/ulasan-pasien/{pemesanan_id}', [\App\Http\Controllers\Dokter\UlasanPasienController::class, 'update'])->name('ulasan.pasien.update');
        
        // KOREKSI: Hapus harus menggunakan DELETE
        Route::delete('/ulasan-pasien/{pemesanan_id}', [\App\Http\Controllers\Dokter\UlasanPasienController::class, 'destroy'])->name('ulasan.pasien.destroy');
    });


/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Biarkan di paling bawah)
|--------------------------------------------------------------------------
*/
// Ini memuat file routes/auth.php (Login, Register, Logout)
require __DIR__.'/auth.php';