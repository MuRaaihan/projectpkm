<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\TotpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class TwoFactorAuthController extends Controller
{
    /**
     * Tampilkan formulir tantangan 2FA saat login.
     */
    public function challenge(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        if (! $request->session()->has('auth.2fa.user_id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verifikasi kode 2FA (TOTP atau Recovery Code) saat login.
     */
    public function verify(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('auth.2fa.user_id');
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (! $user || ! $user->hasTwoFactorEnabled()) {
            $request->session()->forget(['auth.2fa.user_id', 'auth.2fa.remember']);

            return redirect()->route('login');
        }

        $throttleKey = '2fa_verify|'.$userId.'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'code' => "Terlalu banyak percobaan kode 2FA yang salah. Silakan tunggu {$seconds} detik lagi.",
            ]);
        }

        $request->validate([
            'code' => ['nullable', 'string'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        $verified = false;
        $isRecovery = false;

        if ($request->filled('recovery_code')) {
            $recoveryCode = trim((string) $request->input('recovery_code'));
            if ($user->replaceRecoveryCode($recoveryCode)) {
                $verified = true;
                $isRecovery = true;
            }
        } elseif ($request->filled('code')) {
            $code = trim((string) $request->input('code'));
            if ($user->two_factor_secret && TotpService::verify($user->two_factor_secret, $code)) {
                $verified = true;
            }
        }

        if (! $verified) {
            RateLimiter::hit($throttleKey, 300);

            ActivityLog::record(
                action: '2fa_login_failed',
                description: 'Verifikasi kode 2FA gagal untuk akun '.$user->login_id,
                subjectType: 'user',
                subjectId: (string) $user->id,
                userId: $user->id,
                ipAddress: $request->ip()
            );

            return back()->withErrors([
                'code' => 'Kode autentikasi 2FA atau kode pemulihan yang kamu masukkan salah.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        // Bersihkan sesi 2FA sementara
        $remember = $request->session()->pull('auth.2fa.remember', false);
        $request->session()->forget('auth.2fa.user_id');

        // Login resmi
        Auth::login($user, $remember);
        $request->session()->regenerate();

        $user->update([
            'last_login_at' => now(),
            'locked_until' => null,
        ]);

        ActivityLog::record(
            action: $isRecovery ? '2fa_recovery_login' : '2fa_login_success',
            description: $isRecovery
                ? 'Berhasil masuk menggunakan kode pemulihan darurat 2FA'
                : 'Berhasil verifikasi 2FA TOTP ke sistem',
            subjectType: 'user',
            subjectId: (string) $user->id,
            userId: $user->id,
            ipAddress: $request->ip()
        );

        if ($user->must_change_password) {
            return redirect()->route('password.change')->with(
                'warning',
                'Demi keamanan akunmu, silakan ganti kata sandi bawaan terlebih dahulu.'
            );
        }

        return match ($user->role) {
            'master' => redirect()->route('master.dashboard'),
            'bk' => redirect()->route('bk.dashboard'),
            default => redirect('/dashboard'),
        };
    }

    /**
     * Tampilkan halaman pengelolaan 2FA untuk staf (Master / Guru BK).
     */
    public function showSetup(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if (! in_array($user->role, ['master', 'bk'])) {
            abort(403, 'Autentikasi dua faktor hanya diperuntukkan bagi akun pengelola (Master dan Guru BK).');
        }

        // Jika belum memiliki secret key, buatkan secret key baru
        if (! $user->two_factor_secret) {
            $user->two_factor_secret = TotpService::generateSecret();
            $user->save();
        }

        $otpAuthUri = TotpService::getOtpAuthUri('SIPERKA', $user->login_id, $user->two_factor_secret);

        return view('auth.two-factor-setup', [
            'user' => $user,
            'secret' => $user->two_factor_secret,
            'otpAuthUri' => $otpAuthUri,
            'recoveryCodes' => $user->recoveryCodes(),
            'isEnabled' => $user->hasTwoFactorEnabled(),
        ]);
    }

    /**
     * Konfirmasi dan aktifkan 2FA setelah pengguna memasukkan kode 6-digit pertama.
     */
    public function confirm(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! in_array($user->role, ['master', 'bk'])) {
            abort(403);
        }

        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Kode verifikasi 6-digit wajib diisi.',
            'code.size' => 'Kode verifikasi harus tepat 6 digit angka.',
        ]);

        if (! TotpService::verify($user->two_factor_secret, $request->code)) {
            return back()->withErrors([
                'code' => 'Kode verifikasi salah atau sudah kedaluwarsa. Periksa jam di perangkatmu dan coba kembali.',
            ]);
        }

        // Buat 8 kode pemulihan
        $recoveryCodes = TotpService::generateRecoveryCodes(8);

        $user->two_factor_recovery_codes = json_encode($recoveryCodes);
        $user->two_factor_confirmed_at = now();
        $user->save();

        ActivityLog::record(
            action: '2fa_enabled',
            description: 'Autentikasi dua faktor (2FA) berhasil diaktifkan untuk akun '.$user->login_id,
            subjectType: 'user',
            subjectId: (string) $user->id,
            userId: $user->id,
            ipAddress: $request->ip()
        );

        return back()->with('success', 'Autentikasi dua faktor (2FA) berhasil diaktifkan! Harap simpan kode pemulihan daruratmu.');
    }

    /**
     * Nonaktifkan 2FA dengan verifikasi kata sandi akun saat ini.
     */
    public function disable(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! in_array($user->role, ['master', 'bk'])) {
            abort(403);
        }

        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Kata sandi saat ini wajib diisi untuk menonaktifkan 2FA.',
        ]);

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi yang kamu masukkan salah.',
            ]);
        }

        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        ActivityLog::record(
            action: '2fa_disabled',
            description: 'Autentikasi dua faktor (2FA) dinonaktifkan untuk akun '.$user->login_id,
            subjectType: 'user',
            subjectId: (string) $user->id,
            userId: $user->id,
            ipAddress: $request->ip()
        );

        return back()->with('success', 'Autentikasi dua faktor (2FA) telah dinonaktifkan.');
    }

    /**
     * Buat ulang kode pemulihan (recovery codes).
     */
    public function regenerateRecoveryCodes(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! in_array($user->role, ['master', 'bk']) || ! $user->hasTwoFactorEnabled()) {
            abort(403);
        }

        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Kata sandi wajib dimasukkan untuk membuat ulang kode pemulihan.',
        ]);

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi yang kamu masukkan salah.',
            ]);
        }

        $newCodes = TotpService::generateRecoveryCodes(8);
        $user->two_factor_recovery_codes = json_encode($newCodes);
        $user->save();

        ActivityLog::record(
            action: '2fa_recovery_codes_regenerated',
            description: 'Kode pemulihan 2FA dibuat ulang untuk akun '.$user->login_id,
            subjectType: 'user',
            subjectId: (string) $user->id,
            userId: $user->id,
            ipAddress: $request->ip()
        );

        return back()->with('success', 'Kode pemulihan darurat baru berhasil dibuat.');
    }
}
