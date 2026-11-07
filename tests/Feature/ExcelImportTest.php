<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\User;
use App\Services\ExcelImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ExcelImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $master;

    protected User $bk;

    protected SchoolClass $class;

    protected function setUp(): void
    {
        parent::setUp();

        $this->master = User::factory()->master()->create([
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->bk = User::factory()->bk()->create([
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $this->class = SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'VII-A',
            'grade_level' => 7,
        ]);
    }

    /**
     * Non-master tidak dapat mengakses fitur impor Excel.
     */
    public function test_non_master_cannot_access_import(): void
    {
        $this->actingAs($this->bk)->get(route('master.import.index'))->assertStatus(403);
    }

    /**
     * Master dapat mengunduh template Excel siswa dan Guru BK.
     */
    public function test_master_can_download_excel_templates(): void
    {
        $resSiswa = $this->actingAs($this->master)->get(route('master.import.template.siswa'));
        $resSiswa->assertStatus(200);
        $resSiswa->assertHeader('content-disposition');

        $resBk = $this->actingAs($this->master)->get(route('master.import.template.bk'));
        $resBk->assertStatus(200);
        $resBk->assertHeader('content-disposition');
    }

    /**
     * File non-xlsx ditolak oleh validasi sistem.
     */
    public function test_uploading_non_xlsx_file_is_rejected(): void
    {
        $file = UploadedFile::fake()->create('data.csv', 100, 'text/csv');

        $response = $this->actingAs($this->master)->post(route('master.import.preview'), [
            'type' => 'siswa',
            'file' => $file,
        ]);

        $response->assertSessionHasErrors('file');
    }

    /**
     * Uji sanitasi pencegahan injeksi formula Excel.
     */
    public function test_formula_injection_sanitization(): void
    {
        $service = app(ExcelImportService::class);

        $this->assertEquals("'=SUM(A1:A10)", $service->sanitizeCellValue('=SUM(A1:A10)'));
        $this->assertEquals("'+12345", $service->sanitizeCellValue('+12345'));
        $this->assertEquals("'-calc.exe", $service->sanitizeCellValue('-calc.exe'));
        $this->assertEquals("'@cmd", $service->sanitizeCellValue('@cmd'));
        $this->assertEquals('Ahmad Fauzan', $service->sanitizeCellValue('Ahmad Fauzan'));
    }

    /**
     * Eksekusi commit import siswa berhasil membuat akun dan log aktivitas.
     */
    public function test_commit_student_import_creates_users_and_activity_log(): void
    {
        $service = app(ExcelImportService::class);

        $validRows = [
            [
                'nis' => '20261001',
                'nama' => 'Budi Santoso',
                'class_id' => $this->class->id,
                'class_name' => $this->class->name,
                'gender' => 'L',
            ],
            [
                'nis' => '20261002',
                'nama' => 'Siti Aisyah',
                'class_id' => $this->class->id,
                'class_name' => $this->class->name,
                'gender' => 'P',
            ],
        ];

        $credentials = $service->commitStudentImport($validRows);

        $this->assertCount(2, $credentials);
        $this->assertDatabaseHas('users', ['login_id' => '20261001', 'role' => 'siswa']);
        $this->assertDatabaseHas('users', ['login_id' => '20261002', 'role' => 'siswa']);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'excel_imported',
        ]);
    }

    /**
     * Tautan unduh kredensial hanya berlaku satu kali demi keamanan.
     */
    public function test_credentials_download_is_one_time_only(): void
    {
        $token = 'test-token-1234';
        session()->put('credentials_download_'.$token, [
            'type' => 'siswa',
            'credentials' => [
                [
                    'nis' => '20261001',
                    'name' => 'Budi',
                    'class_name' => 'VII-A',
                    'password' => 'Pass1234!',
                ],
            ],
        ]);

        // Unduhan pertama berhasil
        $firstResponse = $this->actingAs($this->master)->get(route('master.import.download-credentials', ['token' => $token]));
        $firstResponse->assertStatus(200);

        // Unduhan kedua ditolak karena sudah dihapus dari sesi
        $secondResponse = $this->actingAs($this->master)->get(route('master.import.download-credentials', ['token' => $token]));
        $secondResponse->assertRedirect(route('master.import.index'));
        $secondResponse->assertSessionHas('error');
    }

    /**
     * Tampilan pratinjau impor berhasil merender baris valid dan tidak valid tanpa error undefined key.
     */
    public function test_import_preview_view_renders_correctly_with_invalid_and_valid_rows(): void
    {
        $token = 'test-preview-token';
        $valid = [
            [
                'row_num' => 2,
                'row_index' => 2,
                'nis' => '20261001',
                'name' => 'Budi Santoso',
                'nama' => 'Budi Santoso',
                'class_id' => $this->class->id,
                'class_name' => $this->class->name,
                'gender' => 'L',
                'password' => '',
            ],
        ];
        $invalid = [
            [
                'row_num' => 3,
                'row_index' => 3,
                'nis' => '20261002',
                'name' => 'Siti Aisyah',
                'nama' => 'Siti Aisyah',
                'class_name' => 'VIII-B',
                'class_id' => null,
                'gender' => 'P',
                'password' => '',
                'errors' => ["Kelas 'VIII-B' belum terdaftar di data master kelas."],
            ],
        ];

        $view = $this->actingAs($this->master)->view('master.import.preview', [
            'token' => $token,
            'type' => 'siswa',
            'total' => 2,
            'valid' => $valid,
            'invalid' => $invalid,
        ]);

        $view->assertSee('Hasil Verifikasi Data Impor');
        $view->assertSee('#3');
        $view->assertSee('Budi Santoso');
        $view->assertSee("Kelas &#039;VIII-B&#039; belum terdaftar", false);
    }
}
