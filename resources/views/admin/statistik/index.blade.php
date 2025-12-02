@extends('layouts.admin')

@section('title', 'Statistik - We Care')

@section('styles')
<style>
    /* CSS ANDA YANG SUDAH DISEDIAKAN */
    .statistik-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .statistik-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    /* Chart Card */
    .chart-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        position: relative;
    }

    .chart-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-header h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .last-update {
        font-size: 12px;
        color: #666;
        background: #f0f4f0;
        padding: 5px 12px;
        border-radius: 20px;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: none;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        z-index: 10;
    }

    .loading-overlay.active {
        display: flex;
    }

    .spinner {
        border: 4px solid #f0f0f0;
        border-top: 4px solid #016B61;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Bar Chart */
    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 300px;
        padding: 20px 0;
        border-bottom: 3px solid #333;
        position: relative;
    }

    .y-axis {
        position: absolute;
        left: -40px;
        top: 0;
        bottom: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 12px;
        color: #666;
    }

    .bar-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        max-width: 80px;
    }

    .bar {
        width: 50px;
        background: linear-gradient(180deg, #016B61 0%, #70B2B2 100%);
        border-radius: 8px 8px 0 0;
        position: relative;
        transition: all 0.5s ease;
    }

    .bar:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(1, 107, 97, 0.3);
    }

    .bar-value {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 13px;
        font-weight: 700;
        color: #016B61;
        white-space: nowrap;
    }

    .bar-label {
        margin-top: 15px;
        font-size: 12px;
        color: #666;
        font-weight: 600;
        text-align: center;
    }

    /* Detail Card */
    .detail-card {
        background: #f0f4f0;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        position: relative;
    }

    .detail-header {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
    }

    .detail-header h3 {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: 600;
    }

    .detail-header .date-range {
        font-size: 12px;
        opacity: 0.9;
    }

    .detail-list {
        background: white;
        border-radius: 10px;
        padding: 15px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-day {
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    .detail-count {
        font-size: 14px;
        font-weight: 700;
        color: #016B61;
    }

    .detail-total {
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        padding: 15px;
        border-radius: 10px;
        margin-top: 15px;
        text-align: center;
    }

    .detail-total .label {
        font-size: 13px;
        margin-bottom: 5px;
        opacity: 0.9;
    }

    .detail-total .value {
        font-size: 28px;
        font-weight: 700;
        transition: all 0.3s;
    }

    /* Filter Form */
    .filter-form {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
    }

    .filter-form .form-group {
        flex: 1;
        min-width: 150px;
    }

    .filter-form label {
        display: block;
        font-size: 13px;
        color: #666;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .filter-form input {
        width: 100%;
        padding: 10px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .filter-form input:focus {
        outline: none;
        border-color: #016B61;
    }

    .filter-form button {
        padding: 10px 25px;
        background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .filter-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(1, 107, 97, 0.3);
    }
    
    .filter-form button:active {
        transform: translateY(0);
    }
    
    #autoRefreshBtn {
        transition: all 0.3s;
    }
    
    #autoRefreshBtn.off {
        background: linear-gradient(135deg, #666 0%, #444 100%);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .statistik-content {
            grid-template-columns: 1fr;
        }

        .filter-form {
            flex-direction: column;
        }

        .filter-form .form-group {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="statistik-container">
    
    <div class="filter-form">
        <div class="form-group">
            <label>Tanggal Mulai:</label>
            {{-- Nama input harus 'start_date' agar controller menangkapnya --}}
            <input type="date" id="startDate" value="{{ $startDate }}" name="start_date"> 
        </div>
        <div class="form-group">
            <label>Tanggal Selesai:</label>
             {{-- Nama input harus 'end_date' agar controller menangkapnya --}}
            <input type="date" id="endDate" value="{{ $endDate }}" name="end_date">
        </div>
        <button type="button" onclick="applyFilter()">📊 Tampilkan</button>
        <button type="button" onclick="manualRefresh()">🔄 Refresh</button>
        <button type="button" id="autoRefreshBtn" onclick="toggleAutoRefresh()">
            🔄 Auto: ON
        </button>
    </div>

    <div class="statistik-content">
        
        <div class="chart-card">
            <div class="loading-overlay" id="chartLoading">
                <div class="spinner"></div>
            </div>
            
            <div class="chart-header">
                <h2>Kunjungan Pasien</h2>
                <span class="last-update" id="lastUpdate">
                    Update: {{ now()->format('H:i:s') }}
                </span>
            </div>

            <div class="bar-chart" id="barChart">
                @php
                    $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                    
                    // Susun data lengkap
                    $finalData = [];
                    foreach ($hariList as $h) {
                        $finalData[$h] = $kunjunganPerHari[$h] ?? 0;
                    }
                    
                    // Max value untuk scaling
                    $maxValue = max($finalData);
                    if ($maxValue < 1) {
                        $maxValue = 5; // Minimal 5 untuk axis yang terlihat bagus
                    }
                    
                    // Step Y-axis (5 level)
                    $step = ceil($maxValue / 5);
                    
                    // TINGGI BAR MAKSIMAL (dalam pixel)
                    $maxHeight = 250;
                @endphp
                
                <div class="y-axis" id="yAxis">
                    @for ($i = 5; $i >= 0; $i--)
                        <span>{{ $step * $i }}</span>
                    @endfor
                </div>

                @foreach($finalData as $hari => $jumlah)
                    @php
                        // Hitung tinggi bar berdasarkan proporsi
                        if ($maxValue > 0) {
                            $heightBar = ($jumlah / $maxValue) * $maxHeight;
                        } else {
                            $heightBar = 0;
                        }
                        
                        // Minimal 3px supaya terlihat (bahkan untuk nilai 0)
                        if ($heightBar < 3 && $jumlah > 0) {
                            $heightBar = 3;
                        }
                    @endphp

                    <div class="bar-item" data-hari="{{ $hari }}">
                        <div class="bar" style="height: {{ $heightBar }}px;">
                            <div class="bar-value">{{ $jumlah }}</div>
                        </div>
                        <div class="bar-label">{{ $hari }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="detail-card">
            <div class="loading-overlay" id="detailLoading">
                <div class="spinner"></div>
            </div>
            
            <div class="detail-header">
                <h3>Kunjungan Pasien</h3>
                <div class="date-range" id="dateRange">
                    {{-- FIX: Menggunakan variabel dinamis --}}
                    {{ $startDateDisplay }} - {{ $endDateDisplay }}
                </div>
            </div>

            <div class="detail-list" id="detailList">
                @foreach($finalData as $hari => $jumlah)
                    <div class="detail-item" data-hari="{{ $hari }}">
                        <span class="detail-day">{{ $hari }}</span>
                        <span class="detail-count">: {{ $jumlah }} Pasien</span>
                    </div>
                @endforeach
            </div>

            <div class="detail-total">
                <div class="label">Total</div>
                <div class="value" id="totalValue">: {{ $totalKunjungan }} Pasien</div>
            </div>
        </div>

    </div>

</div>

<script>
    let autoRefreshInterval;
    let isAutoRefreshEnabled = true;
    
    // Ambil data via AJAX
    async function fetchData(startDate, endDate) {
        // Tampilkan loading saat fetch data
        document.getElementById('chartLoading').classList.add('active');
        document.getElementById('detailLoading').classList.add('active');
        
        try {
            const response = await fetch(`{{ route('admin.statistik.data') }}?start_date=${startDate}&end_date=${endDate}`);
            const result = await response.json();
            
            if (result.success) {
                // Update DOM elements
                updateChart(result.data);
                updateDetailList(result.data);
                updateLastUpdate(result.data.timestamp);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            // Sembunyikan loading setelah fetch selesai
            document.getElementById('chartLoading').classList.remove('active');
            document.getElementById('detailLoading').classList.remove('active');
        }
    }
    
    // Update chart dengan animasi
    function updateChart(data) {
        const kunjungan = data.kunjunganPerHari;
        const values = Object.values(kunjungan);
        const maxValue = Math.max(...values, 5);
        const maxHeight = 250;
        
        // Update Y-axis
        const step = Math.ceil(maxValue / 5);
        const yAxis = document.getElementById('yAxis');
        yAxis.innerHTML = '';
        for (let i = 5; i >= 0; i--) {
            const span = document.createElement('span');
            span.textContent = step * i;
            yAxis.appendChild(span);
        }
        
        // Update bars
        Object.keys(kunjungan).forEach(hari => {
            const jumlah = kunjungan[hari];
            const barItem = document.querySelector(`#barChart .bar-item[data-hari="${hari}"]`);
            
            if (barItem) {
                const bar = barItem.querySelector('.bar');
                const barValue = barItem.querySelector('.bar-value');
                
                let heightBar = 0;
                if (maxValue > 0) {
                    heightBar = (jumlah / maxValue) * maxHeight;
                }
                
                if (heightBar < 3 && jumlah > 0) {
                    heightBar = 3;
                }
                
                // Animasi tinggi bar
                bar.style.height = heightBar + 'px';
                barValue.textContent = jumlah;
            }
        });
    }
    
    // Update detail list
    function updateDetailList(data) {
        const kunjungan = data.kunjunganPerHari;
        const detailList = document.getElementById('detailList');
        
        // Clear the current list
        detailList.innerHTML = ''; 

        // Update tanggal di header detail card
        const startDateDisplay = new Date(data.startDate).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}).replace(/(\s\d{4})/, '');
        const endDateDisplay = new Date(data.endDate).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});

        // Note: Logic ini kompleks karena Carbon formatnya di-backend. Kita ambil string yang sudah diformat dari server jika bisa, atau pakai JS
        // Karena API tidak mengembalikan string display, kita buat manual di JS
        document.getElementById('dateRange').textContent = `${data.startDate.split('-').reverse().join('-')} - ${data.endDate.split('-').reverse().join('-')}`; 
        
        // Membangun ulang list harian
        Object.keys(kunjungan).forEach(hari => {
            const jumlah = kunjungan[hari];
            const div = document.createElement('div');
            div.className = 'detail-item';
            div.setAttribute('data-hari', hari);

            div.innerHTML = `
                <span class="detail-day">${hari}</span>
                <span class="detail-count">: ${jumlah} Pasien</span>
            `;
            detailList.appendChild(div);
        });

        // Update total
        document.getElementById('totalValue').textContent = `: ${data.totalKunjungan} Pasien`;
        // Catatan: Variabel startDateDisplay dan endDateDisplay sudah didefinisikan di controller dan dikirim di API
        // Update Tanggal di Header Detail: Menggunakan data mentah dari API untuk menghindari parsing error
        const startDisp = new Date(data.startDate).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        const endDisp = new Date(data.endDate).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        document.getElementById('dateRange').textContent = `${startDisp.replace('2025', '')} - ${endDisp.replace('2025', '')}`;
    }
    
    // Update last update time
    function updateLastUpdate(timestamp) {
        // Format timestamp dari API
        const date = new Date(timestamp);
        const timeString = date.toLocaleTimeString('id-ID');
        document.getElementById('lastUpdate').textContent = `Update: ${timeString}`;
    }
    
    // Apply filter function
    function applyFilter() {
        // Memastikan format input tanggal yang dikirim ke Controller adalah YYYY-MM-DD
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        // Cek jika input kosong, gunakan default
        if (!startDate || !endDate) {
            alert('Mohon isi kedua kolom tanggal.');
            return;
        }

        fetchData(startDate, endDate);
    }
    
    // Manual refresh function
    function manualRefresh() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        fetchData(startDate, endDate);
    }
    
    // Show loading
    function showLoading() {
        document.getElementById('chartLoading').classList.add('active');
        document.getElementById('detailLoading').classList.add('active');
    }
    
    // Hide loading
    function hideLoading() {
        document.getElementById('chartLoading').classList.remove('active');
        document.getElementById('detailLoading').classList.remove('active');
    }
    
    // Start auto-refresh (setiap 30 detik)
    function startAutoRefresh() {
        isAutoRefreshEnabled = true;
        
        if (autoRefreshInterval) clearInterval(autoRefreshInterval); 
        
        autoRefreshInterval = setInterval(() => {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            // Hanya refresh jika tanggal sudah ada (tidak kosong)
            if (startDate && endDate) {
                fetchData(startDate, endDate); 
            }
        }, 30000);
        updateRefreshButton();
    }
    
    // Stop auto-refresh
    function stopAutoRefresh() {
        isAutoRefreshEnabled = false;
        clearInterval(autoRefreshInterval);
        updateRefreshButton();
    }
    
    // Toggle auto-refresh
    function toggleAutoRefresh() {
        if (isAutoRefreshEnabled) {
            stopAutoRefresh();
        } else {
            startAutoRefresh();
        }
    }
    
    // Update button tampilan
    function updateRefreshButton() {
        const button = document.getElementById('autoRefreshBtn');
        if (isAutoRefreshEnabled) {
            button.innerHTML = '🔄 Auto: ON';
            button.classList.remove('off');
        } else {
            button.innerHTML = '⏸️ Auto: OFF';
            button.classList.add('off');
        }
    }
    
    // Initialize
    window.addEventListener('DOMContentLoaded', function() {
        // Ambil tanggal default yang disematkan PHP
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        // Panggil fetchData awal saat halaman dimuat
        fetchData(startDate, endDate); 
        startAutoRefresh();
    });
    
    // Cleanup
    window.addEventListener('beforeunload', function() {
        stopAutoRefresh();
    });
</script>
@endsection