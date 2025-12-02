@extends('layouts.pasien')

@section('content')
<div class="form-review-container">

    {{-- KOTAK FORMULIR UTAMA --}}
    <div class="review-box">
        
        {{-- JUDUL FORM --}}
        <h2 class="review-title">
            Formulir Ulasan Dokter
        </h2>
        <p class="review-subtitle">
            Berikan rating dan masukan Anda mengenai pelayanan dokter ini.
        </p>

        {{-- INFO DOKTER --}}
        <div class="doctor-info-card">
            <label class="info-label">
                Anda sedang menilai:
            </label>
            {{-- Asumsi $dokter adalah objek yang berisi data dokter --}}
            <p class="doctor-name-display">
                {{ $dokter->nama_dokter ?? 'Dokter' }} ({{ $dokter->spesialisasi ?? 'Umum' }})
            </p>
        </div>
        
        {{-- TAMPILKAN ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="alert alert-danger validation-alert">
                <p>Terdapat beberapa masalah dengan input Anda:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULIR UTAMA --}}
        <form action="{{ route('pasien.komentar.store', $dokter->id) }}" method="POST">
            @csrf

            {{-- 1. INPUT RATING (BINTANG) --}}
            <div class="form-group">
                <label class="form-label">
                    Rating Pelayanan
                </label>
                
                {{-- Bintang Berjajar (menggunakan CSS/JS untuk interaksi) --}}
                <div class="rating-input-group" data-current-rating="{{ old('rating') }}">
                    @for ($i = 5; $i >= 1; $i--)
                        {{-- ID unik untuk setiap bintang --}}
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                            class="rating-radio" required {{ old('rating') == $i ? 'checked' : '' }}>
                        
                        <label for="star{{ $i }}" class="rating-label">
                            ★
                        </label>
                    @endfor
                </div>
                <p class="help-text">*Klik bintang untuk memilih (5=Sangat Baik, 1=Sangat Buruk)</p>
            </div>

            {{-- 2. INPUT KOMENTAR (TEXTAREA) --}}
            <div class="form-group">
                <label for="komentar" class="form-label">
                    Komentar & Saran
                </label>
                <textarea id="komentar" name="komentar" rows="5" 
                    class="form-textarea @error('komentar') is-invalid @enderror"
                    placeholder="Tuliskan pengalaman Anda di sini..." required>{{ old('komentar') }}</textarea>
                @error('komentar')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- 3. TOMBOL AKSI --}}
            <div class="form-actions">
                {{-- Tombol Batal --}}
                <a href="{{ route('pasien.cari_dokter') }}" 
                   class="btn btn-secondary">
                    Batal
                </a>
                
                {{-- Tombol Kirim --}}
                <button type="submit" class="btn btn-primary">
                    Kirim Ulasan
                </button>
            </div>

        </form>
    </div>
</div>

<style>
/* ------------------------------------------------ */
/* CUSTOM CSS FOR REVIEW FORM */
/* ------------------------------------------------ */

.form-review-container {
    padding: 30px 20px;
    background-color: #f4f6f9;
}

.review-box {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    padding: 30px;
}

.review-title {
    font-size: 26px;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

.review-subtitle {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 25px;
}

/* INFO DOKTER */
.doctor-info-card {
    margin-bottom: 25px;
    background-color: #f7fcfb; /* Sangat terang */
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #cce5df;
}

.info-label {
    display: block;
    color: #6c757d;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 4px;
    text-transform: uppercase;
}

.doctor-name-display {
    font-size: 18px;
    font-weight: bold;
    color: #0d9488; /* Warna hijau primer */
    margin: 0;
}

/* FORM ELEMENTS */
.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    color: #495057;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 8px;
}

.form-textarea {
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.06);
    appearance: none;
    border: 1px solid #ced4da;
    border-radius: 6px;
    width: 100%;
    padding: 12px 15px;
    color: #495057;
    line-height: 1.5;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-textarea:focus {
    outline: none;
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
}

.help-text {
    font-size: 11px;
    color: #999;
    margin-top: 5px;
}

.text-error {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

.validation-alert {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}
.validation-alert ul {
    margin-left: 20px;
    margin-top: 5px;
    list-style-type: disc;
}


/* RATING INPUT */
.rating-input-group {
    display: flex;
    flex-direction: row-reverse; /* Untuk menempatkan 5 di paling kanan secara visual */
    justify-content: flex-end; /* Memastikan bintang sejajar ke kiri */
    gap: 4px;
}

.rating-radio {
    display: none;
}

.rating-label {
    cursor: pointer;
    font-size: 40px;
    color: #e9ecef; /* Abu-abu default */
    transition: color 0.2s;
}

/* Interaksi Rating */
.rating-input-group > .rating-radio:checked ~ .rating-label {
    color: #fcc419; /* Kuning Emas */
}

.rating-input-group > .rating-radio:hover ~ .rating-label,
.rating-input-group > .rating-label:hover {
    color: #fcc419;
}

/* TOMBOL AKSI */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.btn {
    padding: 10px 25px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s, box-shadow 0.2s, transform 0.2s;
}

.btn-primary {
    background-color: #0d9488;
    color: white;
    box-shadow: 0 4px 10px rgba(13, 148, 136, 0.3);
}

.btn-primary:hover {
    background-color: #0c7a6e;
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: #e9ecef;
    color: #495057;
}

.btn-secondary:hover {
    background-color: #dee2e6;
}
</style>
@endsection