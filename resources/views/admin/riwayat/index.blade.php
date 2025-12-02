@extends('layouts.admin')

@section('title', 'Riwayat Pasien - We Care')

@section('styles')
<style>
    /* CSS ANDA YANG SUDAH DISEDIAKAN */
    .riwayat-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header */
    .riwayat-header {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        padding: 35px 40px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 8px 30px rgba(1, 107, 97, 0.3);
    }

    .riwayat-header h2 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .riwayat-header p {
        margin: 0;
        opacity: 0.95;
        font-size: 15px;
    }

    /* Search Section */
    .search-section {
        background: white;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-input {
        flex: 1;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #016B61;
        box-shadow: 0 0 0 3px rgba(1, 107, 97, 0.1);
    }

    .btn-search {
        padding: 12px 30px;
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(1, 107, 97, 0.3);
    }

    /* Alert */
    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
    }

    .data-table thead th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 700;
        color: white;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table thead th:first-child {
        text-align: center;
        width: 60px;
    }

    .data-table tbody tr {
        transition: all 0.2s;
        border-bottom: 1px solid #f0f0f0;
    }

    .data-table tbody tr:hover {
        background: #f8fffe;
        transform: scale(1.005);
    }

    .data-table tbody tr:last-child {
        border-bottom: none;
    }

    .data-table tbody td {
        padding: 18px 20px;
        color: #333;
        font-size: 14px;
    }

    .data-table tbody td:first-child {
        text-align: center;
        font-weight: 700;
        color: #016B61;
        font-size: 15px;
    }

    /* Badge */
    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-pasien {
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-dokter {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .badge-status {
        background: #d4edda;
        color: #155724;
    }

    /* Action Button */
    .btn-detail {
        padding: 8px 20px;
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(1, 107, 97, 0.3);
    }

    /* Pagination */
    .pagination-container {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 14px;
        color: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-section {
            flex-direction: column;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            min-width: 800px;
        }
    }
</style>
@endsection

@section('content')
<div class="riwayat-container">
    
    <div class="riwayat-header">
        <h2>
            <span>📋</span>
            Riwayat Pasien
        </h2>
        <p>Data lengkap riwayat konsultasi, diagnosis, dan penanganan pasien</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="search-section">
        <form method="GET" action="{{ route('admin.riwayat') }}" style="display: flex; gap: 15px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                class="search-input" 
                placeholder="🔍 Cari pasien, ID pasien, atau nama dokter..." 
                value="{{ $search ?? '' }}"
            >
            <button type="submit" class="btn-search">Cari</button>
            @if($search)
                <a href="{{ route('admin.riwayat') }}" class="btn-search" style="background: #666;">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Diagnosis</th>
                    <th>Resep/Saran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatList as $index => $riwayat)
                    <tr>
                        <td>{{ $riwayatList->firstItem() + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($riwayat->waktu_janji)->locale('id')->translatedFormat('d M Y, H:i') }}</td>
                        <td>
                            <div>
                                {{-- Nama Pasien (User) --}}
                                <strong>{{ $riwayat->user->nama ?? 'N/A' }}</strong>
                                <br>
                                {{-- ID Pasien (dari tabel pasiens, jika ada) --}}
                                <span class="badge badge-pasien">User ID: {{ $riwayat->user_id }}</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                {{-- Nama Dokter (User Dokter) --}}
                                <strong>{{ $riwayat->dokter->user->nama ?? 'N/A' }}</strong>
                                <br>
                                <span class="badge badge-dokter">{{ $riwayat->dokter->spesialisasi ?? 'Umum' }}</span>
                            </div>
                        </td>
                        <td>
                            {{-- DIAGNOSA (Ambil dari kolom diagnosa di Pemesanan) --}}
                            {{ Str::limit($riwayat->diagnosa ?? 'Belum ada diagnosis', 50) }}
                        </td>
                        <td>
                            {{-- RESEP (Ambil dari kolom resep di Pemesanan) --}}
                            {{ Str::limit($riwayat->resep ?? 'Belum ada resep', 50) }}
                        </td>
                        <td>
                            <span class="badge badge-status">{{ ucfirst($riwayat->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.riwayat.show', $riwayat->id) }}" class="btn-detail">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">📋</div>
                                <h3>Belum Ada Riwayat Selesai</h3>
                                <p>Tidak ada data konsultasi yang sudah lengkap (berstatus 'Selesai').</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(isset($riwayatList) && $riwayatList->hasPages())
            <div class="pagination-container">
                {{ $riwayatList->appends(['search' => $search ?? ''])->links() }}
            </div>
        @endif
    </div>

</div>
@endsection