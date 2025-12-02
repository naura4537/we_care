<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule; 
use App\Models\Pasien; 
use App\Models\Dokter; 
use Illuminate\View\View; // Import untuk tipe return

class UserController extends Controller
{
    
    // WAJIB: Method untuk menampilkan daftar pengguna (index/admin/users)
    public function index() 
    {
        $users = User::paginate(15); 
        return view('admin.users.index', compact('users'));
    }

    // WAJIB: Method untuk menampilkan detail pengguna (show/admin/users/{id})
    public function show(User $user) 
    {
        $user->load('pasien', 'dokter'); 
        return view('admin.users.show', compact('user')); 
    }

    /**
     * Menampilkan formulir untuk mengedit pengguna (Admin).
     */
    public function edit(User $user): View // 👈 FUNGSI BARU DITAMBAHKAN
    {
        // Memuat relasi pasien dan dokter
        // Ini memastikan semua data (spesialisasi, tanggal_lahir, dll.) tersedia di view.
        $user->load('pasien', 'dokter'); 
        
        return view('admin.users.edit', compact('user'));
    }

    // --- FUNGSI UPDATE YANG SUDAH DIBENAHI ---
    public function update(Request $request, User $user)
    {
        // 1. VALIDASI DATA
        // ... (kode validasi Anda di sini)
        $rules = [
            'nama' => 'required|string|max:255', 
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)], 
            'role' => 'required|string|in:admin,dokter,pasien', 
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string', 
            'no_telp' => 'nullable|string|max:20', 
            
            // Validasi Dokter
            'spesialisasi' => 'nullable|string|max:100', 
            'riwayat_pendidikan' => 'nullable|string|max:255',
            'no_str' => 'nullable|string|max:20',
            'biaya' => 'nullable|numeric',
            'jadwal' => 'nullable|string',
        ];

        if ($request->filled('password')) { $rules['password'] = 'string|min:8|confirmed'; }
        
        // ⚠️ Tambahkan pembersihan biaya jika Anda menggunakan format mata uang di form edit
        if ($request->has('biaya') && $request->biaya !== null) {
            $request->merge(['biaya' => str_replace('.', '', $request->input('biaya'))]);
        }

        $request->validate($rules); 

        // 2. ASSIGNMENT UNTUK TABEL USERS
        $user->nama = $request->nama; 
        $user->email = $request->email;
        $user->role = $request->role;
        $user->no_telp = $request->no_telp; 
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save(); 

        // 3. ASSIGNMENT UNTUK TABEL RELASI 
        // ⚠️ LOGIKA KRUSIAL: Jika peran berubah, Anda perlu menghapus detail lama dan membuat yang baru, 
        // atau setidaknya memastikan data relasi dibuat jika belum ada.
        
        if ($user->role === 'pasien') {
             // Pastikan pasien detail dibuat jika belum ada
            if (!$user->pasien) { $user->pasien()->create(['user_id' => $user->id]); } 

            $user->pasien()->update([
                'tanggal_lahir' => $request->tanggal_lahir, 
                'jenis_kelamin' => $request->jenis_kelamin, 
                'alamat' => $request->alamat,
            ]);
            
        } elseif ($user->role === 'dokter') {
            // Pastikan dokter detail dibuat jika belum ada
            if (!$user->dokter) { $user->dokter()->create(['user_id' => $user->id]); }
            
            $user->dokter()->update([ 
                'jenis_kelamin' => $request->jenis_kelamin, 
                'spesialisasi' => $request->spesialisasi,
                'riwayat_pendidikan' => $request->riwayat_pendidikan,
                'no_str' => $request->no_str,
                'biaya' => $request->biaya,
                'jadwal' => $request->jadwal,
            ]);
        }
        
        // 4. LOGIKA REDIRECTION 
        // ... (Logika redirection Anda tetap, ini sudah benar) ...
        if (Auth::user()->id === $user->id) {
            if ($user->role === 'dokter') {
                return redirect()->route('dokter.profile.show')->with('success', 'Profil Anda berhasil diperbarui!');
            }
            if ($user->role === 'pasien') {
                return redirect()->route('pasien.profile.show')->with('success', 'Profil Anda berhasil diperbarui!');
            }
            return redirect()->route('admin.users.show', $user)->with('success', 'Profil Anda berhasil diperbarui!');
        }
        
        return redirect()->route('admin.users.show', $user)->with('success', 'Profil pengguna berhasil diperbarui!');
    }

    public function create()
    {
        return view('admin.users.create'); // Pastikan nama view sudah benar
    }
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' mencari input 'password_confirmation'
            'role' => 'required|in:admin,pasien,dokter',
        ]);

        // 2. Simpan ke Database
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Wajib mengenkripsi password
            'role' => $request->role,
        ]);

        // 3. Redirect dan Beri Pesan Sukses
        return redirect()->route('admin.users.index') // Arahkan ke halaman daftar pengguna
                         ->with('success', 'Pengguna baru berhasil ditambahkan!');
    }
    public function destroy($id)
{
    // Cari pengguna berdasarkan ID
    $user = User::findOrFail($id);

    // 1. HAPUS DATA TERKAIT BERDASARKAN ROLE (Tanpa Transaksi)
    // Jika salah satu gagal, yang lain tetap berlanjut
    try {
        if ($user->role === 'pasien') {
            Pasien::where('user_id', $user->id)->delete();
        } else if ($user->role === 'dokter') {
            Dokter::where('user_id', $user->id)->delete();
        }
        
        // 2. HAPUS PENGGUNA DARI TABEL 'users'
        $user->delete();

    } catch (\Exception $e) {
        // Karena tidak ada rollback, kita hanya menampilkan pesan error
        return back()->with('error', 'Gagal menghapus pengguna. Mungkin data terkait tidak terhapus. Error: ' . $e->getMessage());
    }

    // 3. Redirect dan Beri Pesan Sukses
    return redirect()->route('admin.users.index')
                     ->with('success', 'Pengguna dan data terkait berhasil dihapus!');
}
}