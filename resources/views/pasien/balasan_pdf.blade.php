<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Konsultasi #{{ $pemesanan->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-box { border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; }
        .info-box h4 { margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .diagnosa, .resep { border: 1px solid #ddd; padding: 10px; margin-top: 10px; }
        .diagnosa { background-color: #e6ffe6; border-left: 5px solid #009900; }
        .resep { background-color: #ffe6e6; border-left: 5px solid #cc0000; }
        .clearfix::after { content: ""; clear: both; display: table; }
        .float-left { float: left; width: 48%; }
        .float-right { float: right; width: 48%; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Riwayat Balasan Konsultasi</h2>
        <p>Tanggal Konsultasi: {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->format('d F Y, H:i') }}</p>
    </div>

    <div class="info-box">
        <h4>Detail Pemesanan #{{ $pemesanan->id }}</h4>
        <p><strong>Pasien:</strong> {{ $pemesanan->pasien->user->name ?? 'N/A' }}</p>
        <p><strong>Dokter:</strong> Dr. {{ $pemesanan->dokter->user->name ?? 'N/A' }}</p>
        <p><strong>Waktu Janji:</strong> {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->format('d F Y, H:i') }}</p>
        <p><strong>Keluhan:</strong> {{ $pemesanan->keluhan_pasien }}</p>
    </div>

    <h3>Hasil Konsultasi Dokter</h3>
    
    <div class="clearfix">
        <div class="float-left">
            <div class="diagnosa">
                <h4>Diagnosa Medis:</h4>
                <p style="white-space: pre-wrap;">{{ $pemesanan->diagnosa ?? 'Diagnosa Belum Ditambahkan.' }}</p>
            </div>
        </div>

        <div class="float-right">
            <div class="resep">
                <h4>Resep Obat dan Tindakan:</h4>
                <p style="white-space: pre-wrap;">{{ $pemesanan->resep ?? 'Resep Belum Ditambahkan.' }}</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px; clear: both;">
        <hr>
    </div>

    <div class="info-box">
        <h4>Detail Transaksi</h4>
        <p><strong>Nominal Biaya:</strong> Rp{{ number_format($pemesanan->nominal ?? 0, 0, ',', '.') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $pemesanan->metode_pembayaran ?? 'N/A' }}</p>
        <p><strong>Status Konsultasi:</strong> {{ $pemesanan->status ?? 'Selesai' }}</p>
    </div>

    <div style="margin-top: 40px; text-align: right;">
        <p>Hormat kami,</p>
        <br><br>
        <p>Dr. {{ $pemesanan->dokter->user->name ?? 'N/A' }}</p>
    </div>

</body>
</html>