<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Services\ReportStatisticsService;
use Illuminate\Http\Request;

class BkStatisticController extends Controller
{
    /**
     * Tampilkan dashboard statistik penanganan laporan Guru BK
     */
    public function index(Request $request, ReportStatisticsService $statsService)
    {
        $year = $request->filled('year') ? (int) $request->year : null;
        $month = $request->filled('month') ? (int) $request->month : null;

        $stats = $statsService->getAggregateStats($year, $month);

        return view('bk.statistics.index', [
            'stats' => $stats,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }
}
