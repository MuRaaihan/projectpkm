<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Report;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengelolaan konten sekolah dan beranda (FR-17).
     */
    public function index(): View
    {
        $settings = [
            'school_name' => Setting::get('school_name', 'MTs Soebono Mantofani'),
            'school_address' => Setting::get('school_address', 'Jl. Nurul Huda No. 27, RT 03/01, Jombang, Kec. Ciputat, Kota Tangerang Selatan, Banten 15414'),
            'school_phone' => Setting::get('school_phone', '(021) 745-1234'),
            'school_email' => Setting::get('school_email', 'bk@mtssoebonomantofani.sch.id'),
            'counseling_location' => Setting::get('counseling_location', 'Ruang Bimbingan & Konseling (BK), Gedung Utama MTs Soebono Mantofani'),
            'counseling_hours' => Setting::get('counseling_hours', 'Senin – Jumat, pukul 07.30 – 14.30 WIB'),
            'emergency_contact' => Setting::get('emergency_contact', 'Hubungi Ruang BK atau wali kelas masing-masing'),
            'hero_title' => Setting::get('hero_title', 'Kamu tidak sendirian. Ceritakan di sini, dengan aman.'),
            'hero_subtitle' => Setting::get('hero_subtitle', 'Jika kamu mengalami atau melihat perundungan (bullying) di sekolah, jangan ragu untuk bercerita. Laporanmu dijaga sepenuhnya secara rahasia dan langsung didampingi dengan tulus oleh Guru Bimbingan & Konseling (BK).'),
            'about_text' => Setting::get('about_text', 'SIPERKA (Sistem Pelaporan Perundungan MTs Soebono Mantofani) hadir sebagai ruang terpercaya bagi seluruh peserta didik madrasah untuk menyampaikan kejadian perundungan, kekerasan verbal, fisik, maupun siber, baik yang dialami sendiri maupun disaksikan pada teman sebaya.'),
            'data_retention_years' => (int) Setting::get('data_retention_years', 5),
        ];

        $retentionYears = (int) $settings['data_retention_years'];
        $expiredReportsCount = Report::whereIn('status', ['selesai', 'ditolak'])
            ->where('closed_at', '<=', now()->subYears($retentionYears))
            ->count();

        return view('master.settings.index', compact('settings', 'expiredReportsCount'));
    }

    /**
     * Simpan pembaruan pengaturan sistem oleh Master.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:100',
            'school_address' => 'required|string|max:300',
            'school_phone' => 'nullable|string|max:50',
            'school_email' => 'nullable|email|max:100',
            'counseling_location' => 'required|string|max:200',
            'counseling_hours' => 'required|string|max:100',
            'emergency_contact' => 'nullable|string|max:200',
            'hero_title' => 'required|string|max:150',
            'hero_subtitle' => 'required|string|max:500',
            'about_text' => 'required|string|max:1000',
            'data_retention_years' => 'nullable|integer|min:1|max:20',
        ], [
            'school_name.required' => 'Nama madrasah wajib diisi.',
            'school_address.required' => 'Alamat madrasah wajib diisi.',
            'hero_title.required' => 'Judul utama beranda wajib diisi.',
            'hero_subtitle.required' => 'Penjelasan utama beranda wajib diisi.',
            'data_retention_years.integer' => 'Masa retensi data harus berupa angka bulat tahun.',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'data_retention_years' && $value === null) {
                continue;
            }

            $group = match (true) {
                str_starts_with($key, 'hero_') || $key === 'about_text' => 'landing',
                $key === 'data_retention_years' => 'retention',
                default => 'school',
            };
            Setting::set($key, $value, $group);
        }

        ActivityLog::record(
            action: 'settings_updated',
            description: 'Master '.Auth::user()->name.' memperbarui pengaturan sekolah dan konten beranda.',
            subjectType: 'setting',
            subjectId: 'general',
            userId: Auth::id(),
            ipAddress: $request->ip()
        );

        return back()->with('success', 'Pengaturan informasi madrasah dan konten beranda berhasil diperbarui.');
    }
}
