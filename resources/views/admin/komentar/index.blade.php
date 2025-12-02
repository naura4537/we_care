@extends('layouts.admin')

@section('title', 'Komentar - We Care')

@section('styles')
<style>
    .komentar-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Filter Tabs */
    .filter-tabs {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        display: flex;
        gap: 15px;
    }

    .tab-button {
        flex: 1;
        padding: 15px 30px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #666;
        text-decoration: none;
    }

    .tab-button:hover {
        border-color: #016B61;
        background: #f0f4f0;
    }

    .tab-button.active {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        border-color: #016B61;
        box-shadow: 0 4px 12px rgba(1, 107, 97, 0.3);
    }

    .tab-button .badge {
        background: rgba(255,255,255,0.3);
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
    }

    .tab-button.active .badge {
        background: rgba(255,255,255,0.3);
    }

    /* Search Bar */
    .search-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-bar input {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
    }

    .search-bar input:focus {
        outline: none;
        border-color: #016B61;
    }

    /* Alert */
    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
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

    /* Komentar List */
    .komentar-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .komentar-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }

    .komentar-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .komentar-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: 700;
    }

    .komentar-info {
        flex: 1;
    }

    .komentar-name {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin-bottom: 3px;
    }

    .komentar-role {
        font-size: 13px;
        color: #666;
    }

    .komentar-date {
        font-size: 12px;
        color: #999;
    }

    .rating-stars {
        display: flex;
        gap: 3px;
    }

    .star {
        color: #ffd700;
        font-size: 18px;
    }

    .star.empty {
        color: #e0e0e0;
    }

    .komentar-content {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .komentar-target {
        background: #f0f4f0;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 13px;
        color: #016B61;
        margin-bottom: 15px;
    }

    .komentar-target strong {
        font-weight: 700;
    }

    .komentar-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-reply, .btn-delete {
        padding: 8px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-reply {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
    }

    .btn-reply:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(1, 107, 97, 0.3);
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .badge-balasan {
        background: rgba(255,255,255,0.3);
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        margin-left: 5px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .empty-state-icon {
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

    /* Modal Balasan */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: #999;
        cursor: pointer;
        line-height: 1;
        transition: all 0.3s;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .modal-close:hover {
        background: #f0f0f0;
        color: #333;
        transform: rotate(90deg);
    }

    .modal-komentar {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .modal-komentar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .modal-komentar-name {
        font-weight: 700;
        color: #333;
    }

    .modal-komentar-rating {
        display: flex;
        gap: 2px;
    }

    .modal-komentar-text {
        color: #555;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .modal-komentar-date {
        font-size: 12px;
        color: #999;
    }

    .balasan-list {
        margin-bottom: 20px;
    }

    .balasan-item {
        background: #e3f2fd;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        border-left: 4px solid #016B61;
    }

    .balasan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .balasan-admin {
        font-weight: 700;
        color: #016B61;
        font-size: 14px;
    }

    .balasan-date {
        font-size: 12px;
        color: #666;
    }

    .balasan-text {
        color: #333;
        line-height: 1.6;
        font-size: 14px;
    }

    .balasan-empty {
        text-align: center;
        padding: 20px;
        color: #999;
        font-style: italic;
    }

    .balasan-form label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .balasan-form textarea {
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        box-sizing: border-box;
    }

    .balasan-form textarea:focus {
        outline: none;
        border-color: #016B61;
    }

    .balasan-form-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        justify-content: flex-end;
    }

    .btn-submit, .btn-cancel {
        padding: 10px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-submit {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(1, 107, 97, 0.3);
    }

    .btn-cancel {
        background: #e0e0e0;
        color: #666;
    }

    .btn-cancel:hover {
        background: #ccc;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-tabs {
            flex-direction: column;
        }

        .komentar-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .rating-stars {
            margin-top: 10px;
        }
    }
</style>
@section('content')
<div class="komentar-container">
    
    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            ❌ {{ session('error' )}}
        </div>
    @endif

    <div class="filter-tabs">
        <a href="{{ route('admin.komentar', ['filter' => 'pasien']) }}" 
           class="tab-button {{ $filter === 'pasien' ? 'active' : '' }}">
            👤 Komentar Pasien
            <span class="badge">{{ $totalPasien }}</span>
        </a>
        <a href="{{ route('admin.komentar', ['filter' => 'dokter']) }}" 
           class="tab-button {{ $filter === 'dokter' ? 'active' : '' }}">
            👨‍⚕️ Komentar Dokter
            <span class="badge">{{ $totalDokter }}</span>
        </a>
    </div>

    <div class="search-bar">
        <span>🔍</span>
        <input type="text" placeholder="Cari nama pasien atau dokter..." id="searchInput">
    </div>

    <div class="komentar-list" id="komentarList">
        @forelse($komentarList as $komentar)
            {{-- Penentuan Kelas: is-dokter-review jika filter = dokter --}}
            <div class="komentar-card {{ $filter === 'dokter' ? 'is-dokter-review' : '' }}" 
                 data-search="{{ strtolower($komentar->nama_pasien . ' ' . $komentar->nama_dokter) }}">
                
                <div class="komentar-header">
                    <div class="avatar">
                        {{ strtoupper(substr($komentar->nama_pasien, 0, 1)) }}
                    </div>
                    <div class="komentar-info">
                        {{-- Name and Role --}}
                        <div class="komentar-name">{{ $komentar->nama_pasien }}</div>
                        <div class="komentar-role">{{ $filter === 'pasien' ? 'Pasien' : 'Dokter' }} ({{ $komentar->id_pasien }})</div>
                        <div class="komentar-date">
                            {{ \Carbon\Carbon::parse($komentar->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>
                    <div class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $komentar->rating ? '' : 'empty' }}">★</span>
                        @endfor
                    </div>
                </div>

                {{-- TARGET / DITUJUKAN KEPADA --}}
                <div class="komentar-target">
                    @if ($filter === 'pasien')
                        <strong>Ditujukan Kepada:</strong> {{ $komentar->nama_dokter }} (Dokter {{ $komentar->id_dokter }})
                    @else
                        <strong>Diberikan Kepada:</strong> {{ $komentar->nama_pasien }} (Pasien {{ $komentar->id_pasien }})
                        | <strong>Dari Dokter:</strong> {{ $komentar->nama_dokter }}
                    @endif
                </div>

                <div class="komentar-content">
                    {{ $komentar->komentar }}
                </div>

                <div class="komentar-actions">
                    <button class="btn-reply" onclick="openBalasanModal({{ $komentar->id }})">
                        💬 Balas
                    </button>
                    <button class="btn-delete" onclick="confirmDelete({{ $komentar->id }})">
                        🗑️ Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">💬</div>
                <h3>Belum Ada Komentar</h3>
                <p>
                    @if($filter === 'pasien')
                        Belum ada komentar dari pasien untuk dokter
                    @else
                        Belum ada komentar dari dokter untuk pasien
                    @endif
                </p>
            </div>
        @endforelse
    </div>

</div>

<div class="modal-overlay" id="modalBalasan">
    <div class="modal-content">
        <div class="modal-header"><h3>Balasan Komentar</h3><button class="modal-close" onclick="closeBalasanModal()">×</button></div>
        <div class="modal-komentar" id="komentarOriginal"></div>
        <div class="balasan-list" id="balasanList"></div>
        <div class="balasan-form">
            <form method="POST" action="{{ route('admin.komentar.balasan') }}" id="formBalasan">
                @csrf
                <input type="hidden" name="id_komentar" id="inputIdKomentar">
                <input type="hidden" name="filter" value="{{ $filter }}">
                <label>Tulis Balasan:</label>
                <textarea name="balasan" id="textBalasan" placeholder="Tulis balasan Anda di sini..." required></textarea>
                <div class="balasan-form-actions">
                    <button type="button" class="btn-cancel" onclick="closeBalasanModal()">Batal</button>
                    <button type="submit" class="btn-submit">📤 Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // -----------------------------------------------------------
    // JAVASCRIPT LOGIC
    // -----------------------------------------------------------
    
    // Fungsi dasar Modal (Asumsi Anda sudah punya definisinya)
    function closeBalasanModal() {
        document.getElementById('modalBalasan').classList.remove('active');
    }
    
    // Search functionality (Filtering cards based on text)
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.komentar-card');
        
        cards.forEach(card => {
            const searchData = card.getAttribute('data-search');
            if (searchData && searchData.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Confirmation for delete (Needs to be defined globally if using onclick)
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
            const filter = '{{ $filter }}';
            window.location.href = `/admin/komentar/delete/${id}?filter=${filter}`;
        }
    }
    
    // --- FUNGSIONALITAS MODAL BALASAN (Requires implementation of openBalasanModal) ---
    // Note: Anda harus menambahkan fungsi openBalasanModal(idKomentar) yang memuat data via AJAX
</script>
@endsection