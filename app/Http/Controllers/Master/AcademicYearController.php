<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    /**
     * Tampilkan daftar tahun ajaran.
     */
    public function index(): View
    {
        $academicYears = AcademicYear::withCount('classes')
            ->orderByDesc('is_active')
            ->orderByDesc('id')
            ->paginate(15);

        return view('master.academic-years.index', [
            'academicYears' => $academicYears,
        ]);
    }

    /**
     * Simpan tahun ajaran baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:20', 'unique:academic_years,name'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'is_active' => ['boolean'],
        ], [
            'name.required' => 'Nama tahun ajaran wajib diisi.',
            'name.unique' => 'Nama tahun ajaran sudah ada.',
            'ends_on.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',
        ]);

        $isActive = $request->boolean('is_active');

        // Jika diset aktif, nonaktifkan tahun ajaran lainnya
        if ($isActive) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        $academicYear = AcademicYear::create([
            'name' => trim($validated['name']),
            'starts_on' => $validated['starts_on'] ?? null,
            'ends_on' => $validated['ends_on'] ?? null,
            'is_active' => $isActive,
        ]);

        ActivityLog::record(
            action: 'academic_year_created',
            description: "Menambahkan tahun ajaran baru: {$academicYear->name}",
            subjectType: 'academic_year',
            subjectId: (string) $academicYear->id
        );

        return redirect()->route('master.academic-years.index')
            ->with('success', "Tahun ajaran {$academicYear->name} berhasil ditambahkan.");
    }

    /**
     * Perbarui data tahun ajaran.
     */
    public function update(Request $request, AcademicYear $academicYear): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:20', Rule::unique('academic_years')->ignore($academicYear->id)],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'is_active' => ['boolean'],
        ], [
            'name.required' => 'Nama tahun ajaran wajib diisi.',
            'name.unique' => 'Nama tahun ajaran sudah ada.',
            'ends_on.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',
        ]);

        $isActive = $request->boolean('is_active');

        if ($isActive) {
            AcademicYear::where('id', '!=', $academicYear->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $academicYear->update([
            'name' => trim($validated['name']),
            'starts_on' => $validated['starts_on'] ?? null,
            'ends_on' => $validated['ends_on'] ?? null,
            'is_active' => $isActive,
        ]);

        ActivityLog::record(
            action: 'academic_year_updated',
            description: "Memperbarui tahun ajaran: {$academicYear->name}",
            subjectType: 'academic_year',
            subjectId: (string) $academicYear->id
        );

        return redirect()->route('master.academic-years.index')
            ->with('success', "Tahun ajaran {$academicYear->name} berhasil diperbarui.");
    }

    /**
     * Hapus tahun ajaran (hanya bila tidak memiliki kelas terdaftar).
     */
    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        if ($academicYear->classes()->count() > 0) {
            return back()->with('error', "Tahun ajaran {$academicYear->name} tidak dapat dihapus karena masih memiliki kelas yang terhubung.");
        }

        $name = $academicYear->name;
        $id = $academicYear->id;

        $academicYear->delete();

        ActivityLog::record(
            action: 'academic_year_deleted',
            description: "Menghapus tahun ajaran: {$name}",
            subjectType: 'academic_year',
            subjectId: (string) $id
        );

        return redirect()->route('master.academic-years.index')
            ->with('success', "Tahun ajaran {$name} berhasil dihapus.");
    }
}
