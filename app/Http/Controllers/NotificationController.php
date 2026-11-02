<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Menampilkan daftar seluruh notifikasi pengguna saat ini
     */
    public function index(Request $request)
    {
        $notifications = Auth::user()
            ->siteNotifications()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Menandai semua notifikasi pengguna sebagai sudah dibaca
     */
    public function markAllAsRead(Request $request)
    {
        Auth::user()
            ->siteNotifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Buka notifikasi, tandai sudah dibaca, dan arahkan ke tautan tujuan (dengan perlindungan IDOR)
     */
    public function readAndRedirect(AppNotification $notification)
    {
        // Perlindungan IDOR: Pengguna hanya boleh membuka notifikasi miliknya sendiri
        abort_unless($notification->user_id === Auth::id(), 403, 'Anda tidak berhak mengakses notifikasi ini.');

        $notification->markAsRead();

        if ($notification->url) {
            return redirect($notification->url);
        }

        return redirect()->route('notifications.index');
    }
}
