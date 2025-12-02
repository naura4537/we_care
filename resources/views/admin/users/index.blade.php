@extends('layouts.admin')

@section('content')
    <div class="custom-content-box">
        <h3 class="box-title">Daftar Pengguna</h3>

        {{-- PERBAIKAN 1: Pastikan blok IF ditutup dengan @endif --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif 

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Pastikan data users tidak kosong sebelum loop --}}
                @forelse ($users as $user) 
                    <tr>
                        {{-- PERBAIKAN 2: Menggunakan kolom nama --}}
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nama }}</td> 
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">Lihat</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data pengguna yang ditemukan.</td>
                    </tr>
                @endforelse {{-- PERBAIKAN 3: Menggunakan @endforelse sebagai penutup --}}
            </tbody>
        </table>
        
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="margin-top: 20px;">Tambah Pengguna Baru</a>
    </div>
@endsection