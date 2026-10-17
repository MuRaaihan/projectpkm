<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan daftar log audit aktivitas sistem (Read-only).
     */
    public function index(Request $request): View
    {
        $action = $request->input('action');
        $search = $request->input('q');

        $query = ActivityLog::with('user')
            ->orderByDesc('created_at');

        if ($action) {
            $query->where('action', $action);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('login_id', 'like', "%{$search}%");
                    });
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        $actionTypes = [
            'login_success' => 'Login Berhasil',
            'login_failed' => 'Login Gagal',
            'logout' => 'Logout',
            'password_changed' => 'Ganti Kata Sandi',
            'password_reset' => 'Reset Kata Sandi',
            'user_created' => 'Buat Pengguna',
            'user_updated' => 'Perbarui Pengguna',
            'user_deactivated' => 'Nonaktifkan Pengguna',
            'user_archived' => 'Arsipkan Pengguna',
            'user_deleted_permanently' => 'Hapus Permanen',
            'academic_year_created' => 'Buat Tahun Ajaran',
            'academic_year_updated' => 'Perbarui Tahun Ajaran',
            'academic_year_deleted' => 'Hapus Tahun Ajaran',
            'class_created' => 'Buat Kelas',
            'class_updated' => 'Perbarui Kelas',
            'class_deleted' => 'Hapus Kelas',
            'class_users_archived' => 'Arsip Siswa per Kelas',
            'class_promoted' => 'Kenaikan / Pindah Kelas',
            'excel_imported' => 'Impor Excel',
            'credentials_exported' => 'Ekspor Kredensial',
        ];

        return view('master.activity-logs.index', [
            'logs' => $logs,
            'actionTypes' => $actionTypes,
            'selectedAction' => $action,
            'search' => $search,
        ]);
    }
}
