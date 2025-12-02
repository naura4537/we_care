<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokter - We Care')</title>
    
    @vite(['resources/css/style.css', 'resources/js/main.js']) 
    
    @stack('styles')
</head>
<body>
    <div class="main-layout">
        
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('images/auth-hero.png') }}" alt="WE CARE Logo"> 
            </div>
            <nav>
                <a href="{{ route('dokter.dashboard') }}" 
                   class="{{ Request::routeIs('dokter.dashboard') ? 'active' : '' }}">Dashboard</a>
                   
                <a href="{{ route('dokter.jadwal.index') }}" 
                   class="{{ Request::routeIs('dokter.jadwal.*') ? 'active' : '' }}">Jadwal Konsultasi</a>
                
                <a href="{{ route('dokter.ulasan.index') }}" 
                   class="{{ Request::routeIs('dokter.ulasan.*') ? 'active' : '' }}">Komentar</a>
                
                <a href="#" class="logout-trigger" onclick="openLogoutModal(); return false;">Logout</a>
            </nav>
        </aside>

        <header class="navbar">
            <div class="user-info">
                
                <a href="{{ route('dokter.profile.show') }}" style="text-decoration: none; color: inherit; margin-left: 20px;">
                    <div class="profile-wrapper">
                        <span class="welcome-text">Hai, Dr. Budi!</span>
                        <div class="profile-avatar">D</div>
                    </div>
                </a>

                <div class="notification-icon">
                    </div>
            </div>
        </header>

        <div class="content-wrapper">
            <main>
                @yield('content') 
            </main>
        </div>
        
        {{-- MODAL DAN SCRIPT LOGOUT --}}
        <div class="modal-overlay" id="logout-modal" style="display: none;">
            <div class="modal-card">
                <h3>Apakah Kamu Mau Keluar?</h3>
                <div class="modal-buttons">
                    <a href="#" class="modal-btn modal-btn-ya"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        YA
                    </a>
                    <button class="modal-btn modal-btn-tidak" type="button" onclick="closeLogoutModal()">TIDAK</button>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <script>
        function closeLogoutModal() {
            // Ini memastikan modal benar-benar hilang dari layar
            document.getElementById('logout-modal').style.display = 'none'; 
        }
        // ...
        </script>        
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        {{-- Atau, jika Anda menggunakan Laravel Mix/Vite --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </body>
        </html>
    </div>
</body>
</html>