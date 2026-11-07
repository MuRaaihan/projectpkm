<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bk\BkProfileController;
use App\Http\Controllers\Bk\BkReportController;
use App\Http\Controllers\Bk\BkReportDownloadController;
use App\Http\Controllers\Bk\BkStatisticController;
use App\Http\Controllers\Bk\CategoryController;
use App\Http\Controllers\Master\AcademicYearController;
use App\Http\Controllers\Master\ActivityLogController;
use App\Http\Controllers\Master\BkUserController;
use App\Http\Controllers\Master\ClassOperationController;
use App\Http\Controllers\Master\ImportUserController;
use App\Http\Controllers\Master\SchoolClassController;
use App\Http\Controllers\Master\SettingController;
use App\Http\Controllers\Master\StudentUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PeriodicReportController;
use App\Http\Controllers\Siswa\StudentHelpController;
use App\Http\Controllers\Siswa\StudentProfileController;
use App\Http\Controllers\Siswa\StudentReportController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Models\AcademicYear;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\User;
use App\Services\ReportStatisticsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SISPERKA
|--------------------------------------------------------------------------
*/

// Beranda Publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/kebijakan-privasi', function () {
    return view('privacy');
})->name('privacy');

// Autentikasi Pengguna
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
});

// Tantangan 2FA saat Login (FR-08)
Route::get('/two-factor-challenge', [TwoFactorAuthController::class, 'challenge'])->name('two-factor.challenge');
Route::post('/two-factor-challenge', [TwoFactorAuthController::class, 'verify'])
    ->middleware('throttle:5,1')
    ->name('two-factor.verify');

