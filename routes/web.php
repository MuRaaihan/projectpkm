<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Master\AcademicYearController;
use App\Http\Controllers\Master\ActivityLogController;
use App\Http\Controllers\Master\BkUserController;
use App\Http\Controllers\Master\ClassOperationController;
use App\Http\Controllers\Master\ImportUserController;
use App\Http\Controllers\Master\SchoolClassController;
use App\Http\Controllers\Master\StudentUserController;
use App\Http\Controllers\PasswordController;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\User;
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
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute Terotentikasi
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Ganti Password (Wajib & Mandiri)
    Route::get('/ganti-password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::put('/ganti-password', [PasswordController::class, 'updatePassword'])->name('password.update');

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

    // Modul Master Admin
    Route::middleware('role:master')->prefix('master')->name('master.')->group(function () {
        Route::get('/dashboard', function () {
            $stats = [
                'students_count' => User::where('role', 'siswa')->count(),
                'bk_count' => User::where('role', 'bk')->count(),
                'classes_count' => SchoolClass::count(),
                'active_year' => AcademicYear::where('is_active', true)->first(),
            ];

            return view('master.dashboard', $stats);
        })->name('dashboard');

        // Master Data: Tahun Ajaran
        Route::resource('academic-years', AcademicYearController::class)->except(['create', 'show', 'edit']);

        // Master Data: Kelas
        Route::resource('classes', SchoolClassController::class)->except(['create', 'show', 'edit']);

        // Akun Guru BK
        Route::resource('bk-users', BkUserController::class);
        Route::post('bk-users/{bkUser}/toggle-status', [BkUserController::class, 'toggleStatus'])->name('bk-users.toggle-status');
        Route::delete('bk-users/{bkUser}/archive', [BkUserController::class, 'archive'])->name('bk-users.archive');
        Route::post('bk-users/{id}/restore', [BkUserController::class, 'restore'])->name('bk-users.restore');
        Route::delete('bk-users/{id}/force-delete', [BkUserController::class, 'forceDelete'])->name('bk-users.force-delete');
        Route::post('bk-users/{bkUser}/reset-password', [BkUserController::class, 'resetPassword'])->name('bk-users.reset-password');

        // Akun Siswa
        Route::resource('students', StudentUserController::class);
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
        Route::post('import/preview', [ImportUserController::class, 'preview'])->name('import.preview');
        Route::get('import/download-failed', [ImportUserController::class, 'downloadFailed'])->name('import.download-failed');
        Route::post('import/confirm', [ImportUserController::class, 'confirm'])->name('import.confirm');
        Route::get('import/download-credentials', [ImportUserController::class, 'downloadCredentials'])->name('import.download-credentials');

        // Log Aktivitas
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

    // Modul Guru BK
    Route::middleware('role:bk')->prefix('bk')->name('bk.')->group(function () {
        Route::get('/dashboard', function () {
            return view('bk.dashboard');
        })->name('dashboard');
    });

    // Modul Siswa
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            return view('siswa.dashboard');
        })->name('dashboard');
    });
});
