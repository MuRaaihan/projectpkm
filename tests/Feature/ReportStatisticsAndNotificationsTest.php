<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\AppNotification;
use App\Models\Category;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\User;
use App\Services\ReportExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportStatisticsAndNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected User $master;

    protected User $bk;

    protected User $siswaA;

    protected User $siswaB;

    protected Category $category;

    protected SchoolClass $class;

    protected function setUp(): void
    {
        parent::setUp();

        $year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $this->class = SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'VII-A',
            'grade_level' => 7,
        ]);

        $this->category = Category::create([
            'name' => 'Perundungan Siber',
            'description' => 'Cyberbullying di medsos',
            'is_active' => true,
        ]);

        $this->master = User::factory()->master()->create([
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->bk = User::factory()->bk()->create([
            'name' => 'Guru BK Utama',
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->siswaA = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'NIS2001',
            'name' => 'Siswa Rahasia A',
            'class_id' => $this->class->id,
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->siswaB = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'NIS2002',
            'name' => 'Siswa Budi B',
            'class_id' => $this->class->id,
            'must_change_password' => false,
            'is_active' => true,
        ]);
    }

    /**
     * 1. Master melihat data agregat statistik tanpa memuat kronologi atau identitas pelapor
     */
    public function test_master_sees_aggregate_report_stats_without_chronology_or_identities(): void
    {
        Report::create([
            'reporter_id' => $this->siswaA->id,
            'is_hidden_identity' => true,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Ruang Kelas',
            'description' => 'Ini isi teks rahasia perundungan yang tidak boleh dilihat Master sama sekali.',
            'accused_name' => 'Pelaku Rahasia',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->master)->get(route('master.dashboard'));

        $response->assertOk();
        // Master melihat angka agregat
        $response->assertSee('Statistik Agregat Laporan Perundungan');
        $response->assertSee('Total Laporan');
        $response->assertSee('Perundungan Siber');

        // Master TIDAK BOLEH melihat isi laporan atau identitas siswa
        $response->assertDontSee('Ini isi teks rahasia perundungan');
        $response->assertDontSee('Siswa Rahasia A');
        $response->assertDontSee('Pelaku Rahasia');
    }

    /**
     * 2. Guru BK dapat mengakses halaman statistik dan memfilter periode
     */
    public function test_bk_can_view_statistics_page_and_filter_by_period(): void
    {
        Report::create([
            'reporter_id' => $this->siswaA->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Deskripsi laporan',
            'urgency' => 'sedang',
            'status' => 'selesai',
        ]);

        $response = $this->actingAs($this->bk)->get(route('bk.statistics.index', [
            'year' => date('Y'),
            'month' => date('n'),
        ]));

        $response->assertOk();
        $response->assertSee('Statistik Penanganan Laporan');
        $response->assertSee('Selesai Ditangani');
        $response->assertSee('Perundungan Siber');
    }

    /**
     * 3. Guru BK dapat mengunduh rekap laporan format PDF berlabel RAHASIA
     */
    public function test_bk_can_download_confidential_pdf_report(): void
    {
        Report::create([
            'reporter_id' => $this->siswaA->id,
            'is_hidden_identity' => true,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan uji PDF',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->bk)->post(route('bk.reports.download.pdf'), [
            'status' => 'baru',
        ]);

        $response->assertOk();
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));

        // Tercatat di activity_logs
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'report_downloaded',
            'user_id' => $this->bk->id,
        ]);
    }

    /**
     * 4. Guru BK dapat mengunduh rekap laporan Excel dengan proteksi Formula Injection
     */
    public function test_bk_can_download_confidential_excel_report_with_formula_sanitization(): void
    {
        // Uji proteksi formula injection
        $this->assertEquals("'=SUM(A1:A10)", ReportExportService::sanitizeCellValue('=SUM(A1:A10)'));
        $this->assertEquals("'+12345", ReportExportService::sanitizeCellValue('+12345'));
        $this->assertEquals("'-12345", ReportExportService::sanitizeCellValue('-12345'));
        $this->assertEquals("'@cmd", ReportExportService::sanitizeCellValue('@cmd'));
        $this->assertEquals('Teks Normal', ReportExportService::sanitizeCellValue('Teks Normal'));

        Report::create([
            'reporter_id' => $this->siswaA->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan uji Excel',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->bk)->post(route('bk.reports.download.excel'));

        $response->assertOk();
        $this->assertStringContainsString('spreadsheetml.sheet', (string) $response->headers->get('content-type'));

        // Tercatat di activity_logs
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'report_downloaded',
            'user_id' => $this->bk->id,
        ]);
    }

    /**
     * 5. Master dan Siswa diblokir keras (403) dari mengunduh laporan
     */
    public function test_master_and_student_are_strictly_forbidden_from_downloading_reports(): void
    {
        // Master coba unduh PDF & Excel
        $this->actingAs($this->master)->post(route('bk.reports.download.pdf'))->assertForbidden();
        $this->actingAs($this->master)->post(route('bk.reports.download.excel'))->assertForbidden();

        // Siswa coba unduh PDF & Excel
        $this->actingAs($this->siswaA)->post(route('bk.reports.download.pdf'))->assertForbidden();
        $this->actingAs($this->siswaA)->post(route('bk.reports.download.excel'))->assertForbidden();
    }

    /**
     * 6. Siswa membuat laporan memicu notifikasi ke akun Guru BK
     */
    public function test_submitting_report_notifies_active_bk_users(): void
    {
        $response = $this->actingAs($this->siswaA)->post(route('siswa.reports.store'), [
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin madrasah',
            'description' => 'Saya didorong oleh teman sekelas saat jam makan siang.',
            'accused_name' => '',
            'is_hidden_identity' => '1',
        ]);

        $response->assertRedirect();

        // Notifikasi masuk ke Guru BK
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->bk->id,
            'type' => 'report_created',
            'title' => 'Laporan Baru Masuk',
        ]);
    }

    /**
     * 7. Guru BK memperbarui status laporan memicu notifikasi ke siswa pelapor
     */
    public function test_updating_report_status_notifies_student_reporter(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswaA->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Kasus perundungan',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $this->actingAs($this->bk)->put(route('bk.reports.update-status', $report), [
            'status' => 'diproses',
            'status_note' => 'Menjadwalkan konseling',
        ]);

        // Siswa menerima notifikasi
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->siswaA->id,
            'type' => 'status_updated',
            'title' => 'Status Laporan Diperbarui',
        ]);
    }

    /**
     * 8. Guru BK membalas laporan memicu notifikasi ke siswa pelapor
     */
    public function test_sending_message_notifies_student_reporter(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswaA->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Kasus perundungan',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $this->actingAs($this->bk)->post(route('bk.reports.messages.store', $report), [
            'message' => 'Silakan datang ke ruang BK saat jam istirahat ya.',
        ]);

        // Siswa menerima notifikasi pesan baru
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->siswaA->id,
            'type' => 'message_received',
            'title' => 'Pesan Baru dari Guru BK',
        ]);
    }

    /**
     * 9. Pengguna dapat melihat daftar notifikasi dan menandai sudah dibaca
     */
    public function test_user_can_view_notifications_and_mark_as_read(): void
    {
        $notif = AppNotification::send(
            userId: $this->siswaA->id,
            type: 'status_updated',
            title: 'Laporan Ditangani',
            message: 'Status laporanmu sedang ditangani.',
            url: route('siswa.reports.index'),
        );

        $this->assertFalse($notif->isRead());

        // Buka daftar notifikasi
        $listResponse = $this->actingAs($this->siswaA)->get(route('notifications.index'));
        $listResponse->assertOk();
        $listResponse->assertSee('Laporan Ditangani');

        // Buka notifikasi langsung (tandai dibaca dan diarahkan)
        $readResponse = $this->actingAs($this->siswaA)->get(route('notifications.read', $notif));
        $readResponse->assertRedirect(route('siswa.reports.index'));

        $notif->refresh();
        $this->assertTrue($notif->isRead());
    }

    /**
     * 10. Pengguna dilarang membuka notifikasi milik pengguna lain (IDOR Protection)
     */
    public function test_student_cannot_access_or_read_another_students_notification_idor_protection(): void
    {
        $notifMilikSiswaA = AppNotification::send(
            userId: $this->siswaA->id,
            type: 'status_updated',
            title: 'Notifikasi Siswa A',
            message: 'Pesan rahasia',
        );

        // Siswa B coba membuka notifikasi milik Siswa A -> harus ditolak 403
        $response = $this->actingAs($this->siswaB)->get(route('notifications.read', $notifMilikSiswaA));
        $response->assertForbidden();

        // Siswa B membuka daftar notifikasinya -> tidak boleh melihat notifikasi Siswa A
        $listResponse = $this->actingAs($this->siswaB)->get(route('notifications.index'));
        $listResponse->assertDontSee('Notifikasi Siswa A');
    }

    /**
     * 11. Notifikasi siswa otomatis ditandai dibaca saat membuka detail laporan / balasan guru
     */
    public function test_notification_automatically_marked_as_read_when_student_opens_report_detail(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'incident_date' => now()->subDay()->toDateString(),
            'location' => 'Kelas',
            'description' => 'Kejadian perundungan oleh teman sekelas.',
            'status' => 'baru',
            'urgency' => 'sedang',
        ]);

        $notif = AppNotification::send(
            userId: $this->siswaA->id,
            type: 'message_received',
            title: 'Pesan Baru dari Guru BK',
            message: 'Guru BK telah mengirimkan pesan balasan untuk laporanmu.',
            url: route('siswa.reports.show', $report),
        );

        $this->assertFalse($notif->isRead());
        $this->assertEquals(1, $this->siswaA->unreadNotificationsCount());

        // Siswa langsung membuka halaman detail laporan (tanpa membuka halaman notifikasi)
        $response = $this->actingAs($this->siswaA)->get(route('siswa.reports.show', $report));
        $response->assertOk();

        $notif->refresh();
        $this->assertTrue($notif->isRead());
        $this->assertEquals(0, $this->siswaA->unreadNotificationsCount());
    }

    /**
     * 12. Notifikasi Guru BK otomatis ditandai dibaca saat membuka detail laporan yang masuk
     */
    public function test_notification_automatically_marked_as_read_when_bk_opens_report_detail(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'incident_date' => now()->subDay()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan perundungan baru masuk.',
            'status' => 'baru',
            'urgency' => 'tinggi',
        ]);

        $notif = AppNotification::send(
            userId: $this->bk->id,
            type: 'report_created',
            title: 'Laporan Baru Masuk',
            message: 'Ada laporan perundungan baru yang membutuhkan pemeriksaan Guru BK.',
            url: route('bk.reports.show', $report),
        );

        $this->assertFalse($notif->isRead());
        $this->assertEquals(1, $this->bk->unreadNotificationsCount());

        // Guru BK langsung membuka detail laporan
        $response = $this->actingAs($this->bk)->get(route('bk.reports.show', $report));
        $response->assertOk();

        $notif->refresh();
        $this->assertTrue($notif->isRead());
        $this->assertEquals(0, $this->bk->unreadNotificationsCount());
    }
}
