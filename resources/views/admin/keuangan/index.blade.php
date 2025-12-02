@extends('layouts.admin')

@section('title', 'Laporan Keuangan - We Care')

@section('styles')
<style>
    /* Container */
    .laporan-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Modern */
    .laporan-header {
        background: linear-gradient(135deg, #70B2B2 0%, #016B61 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .laporan-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .laporan-header h2 {
        margin: 0 0 10px 0;
        font-size: 32px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .laporan-header p {
        margin: 0;
        opacity: 0.95;
        font-size: 16px;
        position: relative;
        z-index: 1;
    }

    /* Filter Section Modern */
    .filter-section {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .filter-label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .filter-select {
        padding: 14px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 15px;
        color: #333;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }

    .filter-select:hover {
        border-color: #70B2B2;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    .filter-select:focus {
        outline: none;
        border-color: #70B2B2;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .btn-filter {
        padding: 14px 35px;
        background: linear-gradient(135deg, #70B2B2 0%, #016B61 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 15px;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-filter:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
    }

    .btn-filter:active {
        transform: translateY(-1px);
    }

    /* Summary Cards Premium */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
    }

    .summary-card.pemasukan::before {
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
    }

    .summary-card.pengeluaran::before {
        background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
    }

    .summary-card.saldo::before {
        background: linear-gradient(90deg, #70B2B2 0%, #016B61 100%);
    }

    .summary-label {
        font-size: 13px;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 800;
        margin: 5px 0;
    }

    .summary-card.pemasukan .summary-value {
        color: #10b981;
    }

    .summary-card.pengeluaran .summary-value {
        color: #ef4444;
    }

    .summary-card.saldo .summary-value {
        color: #70B2B2;
    }

    .summary-subtitle {
        font-size: 13px;
        color: #999;
        margin-top: 5px;
    }

    .summary-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 40px;
        opacity: 0.1;
    }

    /* Table Premium */
    .table-wrapper {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern thead {
        background: linear-gradient(135deg, #70B2B2 0%, #016B61 100%);
    }

    .table-modern thead th {
        padding: 20px;
        text-align: left;
        font-weight: 700;
        color: white;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .table-modern thead th:first-child {
        text-align: center;
        width: 80px;
    }

    .table-modern thead th:nth-child(2) {
        width: 130px;
    }

    .table-modern thead th:nth-child(4),
    .table-modern thead th:nth-child(5) {
        text-align: right;
        width: 180px;
    }

    .table-modern tbody tr {
        transition: all 0.3s;
        border-bottom: 1px solid #70B2B2;
    }

    .table-modern tbody tr:hover {
        background: linear-gradient(90deg, #016B61 0%, #fff 100%);
        transform: scale(1.01);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
    }

    .table-modern tbody tr:last-child {
        border-bottom: none;
    }

    .table-modern tbody td {
        padding: 18px 20px;
        color: #333;
        font-size: 14px;
    }

    .table-modern tbody td:first-child {
        text-align: center;
        font-weight: 700;
        color: #70B2B2;
        font-size: 16px;
    }

    .table-modern tbody td:nth-child(2) {
        font-weight: 600;
        color: #555;
    }

    .table-modern tbody td:nth-child(4),
    .table-modern tbody td:nth-child(5) {
        text-align: right;
        font-weight: 600;
    }

    .amount-pemasukan {
        color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-block;
    }

    .amount-pengeluaran {
        color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-block;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 80px;
        opacity: 0.3;
        margin-bottom: 20px;
    }

    .empty-state p {
        font-size: 16px;
        color: #999;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .summary-cards {
            grid-template-columns: 1fr;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .laporan-header h2 {
            font-size: 24px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .summary-card, .table-wrapper {
        animation: fadeInUp 0.5s ease-out;
    }

    .summary-card:nth-child(1) { animation-delay: 0.1s; }
    .summary-card:nth-child(2) { animation-delay: 0.2s; }
    .summary-card:nth-child(3) { animation-delay: 0.3s; }
    .summary-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection

@section('content')
<div class="laporan-container">
    
    <!-- Header -->
    <div class="laporan-header">
        <h2>💎 Laporan Keuangan </h2>
        <p>Data Laporan Keuangan Pemasukan dan Pengeluaran</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.keuangan') }}">
            <div class="filter-grid">
                <div class="filter-group">
                    <label class="filter-label">📅 Pilih Bulan</label>
                    <select name="bulan" class="filter-select" onchange="this.form.submit()">
                        @foreach($namaBulan as $key => $value)
                            <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">📆 Pilih Tahun</label>
                    <select name="tahun" class="filter-select" onchange="this.form.submit()">
                        @php
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y >= 2020; $y--) {
                                $selected = ($tahun == $y) ? 'selected' : '';
                                echo "<option value='$y' $selected>$y</option>";
                            }
                        @endphp
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button type="submit" class="btn-filter">🔍 Tampilkan Laporan</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-icon">📅</div>
            <div class="summary-label">Periode Laporan</div>
            <div class="summary-value" style="color: #333;">{{ $namaBulan[$bulan] }}</div>
            <div class="summary-subtitle">Tahun {{ $tahun }}</div>
        </div>

        <div class="summary-card pemasukan">
            <div class="summary-icon">💰</div>
            <div class="summary-label">Total Pemasukan</div>
            <div class="summary-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <div class="summary-subtitle">Dari pembayaran konsultasi</div>
        </div>

        <div class="summary-card pengeluaran">
            <div class="summary-icon">💸</div>
            <div class="summary-label">Total Pengeluaran</div>
            <div class="summary-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            <div class="summary-subtitle">Transaksi operasional</div>
        </div>

        <div class="summary-card saldo">
            <div class="summary-icon">📈</div>
            <div class="summary-label">Saldo Akhir</div>
            <div class="summary-value">
                Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
            </div>
            <div class="summary-subtitle">
                {{ ($totalPemasukan - $totalPengeluaran) >= 0 ? '✅ Surplus' : '⚠️ Defisit' }}
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataLaporan as $index => $laporan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan['tanggal'])->format('d/m/Y') }}</td>
                        <td>{{ $laporan['keterangan'] }}</td>
                        <td>
                            @if($laporan['pemasukan'] > 0)
                                <span class="amount-pemasukan">
                                    Rp {{ number_format($laporan['pemasukan'], 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($laporan['pengeluaran'] > 0)
                                <span class="amount-pengeluaran">
                                    Rp {{ number_format($laporan['pengeluaran'], 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">📊</div>
                                <p>Belum ada data transaksi untuk periode ini</p>
                                <p style="font-size: 14px; margin-top: 10px;">Silakan pilih bulan/tahun lain atau tunggu hingga ada transaksi baru</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection