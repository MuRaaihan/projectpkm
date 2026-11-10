<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicAndInformationalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $this->class = SchoolClass::create([
            'academic_year_id' => $this->year->id,
            'name' => '8A',
            'grade_level' => 8,
        ]);

        $this->category = Category::create([
            'name' => 'Perundungan Fisik',
            'description' => 'Tindakan fisik tidak menyenangkan',
            'is_active' => true,
        ]);
    }

    public function test_landing_page_renders_successfully_with_required_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SIPERKA');
        $response->assertSee('MTs Soebono Mantofani');
        // Hero headline from docs/ui-guide.md baris 47
        $response->assertSee('Kamu tidak sendirian.');
        $response->assertSee('Ceritakan di sini, dengan aman.');
        // Tata cara & Phone Mockup
        $response->assertSee('Bagaimana Cara Menggunakan SIPERKA?');
        $response->assertSee('Masuk dengan Akun NIS');
        $response->assertSee('Ceritakan Kejadian');
        $response->assertSee('Pilih Opsi Rahasia');
        $response->assertSee('Pantau Penanganan');
        // Konten utama halaman publik
        $response->assertSee('Apa itu SIPERKA?');
        $response->assertSee('Siap Mewujudkan Sekolah Bebas Perundungan?');
        // Footer (FR-41)
        $response->assertSee('Jl. Nurul Huda No. 27');
        $response->assertSee('Layanan Bimbingan & Konseling', false);
    }

    public function test_privacy_policy_page_renders_successfully(): void
    {
        $response = $this->get('/kebijakan-privasi');

        $response->assertStatus(200);
        $response->assertSee('Kebijakan Privasi & Batas Kerahasiaan', false);
        $response->assertSee('Komitmen Perlindungan Peserta Didik');
        $response->assertSee('Permendikbudristek No. 46 Tahun 2023');
        $response->assertSee('Pelapor Rahasia');
        $response->assertSee('Batas Kerahasiaan');
        $response->assertSee('Batasan Akses Master Administrator');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_public_pages_do_not_leak_report_data_or_user_identities(): void
    {
        // Buat data rahasia di database
        $student = User::create([
            'login_id' => '1029384756',
            'name' => 'Siswa Rahasia Tingkat Satu',
            'role' => 'siswa',
            'password' => bcrypt('password123'),
            'class_id' => $this->class->id,
            'is_active' => true,
        ]);

        $report = Report::create([
            'reporter_id' => $student->id,
            'reporter_role' => 'korban',
            'category_id' => $this->category->id,
            'incident_date' => now()->subDays(2),
            'location' => 'Kantin Belakang Madrasah',
            'description' => 'Kronologi rahasia tentang kejadian intimidasi di kantin belakang',
            'accused_name' => 'Terlapor Sangat Rahasia',
            'is_hidden_identity' => true,
            'status' => 'baru',
        ]);

        // Kunjungi halaman beranda
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertDontSee('Siswa Rahasia Tingkat Satu');
        $homeResponse->assertDontSee('1029384756');
        $homeResponse->assertDontSee('Kronologi rahasia');
        $homeResponse->assertDontSee('Terlapor Sangat Rahasia');
        $homeResponse->assertDontSee('Kantin Belakang Madrasah');
        $homeResponse->assertDontSee($report->id);

        // Kunjungi halaman kebijakan privasi
        $privacyResponse = $this->get('/kebijakan-privasi');
        $privacyResponse->assertStatus(200);
        $privacyResponse->assertDontSee('Siswa Rahasia Tingkat Satu');
        $privacyResponse->assertDontSee('1029384756');
        $privacyResponse->assertDontSee('Kronologi rahasia');
        $privacyResponse->assertDontSee('Terlapor Sangat Rahasia');
    }

    public function test_guest_user_sees_login_button(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Masuk');
        $response->assertSee(route('login'));
    }

    public function test_authenticated_user_sees_dashboard_button(): void
    {
        $student = User::create([
            'login_id' => '1122334455',
            'name' => 'Ahmad Fulan',
            'role' => 'siswa',
            'password' => bcrypt('password123'),
            'class_id' => $this->class->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee(url('/dashboard'));
    }

    public function test_public_pages_do_not_contain_external_cdn_scripts_or_trackers(): void
    {
        $response = $this->get('/');
        $content = $response->getContent();

        $this->assertStringNotContainsString('cdn.jsdelivr.net', $content);
        $this->assertStringNotContainsString('unpkg.com', $content);
        $this->assertStringNotContainsString('cdnjs.cloudflare.com', $content);
        $this->assertStringNotContainsString('google-analytics.com', $content);
        $this->assertStringNotContainsString('googletagmanager.com', $content);
        $this->assertStringNotContainsString('fonts.googleapis.com', $content);
    }
}
