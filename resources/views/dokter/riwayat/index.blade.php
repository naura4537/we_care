<tbody>
                @forelse($pasiens as $pasien)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    
                    {{-- 1. CARI DATA KONSULTASI TERAKHIR DI SINI --}}
                    @php
                        // Memastikan logika pencarian ini ada di awal loop
                        $lastConsult = \App\Models\Pemesanan::where('dokter_id', $dokter->id)
                                                             ->where('user_id', $pasien->id)
                                                             ->latest('created_at')
                                                             ->first();
                        
                        // Logika untuk Tombol Ulasan Dokter
                        $hasReviewed = \App\Models\DokterUlasan::where('pemesanan_id', optional($lastConsult)->id)->exists();
                        $reviewRoute = $lastConsult ? route('dokter.ulasan.pasien.form', $lastConsult->id) : '#';
                    @endphp

                    {{-- NAMA PASIEN --}}
                    <td style="padding: 15px; font-size: 14px;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #bfdbfe; display: flex; align-items: center; justify-content: center; color: #2563eb; font-weight: bold; font-size: 14px; margin-right: 10px;">
                                {{ substr($pasien->name ?? 'P', 0, 1) }}
                            </div>
                            <p style="font-weight: bold; margin: 0;">{{ $pasien->name ?? 'Pasien #'.$pasien->id }}</p>
                        </div>
                    </td>

                    {{-- TERAKHIR KONSEL --}}
                    <td style="padding: 15px; font-size: 14px;">
                        @if($lastConsult)
                            <p style="margin: 0;">{{ \Carbon\Carbon::parse($lastConsult->created_at)->format('d M Y') }}</p>
                            <span style="color: #6b7280; font-size: 11px;">Status: {{ $lastConsult->status }}</span>
                        @else
                            <span style="color: #9ca3af;">Belum ada riwayat tercatat.</span>
                        @endif
                    </td>

                    {{-- AKSI / ULASAN DOKTER KE PASIEN --}}
                    <td style="padding: 15px; font-size: 14px;">
                        @if ($lastConsult && $lastConsult->status != 'Menunggu Pembayaran')
                            @if ($hasReviewed)
                                <a href="{{ $reviewRoute }}" style="background-color: #fef3c7; color: #92400e; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px; text-decoration: none;">
                                    Edit Ulasan
                                </a>
                            @else
                                <a href="{{ $reviewRoute }}" style="background-color: #0d9488; color: white; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px; text-decoration: none;">
                                    Nilai Pasien
                                </a>
                            @endif
                        @else
                            <span style="color: #9ca3af; font-size: 11px;">Tunggu pembayaran/konsultasi selesai.</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 20px; text-align: center; color: #6b7280; font-size: 14px;">
                        Anda belum memiliki riwayat pasien.
                    </td>
                </tr>
                @endforelse
            </tbody>