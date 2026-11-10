<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Services\ReportExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BkReportDownloadController extends Controller
{
    /**
     * Tampilkan halaman filter unduh laporan resmi Guru BK
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->get();

        return view('bk.reports.download', compact('categories', 'classes'));
    }

    /**
     * Mengunduh rekapitulasi laporan dalam format PDF berlabel RAHASIA
     */
    public function downloadPdf(Request $request, ReportExportService $exportService)
    {
        $query = $this->buildFilterQuery($request);
        $reports = $query->get();

        ActivityLog::record(
            action: 'report_downloaded',
            description: 'Guru BK '.Auth::user()->name.' mengunduh rekapitulasi laporan dalam format PDF ('.$reports->count().' laporan).',
            subjectType: 'export',
            userId: Auth::id(),
        );

        $pdf = $exportService->exportPdf($reports, $request->all());

        return $pdf->download('rekap-laporan-siperka-rahasia-'.date('Ymd-His').'.pdf');
    }

    /**
     * Mengunduh rekapitulasi laporan dalam format Excel (.xlsx) dengan proteksi Formula Injection
     */
    public function downloadExcel(Request $request, ReportExportService $exportService)
    {
        $query = $this->buildFilterQuery($request);
        $reports = $query->get();

        ActivityLog::record(
            action: 'report_downloaded',
            description: 'Guru BK '.Auth::user()->name.' mengunduh rekapitulasi laporan dalam format Excel ('.$reports->count().' laporan).',
            subjectType: 'export',
            userId: Auth::id(),
        );

        return $exportService->exportExcel($reports, $request->all());
    }

    /**
     * Filter query helper untuk unduhan
     */
    protected function buildFilterQuery(Request $request)
    {
        $query = Report::with(['category', 'reporter'])->latest('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('class_name')) {
            $query->where('reporter_class_name', $request->class_name);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('incident_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('incident_date', '<=', $request->date_to);
        }

        return $query;
    }
}
