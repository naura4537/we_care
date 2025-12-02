<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse // Gunakan LoginRequest
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- BLOK LOGIKA REDIRECTION BERDASARKAN ROLE ---

        $user = Auth::user();

        if ($user->role === 'admin') {
            // Redirection tegas untuk Admin
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->role === 'pasien') {
            // Redirection tegas untuk Pasien
            return redirect()->intended(route('pasien.dashboard'));
        }
        if ($user->role === 'dokter') {
            // Redirection tegas untuk Dokter
            return redirect()->intended(route('dokter.dashboard'));
        }
        // <-- TAMBAHKAN BARIS FALLBACK INI -->
        return redirect()->intended(RouteServiceProvider::HOME);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}