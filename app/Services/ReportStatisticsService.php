<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Report;
use Carbon\Carbon;

class ReportStatisticsService
{
    /**
     * Mengambil statistik laporan agregat murni tanpa isi kronologi maupun identitas pelapor.
     * Sesuai ketentuan PRD FR-15 (Master) dan FR-28 (Guru BK).
     */
    public function getAggregateStats(?int $year = null, ?int $month = null): array
    {
        $baseQuery = Report::query();

        if ($year) {
            $baseQuery->whereYear('created_at', $year);
        }
        if ($month) {
            $baseQuery->whereMonth('created_at', $month);
        }

        // Metrik Angka Ringkasan
        $totalReports = (clone $baseQuery)->count();
        $newReports = (clone $baseQuery)->where('status', 'baru')->count();
        $activeReports = (clone $baseQuery)->whereIn('status', ['diverifikasi', 'diproses'])->count();
        $resolvedReports = (clone $baseQuery)->where('status', 'selesai')->count();
        $rejectedReports = (clone $baseQuery)->where('status', 'ditolak')->count();

        // 1. Tren Laporan 6 Bulan Terakhir
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('Y-m');
            $label = $date->translatedFormat('M Y');

            $count = Report::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyTrend[] = [
                'label' => $label,
                'count' => $count,
            ];
        }

        // 2. Sebaran Kategori Perundungan
        $categories = Category::all();
        $categoryDistribution = [];
        foreach ($categories as $cat) {
            $count = (clone $baseQuery)->where('category_id', $cat->id)->count();
            if ($count > 0 || $categories->count() <= 10) {
                $categoryDistribution[] = [
                    'label' => $cat->name,
                    'count' => $count,
                ];
            }
        }

        // 3. Sebaran Status Laporan
        $statusLabels = [
            'baru' => 'Baru',
            'diverifikasi' => 'Sudah dibaca',
            'diproses' => 'Sedang ditangani',
            'selesai' => 'Selesai',
            'ditolak' => 'Tidak dapat diproses',
        ];
        $statusDistribution = [];
        foreach ($statusLabels as $statusKey => $label) {
            $statusDistribution[] = [
                'label' => $label,
                'count' => (clone $baseQuery)->where('status', $statusKey)->count(),
            ];
        }

        // 4. Sebaran Berdasarkan Tingkat Kelas (7, 8, 9)
        $gradeDistribution = [];
        for ($grade = 7; $grade <= 9; $grade++) {
            $gradeDistribution[] = [
                'label' => 'Kelas '.$grade,
                'count' => (clone $baseQuery)->where('reporter_grade_level', $grade)->count(),
            ];
        }

        return [
            'total_reports' => $totalReports,
            'new_reports' => $newReports,
            'active_reports' => $activeReports,
            'resolved_reports' => $resolvedReports,
            'rejected_reports' => $rejectedReports,
            'monthly_trend' => $monthlyTrend,
            'category_distribution' => $categoryDistribution,
            'status_distribution' => $statusDistribution,
            'grade_distribution' => $gradeDistribution,
        ];
    }
}
