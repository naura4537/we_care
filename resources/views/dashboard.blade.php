@extends('layouts.admin')

@section('content')

    <div class="custom-content-box tip-explanation-box">
        
        <h3 class="box-title" style="margin-top: 0; font-size: 1.3rem; margin-bottom: 15px; color: var(--color-dark);">Tips Menjaga Kebugaran Setiap Hari</h3>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <div class="tip-item">
                <h4 style="font-weight: 700; color: var(--color-dark); margin-bottom: 5px;">Atur Waktu Tidur</h4>
                <p style="margin-left: 5px; color: #666;">Tidur minimal 7-8 jam setiap malam. Tidur yang cukup bantu tubuh memulihkan energi dan menjaga konsentrasi.</p>
            </div>
            <div class="tip-item">
                <h4 style="font-weight: 700; color: var(--color-dark); margin-bottom: 5px;">Pilih Makanan Seimbang</h4>
                <p style="margin-left: 5px; color: #666;">Perbanyak sayur, buah, dan air putih. Kurangi makanan cepat saji serta minuman manis berlebihan.</p>
            </div>
            <div class="tip-item">
                <h4 style="font-weight: 700; color: var(--color-dark); margin-bottom: 5px;">Tetap Aktif Bergerak</h4>
                <p style="margin-left: 5px; color: #666;">Luangkan waktu 20-30 menit untuk olahraga ringan – jalan kaki, stretching, atau bersepeda sudah cukup.</p>
            </div>
            <div class="tip-item">
                <h4 style="font-weight: 700; color: var(--color-dark); margin-bottom: 5px;">Jangan Lupa Minum Air</h4>
                <p style="margin-left: 5px; color: #666;">Tubuh butuh cairan agar tetap segar dan fokus. Idealnya 8 gelas per hari, lebih banyak jika kamu aktif.</p>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>

    <div class="custom-content-box map-location-box" style="padding: 0; margin-top: 24px;"> 
        <h3 class="box-title" style="padding: 24px 24px 10px 24px;">Ini Lokasi Kita Kalo Dilihat dari GMaps</h3>
        
        <div class="map-placeholder-wrapper">
            <img src="{{ asset('images/map_placeholder.png') }}" alt="Peta Lokasi Malang" style="width: 100%; height: auto; border-radius: 0;">
        </div>

        <p style="padding: 15px 24px; font-size: 0.9rem; color: #666; margin: 0;">
        Jl. Cakrawala No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145
        </p>

        <p style="margin: 0; font-size: 0.9rem; color: var(--color-dark);">
            @WeCare_Malang | WeCareMalang@gmail.com | www.wecaremalang.com | 089736213952
        </p>
        </div>

@endsection