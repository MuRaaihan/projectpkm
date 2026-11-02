<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\PeriodicReportSummary;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\Setting;
use App\Models\User;
use App\Services\TotpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReleaseThreeFeaturesTest extends TestCase
{
    use RefreshDatabase;

    private User $masterUser;

    private User $bkUser;

    private User $studentUser;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masterUser = User::factory()->create([
            'role' => 'master',
            'is_active' => true,
            'must_change_password' => false,
            'password' => Hash::make('password123'),
        ]);

        $this->bkUser = User::factory()->create([
            'role' => 'bk',
            'is_active' => true,
            'must_change_password' => false,
            'password' => Hash::make('password123'),
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
            'password' => Hash::make('password123'),
        ]);

        $this->category = Category::create([
            'name' => 'Perundungan Verbal',
            'description' => 'Ejekan, makian, atau fitnah',
            'is_active' => true,
        ]);
    }

    public function test_staff_can_view_two_factor_setup_page_and_secret_is_initialized(): void
    {
        $response = $this->actingAs($this->bkUser)->get(route('two-factor.setup'));

        $response->assertOk();
        $response->assertSee('Autentikasi Dua Faktor (2FA)');
        $response->assertSee('Secret Key');

        $this->bkUser->refresh();
        $this->assertNotNull($this->bkUser->two_factor_secret);
        $this->assertFalse($this->bkUser->hasTwoFactorEnabled());
    }

    public function test_student_cannot_access_two_factor_setup(): void
    {
        $response = $this->actingAs($this->studentUser)->get(route('two-factor.setup'));
        $response->assertForbidden();
    }

    public function test_staff_can_enable_two_factor_with_valid_totp_code(): void
    {
        $secret = TotpService::generateSecret();
        $this->bkUser->two_factor_secret = $secret;
        $this->bkUser->save();

        $validCode = TotpService::generateCode($secret);

        $response = $this->actingAs($this->bkUser)->post(route('two-factor.confirm'), [
            'code' => $validCode,
        ]);

        $response->assertSessionHas('success');
        $this->bkUser->refresh();

        $this->assertTrue($this->bkUser->hasTwoFactorEnabled());
        $this->assertNotNull($this->bkUser->two_factor_confirmed_at);
        $this->assertCount(8, $this->bkUser->recoveryCodes());

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_enabled',
            'user_id' => $this->bkUser->id,
        ]);
    }

    public function test_staff_cannot_enable_two_factor_with_invalid_totp_code(): void
    {
        $secret = TotpService::generateSecret();
        $this->bkUser->two_factor_secret = $secret;
        $this->bkUser->save();

        $response = $this->actingAs($this->bkUser)->post(route('two-factor.confirm'), [
            'code' => '000000',
        ]);

        $response->assertSessionHasErrors(['code']);
        $this->bkUser->refresh();
        $this->assertFalse($this->bkUser->hasTwoFactorEnabled());
    }

    public function test_login_flow_redirects_to_2fa_challenge_when_enabled(): void
    {
        $secret = TotpService::generateSecret();
        $this->bkUser->two_factor_secret = $secret;
        $this->bkUser->two_factor_confirmed_at = now();
        $this->bkUser->two_factor_recovery_codes = json_encode(TotpService::generateRecoveryCodes(8));
        $this->bkUser->save();

        $response = $this->post(route('login'), [
            'login_id' => $this->bkUser->login_id,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('two-factor.challenge'));
        $this->assertGuest();
        $this->assertEquals($this->bkUser->id, session('auth.2fa.user_id'));

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_challenged',
            'user_id' => $this->bkUser->id,
        ]);
    }

    public function test_user_can_complete_login_with_valid_totp_code(): void
    {
        $secret = TotpService::generateSecret();
        $this->bkUser->two_factor_secret = $secret;
        $this->bkUser->two_factor_confirmed_at = now();
        $this->bkUser->two_factor_recovery_codes = json_encode(TotpService::generateRecoveryCodes(8));
        $this->bkUser->save();

        $validCode = TotpService::generateCode($secret);

        $response = $this->withSession(['auth.2fa.user_id' => $this->bkUser->id])
            ->post(route('two-factor.verify'), [
                'code' => $validCode,
            ]);

        $response->assertRedirect(route('bk.dashboard'));
        $this->assertAuthenticatedAs($this->bkUser);
        $this->assertNull(session('auth.2fa.user_id'));

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_login_success',
            'user_id' => $this->bkUser->id,
        ]);
    }

    public function test_user_can_login_with_recovery_code_and_code_is_consumed(): void
    {
        $secret = TotpService::generateSecret();
        $recoveryCodes = TotpService::generateRecoveryCodes(8);
        $usedCode = $recoveryCodes[0];

        $this->bkUser->two_factor_secret = $secret;
        $this->bkUser->two_factor_confirmed_at = now();
        $this->bkUser->two_factor_recovery_codes = json_encode($recoveryCodes);
        $this->bkUser->save();

        $response = $this->withSession(['auth.2fa.user_id' => $this->bkUser->id])
            ->post(route('two-factor.verify'), [
                'recovery_code' => $usedCode,
            ]);

        $response->assertRedirect(route('bk.dashboard'));
        $this->assertAuthenticatedAs($this->bkUser);

        $this->bkUser->refresh();
        $this->assertCount(7, $this->bkUser->recoveryCodes());
        $this->assertNotContains($usedCode, $this->bkUser->recoveryCodes());

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_recovery_login',
            'user_id' => $this->bkUser->id,
        ]);
    }

    public function test_two_factor_challenge_rejects_invalid_code(): void
    {
        $secret = TotpService::generateSecret();
        $this->bkUser->two_factor_secret = $secret;
        $this->bkUser->two_factor_confirmed_at = now();
        $this->bkUser->two_factor_recovery_codes = json_encode(TotpService::generateRecoveryCodes(8));
        $this->bkUser->save();

        $response = $this->withSession(['auth.2fa.user_id' => $this->bkUser->id])
            ->post(route('two-factor.verify'), [
                'code' => '999999',
            ]);

        $response->assertSessionHasErrors(['code']);
        $this->assertGuest();

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_login_failed',
            'user_id' => $this->bkUser->id,
        ]);
    }

    public function test_staff_can_disable_two_factor_with_correct_password(): void
    {
        $this->masterUser->two_factor_secret = TotpService::generateSecret();
        $this->masterUser->two_factor_confirmed_at = now();
        $this->masterUser->two_factor_recovery_codes = json_encode(TotpService::generateRecoveryCodes(8));
        $this->masterUser->save();

        $response = $this->actingAs($this->masterUser)->post(route('two-factor.disable'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHas('success');
        $this->masterUser->refresh();
        $this->assertFalse($this->masterUser->hasTwoFactorEnabled());
        $this->assertNull($this->masterUser->two_factor_secret);

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_disabled',
            'user_id' => $this->masterUser->id,
        ]);
    }

    public function test_staff_cannot_disable_two_factor_with_incorrect_password(): void
    {
        $this->masterUser->two_factor_secret = TotpService::generateSecret();
        $this->masterUser->two_factor_confirmed_at = now();
        $this->masterUser->save();

        $response = $this->actingAs($this->masterUser)->post(route('two-factor.disable'), [
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->masterUser->refresh();
        $this->assertTrue($this->masterUser->hasTwoFactorEnabled());
    }

    public function test_staff_can_regenerate_recovery_codes_with_password(): void
    {
        $oldCodes = TotpService::generateRecoveryCodes(8);
        $this->masterUser->two_factor_secret = TotpService::generateSecret();
        $this->masterUser->two_factor_confirmed_at = now();
        $this->masterUser->two_factor_recovery_codes = json_encode($oldCodes);
        $this->masterUser->save();

        $response = $this->actingAs($this->masterUser)->post(route('two-factor.regenerate-recovery-codes'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHas('success');
        $this->masterUser->refresh();

        $newCodes = $this->masterUser->recoveryCodes();
        $this->assertCount(8, $newCodes);
        $this->assertNotEquals($oldCodes, $newCodes);

        $this->assertDatabaseHas('activity_logs', [
            'action' => '2fa_recovery_codes_regenerated',
            'user_id' => $this->masterUser->id,
        ]);
    }

    public function test_periodic_summary_artisan_command_generates_monthly_and_semester_summaries(): void
    {
        // Create test report
        Report::create([
            'reporter_id' => $this->studentUser->id,
            'reporter_role' => 'korban',
            'reporter_class_name' => '8-A',
            'reporter_grade_level' => 8,
            'category_id' => $this->category->id,
            'incident_date' => now()->toDateString(),
            'location' => 'Kantin Sekolah',
            'description' => 'Insiden perundungan verbal di kantin',
            'accused_name' => 'Siswa X',
            'status' => 'selesai',
            'urgency' => 'tinggi',
            'is_hidden_identity' => false,
            'closed_at' => now(),
        ]);

        $exitCode = Artisan::call('reports:generate-summary', [
            '--period' => 'monthly',
        ]);

        $this->assertEquals(0, $exitCode);
        $this->assertDatabaseHas('periodic_report_summaries', [
            'period_type' => 'monthly',
            'total_reports' => 1,
            'resolved_reports' => 1,
        ]);
    }

    public function test_staff_can_access_periodic_reports_web_pages_and_trigger_manual_generation(): void
    {
        $summary = PeriodicReportSummary::create([
            'period_type' => 'monthly',
            'period_label' => 'Oktober 2026',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-31',
            'total_reports' => 5,
            'resolved_reports' => 4,
            'in_progress_reports' => 1,
            'rejected_reports' => 0,
            'anonymous_reports' => 2,
            'avg_resolution_hours' => 24.5,
            'categories_breakdown' => ['Perundungan Verbal' => 5],
            'classes_breakdown' => ['8-A' => 3, '8-B' => 2],
            'urgencies_breakdown' => ['tinggi' => 2, 'sedang' => 3],
        ]);

        // BK can access index and show
        $bkIndex = $this->actingAs($this->bkUser)->get(route('periodic-reports.index'));
        $bkIndex->assertOk();
        $bkIndex->assertSee('Oktober 2026');

        $bkShow = $this->actingAs($this->bkUser)->get(route('periodic-reports.show', $summary));
        $bkShow->assertOk();
        $bkShow->assertSee('Oktober 2026');
        $bkShow->assertSee('Perundungan Verbal');

        // Master can also access index and show
        $masterIndex = $this->actingAs($this->masterUser)->get(route('periodic-reports.index'));
        $masterIndex->assertOk();

        // Student cannot access
        $studentIndex = $this->actingAs($this->studentUser)->get(route('periodic-reports.index'));
        $studentIndex->assertForbidden();

        // Staff can generate summary via POST
        $generateResponse = $this->actingAs($this->masterUser)->post(route('periodic-reports.generate'), [
            'period' => 'monthly',
        ]);
        $generateResponse->assertSessionHas('success');
    }

    public function test_audit_retention_command_runs_successfully(): void
    {
        $exitCode = Artisan::call('reports:audit-retention');
        $this->assertEquals(0, $exitCode);
    }

    public function test_master_can_update_data_retention_years(): void
    {
        $response = $this->actingAs($this->masterUser)->put(route('master.settings.update'), [
            'school_name' => 'MTs Soebono Mantofani Baru',
            'school_address' => 'Jl. Baru No. 10',
            'counseling_location' => 'Gedung BK',
            'counseling_hours' => '07.30 - 15.00',
            'hero_title' => 'Judul Baru',
            'hero_subtitle' => 'Penjelasan Hero Baru',
            'about_text' => 'Tentang SISPERKA Baru',
            'data_retention_years' => 7,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('7', Setting::get('data_retention_years'));
    }
}
