<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class BkProfileController extends Controller
{
    /**
     * Menampilkan profil akun Guru BK
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return view('bk.profile.show', compact('user'));
    }

    /**
     * Memperbarui profil data diri Guru BK
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'phone.max' => 'Nomor kontak/HP maksimal 20 digit.',
        ]);

        $user->update([
            'name' => trim($validated['name']),
            'phone' => isset($validated['phone']) ? trim($validated['phone']) : null,
        ]);

        ActivityLog::record(
            action: 'profile_updated',
            description: 'Guru BK '.$user->name.' memperbarui profil data diri.',
            subjectType: get_class($user),
            subjectId: $user->id,
            userId: $user->id,
        );

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Memperbarui kata sandi mandiri oleh Guru BK
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
                        $fail('Kata sandi baru tidak boleh sama dengan NIP/Username Anda.');
                    }
                },
            ],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
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
            action: 'password_changed',
            description: 'Guru BK '.$user->name.' memperbarui kata sandi mandiri melalui profil.',
            subjectType: get_class($user),
            subjectId: $user->id,
            userId: $user->id,
        );

        return back()->with('success', 'Kata sandi Anda berhasil diperbarui.');
    }
}
