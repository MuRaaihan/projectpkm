<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Models\ActivityLog;
use App\Models\AppNotification;
use App\Models\Category;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\ReportMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentReportController extends Controller
{
    /**
     * Menampilkan riwayat laporan milik siswa yang login
     */
    public function index(Request $request)
    {
        $reports = $request->user()
            ->reports()
            ->with(['category', 'attachments'])
            ->latest()
            ->paginate(10);

        return view('siswa.reports.index', compact('reports'));
    }

    /**
     * Formulir pembuatan laporan perundungan baru
     */
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('siswa.reports.create', compact('categories'));
    }

    /**
     * Simpan laporan perundungan baru
     */
    public function store(StoreReportRequest $request)
    {
        $user = $request->user();
        $class = $user->schoolClass;

        $report = DB::transaction(function () use ($request, $user, $class) {
            // 1. Simpan data laporan utama
            $report = Report::create([
                'reporter_id' => $user->id,
                'is_hidden_identity' => $request->boolean('is_hidden_identity'),
                'reporter_class_name' => $class?->name,
                'reporter_grade_level' => $class?->grade_level,
                'reporter_role' => $request->validated('reporter_role'),
                'category_id' => $request->validated('category_id'),
                'incident_date' => $request->validated('incident_date'),
                'location' => $request->validated('location'),
                'description' => $request->validated('description'),
                'accused_name' => $request->validated('accused_name'),
                'urgency' => 'sedang',
                'status' => 'baru',
            ]);

            // 2. Simpan lampiran berkas bukti (jika ada) di private storage
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $ext = strtolower($file->getClientOriginalExtension());
                    $storedName = Str::random(40).'.'.$ext;

                    // Hapus EXIF metadata untuk file JPEG jika fungsi GD tersedia
                    $savedViaGd = false;
                    if (in_array($ext, ['jpg', 'jpeg']) && function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
                        try {
                            $img = @imagecreatefromjpeg($file->getRealPath());
                            if ($img !== false) {
                                ob_start();
                                imagejpeg($img, null, 90);
                                $cleanContent = ob_get_clean();
                                imagedestroy($img);

                                if ($cleanContent !== false && $cleanContent !== '') {
                                    Storage::disk('local')->put('reports/'.$storedName, $cleanContent);
                                    $savedViaGd = true;
                                }
                            }
                        } catch (\Throwable $e) {
                            $savedViaGd = false;
                        }
                    }

                    if (! $savedViaGd) {
                        $file->storeAs('reports', $storedName, 'local');
                    }

                    $report->attachments()->create([
                        'stored_name' => $storedName,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size_bytes' => $file->getSize(),
                        'created_at' => now(),
                    ]);
                }
            }

            // 3. Catat entri awal riwayat status
            $report->statusHistories()->create([
                'from_status' => null,
                'to_status' => 'baru',
                'changed_by' => $user->id,
                'reason' => 'Laporan dibuat oleh pelapor.',
                'created_at' => now(),
            ]);

            // 4. Catat aktivitas (tanpa IP di laporan demi privasi)
            ActivityLog::record(
                'report_created',
                'Siswa membuat laporan perundungan baru.',
                'report',
                (string) $report->id,
                $user->id,
                '-'
            );

            // 5. Kirim notifikasi dalam website ke Guru BK aktif (tanpa data sensitif)
            $bkUsers = User::where('role', 'bk')->where('is_active', true)->get();
            foreach ($bkUsers as $bk) {
                AppNotification::send(
                    userId: $bk->id,
                    type: 'report_created',
                    title: 'Laporan Baru Masuk',
                    message: 'Ada laporan perundungan baru yang membutuhkan pemeriksaan Guru BK.',
                    url: route('bk.reports.show', $report),
                );
            }

            return $report;
        });

        return redirect()
            ->route('siswa.reports.show', $report)
            ->with('success', 'Laporanmu telah berhasil terkirim. Guru BK akan meninjau laporan ini.');
    }

    /**
     * Tampilkan detail laporan, status, riwayat status, dan balasan BK
     */
    public function show(Report $report, Request $request)
    {
        Gate::authorize('view', $report);

        // Tandai otomatis notifikasi terkait laporan atau pesan guru ini sebagai telah dibaca
        AppNotification::markAsReadForReport($request->user()->id, $report);

        // Hanya load balasan dan riwayat status (catatan internal notes TIDAK diload ke siswa)
        $report->load([
            'category',
            'attachments',
            'messages.sender',
            'statusHistories.changer',
        ]);

        return view('siswa.reports.show', compact('report'));
    }

    /**
     * Unduh / buka lampiran bukti secara privat dengan otorisasi
     */
    public function downloadAttachment(Report $report, ReportAttachment $attachment, Request $request)
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

    /**
     * Siswa mengirim informasi susulan / klarifikasi tambahan pada laporan aktif (FR-36).
     */
    public function storeFollowUp(Request $request, Report $report)
    {
        Gate::authorize('view', $report);

        if (in_array($report->status, ['selesai', 'ditolak'])) {
            return back()->with('error', 'Tidak dapat menambah informasi susulan karena laporan ini sudah ditutup.');
        }

        $validated = $request->validate([
            'message' => 'required|string|min:3|max:5000',
        ], [
            'message.required' => 'Informasi susulan tidak boleh kosong.',
            'message.min' => 'Informasi susulan minimal 3 karakter.',
            'message.max' => 'Informasi susulan maksimal 5000 karakter.',
        ]);

        ReportMessage::create([
            'report_id' => $report->id,
            'sender_id' => $request->user()->id,
            'sender_role' => 'siswa',
            'message' => $validated['message'],
        ]);

        ActivityLog::record(
            action: 'report_follow_up_added',
            description: 'Siswa menambahkan informasi susulan pada laporan #'.substr($report->id, 0, 8),
            subjectType: Report::class,
            subjectId: (string) $report->id,
            userId: $request->user()->id,
            ipAddress: '-',
        );

        // Kirim notifikasi ke seluruh Guru BK aktif
        $bkUsers = User::where('role', 'bk')->where('is_active', true)->get();
        foreach ($bkUsers as $bk) {
            AppNotification::send(
                userId: $bk->id,
                type: 'report_follow_up',
                title: 'Informasi Susulan Siswa',
                message: 'Ada informasi susulan baru dari siswa untuk laporan perundungan.',
                url: route('bk.reports.show', $report),
            );
        }

        return back()->with('success', 'Informasi susulan berhasil dikirimkan kepada Guru BK.');
    }
}
