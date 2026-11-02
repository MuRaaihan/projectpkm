<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PeriodicReportSummary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PeriodicReportController extends Controller
{
    /**
     * Tampilkan daftar rekap laporan periodik otomatis.
     */
    public function index(Request $request): View
    {
        $query = PeriodicReportSummary::query()->orderByDesc('start_date');

        if ($request->filled('type') && in_array($request->type, ['monthly', 'semester'])) {
            $query->where('period_type', $request->type);
        }

        $summaries = $query->paginate(12)->withQueryString();

        return view('reports.periodic.index', compact('summaries'));
    }

    /**
     * Tampilkan rincian statistik periodik (tanpa data identitas siswa/cerita sensitif).
     */
    public function show(PeriodicReportSummary $summary): View
    {
        return view('reports.periodic.show', compact('summary'));
    }

    /**
     * Picu pembuatan ringkasan periodik secara manual lewat website.
     */
    public function generate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period' => 'required|in:monthly,semester',
            'date' => 'nullable|date',
        ], [
            'period.required' => 'Jenis periode wajib dipilih.',
            'period.in' => 'Jenis periode harus bulanan atau semester.',
        ]);

        $params = [
            '--period' => $validated['period'],
        ];

        if (! empty($validated['date'])) {
            $params['--date'] = $validated['date'];
        }

        Artisan::call('reports:generate-summary', $params);

        ActivityLog::record(
            action: 'periodic_summary_generated',
            description: 'Membuat ringkasan laporan periodik '.$validated['period'],
            subjectType: PeriodicReportSummary::class,
            subjectId: null,
            userId: Auth::id(),
            ipAddress: $request->ip()
        );

        return back()->with('success', 'Ringkasan laporan periodik berhasil diperbarui secara otomatis.');
    }
}
