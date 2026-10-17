<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ClassOperationController extends Controller
{
    /**
     * Tampilkan antarmuka operasi massal kelas.
     */
    public function index(): View
    {
        $classes = SchoolClass::with('academicYear')
            ->withCount(['students' => function ($q) {
                $q->whereNull('deleted_at');
            }])
            ->orderBy('grade_level')
            ->orderBy('name')
            ->get();

        return view('master.class-operations.index', [
            'classes' => $classes,
        ]);
    }

    /**
     * Arsipkan seluruh akun siswa pada kelas tertentu (FR-12).
     * Wajib konfirmasi kata sandi Master.
     */
    public function archiveClassStudents(Request $request): RedirectResponse
    {
        $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'master_password' => ['required', 'string'],
        ], [
            'class_id.required' => 'Kelas yang akan diarsipkan wajib dipilih.',
            'master_password.required' => 'Kata sandi Master wajib diisi untuk konfirmasi pengarsipan massal.',
        ]);

        if (! Hash::check($request->input('master_password'), $request->user()->password)) {
            return back()->with('error', 'Konfirmasi kata sandi Master salah. Pengarsipan massal dibatalkan demi keamanan.');
        }

        $class = SchoolClass::findOrFail($request->input('class_id'));

        $query = User::where('role', 'siswa')
            ->where('class_id', $class->id);

        $count = $query->count();

        if ($count === 0) {
            return back()->with('warning', "Tidak ada siswa aktif yang terdaftar di kelas {$class->name}.");
        }

        // Soft-delete (arsip) seluruh siswa di kelas ini
        $query->delete();

        ActivityLog::record(
            action: 'class_users_archived',
            description: "Mengarsipkan secara massal {$count} akun siswa pada kelas {$class->name}",
            subjectType: 'class',
            subjectId: (string) $class->id
        );

        return back()->with('success', "Sebanyak {$count} akun siswa pada kelas {$class->name} berhasil diarsipkan.");
    }

    /**
     * Pratinjau kenaikan / perpindahan kelas massal (FR-13).
     */
    public function previewPromotion(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'from_class_id' => ['required', 'exists:classes,id', 'different:to_class_id'],
            'to_class_id' => ['required', 'exists:classes,id'],
        ], [
            'from_class_id.required' => 'Kelas asal wajib dipilih.',
            'to_class_id.required' => 'Kelas tujuan wajib dipilih.',
            'from_class_id.different' => 'Kelas tujuan harus berbeda dari kelas asal.',
        ]);

        $fromClass = SchoolClass::with('academicYear')->findOrFail($validated['from_class_id']);
        $toClass = SchoolClass::with('academicYear')->findOrFail($validated['to_class_id']);

        $students = User::where('role', 'siswa')
            ->where('class_id', $fromClass->id)
            ->orderBy('name')
            ->get();

        if ($students->isEmpty()) {
            return back()->with('warning', "Kelas {$fromClass->name} tidak memiliki siswa aktif untuk dipindahkan.");
        }

        return view('master.class-operations.preview-promotion', [
            'fromClass' => $fromClass,
            'toClass' => $toClass,
            'students' => $students,
        ]);
    }

    /**
     * Eksekusi kenaikan / perpindahan kelas massal (FR-13).
     */
    public function promoteClass(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'from_class_id' => ['required', 'exists:classes,id', 'different:to_class_id'],
            'to_class_id' => ['required', 'exists:classes,id'],
        ], [
            'from_class_id.required' => 'Kelas asal wajib dipilih.',
            'to_class_id.required' => 'Kelas tujuan wajib dipilih.',
            'from_class_id.different' => 'Kelas tujuan harus berbeda dari kelas asal.',
        ]);

        $fromClass = SchoolClass::findOrFail($validated['from_class_id']);
        $toClass = SchoolClass::findOrFail($validated['to_class_id']);

        $query = User::where('role', 'siswa')
            ->where('class_id', $fromClass->id);

        $count = $query->count();

        if ($count === 0) {
            return redirect()->route('master.class-operations.index')
                ->with('warning', "Tidak ada siswa pada kelas {$fromClass->name} untuk dipindahkan.");
        }

        // Pindahkan kelas
        $query->update([
            'class_id' => $toClass->id,
        ]);

        ActivityLog::record(
            action: 'class_promoted',
            description: "Memindahkan / menaikkan {$count} siswa dari kelas {$fromClass->name} ke {$toClass->name}",
            subjectType: 'class',
            subjectId: (string) $toClass->id
        );

        return redirect()->route('master.class-operations.index')
            ->with('success', "Sebanyak {$count} siswa berhasil dipindahkan dari kelas {$fromClass->name} ke {$toClass->name}.");
    }
}
