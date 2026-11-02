<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Report;
use App\Models\ReportMessage;
use App\Models\SchoolClass;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReleaseTwoFeaturesTest extends TestCase
{
    use RefreshDatabase;

    private User $masterUser;

    private User $bkUser;

    private User $studentUser;

    private User $otherStudentUser;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masterUser = User::factory()->create([
            'role' => 'master',
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $this->bkUser = User::factory()->create([
            'role' => 'bk',
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $academicYear = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $class = SchoolClass::create([
            'academic_year_id' => $academicYear->id,
            'name' => '8-A',
            'grade_level' => 8,
        ]);

        $this->studentUser = User::factory()->create([
            'role' => 'siswa',
            'is_active' => true,
            'must_change_password' => false,
            'class_id' => $class->id,
        ]);

        $this->otherStudentUser = User::factory()->create([
            'role' => 'siswa',
            'is_active' => true,
            'must_change_password' => false,
            'class_id' => $class->id,
        ]);

        $this->category = Category::create([
            'name' => 'Perundungan Fisik',
            'description' => 'Tindakan fisik melukai atau memukul',
            'is_active' => true,
        ]);
    }

    /**
     * FR-17: Master dapat mengelola pengaturan website dan tampil di publik & bantuan
     */
    public function test_master_can_view_and_update_school_settings(): void
    {
        $response = $this->actingAs($this->masterUser)->get(route('master.settings.index'));
        $response->assertOk();
        $response->assertSee('Pengaturan Informasi Madrasah');

        $updateResponse = $this->actingAs($this->masterUser)->put(route('master.settings.update'), [
            'school_name' => 'MTs Soebono Mantofani Updated',
            'school_phone' => '(021) 745-9999',
            'school_email' => 'bk-update@mtssoebono.sch.id',
            'school_address' => 'Jl. Baru No. 123, Tangerang Selatan',
            'counseling_location' => 'Gedung B Lantai 2',
            'counseling_hours' => 'Senin – Jumat 08.00 – 15.00 WIB',
            'emergency_contact' => 'Hubungi ruang konseling',
            'hero_title' => 'Bersama Lindungi Masa Depan',
            'hero_subtitle' => 'Ceritakan kejadian yang kamu alami dengan aman dan rahasia.',
            'about_text' => 'Website perlindungan peserta didik MTs Soebono Mantofani.',
        ]);

        $updateResponse->assertRedirect(route('master.settings.index'));
        $updateResponse->assertSessionHas('success');

        // Pastikan tersimpan di database setting
        $this->assertEquals('MTs Soebono Mantofani Updated', Setting::get('school_name'));
        $this->assertEquals('(021) 745-9999', Setting::get('school_phone'));

        // Cek log aktivitas
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'settings_updated',
            'user_id' => $this->masterUser->id,
        ]);

        // Cek bahwa informasi tampil di halaman publik / landing
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertOk();
        $homeResponse->assertSee('MTs Soebono Mantofani Updated');
        $homeResponse->assertSee('Bersama Lindungi Masa Depan');

        // Siswa dan BK tidak boleh mengubah pengaturan
        $this->actingAs($this->studentUser)
            ->get(route('master.settings.index'))
            ->assertForbidden();

        $this->actingAs($this->bkUser)
            ->get(route('master.settings.index'))
            ->assertForbidden();
    }

    /**
     * FR-27: Guru BK dapat memperbarui tingkat urgensi dan melakukan filter/sorting
     */
    public function test_bk_can_update_report_urgency_and_filter_by_urgency(): void
    {
        $report1 = Report::create([
            'reporter_id' => $this->studentUser->id,
            'reporter_class_name' => '8-A',
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->subDays(2),
            'location' => 'Kantin Belakang',
            'accused_name' => 'Siswa X',
            'description' => 'Didorong di kantin berkali-kali.',
            'is_hidden_identity' => false,
            'status' => 'diproses',
            'urgency' => 'rendah',
        ]);

        $report2 = Report::create([
            'reporter_id' => $this->studentUser->id,
            'reporter_class_name' => '8-A',
            'reporter_role' => 'saksi',
            'category_id' => $this->category->id,
            'incident_date' => now()->subDay(),
            'location' => 'Depan Gerbang',
            'accused_name' => 'Siswa Y',
            'description' => 'Ancaman fisik dengan kekerasan.',
            'is_hidden_identity' => false,
            'status' => 'baru',
            'urgency' => 'tinggi',
        ]);

        // Guru BK ubah urgensi report1 menjadi 'sedang'
        $response = $this->actingAs($this->bkUser)
            ->put(route('bk.reports.update-urgency', $report1), [
                'urgency' => 'sedang',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals('sedang', $report1->fresh()->urgency);

        // Audit log tercatat
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'report_urgency_updated',
            'subject_id' => $report1->id,
            'user_id' => $this->bkUser->id,
        ]);

        // Validasi urgensi tidak valid
        $badResponse = $this->actingAs($this->bkUser)
            ->put(route('bk.reports.update-urgency', $report1), [
                'urgency' => 'kritis_tidak_sah',
            ]);
        $badResponse->assertSessionHasErrors('urgency');

        // Filter list laporan berdasarkan urgensi 'tinggi'
        $listResponse = $this->actingAs($this->bkUser)
            ->get(route('bk.reports.index', ['urgency' => 'tinggi']));
        $listResponse->assertOk();
        $listResponse->assertSee($report2->id);

        // Sort berdasarkan urgensi_desc
        $sortResponse = $this->actingAs($this->bkUser)
            ->get(route('bk.reports.index', ['sort' => 'urgency_desc']));
        $sortResponse->assertOk();

        // Siswa tidak boleh mengubah urgensi
        $this->actingAs($this->studentUser)
            ->put(route('bk.reports.update-urgency', $report1), ['urgency' => 'tinggi'])
            ->assertForbidden();

        // Master tidak boleh mengubah urgensi
        $this->actingAs($this->masterUser)
            ->put(route('bk.reports.update-urgency', $report1), ['urgency' => 'tinggi'])
            ->assertForbidden();
    }

    /**
     * FR-36: Siswa dapat mengirimkan informasi susulan pada laporan aktif
     */
    public function test_student_can_send_follow_up_information_on_active_report(): void
    {
        $report = Report::create([
            'reporter_id' => $this->studentUser->id,
            'reporter_class_name' => '8-A',
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->subDay(),
            'location' => 'Lorong Kelas 8',
            'accused_name' => 'Siswa A',
            'description' => 'Diejek dan barang tas disembunyikan.',
            'is_hidden_identity' => true,
            'status' => 'diproses',
            'urgency' => 'sedang',
        ]);

        $response = $this->actingAs($this->studentUser)
            ->post(route('siswa.reports.follow-up', $report), [
                'message' => 'Pak/Bu, saya baru ingat ada teman sekelas yang melihat kejadian ini yaitu Budi.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Pesan tersimpan dengan sender_role = 'siswa'
        $this->assertDatabaseHas('report_messages', [
            'report_id' => $report->id,
            'sender_id' => $this->studentUser->id,
            'sender_role' => 'siswa',
        ]);

        // Cek bahwa pesan terenkripsi pada level database
        $msg = ReportMessage::where('report_id', $report->id)->first();
        $this->assertStringContainsString('Budi', $msg->message); // decrypt via cast

        // Cek audit log
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'report_follow_up_added',
            'subject_id' => (string) $report->id,
            'user_id' => $this->studentUser->id,
        ]);

        // Notifikasi terkirim ke Guru BK aktif
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->bkUser->id,
            'type' => 'report_follow_up',
        ]);

        // Guru BK buka laporan pelapor rahasia: jika belum reveal identity, nama siswa tidak boleh bocor
        $bkView = $this->actingAs($this->bkUser)->get(route('bk.reports.show', $report));
        $bkView->assertOk();
        $bkView->assertSee('Pelapor Rahasia');
        $bkView->assertDontSee($this->studentUser->name);

        // Siswa lain tidak dapat mengirim informasi susulan pada laporan bukan miliknya (IDOR)
        $this->actingAs($this->otherStudentUser)
            ->post(route('siswa.reports.follow-up', $report), [
                'message' => 'Pesan dari siswa lain yang tidak sah.',
            ])
            ->assertForbidden();

        // Pada laporan yang sudah selesai atau ditolak, informasi susulan dilarang
        $report->update(['status' => 'selesai']);

        $closedResponse = $this->actingAs($this->studentUser)
            ->post(route('siswa.reports.follow-up', $report), [
                'message' => 'Mencoba mengirim pesan pada laporan yang sudah selesai.',
            ]);

        $closedResponse->assertRedirect();
        $closedResponse->assertSessionHas('error');
    }

    /**
     * FR-39: Siswa dapat membuka halaman bantuan dan kontak darurat
     */
    public function test_student_can_view_help_and_emergency_contacts_page(): void
    {
        $response = $this->actingAs($this->studentUser)->get(route('siswa.help'));
        $response->assertOk();

        // Memuat kontak nasional darurat
        $response->assertSee('SAPA 129');
        $response->assertSee('KPAI');
        $response->assertSee('110');

        // Memuat panduan ketika menghadapi bahaya mendesak
        $response->assertSee('Apa yang harus dilakukan jika kamu merasa terancam sekarang?');
        $response->assertSee('Ruang Bimbingan &amp; Konseling', false);

        // Tamu tanpa login dialihkan ke login
        $this->post(route('logout'));
        $this->get(route('siswa.help'))->assertRedirect(route('login'));

        // Guru BK atau Master tidak boleh mengakses halaman khusus siswa ini
        $this->actingAs($this->bkUser)->get(route('siswa.help'))->assertForbidden();
        $this->actingAs($this->masterUser)->get(route('siswa.help'))->assertForbidden();
    }
}
