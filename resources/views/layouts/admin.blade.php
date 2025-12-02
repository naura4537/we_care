<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - We Care')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @vite(['resources/css/style.css', 'resources/js/main.js']) 
    
    {{-- Support untuk @section('styles') --}}
    @yield('styles')
    
    @stack('page-styles')

    <style>
        /* Notification Styles */
        .notification-wrapper {
            position: relative;
            margin-right: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            font-size: 24px;
            transition: transform 0.3s;
            color: #333;
            background: #f0f0f0;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-icon:hover {
            transform: scale(1.1);
            background: #e0e0e0;
        }

        .notif-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            min-width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .notification-dropdown {
            position: absolute;
            top: 55px;
            right: 0;
            width: 380px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: none;
            z-index: 1000;
            max-height: 500px;
            overflow: hidden;
        }

        .notification-dropdown.active {
            display: block;
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

        .notif-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }

        .mark-all-read {
            font-size: 12px;
            color: #016B61;
            cursor: pointer;
            font-weight: 600;
            transition: color 0.3s;
        }

        .mark-all-read:hover {
            color: #70B2B2;
            text-decoration: underline;
        }

        .notif-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notif-list::-webkit-scrollbar {
            width: 6px;
        }

        .notif-list::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .notif-item {
            display: flex;
            gap: 12px;
            padding: 15px 20px;
            border-bottom: 1px solid #f5f5f5;
            text-decoration: none;
            transition: background 0.3s;
            cursor: pointer;
        }

        .notif-item:hover {
            background: #f8f9fa;
        }

        .notif-item.unread {
            background: #e3f2fd;
        }

        .notif-icon-type {
            font-size: 28px;
            flex-shrink: 0;
        }

        .notif-content {
            flex: 1;
        }

        .notif-text {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
        }

        .notif-item.unread .notif-text {
            font-weight: 600;
        }

        .notif-time {
            font-size: 12px;
            color: #999;
        }

        .notif-empty {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .notif-empty-icon {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.3;
        }

        .notif-footer {
            padding: 12px 20px;
            text-align: center;
            border-top: 1px solid #f0f0f0;
        }

        .view-all-link {
            color: #016B61;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .view-all-link:hover {
            color: #70B2B2;
        }
    </style>
</head>
<body>
    <div class="main-layout">
        
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('images/auth-hero.png') }}" alt="WE CARE Logo"> 
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                   
                <a href="{{ route('admin.keuangan') }}" 
                   class="{{ Request::routeIs('admin.keuangan*') ? 'active' : '' }}">Keuangan</a>
                
                <a href="{{ route('admin.statistik') }}" 
                   class="{{ Request::routeIs('admin.statistik*') ? 'active' : '' }}">Statistik</a>

                <a href="{{ route('admin.riwayat') }}" 
                   class="{{ Request::routeIs('admin.riwayat*') ? 'active' : '' }}">Riwayat Pasien</a>
                   
                <a href="{{ route('admin.transaksi') }}" 
                   class="{{ Request::routeIs('admin.transaksi') ? 'active' : '' }}">Transaksi</a>
                   
                <a href="{{ route('admin.komentar') }}" 
                   class="{{ Request::routeIs('admin.komentar*') ? 'active' : '' }}">Komentar</a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Kelola Pengguna</a>
                
                <a href="#" class="logout-trigger" onclick="openLogoutModal(); return false;">Logout</a>
            </nav>
        </aside>

        <header class="navbar">
            <div class="user-info">
                
                <!-- NOTIFIKASI -->
                <div class="notification-wrapper">
                    <div class="notification-icon" onclick="toggleNotification()" id="notifIcon">
                        🔔
                        <span class="notif-badge" id="notifBadge" style="display: none;">0</span>
                    </div>

                    <!-- Dropdown Notifikasi -->
                    <div class="notification-dropdown" id="notifDropdown">
                        <div class="notif-header">
                            <h4>🔔 Notifikasi</h4>
                            <span class="mark-all-read" onclick="markAllAsRead()">Tandai Semua Dibaca</span>
                        </div>
                        <div class="notif-list" id="notifList">
                            <div class="notif-empty">
                                <div class="notif-empty-icon">🔔</div>
                                <p>Memuat notifikasi...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-wrapper">
                    <span class="welcome-text">Hai, {{ Auth::user()->nama ?? 'Admin' }}!</span>
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <main>
                @yield('content') 
            </main>
        </div>
        
        <div class="modal-overlay" id="logout-modal">
            <div class="modal-card">
                <h3>Apakah Kamu Mau Keluar?</h3>
                <div class="modal-buttons">
                    <a href="#" class="modal-btn modal-btn-ya"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        YA
                    </a>
                    <button class="modal-btn modal-btn-tidak" onclick="closeLogoutModal()">TIDAK</button>
                </div>
            </div>
        </div>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        @stack('scripts')
    </div>

    {{-- SCRIPT JAVASCRIPT --}}
    <script>
    // ===== LOGOUT MODAL =====
    function openLogoutModal() {
        document.getElementById('logout-modal').style.display = 'flex';
    }

    function closeLogoutModal() {
        document.getElementById('logout-modal').style.display = 'none';
    }

    document.getElementById('logout-modal').addEventListener('click', function(e) {
        if (e.target.id === 'logout-modal') {
            closeLogoutModal();
        }
    });

    // ===== NOTIFIKASI =====
    let notifInterval;

    // Toggle dropdown notifikasi
    function toggleNotification() {
        const dropdown = document.getElementById('notifDropdown');
        const isActive = dropdown.classList.contains('active');
        
        if (!isActive) {
            loadNotifications();
        }
        
        dropdown.classList.toggle('active');
    }

    // Load notifikasi dari server
    async function loadNotifications() {
        try {
            const response = await fetch('{{ route("admin.notifikasi.list") }}');
            const data = await response.json();
            
            if (data.success) {
                displayNotifications(data.notifikasi);
                updateBadge(data.unreadCount);
            }
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    // Display notifikasi di dropdown
    function displayNotifications(notifikasi) {
        const notifList = document.getElementById('notifList');
        
        if (notifikasi.length === 0) {
            notifList.innerHTML = `
                <div class="notif-empty">
                    <div class="notif-empty-icon">🔔</div>
                    <p>Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }
        
        let html = '';
        notifikasi.forEach(notif => {
            const icon = getNotifIcon(notif.message);
            const timeAgo = formatTimeAgo(notif.created_at);
            const unreadClass = notif.is_read ? '' : 'unread';
            
            html += `
                <div class="notif-item ${unreadClass}" onclick="markAsRead(${notif.id})">
                    <div class="notif-icon-type">${icon}</div>
                    <div class="notif-content">
                        <p class="notif-text">${notif.message}</p>
                        <span class="notif-time">${timeAgo}</span>
                    </div>
                </div>
            `;
        });
        
        notifList.innerHTML = html;
    }

    // Update badge count
    function updateBadge(count) {
        const badge = document.getElementById('notifBadge');
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    // Mark single notification as read
    async function markAsRead(id) {
        try {
            await fetch(`{{ url('admin/notifikasi') }}/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
            loadNotifications();
        } catch (error) {
            console.error('Error marking as read:', error);
        }
    }

    // Mark all as read
    async function markAllAsRead() {
        try {
            await fetch('{{ route("admin.notifikasi.readAll") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
            loadNotifications();
        } catch (error) {
            console.error('Error marking all as read:', error);
        }
    }

    // Get icon based on notification type
    function getNotifIcon(message) {
        if (message.includes('pembayaran') || message.includes('Pemasukan')) return '💰';
        if (message.includes('pasien baru') || message.includes('registrasi')) return '👤';
        if (message.includes('jadwal') || message.includes('konsultasi')) return '📅';
        if (message.includes('komentar')) return '💬';
        if (message.includes('transaksi') || message.includes('pengeluaran')) return '💸';
        return '🔔';
    }

    // Format time ago
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        if (seconds < 60) return 'Baru saja';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' menit yang lalu';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' jam yang lalu';
        if (seconds < 604800) return Math.floor(seconds / 86400) + ' hari yang lalu';
        return date.toLocaleDateString('id-ID');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const wrapper = document.querySelector('.notification-wrapper');
        const dropdown = document.getElementById('notifDropdown');
        
        if (wrapper && !wrapper.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Auto refresh notifikasi setiap 30 detik
    function startNotificationPolling() {
        loadNotifications(); // Load immediately
        notifInterval = setInterval(() => {
            loadNotifications();
        }, 30000); // 30 seconds
    }

    // Initialize saat page load
    window.addEventListener('DOMContentLoaded', function() {
        startNotificationPolling();
    });

    // Cleanup
    window.addEventListener('beforeunload', function() {
        if (notifInterval) clearInterval(notifInterval);
    });
    </script>
</body>
</html>