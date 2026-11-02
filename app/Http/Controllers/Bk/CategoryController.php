<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar seluruh kategori perundungan
     */
    public function index()
    {
        Gate::authorize('viewAny', Category::class);

        $categories = Category::withCount('reports')
            ->orderBy('is_active', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('bk.categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori ini sudah terdaftar.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category = Category::create([
            'name' => trim($validated['name']),
            'description' => isset($validated['description']) ? trim($validated['description']) : null,
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        ActivityLog::record(
            action: 'category_created',
            description: 'Guru BK '.Auth::user()->name.' menambahkan kategori: '.$category->name,
            subjectType: Category::class,
            subjectId: $category->id,
            userId: Auth::id(),
        );

        return back()->with('success', 'Kategori "'.$category->name.'" berhasil ditambahkan.');
    }

    /**
     * Memperbarui kategori
     */
    public function update(Request $request, Category $category)
    {
        Gate::authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori ini sudah terdaftar.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category->update([
            'name' => trim($validated['name']),
            'description' => isset($validated['description']) ? trim($validated['description']) : null,
        ]);

        ActivityLog::record(
            action: 'category_updated',
            description: 'Guru BK '.Auth::user()->name.' memperbarui kategori: '.$category->name,
            subjectType: Category::class,
            subjectId: $category->id,
            userId: Auth::id(),
        );

        return back()->with('success', 'Kategori "'.$category->name.'" berhasil diperbarui.');
    }

    /**
     * Mengubah status aktif / nonaktif kategori
     */
    public function toggleStatus(Category $category)
    {
        Gate::authorize('update', $category);

        $category->is_active = ! $category->is_active;
        $category->save();

        $statusText = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::record(
            action: 'category_status_toggled',
            description: 'Guru BK '.Auth::user()->name.' mengubah status kategori "'.$category->name.'" menjadi '.$statusText,
            subjectType: Category::class,
            subjectId: $category->id,
            userId: Auth::id(),
        );

        return back()->with('success', 'Kategori "'.$category->name.'" berhasil '.$statusText.'.');
    }

    /**
     * Menghapus kategori bila belum digunakan oleh laporan
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        // Aturan Integritas PRD FR-26: Kategori yang sudah dipakai laporan tidak boleh dihapus
        if ($category->reports()->exists()) {
            return back()->with('error', 'Kategori "'.$category->name.'" tidak dapat dihapus karena sudah memiliki data laporan terkait. Anda dapat menonaktifkannya agar tidak muncul lagi pada form laporan baru.');
        }

        $name = $category->name;
        $category->delete();

        ActivityLog::record(
            action: 'category_deleted',
            description: 'Guru BK '.Auth::user()->name.' menghapus kategori: '.$name,
            subjectType: Category::class,
            subjectId: $category->id,
            userId: Auth::id(),
        );

        return back()->with('success', 'Kategori "'.$name.'" berhasil dihapus.');
    }
}
