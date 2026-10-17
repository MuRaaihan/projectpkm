<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('login|*');
    }

    /**
     * Halaman login tunggal dapat dimuat dengan baik.
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk ke SISPERKA');
        $response->assertSee('ID Pengguna (NIS / NIP / Username)');
    }

    /**
     * Master dapat login dan diarahkan ke dashboard master.
     */
    public function test_master_can_login_and_redirect_to_master_dashboard(): void
    {
        $master = User::factory()->create([
            'role' => 'master',
            'login_id' => 'master_test',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'login_id' => 'master_test',
            'password' => 'Password123!',
        ]);

        $this->assertAuthenticatedAs($master);
        $response->assertRedirect(route('master.dashboard'));

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $master->id,
            'action' => 'login_success',
        ]);
    }

    /**
     * Guru BK dapat login dan diarahkan ke dashboard BK.
     */
    public function test_bk_can_login_and_redirect_to_bk_dashboard(): void
    {
        $bk = User::factory()->create([
            'role' => 'bk',
            'login_id' => '198501012010012001',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'login_id' => '198501012010012001',
            'password' => 'Password123!',
        ]);

        $this->assertAuthenticatedAs($bk);
        $response->assertRedirect(route('bk.dashboard'));
    }

    /**
     * Siswa dapat login menggunakan NIS dan diarahkan ke dashboard siswa.
     */
    public function test_siswa_can_login_with_nis_and_redirect_to_siswa_dashboard(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'login_id' => '998877',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'login_id' => '998877',
            'password' => 'Password123!',
        ]);

        $this->assertAuthenticatedAs($siswa);
        $response->assertRedirect(route('siswa.dashboard'));
    }

    /**
     * Pesan error login identik antara NIS salah dan password salah (tidak membocorkan akun).
     */
    public function test_login_error_message_does_not_leak_account_existence(): void
    {
        User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'siswa_ada',
            'password' => Hash::make('PasswordBenar123!'),
            'is_active' => true,
        ]);

        // 1. Password salah untuk akun yang ada
        $resExisting = $this->from('/login')->post('/login', [
            'login_id' => 'siswa_ada',
            'password' => 'PasswordSalah!',
        ]);
        $resExisting->assertRedirect('/login');
        $resExisting->assertSessionHasErrors(['login_id' => 'ID Pengguna atau kata sandi yang kamu masukkan tidak sesuai.']);

        // 2. Akun tidak terdaftar
        $resNonExisting = $this->from('/login')->post('/login', [
            'login_id' => 'siswa_tidak_ada',
            'password' => 'PasswordApapun!',
        ]);
        $resNonExisting->assertRedirect('/login');
        $resNonExisting->assertSessionHasErrors(['login_id' => 'ID Pengguna atau kata sandi yang kamu masukkan tidak sesuai.']);

        // Catatan log gagal tersimpan
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'login_failed',
        ]);
    }

    /**
     * Akun nonaktif tidak bisa login.
     */
    public function test_inactive_account_cannot_login(): void
    {
        User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'siswa_nonaktif',
            'password' => Hash::make('Password123!'),
            'is_active' => false,
        ]);

        $response = $this->from('/login')->post('/login', [
            'login_id' => 'siswa_nonaktif',
            'password' => 'Password123!',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('login_id');
    }

    /**
     * Percobaan login salah berulang kali (5 kali) memicu rate limiting.
     */
    public function test_rate_limiting_locks_out_after_repeated_failures(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'login_id' => 'user_bruteforce',
                'password' => 'SalahSemua!',
            ]);
        }

        // Percobaan ke-6 harus di-throttle
        $response = $this->post('/login', [
            'login_id' => 'user_bruteforce',
            'password' => 'SalahSemua!',
        ]);

        $response->assertSessionHasErrors('login_id');
        $errors = session('errors')->get('login_id');
        $this->assertStringContainsString('Terlalu banyak percobaan masuk', $errors[0]);
    }

    /**
     * Pengguna dengan must_change_password diblokir dari dashboard dan diarahkan ke ganti password.
     */
    public function test_must_change_password_blocks_dashboard_access(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'siswa_baru',
            'password' => Hash::make('Awal123!'),
            'must_change_password' => true,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        // Mencoba akses dashboard siswa
        $response = $this->get('/siswa/dashboard');

        $response->assertRedirect(route('password.change'));
        $response->assertSessionHas('warning');
    }

    /**
     * Pengguna dapat berhasil mengganti password dan membuka akses dashboard.
     */
    public function test_user_can_change_password_successfully(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'siswa_ganti',
            'password' => Hash::make('PasswordAwal123!'),
            'must_change_password' => true,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->put('/ganti-password', [
            'password' => 'PasswordBaruKuat123!',
            'password_confirmation' => 'PasswordBaruKuat123!',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertFalse($user->must_change_password);
        $this->assertTrue(Hash::check('PasswordBaruKuat123!', $user->password));

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'password_changed',
        ]);
    }

    /**
     * Password baru tidak boleh sama dengan ID Pengguna / NIS.
     */
    public function test_password_cannot_be_same_as_login_id(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
            'login_id' => '12345678',
            'password' => Hash::make('PasswordAwal123!'),
            'must_change_password' => true,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->put('/ganti-password', [
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertSessionHasErrors('password');
        $user->refresh();
        $this->assertTrue($user->must_change_password);
    }

    /**
     * Otorisasi peran: Siswa tidak bisa mengakses URL Master atau BK (403 Forbidden).
     */
    public function test_siswa_cannot_access_master_or_bk_routes(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'siswa_biasa',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->actingAs($siswa);

        // Akses route master -> 403
        $resMaster = $this->get('/master/dashboard');
        $resMaster->assertStatus(403);

        // Akses route bk -> 403
        $resBk = $this->get('/bk/dashboard');
        $resBk->assertStatus(403);
    }

    /**
     * Otorisasi peran: Guru BK tidak bisa mengakses URL Master (403 Forbidden).
     */
    public function test_bk_cannot_access_master_routes(): void
    {
        $bk = User::factory()->create([
            'role' => 'bk',
            'login_id' => 'bk_user',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->actingAs($bk);

        $response = $this->get('/master/dashboard');
        $response->assertStatus(403);

        $resSiswa = $this->get('/siswa/dashboard');
        $resSiswa->assertStatus(403);
    }

    /**
     * Otorisasi peran: Master tidak bisa mengakses URL Guru BK atau Siswa (403 Forbidden).
     */
    public function test_master_cannot_access_bk_or_siswa_routes(): void
    {
        $master = User::factory()->create([
            'role' => 'master',
            'login_id' => 'master_user',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->actingAs($master);

        $resBk = $this->get('/bk/dashboard');
        $resBk->assertStatus(403);

        $resSiswa = $this->get('/siswa/dashboard');
        $resSiswa->assertStatus(403);
    }

    /**
     * Logout menghancurkan sesi dan mengalihkan ke beranda.
     */
    public function test_logout_ends_session(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
            'login_id' => 'siswa_logout',
            'password' => Hash::make('Password123!'),
            'must_change_password' => false,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'logout',
        ]);
    }
}
