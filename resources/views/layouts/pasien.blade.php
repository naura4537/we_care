<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasien - We Care')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH572XFev88l28xL9q3rQW0qfVq4cK5t9/x5f5w5/0f7eN8l+V4uN7z4P2/2g5E4zYy13/1Q5P6w7c1w4n8Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('styles')
    @vite(['resources/css/style.css', 'resources/js/main.js']) 
    
    @stack('styles')
</head>
<body>
    <style>
        
    </style>

    <div class="main-layout">
        
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('images/auth-hero.png') }}" alt="WE CARE Logo"> 
            </div>
            <nav>
                <a href="{{ route('pasien.dashboard') }}" 
                   class="{{ Request::routeIs('pasien.dashboard') ? 'active' : '' }}">Dashboard</a>
                   
                <a href="{{ route('pasien.cari_dokter') }}" 
                   class="{{ Request::routeIs('pasien.cari_dokter') ? 'active' : '' }}">Cari Dokter</a>
                
                   
                <a href="{{ route('pasien.riwayat') }}" 
                   class="{{ Request::routeIs('pasien.riwayat') ? 'active' : '' }}">Riwayat</a>
                   
                <a href="{{ route('pasien.komentar') }}" 
                   class="{{ Request::routeIs('pasien.komentar') ? 'active' : '' }}">Komentar</a>
                
                <a href="#" class="logout-trigger" onclick="openLogoutModal(); return false;">Logout</a>
            </nav>
            <div class="modal-overlay" id="logout-modal" style="display: none;">
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
        </aside>

        <header class="navbar">
    <div style="display: flex; align-items: center; justify-content: flex-end; width: 100%;">
        
        
        {{-- Tombol Notifikasi (Kanan) --}}
        <div class="notification-icon" style="margin-left: auto;">
            {{-- Placeholder Bell Icon --}}
        </div>

        {{-- Profil (Pojok Kanan) - DIBUNGKUS TAUTAN --}}
        <a href="{{ route('pasien.profile.show') }}" style="text-decoration: none; color: inherit; margin-left: 20px;">
            <div class="profile-wrapper">
                <span class="welcome-text">Hai, {{ Auth::user()->nama ?? 'Pasien' }}!</span>
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->nama ?? 'P', 0, 1)) }}
                </div>
            </div>
        </a>
    </div>
</header>

        <div class="content-wrapper">
            <main>
                @yield('content') 
            </main>
        </div>
        
        @stack('scripts') 
    </div>
    <script>
function openLogoutModal() {
    document.getElementById('logout-modal').style.display = 'flex';
}

function closeLogoutModal() {
    document.getElementById('logout-modal').style.display = 'none';
}

// Tutup modal jika user mengklik area abu-abu
document.getElementById('logout-modal').addEventListener('click', function(e) {
    if (e.target.id === 'logout-modal') {
        closeLogoutModal();
    }
});

</script>
</body>
</html>