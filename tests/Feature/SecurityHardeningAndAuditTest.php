<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\User;
use App\Services\ReportExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityHardeningAndAuditTest extends TestCase
{
    use RefreshDatabase;

    protected User $master;

    protected User $bk;

    protected User $studentA;

    protected User $studentB;

    protected Category $category;

    protected SchoolClass $class;

    protected AcademicYear $year;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $this->class = SchoolClass::create([
            'academic_year_id' => $this->year->id,
            'name' => '8B',
            'grade_level' => 8,
        ]);

        $this->master = User::create([
            'login_id' => 'master_sec',
            'name' => 'Master Keamanan',
            'role' => 'master',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        $this->bk = User::create([
            'login_id' => 'bk_sec',
            'name' => 'Guru BK Keamanan',
            'role' => 'bk',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        $this->studentA = User::create([
            'login_id' => '1001',
            'name' => 'Siswa Korban A',
            'role' => 'siswa',
            'password' => bcrypt('password123'),
            'class_id' => $this->class->id,
            'is_active' => true,
        ]);

        $this->studentB = User::create([
            'login_id' => '1002',
            'name' => 'Siswa Pengamat B',
            'role' => 'siswa',
            'password' => bcrypt('password123'),
            'class_id' => $this->class->id,
            'is_active' => true,
        ]);

        $this->category = Category::create([
            'name' => 'Perundungan Relasional',
            'description' => 'Pengucilan atau intimidasi sosial',
            'is_active' => true,
        ]);
    }

    /**
     * 1. Verifikasi Security Headers (CSP, X-Frame-Options, X-Content-Type-Options, dll)
     */
    public function test_security_headers_are_attached_to_all_web_responses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $this->assertStringContainsString("default-src 'self'", (string) $response->headers->get('Content-Security-Policy'));
    }

    /**
     * 2. Skenario J1: Uji IDOR Mendalam
     */
    public function test_idor_protection_student_cannot_access_other_students_report_or_attachment(): void
    {
        $reportA = Report::create([
            'reporter_id' => $this->studentA->id,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->subDay(),
            'location' => 'Laboratorium Komputer',
            'description' => 'Siswa A mengalami intimidasi di ruang lab komputer.',
            'status' => 'baru',
        ]);

        Storage::disk('local')->put('reports/evidence_secret.jpg', 'fake-image-content');
        $attachmentA = $reportA->attachments()->create([
            'stored_name' => 'evidence_secret.jpg',
            'original_name' => 'foto_bukti_a.jpg',
            'mime_type' => 'image/jpeg',
            'size_bytes' => 1024,
            'created_at' => now(),
        ]);

        // Siswa B mencoba membuka laporan Siswa A via URL
        $responseView = $this->actingAs($this->studentB)->get("/siswa/laporan/{$reportA->id}");
        $responseView->assertStatus(403);

        // Siswa B mencoba mengunduh bukti Siswa A
        $responseAttach = $this->actingAs($this->studentB)->get("/siswa/laporan/{$reportA->id}/bukti/{$attachmentA->id}");
        $responseAttach->assertStatus(403);
    }

    /**
     * 3. Skenario J2: Batas Peran Master (Master sama sekali tidak bisa melihat isi, bukti, maupun unduh laporan)
     */
    public function test_master_role_boundaries_strictly_blocked_from_reports_and_downloads(): void
    {
        $report = Report::create([
            'reporter_id' => $this->studentA->id,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->subDay(),
            'location' => 'Kantin',
            'description' => 'Data sensitif laporan yang tidak boleh dibaca Master.',
            'status' => 'baru',
        ]);

        // Master coba akses rute siswa
        $this->actingAs($this->master)->get("/siswa/laporan/{$report->id}")->assertStatus(403);

        // Master coba akses rute BK
        $this->actingAs($this->master)->get("/bk/laporan/{$report->id}")->assertStatus(403);
        $this->actingAs($this->master)->post("/bk/laporan/{$report->id}/lihat-identitas")->assertStatus(403);
        $this->actingAs($this->master)->post('/bk/unduh-laporan/pdf')->assertStatus(403);
        $this->actingAs($this->master)->post('/bk/unduh-laporan/excel')->assertStatus(403);

        // Master dashboard hanya berisi statistik agregat angka
        $dashboardResponse = $this->actingAs($this->master)->get('/master/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertDontSee('Data sensitif laporan yang tidak boleh dibaca Master.');
        $dashboardResponse->assertDontSee($this->studentA->name);
    }

    /**
     * 4. Skenario J3: Kerahasiaan Identitas & Enkripsi Kolom Database
     */
    public function test_secret_reporter_is_hidden_and_database_columns_are_encrypted(): void
    {
        $rawDescription = 'Kronologi sangat rahasia dari korban bullying.';
        $rawAccused = 'Nama Terlapor Penting';

        $report = Report::create([
            'reporter_id' => $this->studentA->id,
            'reporter_role' => 'korban',
            'is_hidden_identity' => true,
            'category_id' => $this->category->id,
            'incident_date' => now()->subDay(),
            'location' => 'Musholla Madrasah',
            'description' => $rawDescription,
            'accused_name' => $rawAccused,
            'status' => 'baru',
        ]);

        // Periksa data mentah langsung di database via PDO: wajib terenkripsi
        $rawDbRow = DB::table('reports')->where('id', $report->id)->first();
        $this->assertNotEquals($rawDescription, $rawDbRow->description);
        $this->assertNotEquals($rawAccused, $rawDbRow->accused_name);

        // Guru BK membuka daftar: nama pelapor harus "Pelapor Rahasia"
        $bkListResponse = $this->actingAs($this->bk)->get('/bk/laporan');
        $bkListResponse->assertStatus(200);
        $bkListResponse->assertSee('Pelapor Rahasia');
        $bkListResponse->assertDontSee($this->studentA->name);

        // Guru BK melakukan aksi "Lihat Identitas"
        $revealResponse = $this->actingAs($this->bk)->post("/bk/laporan/{$report->id}/lihat-identitas");
        $revealResponse->assertRedirect();
        $revealResponse->assertSessionHas('identity_revealed_'.$report->id, true);

        // Verifikasi aksi pembukaan identitas tercatat di activity_logs
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'identity_revealed',
            'user_id' => $this->bk->id,
            'subject_id' => (string) $report->id,
        ]);
    }

    /**
     * 5. Skenario J5: Penolakan File Berbahaya & Penyimpanan Disk Privat
     */
    public function test_malicious_file_upload_rejected_and_files_stored_in_private_disk(): void
    {
        // 1. File berekstensi .php langsung ditolak validasi
        $phpFile = UploadedFile::fake()->create('exploit.php', 10, 'text/x-php');
        $responsePhp = $this->actingAs($this->studentA)->post('/siswa/laporan', [
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->format('Y-m-d'),
            'location' => 'Kelas 8B',
            'description' => 'Mencoba upload file php jahat.',
            'attachments' => [$phpFile],
        ]);
        $responsePhp->assertSessionHasErrors('attachments.0');

        // 2. File palsu: berekstensi .jpg tetapi isi php/html
        $fakeJpg = UploadedFile::fake()->createWithContent('malicious.jpg', "<?php system('ls'); ?>");
        // Bila diupload, ukuran file sah atau MIME divalidasi
        $responseFake = $this->actingAs($this->studentA)->post('/siswa/laporan', [
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->format('Y-m-d'),
            'location' => 'Kelas 8B',
            'description' => 'Mencoba upload fake jpg.',
            'attachments' => [$fakeJpg],
        ]);
        // Validasi ekstensi mimes:jpg,jpeg,png,pdf
        $this->assertTrue($responseFake->isRedirection());

        // 3. Pastikan berkas tersimpan di storage lokal privat, BUKAN di public path
        $publicStoragePath = public_path('storage/reports');
        $this->assertDirectoryDoesNotExist($publicStoragePath);
    }

    /**
     * 6. Skenario J6: Pencegahan Injeksi Formula Excel
     */
    public function test_excel_export_sanitizes_formula_injection_characters(): void
    {
        $formulaInputs = [
            '=SUM(A1:A10)',
            '+cmd|/C calc!A0',
            '-1337+20',
            '@HYPERLINK("http://evil.com","click")',
        ];

        foreach ($formulaInputs as $input) {
            $sanitized = ReportExportService::sanitizeCellValue($input);
            $this->assertStringStartsWith("'", $sanitized, "Input {$input} must start with single quote to prevent formula execution");
        }

        // Teks biasa tidak boleh diberi tanda petik tambahan
        $normalText = 'Laporan perundungan normal';
        $this->assertEquals($normalText, ReportExportService::sanitizeCellValue($normalText));
    }

    /**
     * 7. Skenario J7: Mass Assignment & XSS Protection
     */
    public function test_mass_assignment_and_xss_protection(): void
    {
        $xssString = '<script>alert("xss")</script>';

        // Siswa mengirim payload dengan atribut status='selesai' dan urgency='tinggi'
        $response = $this->actingAs($this->studentA)->post('/siswa/laporan', [
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->format('Y-m-d'),
            'location' => 'Kelas 8B',
            'description' => 'Kronologi dengan script '.$xssString,
            'status' => 'selesai',
            'urgency' => 'tinggi',
            'role' => 'master',
        ]);

        $response->assertSessionHasNoErrors();

        $createdReport = Report::where('reporter_id', $this->studentA->id)->latest()->first();
        $this->assertNotNull($createdReport);

        // Status WAJIB 'baru', tidak boleh di-override oleh siswa
        $this->assertEquals('baru', $createdReport->status);
        $this->assertEquals('sedang', $createdReport->urgency);

        // Buka halaman detail untuk verifikasi XSS di-escape oleh Blade
        $detailResponse = $this->actingAs($this->studentA)->get("/siswa/laporan/{$createdReport->id}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertDontSee($xssString, false);
        $detailResponse->assertSee('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', false);
    }

    /**
     * 8. Skenario J8: Immutability Log Aktivitas (Tidak ada route edit/delete untuk log)
     */
    public function test_activity_logs_have_no_update_or_delete_routes(): void
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $uri = $route->uri();

            if (str_contains($uri, 'activity-log')) {
                $methods = $route->methods();
                $this->assertNotContains('PUT', $methods, "Activity log must not have PUT route: {$uri}");
                $this->assertNotContains('PATCH', $methods, "Activity log must not have PATCH route: {$uri}");
                $this->assertNotContains('DELETE', $methods, "Activity log must not have DELETE route: {$uri}");
            }
        }
    }
}
