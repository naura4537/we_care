<!DOCTYPE html>
<html>
<head>
    <title>Invoice & Laporan Medis - #{{ $pemesanan->id }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; color: #333; font-size: 14px; }
        .header { text-align: center; border-bottom: 3px solid #009688; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #009688; text-transform: uppercase; }
        .sub-header { font-size: 12px; color: #666; margin-top: 5px; }
        
        .title { text-align: center; margin-bottom: 20px; font-size: 18px; text-decoration: underline; font-weight: bold; }
        
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 150px; }
        
        /* Kotak untuk Keluhan, Diagnosa, Resep */
        .box { border: 1px solid #ccc; padding: 10px; border-radius: 5px; margin-bottom: 15px; background-color: #fcfcfc; }
        .box h4 { margin: 0 0 5px 0; color: #009688; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }
        .box p { margin: 0; }

        /* Bagian Biaya */
        .total-box { text-align: right; margin-top: 20px; border-top: 2px solid #333; padding-top: 10px; }
        .total-amount { font-size: 18px; font-weight: bold; color: #d32f2f; }

        .footer { margin-top: 40px; text-align: right; font-size: 10px; color: #888; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">We Care</div>
        <div class="sub-header">Dokumen Resmi Layanan Telemedicine</div>
    </div>

    <div class="title">LAPORAN KONSULTASI & BUKTI BAYAR</div>

    <table class="info-table">
        <tr>
            <td class="label">No. Transaksi</td>
            <td>: #{{ $pemesanan->id }}</td>
        </tr>
        <tr>
            <td class="label">Waktu Konsultasi</td>
            {{-- Mengambil dari kolom 'waktu_janji' sesuai database --}}
            <td>: {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->isoFormat('D MMMM Y, HH:mm') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Pasien</td>
            <td>: {{ $pemesanan->pasien->name ?? $pemesanan->user->name ?? 'Pasien Umum' }}</td>
        </tr>
        <tr>
            <td class="label">Dokter</td>
            <td>: {{ $pemesanan->dokter->nama_dokter ?? 'Dokter Umum' }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>: {{ $pemesanan->status }}</td>
        </tr>
    </table>

    {{-- KELUHAN PASIEN (Sesuai kolom database 'keluhan_pasien') --}}
    <div class="box">
        <h4>Keluhan Pasien</h4>
        <p>{{ $pemesanan->keluhan_pasien ?? '-' }}</p>
    </div>

    {{-- DIAGNOSA --}}
    <div class="box">
        <h4>Diagnosa Dokter</h4>
        <p>{{ $pemesanan->diagnosa ?? 'Belum ada diagnosa' }}</p>
    </div>

    {{-- RESEP --}}
    <div class="box">
        <h4>Resep & Catatan Obat</h4>
        <p>{{ $pemesanan->resep ?? 'Tidak ada resep obat' }}</p>
    </div>

    {{-- NOMINAL / BIAYA (Sesuai kolom database 'nominal') --}}
    <div class="total-box">
        Total Biaya: 
        <span class="total-amount">
            Rp {{ number_format($pemesanan->nominal, 0, ',', '.') }}
        </span>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
        <p>Terima kasih telah mempercayakan kesehatan Anda pada We Care.</p>
    </div>

</body>
</html>