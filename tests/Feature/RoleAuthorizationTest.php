<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $master;

    protected User $bk;

    protected User $siswa;

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

        $this->siswa = User::factory()->create([
            'role' => 'siswa',
            'must_change_password' => false,
            'is_active' => true,
        ]);
    }

    /**
     * Tamu (guest) yang mengakses /dashboard dialihkan ke login.
     */
    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Pengguna Master dialihkan ke dashboard master dari route umum /dashboard.
     */
    public function test_master_is_redirected_to_master_dashboard(): void
    {
        $this->actingAs($this->master);

        $response = $this->get('/dashboard');
        $response->assertRedirect(route('master.dashboard'));
    }

    /**
     * Guru BK dialihkan ke dashboard BK dari route umum /dashboard.
     */
    public function test_bk_is_redirected_to_bk_dashboard(): void
    {
        $this->actingAs($this->bk);

        $response = $this->get('/dashboard');
        $response->assertRedirect(route('bk.dashboard'));
    }

    /**
     * Siswa dialihkan ke dashboard siswa dari route umum /dashboard.
     */
    public function test_siswa_is_redirected_to_siswa_dashboard(): void
    {
        $this->actingAs($this->siswa);

        $response = $this->get('/dashboard');
        $response->assertRedirect(route('siswa.dashboard'));
    }

    /**
     * Siswa dilarang keras (403) mengakses seluruh modul Master.
     */
    public function test_siswa_is_forbidden_from_all_master_routes(): void
    {
        $this->actingAs($this->siswa);

        $masterRoutes = [
            '/master/dashboard',
            '/master/students',
            '/master/bk-users',
            '/master/import',
            '/master/class-operations',
            '/master/classes',
            '/master/academic-years',
            '/master/activity-logs',
        ];

        foreach ($masterRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(403);
        }
    }

    /**
     * Guru BK dilarang keras (403) mengakses seluruh modul Master.
     */
    public function test_bk_is_forbidden_from_all_master_routes(): void
    {
        $this->actingAs($this->bk);

        $masterRoutes = [
            '/master/dashboard',
            '/master/students',
            '/master/bk-users',
            '/master/import',
            '/master/class-operations',
            '/master/classes',
            '/master/academic-years',
            '/master/activity-logs',
        ];

        foreach ($masterRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(403);
        }
    }

    /**
     * Master dilarang keras (403) mengakses dashboard Guru BK dan Siswa.
     */
    public function test_master_is_forbidden_from_bk_and_siswa_routes(): void
    {
        $this->actingAs($this->master);

        $responseBk = $this->get('/bk/dashboard');
        $responseBk->assertStatus(403);

        $responseSiswa = $this->get('/siswa/dashboard');
        $responseSiswa->assertStatus(403);
    }

    /**
     * Siswa dilarang keras (403) mengakses dashboard Guru BK.
     */
    public function test_siswa_is_forbidden_from_bk_routes(): void
    {
        $this->actingAs($this->siswa);

        $response = $this->get('/bk/dashboard');
        $response->assertStatus(403);
    }

    /**
     * Guru BK dilarang keras (403) mengakses dashboard Siswa.
     */
    public function test_bk_is_forbidden_from_siswa_routes(): void
    {
        $this->actingAs($this->bk);

        $response = $this->get('/siswa/dashboard');
        $response->assertStatus(403);
    }
}
