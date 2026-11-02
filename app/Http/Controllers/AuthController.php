<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login tunggal untuk semua peran.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login_id.required' => 'ID Pengguna (NIS/NIP/Username) wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginId = trim((string) $request->input('login_id'));
        $throttleKey = 'login|'.Str::lower($loginId).'|'.$request->ip();

        // 1. Cek Rate Limiting (Maks 5 percobaan)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withErrors([
                    'login_id' => "Terlalu banyak percobaan masuk yang salah. Silakan tunggu {$seconds} detik lagi sebelum mencoba kembali.",
                ])
                ->onlyInput('login_id');
        }

        // 2. Cari pengguna berdasarkan login_id (termasuk yang soft-deleted untuk keamanan)
        $user = User::withTrashed()->where('login_id', $loginId)->first();

        // 3. Validasi keberadaan akun dan kecocokan password
        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            RateLimiter::hit($throttleKey, 900); // 15 menit decay

            // Catat ke log audit keamanan
            ActivityLog::record(
                action: 'login_failed',
                description: 'Percobaan masuk gagal untuk login_id: '.$loginId,
                subjectType: 'user',
                subjectId: $user ? (string) $user->id : null,
                userId: $user?->id,
                ipAddress: $request->ip()
            );

            // Pesan error identik (tidak membocorkan apakah login_id ada)
            return back()
                ->withErrors([
                    'login_id' => 'ID Pengguna atau kata sandi yang kamu masukkan tidak sesuai.',
                ])
                ->onlyInput('login_id');
        }

        // 4. Periksa apakah akun telah diarsipkan / dihapus secara soft-delete
        if ($user->trashed()) {
            ActivityLog::record(
                action: 'login_failed',
                description: 'Percobaan masuk pada akun yang telah diarsipkan: '.$loginId,
                subjectType: 'user',
                subjectId: (string) $user->id,
                userId: $user->id,
                ipAddress: $request->ip()
            );

            return back()
                ->withErrors([
                    'login_id' => 'Akun ini telah diarsipkan. Silakan hubungi pengelola madrasah.',
                ])
                ->onlyInput('login_id');
        }

        // 5. Periksa apakah akun sedang dikunci sementara
        if ($user->locked_until && $user->locked_until->isFuture()) {
            $diff = $user->locked_until->diffForHumans();

            return back()
                ->withErrors([
                    'login_id' => "Akun kamu sedang dikunci sementara demi keamanan. Coba lagi {$diff}.",
                ])
                ->onlyInput('login_id');
        }

        // 6. Periksa apakah akun aktif
        if (! $user->is_active) {
            ActivityLog::record(
                action: 'login_failed',
                description: 'Percobaan masuk pada akun nonaktif: '.$loginId,
                subjectType: 'user',
                subjectId: (string) $user->id,
                userId: $user->id,
                ipAddress: $request->ip()
            );

            return back()
                ->withErrors([
                    'login_id' => 'Akun kamu saat ini sedang dinonaktifkan. Silakan hubungi Guru BK atau pihak madrasah.',
                ])
                ->onlyInput('login_id');
        }

        // 7. Bersihkan pembatasan rate limiter
        RateLimiter::clear($throttleKey);

        // 7b. Periksa apakah akun staf (Master / Guru BK) telah mengaktifkan 2FA (FR-08)
        if ($user->hasTwoFactorEnabled() && in_array($user->role, ['master', 'bk'])) {
            $request->session()->put('auth.2fa.user_id', $user->id);
            $request->session()->put('auth.2fa.remember', $request->boolean('remember'));

            ActivityLog::record(
                action: '2fa_challenged',
                description: 'Tantangan autentikasi 2FA diajukan untuk akun '.$user->login_id,
                subjectType: 'user',
                subjectId: (string) $user->id,
                userId: $user->id,
                ipAddress: $request->ip()
            );

            return redirect()->route('two-factor.challenge');
        }

        // 8. Login dan regenerasi sesi
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // 9. Perbarui data login terakhir
        $user->update([
            'last_login_at' => now(),
            'locked_until' => null,
        ]);

        // 10. Catat aktivitas berhasil
        ActivityLog::record(
            action: 'login_success',
            description: 'Berhasil masuk ke sistem dengan peran '.$user->role,
            subjectType: 'user',
            subjectId: (string) $user->id,
            userId: $user->id,
            ipAddress: $request->ip()
        );

        // 11. Jika wajib ganti password, arahkan ke form ganti password
        if ($user->must_change_password) {
            return redirect()->route('password.change')->with(
                'warning',
                'Demi keamanan akunmu, silakan ganti kata sandi bawaan terlebih dahulu.'
            );
        }

        // 12. Arahkan ke dashboard sesuai peran
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Logout pengguna dan hancurkan sesi.
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            ActivityLog::record(
                action: 'logout',
                description: 'Pengguna keluar dari sistem',
                subjectType: 'user',
                subjectId: (string) Auth::id(),
                userId: Auth::id(),
                ipAddress: $request->ip()
            );

            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Pengalihan rute berdasarkan peran akun.
     */
    protected function redirectBasedOnRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'master' => redirect()->route('master.dashboard'),
            'bk' => redirect()->route('bk.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect('/'),
        };
    }
}
