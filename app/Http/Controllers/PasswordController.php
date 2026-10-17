<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Tampilkan formulir ganti kata sandi.
     */
    public function showChangeForm(): View
    {
        $user = Auth::user();

        return view('auth.change-password', [
            'isMandatory' => (bool) $user->must_change_password,
        ]);
    }

    /**
     * Proses pembaruan kata sandi.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $rules = [
            'password' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',
                function (string $attribute, mixed $value, \Closure $fail) use ($user) {
                    if (strcasecmp((string) $value, (string) $user->login_id) === 0) {
                        $fail('Kata sandi baru tidak boleh sama dengan ID Pengguna / NIS kamu.');
                    }
                },
            ],
        ];

        // Jika bukan login pertama / bukan reset wajib, verifikasi password saat ini
        if (! $user->must_change_password) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $messages = [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ];

        $request->validate($rules, $messages);

        // Update password dan matikan tanda wajib ganti password
        $user->update([
            'password' => Hash::make($request->input('password')),
            'must_change_password' => false,
        ]);

        // Catat log audit
        ActivityLog::record(
            action: 'password_changed',
            description: 'Kata sandi akun berhasil diperbarui',
            subjectType: 'user',
            subjectId: (string) $user->id,
            userId: $user->id,
            ipAddress: $request->ip()
        );

        $redirectRoute = match ($user->role) {
            'master' => 'master.dashboard',
            'bk' => 'bk.dashboard',
            'siswa' => 'siswa.dashboard',
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute)->with('success', 'Kata sandi kamu berhasil diperbarui.');
    }
}
