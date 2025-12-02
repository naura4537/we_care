@extends('layouts.pasien')

@section('content')
<div class="komentar-container">
    
    {{-- HEADER HALAMAN --}}
    <div class="header-section">
        <h2 class="title">Riwayat Ulasan Saya</h2>
        <p class="subtitle">Daftar penilaian yang pernah Anda berikan.</p>
        
        {{-- TOMBOL TAMBAH ULASAN --}}
        <a href="{{ route('pasien.cari_dokter') }}" 
           class="btn-add-review">
            + Beri Ulasan Baru
        </a>
    </div>

    {{-- ALERT SUKSES --}}
    @if (session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- LIST KOMENTAR --}}
    <div class="table-card">
        @if ($komentars->isEmpty())
            {{-- TAMPILAN JIKA KOSONG --}}
            <div class="empty-state">
                <div class="empty-icon">💬</div>
                <h3 class="empty-title">Belum Ada Ulasan</h3>
                <p class="empty-text">Anda belum pernah memberikan penilaian untuk dokter manapun.</p>
                <a href="{{ route('pasien.cari_dokter') }}" class="link-action">
                    Cari Dokter untuk Diulas &rarr;
                </a>
            </div>
        @else
            {{-- TABEL DATA --}}
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Dokter</th>
                            <th>Ulasan & Rating</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komentars as $index => $komentar)
                        <tr class="data-row">
                            <td class="col-no">{{ $index + 1 }}</td>
                            
                            <td class="col-dokter">
                                <div class="dokter-name">
                                    {{-- FIX: Mengakses Nama melalui relasi Dokter dan User, menggunakan 'nama' --}}
                                    {{ optional(optional($komentar->dokter)->user)->nama ?? 'Dokter Tidak Ditemukan' }}
                                </div>
                            </td>
                            
                            <td class="col-ulasan">
                                <div class="rating-display">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star-symbol {{ $i <= $komentar->rating ? 'filled' : '' }}">★</span>
                                    @endfor
                                    <span class="rating-value">({{ $komentar->rating }}/5)</span>
                                </div>
                                <p class="comment-text">{{Str::limit($komentar->komentar, 50) }}</p>
                            </td>
                            
                            <td class="col-tanggal">
                                <span class="date">{{ $komentar->created_at->format('d M Y') }}</span>
                                <span class="time">{{ $komentar->created_at->format('H:i') }} WIB</span>
                            </td>
                            
                            <td class="col-aksi">
                                <div class="action-buttons-group">
                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('pasien.komentar.edit', $komentar->id) }}" 
                                    class="btn-action btn-edit">
                                        Edit
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('pasien.komentar.destroy', $komentar->id) }}" method="POST" 
                                        onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');" 
                                        style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
/* ------------------------------------------------ */
/* CUSTOM CSS FOR CLEAN TABLE VIEW */
/* ------------------------------------------------ */

.komentar-container {
    padding: 30px 20px;
}

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.subtitle {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.btn-add-review {
    background-color: #0d9488;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(13, 148, 136, 0.3);
    transition: transform 0.3s;
}

.btn-add-review:hover {
    transform: translateY(-2px);
}

/* TABLE STYLING */
.table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    border: 1px solid #e0e0e0;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    background-color: #f3f4f6;
    color: #4b5563;
    padding: 15px 20px;
    font-size: 11px;
    font-weight: 700;
    text-align: left;
    text-transform: uppercase;
    border-bottom: 2px solid #e0e0e0;
}

.data-row {
    transition: background-color 0.2s;
    border-bottom: 1px solid #f0f0f0;
}

.data-row:hover {
    background-color: #fafafa;
}

.data-table tbody td {
    padding: 15px 20px;
    font-size: 14px;
    color: #333;
}

/* Column Specifics */
.col-no {
    width: 50px;
    text-align: center;
    font-weight: bold;
    color: #0d9488;
}

.col-ulasan {
    width: 35%;
}

.comment-text {
    color: #666;
    font-style: italic;
    margin-top: 5px;
}

/* Rating */
.rating-display {
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 5px;
}

.star-symbol {
    font-size: 18px;
}

.star-symbol.filled {
    color: #FFD700;
}

.star-symbol {
    color: #e0e0e0;
}

.rating-value {
    color: #999;
    font-size: 12px;
    margin-left: 5px;
}

/* Action Button */
.action-buttons-group {
    display: flex;
    gap: 8px;
    white-space: nowrap;
}

.btn-action {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-edit {
    background-color: #FFF3E0; /* Light Orange */
    color: #FF9800;
    border: 1px solid #FFCC80;
}

.btn-delete {
    background-color: #FFEBEE; /* Light Red */
    color: #E53935;
    border: 1px solid #FFCDD2;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px;
}

.empty-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.link-action {
    color: #0d9488;
    font-weight: bold;
    text-decoration: none;
    margin-top: 15px;
    display: inline-block;
}

</style>
@endsection