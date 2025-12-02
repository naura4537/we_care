<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Care - Konsultasi Dokter Online</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <custom-navbar></custom-navbar>

    <!-- Hero Section -->
    <section class="min-h-screen bg-gradient-to-br from-blue-50 to-teal-50 flex items-center">
        <div class="container mx-auto px-6 py-20">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-800 mb-6 leading-tight">
                        Konsultasi Dokter
                        <span class="text-blue-600">Online</span>
                        dengan Mudah
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Dapatkan layanan kesehatan profesional dari rumah. Konsultasi dengan dokter berpengalaman dan unduh hasil konsultasi untuk referensi medis Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#konsultasi" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition duration-300 shadow-lg hover:shadow-xl text-center">
                            Mulai Konsultasi
                        </a>
                        <a href="#fitur" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg font-semibold text-lg transition duration-300 text-center">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="w-80 h-80 lg:w-96 lg:h-96 bg-blue-100 rounded-full flex items-center justify-center">
                            <i data-feather="heart" class="w-32 h-32 text-blue-600"></i>
                        </div>
                        <div class="absolute -top-4 -right-4 bg-white p-4 rounded-lg shadow-lg">
                            <i data-feather="video" class="w-8 h-8 text-green-500"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-lg shadow-lg">
                            <i data-feather="file-text" class="w-8 h-8 text-blue-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Platform kesehatan digital yang memberikan pengalaman konsultasi terbaik untuk Anda
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i data-feather="video" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Konsultasi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Berbicara langsung dengan dokter melalui video call yang aman dan nyaman dari mana saja.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i data-feather="download" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Unduh Hasil Konsultasi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Simpan dan unduh rekam medis serta hasil konsultasi dalam format PDF untuk kebutuhan medis Anda.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i data-feather="clock" class="w-8 h-8 text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">24/7 Tersedia</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Layanan konsultasi tersedia kapan saja, dokter siap membantu Anda 24 jam sehari.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Cara Kerja Platform</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Hanya dalam 3 langkah sederhana, dapatkan layanan kesehatan profesional
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        1
                    </div>
                    <h3 href="{{ route('login') }}" class="text-xl font-bold text-gray-800 mb-4">Daftar & Login</h3>
                    <p class="text-gray-600">
                        Buat akun dan login ke platform kami dengan mudah dan aman.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Pilih Dokter</h3>
                    <p class="text-gray-600">
                        Pilih dokter spesialis sesuai kebutuhan kesehatan Anda.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Konsultasi & Unduh</h3>
                    <p class="text-gray-600">
                        Lakukan konsultasi dan unduh hasilnya untuk referensi medis.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="konsultasi" class="py-20 bg-blue-600">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                Siap Memulai Konsultasi?
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pasien yang telah merasakan kemudahan konsultasi dokter online dengan We Care.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"   class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg transition duration-300 shadow-lg">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white hover:bg-blue-700 px-8 py-4 rounded-lg font-semibold text-lg transition duration-300">
                    Masuk Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <custom-footer></custom-footer>

    <!-- Components -->
    <script src="components/navbar.js"></script>
    <script src="components/footer.js"></script>
    <script src="script.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>