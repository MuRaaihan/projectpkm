<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BkUserController extends Controller
{
    /**
     * Tampilkan daftar akun Guru BK.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status', 'active');
        $search = $request->input('q');

        $query = User::where('role', 'bk');

        if ($status === 'archived') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        } else {
            // default active
            $query->where('is_active', true);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('login_id', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $bkUsers = $query->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('master.bk-users.index', [
            'bkUsers' => $bkUsers,
            'status' => $status,
            'search' => $search,
        ]);
    }

    /**
     * Tampilkan formulir tambah akun Guru BK.
     */
    public function create(): View
    {
        return view('master.bk-users.create');
    }

    /**
     * Simpan akun Guru BK baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login_id' => ['required', 'string', 'max:50', 'unique:users,login_id'],
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8'],
        ], [
            'login_id.required' => 'NIP / Username Guru BK wajib diisi.',
            'login_id.unique' => 'NIP / Username ini sudah digunakan akun lain.',
            'name.required' => 'Nama lengkap Guru BK wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $plainPassword = ! empty($validated['password']) ? $validated['password'] : 'GuruBKMTS!';

        $user = User::create([
            'role' => 'bk',
            'login_id' => trim($validated['login_id']),
            'name' => trim($validated['name']),
            'phone' => $validated['phone'] ? trim($validated['phone']) : null,
            'password' => Hash::make($plainPassword),
            'is_active' => true,
            'must_change_password' => true,
        ]);

        ActivityLog::record(
            action: 'user_created',
            description: "Menambahkan akun Guru BK baru: {$user->name} ({$user->login_id})",
            subjectType: 'user',
            subjectId: (string) $user->id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Akun Guru BK {$user->name} berhasil dibuat. Kata sandi awal: {$plainPassword}");
    }

    /**
     * Tampilkan formulir ubah data Guru BK.
     */
    public function edit(User $bkUser): View
    {
        abort_unless($bkUser->role === 'bk', 404);

        return view('master.bk-users.edit', [
            'bkUser' => $bkUser,
        ]);
    }

    /**
     * Perbarui data akun Guru BK.
     */
    public function update(Request $request, User $bkUser): RedirectResponse
    {
        abort_unless($bkUser->role === 'bk', 404);

        $validated = $request->validate([
            'login_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'login_id')->ignore($bkUser->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'login_id.required' => 'NIP / Username Guru BK wajib diisi.',
            'login_id.unique' => 'NIP / Username ini sudah digunakan akun lain.',
            'name.required' => 'Nama lengkap Guru BK wajib diisi.',
        ]);

        $bkUser->update([
            'login_id' => trim($validated['login_id']),
            'name' => trim($validated['name']),
            'phone' => $validated['phone'] ? trim($validated['phone']) : null,
        ]);

        ActivityLog::record(
            action: 'user_updated',
            description: "Memperbarui data akun Guru BK: {$bkUser->name} ({$bkUser->login_id})",
            subjectType: 'user',
            subjectId: (string) $bkUser->id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Data Guru BK {$bkUser->name} berhasil diperbarui.");
    }

    /**
     * Aktifkan atau nonaktifkan akun Guru BK.
     */
    public function toggleStatus(User $bkUser): RedirectResponse
    {
        abort_unless($bkUser->role === 'bk', 404);

        $bkUser->update([
            'is_active' => ! $bkUser->is_active,
        ]);

        $statusText = $bkUser->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';
        $action = $bkUser->is_active ? 'user_updated' : 'user_deactivated';

        ActivityLog::record(
            action: $action,
            description: "Akun Guru BK {$bkUser->name} ({$bkUser->login_id}) {$statusText}",
            subjectType: 'user',
            subjectId: (string) $bkUser->id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Akun Guru BK {$bkUser->name} berhasil {$statusText}.");
    }

    /**
     * Arsipkan akun Guru BK (Soft delete default).
     */
    public function archive(User $bkUser): RedirectResponse
    {
        abort_unless($bkUser->role === 'bk', 404);

        $name = $bkUser->name;
        $id = $bkUser->id;

        $bkUser->delete();

        ActivityLog::record(
            action: 'user_archived',
            description: "Mengarsipkan akun Guru BK: {$name}",
            subjectType: 'user',
            subjectId: (string) $id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Akun Guru BK {$name} berhasil diarsipkan.");
    }

    /**
     * Pulihkan akun Guru BK dari arsip.
     */
    public function restore(int $id): RedirectResponse
    {
        $bkUser = User::onlyTrashed()->where('role', 'bk')->findOrFail($id);
        $bkUser->restore();

        ActivityLog::record(
            action: 'user_updated',
            description: "Memulihkan akun Guru BK dari arsip: {$bkUser->name}",
            subjectType: 'user',
            subjectId: (string) $bkUser->id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Akun Guru BK {$bkUser->name} berhasil dipulihkan.");
    }

    /**
     * Hapus permanen akun Guru BK (Wajib konfirmasi kata sandi Master).
     */
    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'master_password' => ['required', 'string'],
        ], [
            'master_password.required' => 'Kata sandi Master wajib diisi untuk konfirmasi penghapusan permanen.',
        ]);

        if (! Hash::check($request->input('master_password'), $request->user()->password)) {
            return back()->with('error', 'Konfirmasi kata sandi Master salah. Penghapusan permanen dibatalkan demi keamanan.');
        }

        $bkUser = User::withTrashed()->where('role', 'bk')->findOrFail($id);
        $name = $bkUser->name;
        $loginId = $bkUser->login_id;

        $bkUser->forceDelete();

        ActivityLog::record(
            action: 'user_deleted_permanently',
            description: "Menghapus permanen akun Guru BK: {$name} ({$loginId})",
            subjectType: 'user',
            subjectId: (string) $id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Akun Guru BK {$name} telah dihapus secara permanen.");
    }

    /**
     * Reset password Guru BK oleh Master.
     */
    public function resetPassword(User $bkUser): RedirectResponse
    {
        abort_unless($bkUser->role === 'bk', 404);

        $newPassword = 'GuruBKMTS!';

        $bkUser->update([
            'password' => Hash::make($newPassword),
            'must_change_password' => true,
        ]);

        ActivityLog::record(
            action: 'password_reset',
            description: "Master mereset kata sandi Guru BK: {$bkUser->name} ({$bkUser->login_id})",
            subjectType: 'user',
            subjectId: (string) $bkUser->id
        );

        return redirect()->route('master.bk-users.index')
            ->with('success', "Kata sandi Guru BK {$bkUser->name} berhasil direset ke kata sandi default: {$newPassword}");
    }
}
