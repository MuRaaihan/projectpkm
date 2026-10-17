<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentUserController extends Controller
{
    /**
     * Tampilkan daftar akun Siswa.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status', 'active');
        $classId = $request->input('class_id');
        $search = $request->input('q');

        $query = User::where('role', 'siswa')
            ->with('schoolClass');

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

        if ($classId) {
            $query->where('class_id', $classId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('login_id', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $classes = SchoolClass::orderBy('grade_level')
            ->orderBy('name')
            ->get();

        return view('master.students.index', [
            'students' => $students,
            'classes' => $classes,
            'status' => $status,
            'classId' => $classId,
            'search' => $search,
        ]);
    }

    /**
     * Tampilkan formulir tambah akun siswa.
     */
    public function create(): View
    {
        $classes = SchoolClass::orderBy('grade_level')
            ->orderBy('name')
            ->get();

        return view('master.students.create', [
            'classes' => $classes,
        ]);
    }

    /**
     * Simpan akun siswa baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login_id' => ['required', 'string', 'max:50', 'unique:users,login_id'],
            'name' => ['required', 'string', 'max:100'],
            'class_id' => ['required', 'exists:classes,id'],
            'gender' => ['required', 'in:L,P'],
            'password' => ['nullable', 'string', 'min:8'],
        ], [
            'login_id.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'login_id.unique' => 'NIS ini sudah digunakan oleh akun lain.',
            'name.required' => 'Nama lengkap siswa wajib diisi.',
            'class_id.required' => 'Kelas wajib dipilih.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $plainPassword = ! empty($validated['password']) ? $validated['password'] : ('Siswa'.Str::random(3).'!'.rand(10, 99));

        $user = User::create([
            'role' => 'siswa',
            'login_id' => trim($validated['login_id']),
            'name' => trim($validated['name']),
            'class_id' => $validated['class_id'],
            'gender' => $validated['gender'],
            'password' => Hash::make($plainPassword),
            'is_active' => true,
            'must_change_password' => true,
        ]);

        ActivityLog::record(
            action: 'user_created',
            description: "Menambahkan akun siswa baru: {$user->name} (NIS: {$user->login_id})",
            subjectType: 'user',
            subjectId: (string) $user->id
        );

        return redirect()->route('master.students.index', ['class_id' => $user->class_id])
            ->with('success', "Akun siswa {$user->name} berhasil dibuat. Kata sandi awal: {$plainPassword}");
    }

    /**
     * Tampilkan formulir ubah data siswa.
     */
    public function edit(User $student): View
    {
        abort_unless($student->role === 'siswa', 404);

        $classes = SchoolClass::orderBy('grade_level')
            ->orderBy('name')
            ->get();

        return view('master.students.edit', [
            'student' => $student,
            'classes' => $classes,
        ]);
    }

    /**
     * Perbarui data akun siswa.
     */
    public function update(Request $request, User $student): RedirectResponse
    {
        abort_unless($student->role === 'siswa', 404);

        $validated = $request->validate([
            'login_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'login_id')->ignore($student->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'class_id' => ['required', 'exists:classes,id'],
            'gender' => ['required', 'in:L,P'],
        ], [
            'login_id.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'login_id.unique' => 'NIS ini sudah digunakan oleh akun lain.',
            'name.required' => 'Nama lengkap siswa wajib diisi.',
            'class_id.required' => 'Kelas wajib dipilih.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $student->update([
            'login_id' => trim($validated['login_id']),
            'name' => trim($validated['name']),
            'class_id' => $validated['class_id'],
            'gender' => $validated['gender'],
        ]);

        ActivityLog::record(
            action: 'user_updated',
            description: "Memperbarui data siswa: {$student->name} (NIS: {$student->login_id})",
            subjectType: 'user',
            subjectId: (string) $student->id
        );

        return redirect()->route('master.students.index', ['class_id' => $student->class_id])
            ->with('success', "Data siswa {$student->name} berhasil diperbarui.");
    }

    /**
     * Aktifkan atau nonaktifkan akun siswa.
     */
    public function toggleStatus(User $student): RedirectResponse
    {
        abort_unless($student->role === 'siswa', 404);

        $student->update([
            'is_active' => ! $student->is_active,
        ]);

        $statusText = $student->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';
        $action = $student->is_active ? 'user_updated' : 'user_deactivated';

        ActivityLog::record(
            action: $action,
            description: "Akun siswa {$student->name} (NIS: {$student->login_id}) {$statusText}",
            subjectType: 'user',
            subjectId: (string) $student->id
        );

        return redirect()->route('master.students.index', ['class_id' => $student->class_id])
            ->with('success', "Akun siswa {$student->name} berhasil {$statusText}.");
    }

    /**
     * Arsipkan akun siswa (Soft delete default).
     */
    public function archive(User $student): RedirectResponse
    {
        abort_unless($student->role === 'siswa', 404);

        $name = $student->name;
        $id = $student->id;
        $classId = $student->class_id;

        $student->delete();

        ActivityLog::record(
            action: 'user_archived',
            description: "Mengarsipkan akun siswa: {$name}",
            subjectType: 'user',
            subjectId: (string) $id
        );

        return redirect()->route('master.students.index', ['class_id' => $classId])
            ->with('success', "Akun siswa {$name} berhasil diarsipkan.");
    }

    /**
     * Pulihkan akun siswa dari arsip.
     */
    public function restore(int $id): RedirectResponse
    {
        $student = User::onlyTrashed()->where('role', 'siswa')->findOrFail($id);
        $student->restore();

        ActivityLog::record(
            action: 'user_updated',
            description: "Memulihkan akun siswa dari arsip: {$student->name}",
            subjectType: 'user',
            subjectId: (string) $student->id
        );

        return redirect()->route('master.students.index', ['status' => 'archived'])
            ->with('success', "Akun siswa {$student->name} berhasil dipulihkan.");
    }

    /**
     * Hapus permanen akun siswa (Wajib konfirmasi kata sandi Master).
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

        $student = User::withTrashed()->where('role', 'siswa')->findOrFail($id);
        $name = $student->name;
        $loginId = $student->login_id;

        $student->forceDelete();

        ActivityLog::record(
            action: 'user_deleted_permanently',
            description: "Menghapus permanen akun siswa: {$name} (NIS: {$loginId})",
            subjectType: 'user',
            subjectId: (string) $id
        );

        return redirect()->route('master.students.index')
            ->with('success', "Akun siswa {$name} telah dihapus secara permanen.");
    }

    /**
     * Reset password siswa oleh Master.
     */
    public function resetPassword(User $student): RedirectResponse
    {
        abort_unless($student->role === 'siswa', 404);

        $newPassword = 'Siswa'.Str::random(3).'!'.rand(10, 99);

        $student->update([
            'password' => Hash::make($newPassword),
            'must_change_password' => true,
        ]);

        ActivityLog::record(
            action: 'password_reset',
            description: "Master mereset kata sandi siswa: {$student->name} (NIS: {$student->login_id})",
            subjectType: 'user',
            subjectId: (string) $student->id
        );

        return redirect()->route('master.students.index', ['class_id' => $student->class_id])
            ->with('success', "Kata sandi siswa {$student->name} berhasil direset. Kata sandi sementara: {$newPassword}");
    }
}
