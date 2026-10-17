<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
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
            return view('master.dashboard');
        })->name('dashboard');
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
