@extends('layouts.pasien')

@section('title', 'Chat Konsultasi Aktif')

{{-- Menambahkan styling CSS manual untuk Chat Interface --}}
@push('styles')
<style>
    /* Styling Umum Kontainer */
    .chat-container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        height: 80vh; /* Mengambil sebagian besar tinggi viewport */
        overflow: hidden; /* Memastikan konten tidak meluber */
    }

    /* Header Chat */
    .chat-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e5e7eb;
        background-color: #f0fdfa; /* Teal-50 */
        border-radius: 10px 10px 0 0;
    }

    .chat-header h2 {
        font-size: 1.5em;
        font-weight: bold;
        color: #0d9488;
        margin: 0;
    }

    .chat-header p {
        font-size: 0.85em;
        color: #4b5563;
        margin: 5px 0 0;
    }

    /* Area Pesan (Jendela Chat) */
    .message-area {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto; /* Penting agar bisa di-scroll */
        background-color: #f9fafb;
        display: flex;
        flex-direction: column;
    }

    /* Bubble Pesan */
    .message-bubble {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 18px;
        margin-bottom: 10px;
        line-height: 1.4;
        word-wrap: break-word; /* Memastikan teks panjang tidak merusak layout */
    }

    /* Styling Pesan Pasien (Kanan) */
    .pasien-message {
        align-self: flex-end;
        background-color: #0d9488; /* Teal-600 */
        color: white;
        border-bottom-right-radius: 4px; 
    }

    /* Styling Pesan Dokter (Kiri) */
    .dokter-message {
        align-self: flex-start;
        background-color: #e5e7eb; /* Gray-200 */
        color: #1f2937;
        border-bottom-left-radius: 4px;
    }

    /* Area Input Chat */
    .chat-input-area {
        padding: 15px 20px;
        border-top: 1px solid #e5e7eb;
    }

    .chat-input-area form {
        display: flex;
        gap: 10px;
    }

    .chat-input-area textarea {
        flex-grow: 1;
        resize: none;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1em;
        transition: border-color 0.2s;
    }
    
    .chat-input-area textarea:focus {
        border-color: #0d9488; /* Teal focus */
        outline: none;
    }

    .chat-input-area button {
        padding: 10px 20px;
        background-color: #0d9488;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .chat-input-area button:hover {
        background-color: #057a6e;
    }
</style>
@endpush

@section('content')
<div class="chat-container">
    
    {{-- HEADER CHAT --}}
    <div class="chat-header">
        {{-- Menggunakan data aktual dari Controller --}}
        <h2>Konsultasi dengan Dr. {{ $pemesanan->dokter->user->nama ?? 'N/A' }}</h2>
        <p>Waktu Janji: {{ \Carbon\Carbon::parse($pemesanan->waktu_janji)->format('d M Y, H:i') }}</p>
    </div>

    {{-- JENDELA PESAN --}}
    <div class="message-area">
        
        {{-- DUMMY PESAN 1: Pasien --}}
        <div class="message-bubble pasien-message">
            Selamat malam, Dok. Saya demam tinggi dan pusing sejak dua hari lalu. Apakah saya harus minum Paracetamol?
        </div>
        
        {{-- DUMMY PESAN 2: Dokter --}}
        <div class="message-bubble dokter-message">
            Selamat malam. Ya, Paracetamol boleh diminum. Selain itu, apakah ada gejala lain seperti mual, batuk, atau nyeri tenggorokan?
        </div>

        {{-- DUMMY PESAN 3: Pasien --}}
        <div class="message-bubble pasien-message">
            Ada sedikit batuk kering, Dok. Saya khawatir ini flu berat.
        </div>

        {{-- DUMMY PESAN 4: Dokter --}}
        <div class="message-bubble dokter-message">
            Baik, saya sarankan Anda cek suhu tubuh sekarang dan minum air hangat. Kami akan pantau selama 15 menit ke depan. Pastikan Anda juga sudah makan.
        </div>
        
        {{-- Di sini, Anda akan me-looping pesan-pesan aktual dari database/WebSocket --}}
        {{-- @foreach ($messages as $message) ... @endforeach --}}
    </div>

    {{-- AREA INPUT PESAN --}}
    <div class="chat-input-area">
        <form id="chat-form">
            @csrf
            {{-- Tambahkan input untuk ID pemesanan --}}
            <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}"> 
            
            <textarea name="message" rows="2" placeholder="Ketik pesan Anda di sini..." required></textarea>
            <button type="submit">Kirim</button>
        </form>
    </div>
        
        {{-- TOMBOL AKHIRI KONSULTASI --}}
        {{-- Menggunakan FORM dengan method POST untuk aksi perubahan status yang aman --}}
        
        <form action="{{ route('pasien.konsultasi.akhiri', $pemesanan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri konsultasi? Anda akan diarahkan ke halaman hasil.');">
            @csrf
            {{-- Tambahkan styling langsung atau melalui tag @push('styles') --}}
            <button type="submit" 
                    class="btn-end-chat" 
                    style="background-color: #ef4444; /* Merah */ 
                           color: white; 
                           padding: 10px 15px; 
                           border: none; 
                           border-radius: 6px; 
                           cursor: pointer; 
                           font-weight: bold; 
                           transition: background-color 0.2s;">
                Akhiri Konsultasi
            </button>
        </form>
        
    </div>
</div>

@endsection