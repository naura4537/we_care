@extends('layouts.pasien')

@section('content')
<div style="padding: 40px 20px;">
    <div style="max-width: 768px; margin: 0 auto; background: white; border-radius: 16px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; overflow: hidden;">
        
        {{-- HEADER: HIJAU/TEAL ACCENT --}}
        <div style="background: linear-gradient(135deg, #016B61 0%, #70B2B2 100%); color: white; padding: 30px; border-bottom: 2px solid #016B61; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-size: 24px; font-weight: 700; margin: 0;">Edit Ulasan</h2>
                <p style="font-size: 14px; margin: 5px 0 0 0; opacity: 0.9;">Ubah penilaian Anda untuk dokter ini</p>
            </div>
            <span style="font-size: 28px;">✏️</span>
        </div>

        <div style="padding: 30px;">
            {{-- Info Dokter --}}
            <div style="margin-bottom: 30px; padding: 15px; background: #e0f2f1; border-radius: 10px; border: 1px solid #b2dfdb;">
                <span style="display: block; font-size: 12px; font-weight: 700; color: #00897b; text-transform: uppercase;">Dokter:</span>
                <span style="display: block; font-size: 18px; font-weight: 700; color: #333; margin-top: 5px;">{{ optional(optional($komentar->dokter)->user)->nama ?? 'Dokter Umum' }}</span>
            </div>

            <form action="{{ route('pasien.komentar.update', $komentar->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- PENTING: Untuk Update data --}}

                {{-- Rating --}}
                <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0;">
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #333; margin-bottom: 15px;">Rating Pelayanan</label>
                    <div style="display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px;">
                        
                        {{-- LOOP BINTANG --}}
                        @for ($i = 5; $i >= 1; $i--)
                            {{-- FIX: Hiding input using custom class (not display: none) --}}
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="rating-input-control"
                                {{ $komentar->rating == $i ? 'checked' : '' }} required>
                            
                            {{-- Label Bintang --}}
                            <label for="star{{ $i }}" 
                                   class="rating-star"
                                   style="cursor: pointer; font-size: 40px; color: #e0e0e0; transition: color 0.3s;">★</label>
                        @endfor
                    </div>
                </div>

                {{-- Komentar --}}
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #333; margin-bottom: 10px;">Komentar</label>
                    <textarea name="komentar" rows="6" 
                        style="width: 100%; padding: 12px; border-radius: 8px; border: 2px solid #e0e0e0; font-size: 14px; resize: vertical; box-sizing: border-box; transition: border-color 0.3s;"
                        required>{{ old('komentar', $komentar->komentar) }}</textarea>
                </div>

                {{-- Tombol --}}
                <div style="display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid #f0f0f0; padding-top: 20px;">
                    <a href="{{ route('pasien.komentar') }}" 
                       style="padding: 10px 20px; border-radius: 8px; background: #e0e0e0; color: #666; font-weight: 600; text-decoration: none; transition: background 0.3s;">Batal</a>
                    
                    <button type="submit" 
                            style="padding: 10px 30px; border-radius: 8px; background: #016B61; color: white; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(1, 107, 97, 0.4);">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CSS Selector PENTING untuk Bintang --}}
<style>
    /* FIX 1: Hiding input without disrupting the label click */
    .rating-input-control {
        opacity: 0;
        position: absolute;
        width: 1px;
        height: 1px;
        margin: 0;
        z-index: 1; /* Agar bintang tidak menutupi input secara fungsional */
    }

    /* FIX 2: Functional Coloring (The ultimate solution for coloring) */
    .rating-input-control:checked ~ .rating-star,
    .rating-input-control:hover ~ .rating-star { 
        color: #FACC15 !important;
    }
    
    /* Memastikan hover pada label yang belum dipilih juga bekerja */
    .rating-star:hover {
        color: #FACC15;
    }
    
    /* Default color for stars */
    .rating-star {
        color: #e0e0e0; 
        transition: color 0.3s;
    }
</style>
@endsection