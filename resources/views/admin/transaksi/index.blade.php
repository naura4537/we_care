@extends('layouts.admin')

@section('title', 'Transaksi - We Care')

@section('styles')
<style>
    .transaksi-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        background: #f0f4f0;
        min-height: 100vh;
    }

    /* Header dengan Saldo */
    .transaksi-header {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(1, 107, 97, 0.3);
    }

    .transaksi-header h2 {
        margin: 0 0 15px 0;
        font-size: 18px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .total-saldo {
        font-size: 36px;
        font-weight: 700;
        margin: 10px 0;
    }

    /* Alert Messages */
    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    /* Container untuk 2 kolom */
    .transaksi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* Card untuk Transaksi Masuk & Keluar */
    .transaksi-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .transaksi-card h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-tambah {
        padding: 10px 18px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-tambah:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* List Item Transaksi */
    .transaksi-list {
        max-height: 450px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .transaksi-list::-webkit-scrollbar {
        width: 6px;
    }

    .transaksi-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .transaksi-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .transaksi-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s;
    }

    .transaksi-item:hover {
        background: #f3f4f6;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .transaksi-info {
        flex: 1;
    }

    .transaksi-info .tanggal {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }

    .transaksi-info .keterangan {
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    .transaksi-info .bank {
        font-size: 11px;
        color: #999;
        margin-top: 3px;
    }

    .transaksi-nominal {
        font-size: 16px;
        font-weight: 700;
        margin: 0 15px;
    }

    .nominal-masuk {
        color: #10b981;
    }

    .nominal-keluar {
        color: #ef4444;
    }

    .transaksi-actions {
        display: flex;
        gap: 5px;
    }

    .btn-edit, .btn-delete {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
    }

    .modal.show {
        display: block;
    }

    .modal-content {
        background: white;
        margin: 3% auto;
        padding: 35px;
        border-radius: 15px;
        width: 90%;
        max-width: 550px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-content h3 {
        margin: 0 0 25px 0;
        font-size: 24px;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-group label .required {
        color: #ef4444;
        margin-left: 3px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
        box-sizing: border-box;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #016B61;
        box-shadow: 0 0 0 3px rgba(1, 107, 97, 0.1);
    }

    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(1, 107, 97, 0.4);
    }

    .close {
        font-size: 28px;
        font-weight: bold;
        color: #999;
        cursor: pointer;
        transition: color 0.3s;
    }

    .close:hover {
        color: #333;
    }

    @media (max-width: 992px) {
        .transaksi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="transaksi-container">
    
    <!-- Header dengan Total Saldo -->
    <div class="transaksi-header">
        <h2>Total Saldo</h2>
        <div class="total-saldo">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Grid 2 Kolom -->
    <div class="transaksi-grid">
        
        <!-- Transaksi Masuk (Otomatis dari Pembayaran) -->
        <div class="transaksi-card">
            <h3><span>Transaksi Masuk</span></h3>
            
            <div class="transaksi-list">
                @forelse($transaksiMasuk as $index => $transaksi)
                    <div class="transaksi-item">
                        <div class="transaksi-info">
                            <div class="tanggal">{{ $index + 1 }}. {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</div>
                            <div class="keterangan">{{ $transaksi->keterangan }}</div>
                        </div>
                        <div class="transaksi-nominal nominal-masuk">
                            Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>💰 Belum ada transaksi masuk</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Transaksi Keluar (CRUD) -->
        <div class="transaksi-card">
            <h3>
                <span>Transaksi Keluar</span>
                <button class="btn-tambah" type="button" onclick="openModalTambah()">+ Tambah</button>
            </h3>
            
            <div class="transaksi-list">
                @forelse($transaksiKeluar as $index => $transaksi)
                    <div class="transaksi-item">
                        <div class="transaksi-info">
                            <div class="tanggal">{{ $index + 1 }}. {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i') }}</div>
                            <div class="keterangan">{{ $transaksi->keterangan }}</div>
                            @if($transaksi->bank_tujuan)
                                <div class="bank">🏦 {{ $transaksi->bank_tujuan }}</div>
                            @endif
                        </div>
                        <div class="transaksi-nominal nominal-keluar">
                            Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                        </div>
                        <div class="transaksi-actions">
                            <button class="btn-edit" onclick='editTransaksi(@json($transaksi))'>Edit</button>
                            <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('⚠️ Yakin hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>💸 Belum ada transaksi keluar</p>
                        <p style="font-size: 12px; color: #bbb;">Klik tombol "+ Tambah" untuk menambahkan</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h3>
            <span>Tambah Transaksi Pengeluaran</span>
            <span class="close" onclick="closeModalTambah()">&times;</span>
        </h3>
        <form method="POST" action="{{ route('admin.transaksi.store') }}">
            @csrf
            <div class="form-group">
                <label>Tanggal & Waktu: <span class="required">*</span></label>
                <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Keterangan: <span class="required">*</span></label>
                <input type="text" name="keterangan" class="form-control" required placeholder="Contoh: Pembelian alat medis">
            </div>
            
            <div class="form-group">
                <label>Nominal: <span class="required">*</span></label>
                <input type="number" name="nominal" class="form-control" step="0.01" min="1" required placeholder="50000">
            </div>

            <div class="form-group">
                <label>Bank Tujuan: <span class="required">*</span></label>
                <select name="bank_tujuan" class="form-control" required>
                    <option value="">-- Pilih Bank --</option>
                    <option value="BCA">BCA</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="BSI">BSI (Bank Syariah Indonesia)</option>
                    <option value="CIMB Niaga">CIMB Niaga</option>
                    <option value="Cash">Cash/Tunai</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            
            <button type="submit" class="btn-submit">💸 Kirim Transaksi</button>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h3>
            <span>Edit Transaksi</span>
            <span class="close" onclick="closeModalEdit()">&times;</span>
        </h3>
        <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Tanggal & Waktu: <span class="required">*</span></label>
                <input type="datetime-local" name="tanggal" id="edit_tanggal" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Keterangan: <span class="required">*</span></label>
                <input type="text" name="keterangan" id="edit_keterangan" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Nominal: <span class="required">*</span></label>
                <input type="number" name="nominal" id="edit_nominal" class="form-control" step="0.01" min="1" required>
            </div>

            <div class="form-group">
                <label>Bank Tujuan: <span class="required">*</span></label>
                <select name="bank_tujuan" id="edit_bank" class="form-control" required>
                    <option value="">-- Pilih Bank --</option>
                    <option value="BCA">BCA</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="BSI">BSI</option>
                    <option value="CIMB Niaga">CIMB Niaga</option>
                    <option value="Cash">Cash/Tunai</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            
            <button type="submit" class="btn-submit">✅ Update Transaksi</button>
        </form>
    </div>
</div>

<script>
    function setDefaultDateTime() {
        const now = new Date();
        const datetime = now.toISOString().slice(0, 16);
        document.getElementById('tanggal').value = datetime;
    }

    function openModalTambah() {
        setDefaultDateTime();
        document.getElementById('modalTambah').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModalTambah() {
        document.getElementById('modalTambah').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openModalEdit() {
        document.getElementById('modalEdit').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function editTransaksi(transaksi) {
        const form = document.getElementById('formEdit');
        form.action = `/admin/transaksi/${transaksi.id}`;
        
        document.getElementById('edit_keterangan').value = transaksi.keterangan;
        document.getElementById('edit_nominal').value = transaksi.nominal;
        document.getElementById('edit_bank').value = transaksi.bank_tujuan || '';
        
        const date = new Date(transaksi.tanggal);
        document.getElementById('edit_tanggal').value = date.toISOString().slice(0, 16);
        
        openModalEdit();
    }

    window.onclick = function(event) {
        const modalTambah = document.getElementById('modalTambah');
        const modalEdit = document.getElementById('modalEdit');
        
        if (event.target === modalTambah) closeModalTambah();
        if (event.target === modalEdit) closeModalEdit();
    }

    window.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
@endsection