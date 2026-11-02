<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BkReportManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $bk;

    protected User $siswa;

    protected User $master;

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
            'name' => 'VIII-B',
            'grade_level' => 8,
        ]);

        $this->category = Category::create([
            'name' => 'Perundungan Verbal',
            'description' => 'Ejekan, makian, dan penghinaan',
            'is_active' => true,
        ]);

        $this->bk = User::factory()->bk()->create([
            'login_id' => 'NIP_BK01',
            'name' => 'Ibu Siti Khadijah, S.Pd',
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->siswa = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'NIS1001',
            'name' => 'Ahmad Raka',
            'class_id' => $this->class->id,
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->master = User::factory()->master()->create([
            'must_change_password' => false,
            'is_active' => true,
        ]);
    }

    /**
     * 1. Guru BK dapat mengakses dashboard dan melihat metrik
     */
    public function test_bk_can_access_dashboard_and_see_metrics(): void
    {
        Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin madrasah',
            'description' => 'Diejek terus menerus saat jam istirahat',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->bk)->get(route('bk.dashboard'));

        $response->assertOk();
        $response->assertSee('Ibu Siti Khadijah');
        $response->assertSee('Laporan Baru');
        $response->assertSee('Perundungan Verbal');
    }

    /**
     * 2. Guru BK dapat melihat daftar laporan dan melakukan filter
     */
    public function test_bk_can_view_reports_list_with_filters(): void
    {
        $reportBaru = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Koridor',
            'description' => 'Laporan satu',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $reportSelesai = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'saksi',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Lapangan',
            'description' => 'Laporan dua',
            'urgency' => 'rendah',
            'status' => 'selesai',
        ]);

        // Akses daftar tanpa filter
        $response = $this->actingAs($this->bk)->get(route('bk.reports.index'));
        $response->assertOk();
        $response->assertSee(route('bk.reports.show', $reportBaru));
        $response->assertSee(route('bk.reports.show', $reportSelesai));

        // Filter status = baru
        $responseFiltered = $this->actingAs($this->bk)->get(route('bk.reports.index', ['status' => 'baru']));
        $responseFiltered->assertOk();
        $responseFiltered->assertSee(route('bk.reports.show', $reportBaru));
        $responseFiltered->assertDontSee(route('bk.reports.show', $reportSelesai));
    }

    /**
     * 3. Pelapor rahasia ditampilkan sebagai "Pelapor Rahasia" pada daftar
     */
    public function test_confidential_reporter_name_is_masked_in_reports_list(): void
    {
        Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => true, // Sembunyikan nama
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kelas',
            'description' => 'Kronologi rahasia',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->bk)->get(route('bk.reports.index'));

        $response->assertOk();
        $response->assertSee('Pelapor Rahasia');
        $response->assertDontSee('Ahmad Raka'); // Nama asli siswa tidak boleh bocor di daftar
    }

    /**
     * 4. Guru BK dapat melihat detail laporan dan kronologi terdekripsi
     */
    public function test_bk_can_view_report_detail(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Laboratorium Komputer',
            'description' => 'Ini adalah kronologi perundungan yang sangat rahasia',
            'accused_name' => 'Budi Terlapor',
            'urgency' => 'tinggi',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->bk)->get(route('bk.reports.show', $report));

        $response->assertOk();
        $response->assertSee('Laboratorium Komputer');
        $response->assertSee('Ini adalah kronologi perundungan yang sangat rahasia');
        $response->assertSee('Budi Terlapor');
        $response->assertSee('Ahmad Raka');
    }

    /**
     * 5. Guru BK dapat membuka identitas pelapor rahasia dan aksi tersebut tercatat di audit log
     */
    public function test_bk_can_reveal_confidential_reporter_identity_and_logs_audit_trail(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => true, // Rahasia
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Musholla',
            'description' => 'Perundungan di musholla',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        // Sebelum dibuka: detail menampilkan "Pelapor Rahasia" dan tombol "Buka Identitas Pelapor"
        $responseBefore = $this->actingAs($this->bk)->get(route('bk.reports.show', $report));
        $responseBefore->assertOk();
        $responseBefore->assertSee('Pelapor Rahasia');
        $responseBefore->assertSee('Buka Identitas Pelapor');
        $responseBefore->assertDontSee('Ahmad Raka');

        // Guru BK menekan tombol buka identitas
        $revealResponse = $this->actingAs($this->bk)->post(route('bk.reports.reveal-identity', $report));
        $revealResponse->assertRedirect();
        $revealResponse->assertSessionHas('info');

        // Pastikan tercatat di activity_logs
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'identity_revealed',
            'subject_id' => $report->id,
            'user_id' => $this->bk->id,
            'ip_address' => '-', // Tidak mencatat IP
        ]);

        // Setelah dibuka pada sesi ini: Nama asli siswa ditampilkan
        $responseAfter = $this->actingAs($this->bk)
            ->withSession(["identity_revealed_{$report->id}" => true])
            ->get(route('bk.reports.show', $report));

        $responseAfter->assertOk();
        $responseAfter->assertSee('Ahmad Raka');
        $responseAfter->assertSee('NIS1001');
    }

    /**
     * 6. Guru BK dapat mengubah status laporan
     */
    public function test_bk_can_update_report_status(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Perundungan di kantin',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $response = $this->actingAs($this->bk)->put(route('bk.reports.update-status', $report), [
            'status' => 'diverifikasi',
            'status_note' => 'Laporan telah diverifikasi oleh Guru BK',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $report->refresh();
        $this->assertEquals('diverifikasi', $report->status);

        // Riwayat perubahan status tercatat
        $this->assertDatabaseHas('report_status_histories', [
            'report_id' => $report->id,
            'from_status' => 'baru',
            'to_status' => 'diverifikasi',
            'changed_by' => $this->bk->id,
        ]);
    }

    /**
     * 7. Mengubah status ke Ditolak wajib menyertakan alasan
     */
    public function test_rejecting_report_requires_reason(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan uji tolak',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        // Ditolak tanpa alasan -> gagal validasi
        $responseFail = $this->actingAs($this->bk)->put(route('bk.reports.update-status', $report), [
            'status' => 'ditolak',
            'reject_reason' => '',
        ]);
        $responseFail->assertSessionHasErrors('reject_reason');

        // Ditolak dengan alasan lengkap -> berhasil
        $responseSuccess = $this->actingAs($this->bk)->put(route('bk.reports.update-status', $report), [
            'status' => 'ditolak',
            'reject_reason' => 'Peristiwa merupakan kesalahpahaman bercanda dan telah selesai saling memaafkan.',
        ]);

        $responseSuccess->assertRedirect();
        $responseSuccess->assertSessionHas('success');

        $report->refresh();
        $this->assertEquals('ditolak', $report->status);
        $this->assertNotNull($report->closed_at);
        $this->assertEquals('Peristiwa merupakan kesalahpahaman bercanda dan telah selesai saling memaafkan.', $report->reject_reason);
    }

    /**
     * 8. Guru BK dapat menambahkan catatan internal, dan siswa TIDAK DAPAT melihatnya
     */
    public function test_bk_can_add_internal_note_and_student_cannot_see_it(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan kasus',
            'urgency' => 'sedang',
            'status' => 'diproses',
        ]);

        $response = $this->actingAs($this->bk)->post(route('bk.reports.notes.store', $report), [
            'note' => 'Catatan konseling rahasia: terlapor dipanggil ke ruang BK pukul 10:00.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifikasi tersimpan di database
        $this->assertDatabaseHas('report_notes', [
            'report_id' => $report->id,
            'user_id' => $this->bk->id,
        ]);

        // Guru BK dapat melihat catatan ini
        $bkView = $this->actingAs($this->bk)->get(route('bk.reports.show', $report));
        $bkView->assertOk();
        $bkView->assertSee('Catatan konseling rahasia: terlapor dipanggil ke ruang BK pukul 10:00.');

        // Siswa pemilik laporan TIDAK DAPAT melihat catatan ini
        $studentView = $this->actingAs($this->siswa)->get(route('siswa.reports.show', $report));
        $studentView->assertOk();
        $studentView->assertDontSee('Catatan konseling rahasia: terlapor dipanggil ke ruang BK pukul 10:00.');
    }

    /**
     * 9. Guru BK dapat mengirim pesan balasan resmi ke siswa
     */
    public function test_bk_can_send_message_reply_to_student(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan kasus',
            'urgency' => 'sedang',
            'status' => 'diproses',
        ]);

        $response = $this->actingAs($this->bk)->post(route('bk.reports.messages.store', $report), [
            'message' => 'Terima kasih telah melapor, kami akan menjadwalkan konseling pendampingan besok.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Guru BK melihat balasan di detail laporan
        $bkView = $this->actingAs($this->bk)->get(route('bk.reports.show', $report));
        $bkView->assertSee('Terima kasih telah melapor, kami akan menjadwalkan konseling pendampingan besok.');

        // Siswa juga melihat balasan ini di detail laporannya
        $studentView = $this->actingAs($this->siswa)->get(route('siswa.reports.show', $report));
        $studentView->assertSee('Terima kasih telah melapor, kami akan menjadwalkan konseling pendampingan besok.');
    }

    /**
     * 10. Guru BK dapat mengelola kategori (tambah, edit, toggle status)
     */
    public function test_bk_can_manage_categories(): void
    {
        // Tambah kategori baru
        $storeResponse = $this->actingAs($this->bk)->post(route('bk.categories.store'), [
            'name' => 'Perundungan Siber',
            'description' => 'Kekerasan dan pelecehan daring di media sosial',
        ]);
        $storeResponse->assertRedirect();
        $storeResponse->assertSessionHas('success');

        $newCategory = Category::where('name', 'Perundungan Siber')->first();
        $this->assertNotNull($newCategory);
        $this->assertTrue($newCategory->is_active);

        // Edit kategori
        $updateResponse = $this->actingAs($this->bk)->put(route('bk.categories.update', $newCategory), [
            'name' => 'Cyberbullying (Siber)',
            'description' => 'Diperbarui',
        ]);
        $updateResponse->assertRedirect();
        $newCategory->refresh();
        $this->assertEquals('Cyberbullying (Siber)', $newCategory->name);

        // Toggle status (nonaktifkan)
        $toggleResponse = $this->actingAs($this->bk)->post(route('bk.categories.toggle-status', $newCategory));
        $toggleResponse->assertRedirect();
        $newCategory->refresh();
        $this->assertFalse($newCategory->is_active);
    }

    /**
     * 11. Kategori yang sudah memiliki laporan dicegah dari penghapusan fisik
     */
    public function test_category_used_in_reports_cannot_be_deleted(): void
    {
        // Hubungkan kategori dengan laporan
        Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan terkait kategori',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        $deleteResponse = $this->actingAs($this->bk)->delete(route('bk.categories.destroy', $this->category));
        $deleteResponse->assertRedirect();
        $deleteResponse->assertSessionHas('error');

        // Pastikan kategori tetap ada di database
        $this->assertDatabaseHas('categories', ['id' => $this->category->id]);

        // Kategori yang belum memiliki laporan dapat dihapus
        $unusedCategory = Category::create([
            'name' => 'Kategori Baru Bebas',
            'is_active' => true,
        ]);
        $deleteUnused = $this->actingAs($this->bk)->delete(route('bk.categories.destroy', $unusedCategory));
        $deleteUnused->assertRedirect();
        $deleteUnused->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $unusedCategory->id]);
    }

    /**
     * 12. Master dilarang keras membuka laporan maupun kategori BK (Otorisasi 403)
     */
    public function test_master_is_strictly_forbidden_from_bk_reports_and_categories(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswa->id,
            'is_hidden_identity' => false,
            'reporter_class_name' => $this->class->name,
            'reporter_grade_level' => $this->class->grade_level,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan kasus',
            'urgency' => 'sedang',
            'status' => 'baru',
        ]);

        // Master coba akses daftar laporan BK
        $responseList = $this->actingAs($this->master)->get(route('bk.reports.index'));
        $responseList->assertForbidden();

        // Master coba akses detail laporan BK
        $responseShow = $this->actingAs($this->master)->get(route('bk.reports.show', $report));
        $responseShow->assertForbidden();

        // Master coba akses kelola kategori BK
        $responseCat = $this->actingAs($this->master)->get(route('bk.categories.index'));
        $responseCat->assertForbidden();
    }

    /**
     * 13. Guru BK dapat memperbarui profil data diri dan kata sandi mandiri
     */
    public function test_bk_can_update_profile_and_password(): void
    {
        // Update data diri
        $updateProfile = $this->actingAs($this->bk)->put(route('bk.profile.update'), [
            'name' => 'Ibu Siti Khadijah, M.Pd',
            'phone' => '081298765432',
        ]);
        $updateProfile->assertRedirect();
        $updateProfile->assertSessionHas('success');

        $this->bk->refresh();
        $this->assertEquals('Ibu Siti Khadijah, M.Pd', $this->bk->name);
        $this->assertEquals('081298765432', $this->bk->phone);

        // Update password
        $updatePassword = $this->actingAs($this->bk)->put(route('bk.profile.password'), [
            'current_password' => 'Password123!',
            'password' => 'BaruRahasia999!',
            'password_confirmation' => 'BaruRahasia999!',
        ]);
        $updatePassword->assertRedirect();
        $updatePassword->assertSessionHas('success');

        $this->bk->refresh();
        $this->assertTrue(Hash::check('BaruRahasia999!', $this->bk->password));
    }
}
