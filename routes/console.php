<?php

use Illuminate\Support\Facades\Schedule;

// Jadwalkan pembuatan ringkasan statistik periodik bulanan setiap tanggal 1
Schedule::command('reports:generate-summary --period=monthly')->monthlyOn(1, '01:00');

// Jadwalkan peninjauan masa retensi data laporan setiap minggu
Schedule::command('reports:audit-retention')->weekly();
