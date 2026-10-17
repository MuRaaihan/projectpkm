<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ActivityLog;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    /**
     * Tampilkan daftar kelas.
     */
    public function index(Request $request): View
    {
        $selectedYearId = $request->input('academic_year_id');

        $query = SchoolClass::with('academicYear')
            ->withCount('students');

        if ($selectedYearId) {
            $query->where('academic_year_id', $selectedYearId);
        }

        $classes = $query->orderBy('grade_level')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $academicYears = AcademicYear::orderByDesc('is_active')
            ->orderByDesc('id')
            ->get();

        return view('master.classes.index', [
            'classes' => $classes,
            'academicYears' => $academicYears,
            'selectedYearId' => $selectedYearId,
        ]);
    }

    /**
     * Simpan kelas baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('academic_year_id', $request->input('academic_year_id'));
                }),
            ],
            'grade_level' => ['required', 'integer', 'in:7,8,9'],
        ], [
            'academic_year_id.required' => 'Tahun ajaran wajib dipilih.',
            'name.required' => 'Nama kelas wajib diisi.',
            'name.unique' => 'Nama kelas sudah terdaftar pada tahun ajaran ini.',
            'grade_level.in' => 'Tingkat kelas harus 7, 8, atau 9.',
        ]);

        $schoolClass = SchoolClass::create([
            'academic_year_id' => $validated['academic_year_id'],
            'name' => trim($validated['name']),
            'grade_level' => (int) $validated['grade_level'],
        ]);

        ActivityLog::record(
            action: 'class_created',
            description: "Menambahkan kelas baru: {$schoolClass->name} (Tingkat {$schoolClass->grade_level})",
            subjectType: 'class',
            subjectId: (string) $schoolClass->id
        );

        return redirect()->route('master.classes.index', ['academic_year_id' => $schoolClass->academic_year_id])
            ->with('success', "Kelas {$schoolClass->name} berhasil ditambahkan.");
    }

    /**
     * Perbarui data kelas.
     */
    public function update(Request $request, SchoolClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('academic_year_id', $request->input('academic_year_id'));
                })->ignore($class->id),
            ],
            'grade_level' => ['required', 'integer', 'in:7,8,9'],
        ], [
            'academic_year_id.required' => 'Tahun ajaran wajib dipilih.',
            'name.required' => 'Nama kelas wajib diisi.',
            'name.unique' => 'Nama kelas sudah terdaftar pada tahun ajaran ini.',
            'grade_level.in' => 'Tingkat kelas harus 7, 8, atau 9.',
        ]);

        $class->update([
            'academic_year_id' => $validated['academic_year_id'],
            'name' => trim($validated['name']),
            'grade_level' => (int) $validated['grade_level'],
        ]);

        ActivityLog::record(
            action: 'class_updated',
            description: "Memperbarui data kelas: {$class->name}",
            subjectType: 'class',
            subjectId: (string) $class->id
        );

        return redirect()->route('master.classes.index', ['academic_year_id' => $class->academic_year_id])
            ->with('success', "Kelas {$class->name} berhasil diperbarui.");
    }

    /**
     * Hapus kelas (hanya bila tidak memiliki data siswa).
     */
    public function destroy(SchoolClass $class): RedirectResponse
    {
        if ($class->students()->count() > 0) {
            return back()->with('error', "Kelas {$class->name} tidak dapat dihapus karena masih memiliki data siswa yang terhubung.");
        }

        $name = $class->name;
        $id = $class->id;
        $yearId = $class->academic_year_id;

        $class->delete();

        ActivityLog::record(
            action: 'class_deleted',
            description: "Menghapus kelas: {$name}",
            subjectType: 'class',
            subjectId: (string) $id
        );

        return redirect()->route('master.classes.index', ['academic_year_id' => $yearId])
            ->with('success', "Kelas {$name} berhasil dihapus.");
    }
}
