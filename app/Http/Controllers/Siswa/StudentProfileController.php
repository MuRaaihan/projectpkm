<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentProfileController extends Controller
{
    /**
     * Tampilkan profil akun siswa
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('schoolClass');

        return view('siswa.profile', compact('user'));
    }

    /**
     * Perbarui kata sandi mandiri oleh siswa
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',
                'different:current_password',
                function ($attribute, $value, $fail) use ($user) {
                    if (strtolower($value) === strtolower($user->login_id)) {
                        $fail('Kata sandi baru tidak boleh sama dengan NIS kamu.');
                    }
                },
            ],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang kamu masukkan salah.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.different' => 'Kata sandi baru harus berbeda dari kata sandi lama.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        ActivityLog::record(
            'password_changed',
            'Siswa memperbarui kata sandi mandiri melalui profil.',
            'user',
            (string) $user->id,
            $user->id,
            $request->ip()
        );

        return back()->with('success', 'Kata sandi akunmu berhasil diperbarui.');
    }
}
