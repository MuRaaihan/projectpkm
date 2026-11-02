<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $siswaA;

    protected User $siswaB;

    protected User $bk;

    protected User $master;

    protected Category $category;

    protected SchoolClass $class;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

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
            'name' => 'Perundungan Fisik',
            'description' => 'Kekerasan fisik',
            'is_active' => true,
        ]);

        $this->siswaA = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'NIS001',
            'name' => 'Siswa Ahmad',
            'class_id' => $this->class->id,
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->siswaB = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'NIS002',
            'name' => 'Siswa Budi',
            'class_id' => $this->class->id,
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->bk = User::factory()->bk()->create([
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->master = User::factory()->master()->create([
            'must_change_password' => false,
            'is_active' => true,
        ]);
    }

    /**
     * Siswa dapat membuka formulir pembuatan laporan
     */
    public function test_student_can_view_create_report_form(): void
    {
        $this->actingAs($this->siswaA);

        $response = $this->get(route('siswa.reports.create'));
        $response->assertStatus(200);
        $response->assertSee('Buat Laporan Perundungan');
        $response->assertSee($this->category->name);
    }

    /**
     * Siswa dapat membuat laporan tanpa menyembunyikan identitas
     */
    public function test_student_can_create_report_without_hiding_identity(): void
    {
        $this->actingAs($this->siswaA);

        $data = [
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin Madrasah',
            'description' => 'Saya didorong dan tas saya diambil paksa saat istirahat siang.',
            'accused_name' => 'Teman sekelas',
            'is_hidden_identity' => '0',
        ];

        $response = $this->post(route('siswa.reports.store'), $data);

        $report = Report::latest()->first();
        $this->assertNotNull($report);
        $response->assertRedirect(route('siswa.reports.show', $report));

        $this->assertEquals($this->siswaA->id, $report->reporter_id);
        $this->assertFalse($report->is_hidden_identity);
        $this->assertEquals('VII-A', $report->reporter_class_name);
        $this->assertEquals(7, $report->reporter_grade_level);
        $this->assertEquals('baru', $report->status);
        $this->assertEquals($this->siswaA->name, $report->reporter_display_name);

        // Verifikasi entri riwayat status awal
        $this->assertDatabaseHas('report_status_histories', [
            'report_id' => $report->id,
            'to_status' => 'baru',
            'changed_by' => $this->siswaA->id,
        ]);

        // Verifikasi log aktivitas tercatat
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->siswaA->id,
            'action' => 'report_created',
            'subject_id' => $report->id,
        ]);
    }

    /**
     * Siswa dapat membuat laporan dengan opsi sembunyikan nama ("Pelapor Rahasia")
     */
    public function test_student_can_create_report_with_hidden_identity(): void
    {
        $this->actingAs($this->siswaA);

        $data = [
            'category_id' => $this->category->id,
            'reporter_role' => 'saksi',
            'incident_date' => now()->toDateString(),
            'location' => 'Lorong Belakang Perpustakaan',
            'description' => 'Melihat teman saya diancam oleh kakak kelas.',
            'is_hidden_identity' => '1',
        ];

        $response = $this->post(route('siswa.reports.store'), $data);
        $report = Report::latest()->first();

        $this->assertTrue($report->is_hidden_identity);
        $this->assertEquals('Pelapor Rahasia', $report->reporter_display_name);
    }

    /**
     * Kronologi dan nama terlapor tersimpan dalam bentuk terenkripsi di database mentah
     */
    public function test_report_description_and_accused_are_encrypted_in_database(): void
    {
        $this->actingAs($this->siswaA);

        $plainDescription = 'Teks kronologi yang sangat sensitif dan rahasia.';
        $plainAccused = 'Nama Terlapor Rahasia';

        $this->post(route('siswa.reports.store'), [
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kelas VII-A',
            'description' => $plainDescription,
            'accused_name' => $plainAccused,
        ]);

        $report = Report::latest()->first();

        // Di level model, Eloquent mendekripsikannya secara otomatis
        $this->assertEquals($plainDescription, $report->description);
        $this->assertEquals($plainAccused, $report->accused_name);

        // Di level raw database query, teks tidak boleh berwujud plain text
        $rawRow = DB::table('reports')->where('id', $report->id)->first();
        $this->assertStringNotContainsString($plainDescription, $rawRow->description);
        $this->assertStringNotContainsString($plainAccused, $rawRow->accused_name);
    }

    /**
     * Siswa dapat mengunggah bukti valid (JPG & PDF) yang tersimpan di disk privat dengan nama acak
     */
    public function test_student_can_upload_valid_attachments(): void
    {
        $this->actingAs($this->siswaA);

        $jpgFile = UploadedFile::fake()->image('bukti_luka.jpg');
        $pdfFile = UploadedFile::fake()->create('dokumen_chat.pdf', 500, 'application/pdf');

        $response = $this->post(route('siswa.reports.store'), [
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Kejadian pemalakan uang saku di kantin.',
            'attachments' => [$jpgFile, $pdfFile],
        ]);

        $report = Report::latest()->first();
        $this->assertCount(2, $report->attachments);

        foreach ($report->attachments as $attachment) {
            // Pastikan nama asli tercatat
            $this->assertContains($attachment->original_name, ['bukti_luka.jpg', 'dokumen_chat.pdf']);

            // Pastikan nama di disk adalah nama acak (bukan nama asli)
            $this->assertNotEquals('bukti_luka.jpg', $attachment->stored_name);
            $this->assertNotEquals('dokumen_chat.pdf', $attachment->stored_name);

            // Pastikan tersimpan di storage lokal (storage/app/private)
            Storage::disk('local')->assertExists('reports/'.$attachment->stored_name);
        }
    }

    /**
     * Berkas berbahaya (seperti .php, .exe) dan jumlah melebihi batas ditolak validasi
     */
    public function test_malicious_and_oversized_attachments_are_rejected(): void
    {
        $this->actingAs($this->siswaA);

        // Upload berkas ekstensi berbahaya
        $maliciousFile = UploadedFile::fake()->create('hack.php', 100, 'application/x-php');

        $response = $this->post(route('siswa.reports.store'), [
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Mencoba mengunggah skrip php.',
            'attachments' => [$maliciousFile],
        ]);

        $response->assertSessionHasErrors('attachments.0');

        // Upload lebih dari 3 berkas
        $files = [
            UploadedFile::fake()->image('img1.png'),
            UploadedFile::fake()->image('img2.png'),
            UploadedFile::fake()->image('img3.png'),
            UploadedFile::fake()->image('img4.png'),
        ];

        $responseOverLimit = $this->post(route('siswa.reports.store'), [
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Mencoba mengunggah 4 berkas sekaligus.',
            'attachments' => $files,
        ]);

        $responseOverLimit->assertSessionHasErrors('attachments');
    }

    /**
     * Siswa dapat melihat daftar laporan miliknya dan membuka halaman detail
     */
    public function test_student_can_view_own_reports_index_and_details(): void
    {
        $this->actingAs($this->siswaA);

        $report = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan uji coba.',
            'status' => 'baru',
        ]);

        // Buka daftar
        $responseIndex = $this->get(route('siswa.reports.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee($this->category->name);

        // Buka detail
        $responseShow = $this->get(route('siswa.reports.show', $report));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Laporan uji coba.');
    }

    /**
     * UJI IDOR: Siswa A tidak dapat membuka laporan milik Siswa B
     */
    public function test_idor_student_cannot_view_another_students_report(): void
    {
        // Laporan milik Siswa A
        $reportA = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan rahasia milik siswa A.',
            'status' => 'baru',
        ]);

        // Siswa B mencoba membuka laporan Siswa A lewat UUID URL
        $this->actingAs($this->siswaB);

        $response = $this->get(route('siswa.reports.show', $reportA));
        $response->assertStatus(403);
    }

    /**
     * UJI IDOR BUKTI: Siswa B tidak dapat mengunduh lampiran bukti laporan milik Siswa A
     */
    public function test_idor_student_cannot_download_another_students_attachment(): void
    {
        $reportA = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan dengan bukti.',
            'status' => 'baru',
        ]);

        $storedName = 'test_secret_image.jpg';
        Storage::disk('local')->put('reports/'.$storedName, 'fake content');

        $attachment = $reportA->attachments()->create([
            'stored_name' => $storedName,
            'original_name' => 'luka.jpg',
            'mime_type' => 'image/jpeg',
            'size_bytes' => 1024,
            'created_at' => now(),
        ]);

        // Siswa A (pemilik) boleh mengunduh
        $this->actingAs($this->siswaA);
        $responseA = $this->get(route('siswa.reports.attachment', [$reportA, $attachment]));
        $responseA->assertStatus(200);

        // Siswa B (bukan pemilik) DITOLAK 403
        $this->actingAs($this->siswaB);
        $responseB = $this->get(route('siswa.reports.attachment', [$reportA, $attachment]));
        $responseB->assertStatus(403);
    }

    /**
     * Master dilarang keras (403) membuka laporan siswa maupun mengunduh bukti
     */
    public function test_master_cannot_access_student_reports_or_attachments(): void
    {
        $reportA = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan rahasia.',
            'status' => 'baru',
        ]);

        $storedName = 'evidence.pdf';
        Storage::disk('local')->put('reports/'.$storedName, 'pdf content');

        $attachment = $reportA->attachments()->create([
            'stored_name' => $storedName,
            'original_name' => 'evidence.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 2048,
            'created_at' => now(),
        ]);

        $this->actingAs($this->master);

        $responseIndex = $this->get(route('siswa.reports.index'));
        $responseIndex->assertStatus(403);

        $responseShow = $this->get(route('siswa.reports.show', $reportA));
        $responseShow->assertStatus(403);

        $responseDownload = $this->get(route('siswa.reports.attachment', [$reportA, $attachment]));
        $responseDownload->assertStatus(403);
    }

    /**
     * Siswa dapat melihat profil dan memperbarui kata sandi secara mandiri
     */
    public function test_student_can_view_profile_and_change_password(): void
    {
        $this->actingAs($this->siswaA);

        // 1. Lihat profil
        $responseProfile = $this->get(route('siswa.profile'));
        $responseProfile->assertStatus(200);
        $responseProfile->assertSee('NIS001');
        $responseProfile->assertSee('Siswa Ahmad');

        // 2. Ganti password gagal jika password baru sama dengan NIS
        $responseFailed = $this->put(route('siswa.profile.password'), [
            'current_password' => 'Password123!',
            'password' => 'NIS001',
            'password_confirmation' => 'NIS001',
        ]);
        $responseFailed->assertSessionHasErrors('password');

        // 3. Ganti password berhasil dengan kombinasi valid
        $responseSuccess = $this->put(route('siswa.profile.password'), [
            'current_password' => 'Password123!',
            'password' => 'RahasiaBaru123!',
            'password_confirmation' => 'RahasiaBaru123!',
        ]);

        $responseSuccess->assertRedirect();
        $responseSuccess->assertSessionHas('success');

        $this->assertTrue(Hash::check('RahasiaBaru123!', $this->siswaA->fresh()->password));
    }

    /**
     * Laporan milik siswa yang diarsipkan (soft-deleted) tetap tersimpan dan nama disamarkan
     */
    public function test_archived_student_report_remains_intact_with_anonymized_display_name(): void
    {
        $report = Report::create([
            'reporter_id' => $this->siswaA->id,
            'category_id' => $this->category->id,
            'reporter_role' => 'korban',
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin',
            'description' => 'Laporan siswa yang akan diarsipkan.',
            'status' => 'baru',
        ]);

        // Arsipkan siswa A
        $this->siswaA->delete();

        // Laporan tetap ada di database
        $this->assertDatabaseHas('reports', ['id' => $report->id]);

        // Display name pelapor otomatis menjadi "Akun diarsipkan"
        $this->assertEquals('Akun diarsipkan', $report->fresh()->reporter_display_name);
    }
}
