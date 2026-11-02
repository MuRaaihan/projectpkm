<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AppNotification;
use App\Models\Category;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\ReportMessage;
use App\Models\ReportNote;
use App\Models\ReportStatusHistory;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BkReportController extends Controller
{
    /**
     * Menampilkan daftar seluruh laporan dengan filter dan pencarian
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Report::class);

        $query = Report::with(['category', 'reporter']);

        // Filter status
        if ($request->filled('status') && in_array($request->status, ['baru', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // Filter urgensi (FR-27)
        if ($request->filled('urgency') && in_array($request->urgency, ['rendah', 'sedang', 'tinggi'])) {
            $query->where('urgency', $request->urgency);
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter kelas
        if ($request->filled('class_name')) {
            $query->where('reporter_class_name', $request->class_name);
        }

        // Filter tanggal kejadian
        if ($request->filled('date_from')) {
            $query->whereDate('incident_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('incident_date', '<=', $request->date_to);
        }

        // Pencarian ringkas berdasarkan ID atau nama kelas
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('reporter_class_name', 'like', "%{$search}%");
            });
        }

        // Pengurutan (default: terbaru; atau urgensi_desc)
        if ($request->query('sort') === 'urgency_desc') {
            $query->orderByRaw("CASE urgency WHEN 'tinggi' THEN 1 WHEN 'sedang' THEN 2 ELSE 3 END")
                ->latest('created_at');
        } else {
            $query->latest('created_at');
        }

        $reports = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $classes = SchoolClass::orderBy('name')->get();

        return view('bk.reports.index', compact('reports', 'categories', 'classes'));
    }

    /**
     * Menampilkan detail lengkap laporan
     */
    public function show(Report $report, Request $request)
    {
        Gate::authorize('view', $report);

        // Tandai otomatis notifikasi terkait laporan atau pesan susulan siswa ini sebagai telah dibaca
        AppNotification::markAsReadForReport($request->user()->id, $report);

        $report->load([
            'category',
            'reporter',
            'attachments',
            'messages.sender',
            'notes.user',
            'statusHistories.changer',
        ]);

        // Cek status buka identitas untuk pelapor rahasia pada sesi ini
        $identityRevealed = false;
        if ($report->is_hidden_identity) {
            $identityRevealed = session()->get("identity_revealed_{$report->id}", false);
        }

        return view('bk.reports.show', compact('report', 'identityRevealed'));
    }

    /**
     * Membuka identitas pelapor rahasia dan mencatat audit log
     */
    public function revealIdentity(Report $report)
    {
        Gate::authorize('revealIdentity', $report);

        if (! $report->is_hidden_identity) {
            return back()->with('info', 'Laporan ini tidak disembunyikan identitasnya.');
        }

        // Catat aksi ke activity_logs (audit trail keamanan)
        ActivityLog::record(
            action: 'identity_revealed',
            description: 'Guru BK '.Auth::user()->name.' membuka identitas pelapor rahasia untuk laporan #'.substr($report->id, 0, 8),
            subjectType: Report::class,
            subjectId: $report->id,
            userId: Auth::id(),
            ipAddress: '-', // Aturan keamanan: Tidak mencatat IP pada aksi terkait laporan
        );

        // Tandai dibuka pada sesi saat ini
        session()->put("identity_revealed_{$report->id}", true);

        return back()->with('info', 'Identitas asli pelapor rahasia telah dibuka untuk sesi ini. Pembukaan ini telah dicatat di log audit keamanan.');
    }

    /**
     * Memperbarui status laporan dan mencatat riwayat
     */
    public function updateStatus(Request $request, Report $report)
    {
        Gate::authorize('updateStatus', $report);

        $validated = $request->validate([
            'status' => 'required|in:baru,diverifikasi,diproses,selesai,ditolak',
            'reject_reason' => 'required_if:status,ditolak|nullable|string|min:5|max:1000',
            'status_note' => 'nullable|string|max:1000',
        ], [
            'reject_reason.required_if' => 'Alasan penolakan wajib diisi bila laporan ditolak.',
            'reject_reason.min' => 'Alasan penolakan minimal 5 karakter agar dapat dipahami pelapor.',
        ]);

        $oldStatus = $report->status;
        $newStatus = $validated['status'];

        $report->status = $newStatus;
        if ($newStatus === 'ditolak') {
            $report->reject_reason = $validated['reject_reason'];
            $report->closed_at = now();
        } elseif ($newStatus === 'selesai') {
            $report->closed_at = now();
        } else {
            $report->closed_at = null;
        }
        $report->save();

        // Simpan ke riwayat perubahan status
        ReportStatusHistory::create([
            'report_id' => $report->id,
            'from_status' => $oldStatus,
            'to_status' => $newStatus,
            'changed_by' => Auth::id(),
            'reason' => $newStatus === 'ditolak' ? $validated['reject_reason'] : ($validated['status_note'] ?? null),
            'created_at' => now(),
        ]);

        // Catat ke log aktivitas
        ActivityLog::record(
            action: 'report_status_updated',
            description: 'Status laporan #'.substr($report->id, 0, 8).' diubah dari '.$oldStatus.' menjadi '.$newStatus,
            subjectType: Report::class,
            subjectId: $report->id,
            userId: Auth::id(),
            ipAddress: '-',
        );

        // Kirim notifikasi ramah dalam website ke siswa pelapor
        if ($report->reporter_id) {
            AppNotification::send(
                userId: $report->reporter_id,
                type: 'status_updated',
                title: 'Status Laporan Diperbarui',
                message: 'Status laporanmu telah diperbarui menjadi "'.$report->status_label.'".',
                url: route('siswa.reports.show', $report),
            );
        }

        return back()->with('success', 'Status laporan berhasil diperbarui menjadi "'.$report->status_label.'".');
    }

    /**
     * Memperbarui tingkat urgensi laporan (FR-27: rendah, sedang, tinggi)
     */
    public function updateUrgency(Request $request, Report $report)
    {
        Gate::authorize('updateStatus', $report);

        $validated = $request->validate([
            'urgency' => 'required|in:rendah,sedang,tinggi',
        ], [
            'urgency.required' => 'Tingkat urgensi wajib dipilih.',
            'urgency.in' => 'Tingkat urgensi harus rendah, sedang, atau tinggi.',
        ]);

        $oldUrgency = $report->urgency;
        $report->urgency = $validated['urgency'];
        $report->save();

        ActivityLog::record(
            action: 'report_urgency_updated',
            description: 'Urgensi laporan #'.substr($report->id, 0, 8).' diubah dari '.$oldUrgency.' menjadi '.$report->urgency,
            subjectType: Report::class,
            subjectId: $report->id,
            userId: Auth::id(),
            ipAddress: '-',
        );

        return back()->with('success', 'Tingkat urgensi laporan berhasil diperbarui menjadi "'.ucfirst($report->urgency).'".');
    }

    /**
     * Menyimpan catatan internal rahasia Guru BK
     */
    public function storeNote(Request $request, Report $report)
    {
        Gate::authorize('addNote', $report);

        $validated = $request->validate([
            'note' => 'required|string|min:3|max:5000',
        ], [
            'note.required' => 'Catatan internal tidak boleh kosong.',
            'note.min' => 'Catatan internal minimal 3 karakter.',
        ]);

        ReportNote::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(),
            'note' => $validated['note'],
        ]);

        ActivityLog::record(
            action: 'report_note_added',
            description: 'Guru BK '.Auth::user()->name.' menambahkan catatan internal pada laporan #'.substr($report->id, 0, 8),
            subjectType: Report::class,
            subjectId: $report->id,
            userId: Auth::id(),
            ipAddress: '-',
        );

        return back()->with('success', 'Catatan internal penanganan berhasil disimpan dengan aman.');
    }

    /**
     * Mengirimkan balasan kepada siswa pelapor
     */
    public function storeMessage(Request $request, Report $report)
    {
        Gate::authorize('sendMessage', $report);

        $validated = $request->validate([
            'message' => 'required|string|min:3|max:5000',
        ], [
            'message.required' => 'Pesan balasan tidak boleh kosong.',
            'message.min' => 'Pesan balasan minimal 3 karakter.',
        ]);

        ReportMessage::create([
            'report_id' => $report->id,
            'sender_id' => Auth::id(),
            'sender_role' => 'bk',
            'message' => $validated['message'],
        ]);

        ActivityLog::record(
            action: 'report_message_sent',
            description: 'Guru BK '.Auth::user()->name.' mengirim balasan untuk laporan #'.substr($report->id, 0, 8),
            subjectType: Report::class,
            subjectId: $report->id,
            userId: Auth::id(),
            ipAddress: '-',
        );

        // Kirim notifikasi ke siswa pelapor
        if ($report->reporter_id) {
            AppNotification::send(
                userId: $report->reporter_id,
                type: 'message_received',
                title: 'Pesan Baru dari Guru BK',
                message: 'Guru BK telah mengirimkan pesan balasan untuk laporanmu.',
                url: route('siswa.reports.show', $report),
            );
        }

        return back()->with('success', 'Balasan untuk siswa berhasil dikirim.');
    }

    /**
     * Mengunduh / melihat berkas lampiran dengan otorisasi Guru BK
     */
    public function downloadAttachment(Report $report, ReportAttachment $attachment)
    {
        Gate::authorize('viewAttachment', $report);

        if ($attachment->report_id !== $report->id) {
            abort(404);
        }

        $filePath = 'reports/'.$attachment->stored_name;

        if (! Storage::disk('local')->exists($filePath)) {
            abort(404, 'File lampiran tidak ditemukan.');
        }

        return Storage::disk('local')->response(
            $filePath,
            $attachment->original_name,
            [
                'Content-Type' => $attachment->mime_type,
                'Content-Disposition' => 'inline; filename="'.addslashes($attachment->original_name).'"',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }
}