// Rute Terotentikasi
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Ganti Password (Wajib & Mandiri)
    Route::get('/ganti-password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::put('/ganti-password', [PasswordController::class, 'updatePassword'])
        ->middleware('throttle:10,1')
        ->name('password.update');

    // Notifikasi Dalam Website
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/tandai-semua-dibaca', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifikasi/{notification}', [NotificationController::class, 'readAndRedirect'])->name('notifications.read');

    // Pengalihan umum /dashboard sesuai peran
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match ($user->role) {
            'master' => redirect()->route('master.dashboard'),
            'bk' => redirect()->route('bk.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('home'),
        };
    })->name('dashboard');

    // Fitur Bersama Staf (Master & Guru BK): 2FA & Laporan Periodik
    Route::middleware('role:master,bk')->group(function () {
        // Pengelolaan 2FA Mandiri (FR-08)
        Route::get('/two-factor-setup', [TwoFactorAuthController::class, 'showSetup'])->name('two-factor.setup');
        Route::post('/two-factor-setup/confirm', [TwoFactorAuthController::class, 'confirm'])->name('two-factor.confirm');
        Route::post('/two-factor-setup/disable', [TwoFactorAuthController::class, 'disable'])->name('two-factor.disable');
        Route::post('/two-factor-setup/regenerate-recovery-codes', [TwoFactorAuthController::class, 'regenerateRecoveryCodes'])->name('two-factor.regenerate-recovery-codes');

        // Laporan Periodik Otomatis (Bulanan & Semesteran)
        Route::get('/laporan-periodik', [PeriodicReportController::class, 'index'])->name('periodic-reports.index');
        Route::post('/laporan-periodik/generate', [PeriodicReportController::class, 'generate'])->name('periodic-reports.generate');
        Route::get('/laporan-periodik/{summary}', [PeriodicReportController::class, 'show'])->name('periodic-reports.show');
    });

    // Modul Master Admin
    Route::middleware('role:master')->prefix('master')->name('master.')->group(function () {
        Route::get('/dashboard', function (ReportStatisticsService $statsService) {
            $stats = [
                'students_count' => User::where('role', 'siswa')->count(),
                'bk_count' => User::where('role', 'bk')->count(),
                'classes_count' => SchoolClass::count(),
                'active_year' => AcademicYear::where('is_active', true)->first(),
                'report_stats' => $statsService->getAggregateStats(),
            ];

            return view('master.dashboard', $stats);
        })->name('dashboard');

        // Master Data: Tahun Ajaran
        Route::resource('academic-years', AcademicYearController::class)->except(['create', 'show', 'edit']);

        // Master Data: Kelas
        Route::resource('classes', SchoolClassController::class)->except(['create', 'show', 'edit']);

        // Akun Guru BK
        Route::resource('bk-users', BkUserController::class)->except(['show', 'destroy']);
        Route::post('bk-users/{bkUser}/toggle-status', [BkUserController::class, 'toggleStatus'])->name('bk-users.toggle-status');
        Route::delete('bk-users/{bkUser}/archive', [BkUserController::class, 'archive'])->name('bk-users.archive');
        Route::post('bk-users/{id}/restore', [BkUserController::class, 'restore'])->name('bk-users.restore');
        Route::delete('bk-users/{id}/force-delete', [BkUserController::class, 'forceDelete'])->name('bk-users.force-delete');
        Route::post('bk-users/{bkUser}/reset-password', [BkUserController::class, 'resetPassword'])->name('bk-users.reset-password');

        // Akun Siswa
        Route::resource('students', StudentUserController::class)->except(['show', 'destroy']);
        Route::post('students/{student}/toggle-status', [StudentUserController::class, 'toggleStatus'])->name('students.toggle-status');
        Route::delete('students/{student}/archive', [StudentUserController::class, 'archive'])->name('students.archive');
        Route::post('students/{id}/restore', [StudentUserController::class, 'restore'])->name('students.restore');
        Route::delete('students/{id}/force-delete', [StudentUserController::class, 'forceDelete'])->name('students.force-delete');
        Route::post('students/{student}/reset-password', [StudentUserController::class, 'resetPassword'])->name('students.reset-password');

        // Operasi Massal Kelas
        Route::get('class-operations', [ClassOperationController::class, 'index'])->name('class-operations.index');
        Route::post('class-operations/archive-students', [ClassOperationController::class, 'archiveClassStudents'])->name('class-operations.archive-students');
        Route::post('class-operations/preview-promotion', [ClassOperationController::class, 'previewPromotion'])->name('class-operations.preview-promotion');
        Route::post('class-operations/promote', [ClassOperationController::class, 'promoteClass'])->name('class-operations.promote');

        // Impor Excel
        Route::get('import', [ImportUserController::class, 'index'])->name('import.index');
        Route::get('import/template/siswa', [ImportUserController::class, 'downloadStudentTemplate'])->name('import.template.siswa');
        Route::get('import/template/bk', [ImportUserController::class, 'downloadBkTemplate'])->name('import.template.bk');
        Route::post('import/preview', [ImportUserController::class, 'preview'])
            ->middleware('throttle:15,1')
            ->name('import.preview');
        Route::get('import/download-failed', [ImportUserController::class, 'downloadFailed'])->name('import.download-failed');
        Route::post('import/confirm', [ImportUserController::class, 'confirm'])
            ->middleware('throttle:15,1')
            ->name('import.confirm');
        Route::get('import/download-credentials', [ImportUserController::class, 'downloadCredentials'])->name('import.download-credentials');

        // Log Aktivitas
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Pengaturan Website & Beranda (FR-17)
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Modul Guru BK
    Route::middleware('role:bk')->prefix('bk')->name('bk.')->group(function () {
        Route::get('/dashboard', function () {
            $stats = [
                'total_reports' => Report::count(),
                'new_reports' => Report::where('status', 'baru')->count(),
                'active_reports' => Report::whereIn('status', ['diverifikasi', 'diproses'])->count(),
                'resolved_reports' => Report::where('status', 'selesai')->count(),
                'recent_reports' => Report::with(['category', 'reporter'])->latest('created_at')->take(5)->get(),
            ];

            return view('bk.dashboard', $stats);
        })->name('dashboard');

        // Laporan Masuk
        Route::get('laporan', [BkReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/{report}', [BkReportController::class, 'show'])->name('reports.show');
        Route::post('laporan/{report}/lihat-identitas', [BkReportController::class, 'revealIdentity'])->name('reports.reveal-identity');
        Route::put('laporan/{report}/status', [BkReportController::class, 'updateStatus'])->name('reports.update-status');
        Route::put('laporan/{report}/urgency', [BkReportController::class, 'updateUrgency'])->name('reports.update-urgency');
        Route::post('laporan/{report}/catatan', [BkReportController::class, 'storeNote'])->name('reports.notes.store');
        Route::post('laporan/{report}/balasan', [BkReportController::class, 'storeMessage'])->name('reports.messages.store');
        Route::get('laporan/{report}/bukti/{attachment}', [BkReportController::class, 'downloadAttachment'])->name('reports.attachment');

        // Kelola Kategori
        Route::resource('kategori', CategoryController::class)
            ->parameters(['kategori' => 'category'])
            ->names('categories')
            ->except(['create', 'show', 'edit']);
        Route::post('kategori/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Statistik Penanganan Laporan
        Route::get('statistik', [BkStatisticController::class, 'index'])->name('statistics.index');

        // Unduh Laporan Resmi (PDF & Excel)
        Route::get('unduh-laporan', [BkReportDownloadController::class, 'index'])->name('reports.download.view');
        Route::post('unduh-laporan/pdf', [BkReportDownloadController::class, 'downloadPdf'])
            ->middleware('throttle:20,1')
            ->name('reports.download.pdf');
        Route::post('unduh-laporan/excel', [BkReportDownloadController::class, 'downloadExcel'])
            ->middleware('throttle:20,1')
            ->name('reports.download.excel');

        // Profil Guru BK
        Route::get('profil', [BkProfileController::class, 'show'])->name('profile.show');
        Route::put('profil', [BkProfileController::class, 'update'])->name('profile.update');
        Route::put('profil/password', [BkProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // Modul Siswa
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            $reportsQuery = $user->reports();

            $stats = [
                'total_reports' => (clone $reportsQuery)->count(),
                'active_reports' => (clone $reportsQuery)->whereIn('status', ['baru', 'diverifikasi', 'diproses'])->count(),
                'resolved_reports' => (clone $reportsQuery)->where('status', 'selesai')->count(),
                'recent_reports' => (clone $reportsQuery)->with('category')->latest()->take(5)->get(),
            ];

            return view('siswa.dashboard', $stats);
        })->name('dashboard');

        // Laporan Siswa
        Route::get('laporan', [StudentReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/buat', [StudentReportController::class, 'create'])->name('reports.create');
        Route::post('laporan', [StudentReportController::class, 'store'])
            ->middleware('throttle:10,1')
            ->name('reports.store');
        Route::get('laporan/{report}', [StudentReportController::class, 'show'])->name('reports.show');
        Route::post('laporan/{report}/susulan', [StudentReportController::class, 'storeFollowUp'])
            ->middleware('throttle:10,1')
            ->name('reports.follow-up');
        Route::get('laporan/{report}/bukti/{attachment}', [StudentReportController::class, 'downloadAttachment'])->name('reports.attachment');

        // Halaman Bantuan & Kontak Darurat (FR-39)
        Route::get('bantuan', [StudentHelpController::class, 'index'])->name('help');

        // Profil Siswa
        Route::get('profil', [StudentProfileController::class, 'show'])->name('profile');
        Route::put('profil/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
    });
});
