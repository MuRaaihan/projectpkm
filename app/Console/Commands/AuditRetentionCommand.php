<?php

namespace App\Console\Commands;

use App\Models\Report;
use App\Models\Setting;
use Illuminate\Console\Command;

class AuditRetentionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:audit-retention 
                            {--years= : Masa retensi dalam tahun (opsional, bawaan dari pengaturan)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Meninjau laporan tertutup yang telah melampaui batas masa retensi data madrasah';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $years = (int) ($this->option('years') ?: Setting::get('data_retention_years', 5));
        $cutoffDate = now()->subYears($years);

        $this->info("Meninjau laporan tertutup sebelum tanggal {$cutoffDate->toDateString()} (Retensi: {$years} tahun)...");

        $expiredReports = Report::whereIn('status', ['selesai', 'ditolak'])
            ->where('closed_at', '<=', $cutoffDate)
            ->get(['id', 'status', 'reporter_class_name', 'created_at', 'closed_at']);

        $totalExpired = $expiredReports->count();

        if ($totalExpired === 0) {
            $this->info("Tidak ada laporan yang melampaui masa retensi {$years} tahun.");

            return 0;
        }

        $this->warn("Ditemukan {$totalExpired} laporan tertutup yang melampaui masa retensi {$years} tahun:");

        $tableData = $expiredReports->map(function ($r) {
            return [
                'ID' => substr($r->id, 0, 8).'...',
                'Status' => $r->status,
                'Kelas' => $r->reporter_class_name ?? '-',
                'Dibuat' => $r->created_at->format('Y-m-d'),
                'Ditutup' => $r->closed_at ? $r->closed_at->format('Y-m-d') : '-',
            ];
        })->toArray();

        $this->table(['ID Ringkas', 'Status', 'Kelas', 'Tanggal Dibuat', 'Tanggal Ditutup'], $tableData);

        $this->comment('Catatan Keamanan: Evaluasi penghapusan permanen atau pemusnahan berkas hanya dapat diputuskan oleh Master Administrator madrasah.');

        return 0;
    }
}
