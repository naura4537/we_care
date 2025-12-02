{{-- Memberitahu Laravel untuk menggunakan 'cangkang' yang kita buat --}}
@extends('layouts.admin')

{{-- Memberitahu Laravel di mana harus meletakkan konten ini --}}
@section('content')

    <div class="custom-content-box tips-box">
        <p style="margin-bottom: 25px; color: #333; line-height: 1.6;">
            Menjaga kesehatan bukan cuma soal tidak sakit, tapi tentang bagaimana kita membuat tubuh dan pikiran tetap bugar setiap hari. Dengan rutinitas yang padat, sering kali kita lupa memperhatikan hal-hal kecil yang sebenarnya punya dampak besar bagi kesehatan. Nah, biar kamu tetap fit dan semangat menjalani hari, yuk simak beberapa tips dan trik sederhana yang bisa kamu lakukan mulai sekarang!
        </p>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <div class="tip-item" style="display: flex; align-items: center; gap: 15px;">
                <span class="tip-icon">⏳</span>
                <div>
                    <h4 style="font-weight: 700; color: var(--color-dark); margin: 0;">Atur Waktu Tidur</h4>
                    <p style="margin: 0; color: #666; font-size: 0.95rem;">Tidur minimal 7-8 jam setiap malam. Tidur yang cukup bantu tubuh memulihkan energi dan menjaga konsentrasi.</p>
                </div>
            </div>

            <div class="tip-item" style="display: flex; align-items: center; gap: 15px;">
                <span class="tip-icon">🥗</span>
                <div>
                    <h4 style="font-weight: 700; color: var(--color-dark); margin: 0;">Pilih Makanan Seimbang</h4>
                    <p style="margin: 0; color: #666; font-size: 0.95rem;">Perbanyak sayur, buah, dan air putih. Kurangi makanan cepat saji serta minuman manis berlebihan.</p>
                </div>
            </div>
            <div class="tip-item" style="display: flex; align-items: center; gap: 15px;">
                <span class="tip-icon">🏃‍♀️</span>
                <div>
                    <h4 style="font-weight: 700; color: var(--color-dark); margin: 0;">Tetap Aktif Bergerak</h4>
                    <p style="margin: 0; color: #666; font-size: 0.95rem;">Luangkan waktu 20-30 menit untuk olahraga ringan – jalan kaki, stretching, atau bersepeda sudah cukup.</p>
                </div>
            </div>
            
            <div class="tip-item" style="display: flex; align-items: center; gap: 15px;">
                <span class="tip-icon">💧</span>
                <div>
                    <h4 style="font-weight: 700; color: var(--color-dark); margin: 0;">Jangan Lupa Minum Air</h4>
                    <p style="margin: 0; color: #666; font-size: 0.95rem;">Tubuh butuh cairan agar tetap segar dan fokus. Idealnya 8 gelas per hari, lebih banyak jika kamu aktif.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-content-box map-placeholder" style="margin-top: 24px; padding: 0;">
        <h4 style="padding: 15px; border-bottom: 1px solid #eee; margin: 0; color: var(--color-dark);">Lokasi Kami di GMaps</h4>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15805.18182054211!2d112.60509673955078!3d-7.960594299999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e788281bdd08839%3A0xc915f268bffa831f!2sUniversitas%20Negeri%20Malang!5e0!3m2!1sen!2sid" 
            width="100%" 
            height="350" 
            frameborder="0" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <footer class="footer" style="margin-top: 24px; text-align: center;">
        <p>Jl. Cakrawala No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145</p>
        <p>@WeCare_Malang | WeCareMalang@gmail.com | www.wecaremalang.com | 089736213952</p>
    </footer>

@endsection