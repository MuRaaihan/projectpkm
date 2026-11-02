<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\PeriodicReportSummary;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GeneratePeriodicSummaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate-summary 
                            {--period=monthly : monthly atau semester} 
                            {--date= : Tanggal referensi (YYYY-MM atau YYYY-MM-DD)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghasilkan ringkasan laporan periodik otomatis (bulanan/semester) tanpa data sensitif';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $periodType = strtolower((string) $this->option('period'));
        if (! in_array($periodType, ['monthly', 'semester'])) {
            $this->error('Parameter --period harus bernilai "monthly" atau "semester".');

            return 1;
        }

        $dateInput = $this->option('date') ?: now()->toDateString();
        $refDate = Carbon::parse($dateInput)->locale('id');

        if ($periodType === 'monthly') {
            $startDate = $refDate->copy()->startOfMonth()->toDateString();
            $endDate = $refDate->copy()->endOfMonth()->toDateString();
            $periodLabel = $refDate->isoFormat('MMMM Y');
        } else {
            // Semester Ganjil (Juli - Desember), Semester Genap (Januari - Juni)
            if ($refDate->month >= 7) {
                $yearNext = $refDate->year + 1;
                $periodLabel = "Semester Ganjil {$refDate->year}/{$yearNext}";
                $startDate = Carbon::create($refDate->year, 7, 1)->toDateString();
                $endDate = Carbon::create($refDate->year, 12, 31)->toDateString();
            } else {
                $yearPrev = $refDate->year - 1;
                $periodLabel = "Semester Genap {$yearPrev}/{$refDate->year}";
                $startDate = Carbon::create($refDate->year, 1, 1)->toDateString();
                $endDate = Carbon::create($refDate->year, 6, 30)->toDateString();
            }
        }

        $this->info("Memproses ringkasan {$periodType}: {$periodLabel} ({$startDate} s/d {$endDate})...");

        // Ambil data agregat laporan pada rentang tanggal tersebut
        $reportsQuery = Report::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        $totalReports = (clone $reportsQuery)->count();
        $newReports = (clone $reportsQuery)->where('status', 'baru')->count();
        $inProcessReports = (clone $reportsQuery)->whereIn('status', ['diverifikasi', 'diproses'])->count();
        $resolvedReports = (clone $reportsQuery)->where('status', 'selesai')->count();
        $rejectedReports = (clone $reportsQuery)->where('status', 'ditolak')->count();

        $urgentHigh = (clone $reportsQuery)->where('urgency', 'tinggi')->count();
        $urgentMedium = (clone $reportsQuery)->where('urgency', 'sedang')->count();
        $urgentLow = (clone $reportsQuery)->where('urgency', 'rendah')->count();

        // Agregasi kategori (tanpa memuat identitas atau kronologi cerita)
        $categoriesBreakdown = (clone $reportsQuery)
            ->select('category_id', DB::raw('count(*) as count'))
            ->groupBy('category_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $categoryName = Category::find($item->category_id)?->name ?? 'Lainnya';

                return [$categoryName => $item->count];
            })
            ->toArray();

        // Agregasi kelas siswa
        $classesBreakdown = (clone $reportsQuery)
            ->select('reporter_class_name', DB::raw('count(*) as count'))
            ->whereNotNull('reporter_class_name')
            ->groupBy('reporter_class_name')
            ->orderBy('reporter_class_name')
            ->pluck('count', 'reporter_class_name')
            ->toArray();

        // Rata-rata durasi penanganan (dalam hari) untuk laporan yang selesai
        $avgDays = (clone $reportsQuery)
            ->where('status', 'selesai')
            ->whereNotNull('closed_at')
            ->selectRaw('AVG(DATEDIFF(closed_at, created_at)) as avg_duration')
            ->value('avg_duration');

        $avgResolutionDays = $avgDays !== null ? round((float) $avgDays, 2) : null;

        // Simpan atau perbarui data ringkasan periodik
        $summary = PeriodicReportSummary::updateOrCreate(
            [
                'period_type' => $periodType,
                'period_label' => $periodLabel,
            ],
            [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_reports' => $totalReports,
                'new_reports' => $newReports,
                'in_process_reports' => $inProcessReports,
                'resolved_reports' => $resolvedReports,
                'rejected_reports' => $rejectedReports,
                'urgent_high_reports' => $urgentHigh,
                'urgent_medium_reports' => $urgentMedium,
                'urgent_low_reports' => $urgentLow,
                'categories_breakdown' => $categoriesBreakdown,
                'classes_breakdown' => $classesBreakdown,
                'avg_resolution_days' => $avgResolutionDays,
                'generated_at' => now(),
            ]
        );

        $this->info("Ringkasan berhasil disimpan! ID: {$summary->id}, Total Laporan: {$totalReports}");

        return 0;
    }
}
