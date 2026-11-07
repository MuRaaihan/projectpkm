<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MasterAccountManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $master;

    protected User $bk;

    protected User $siswa;

    protected SchoolClass $class;

    protected function setUp(): void
    {
        parent::setUp();

        $this->master = User::factory()->master()->create([
            'password' => Hash::make('MasterSecret123!'),
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

        $this->siswa = User::factory()->create([
            'role' => 'siswa',
            'class_id' => $this->class->id,
            'gender' => 'L',
            'must_change_password' => false,
            'is_active' => true,
        ]);
    }

    /**
     * Master dapat membuat akun Guru BK baru.
     */
    public function test_master_can_create_bk_user(): void
    {
        $response = $this->actingAs($this->master)->post(route('master.bk-users.store'), [
            'login_id' => 'bk_nurul',
            'name' => 'Nurul Hidayati, S.Pd',
            'phone' => '081234567890',
            'password' => '', // kosong, sistem generate acak
        ]);

        $response->assertRedirect(route('master.bk-users.index'));
        $this->assertDatabaseHas('users', [
            'login_id' => 'bk_nurul',
            'name' => 'Nurul Hidayati, S.Pd',
            'role' => 'bk',
            'must_change_password' => true,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'user_created',
        ]);
    }

    /**
     * Master dapat mengaktifkan dan menonaktifkan akun Guru BK.
     */
    public function test_master_can_toggle_bk_status(): void
    {
        $this->assertTrue($this->bk->is_active);

        $response = $this->actingAs($this->master)->post(route('master.bk-users.toggle-status', $this->bk));
        $response->assertRedirect(route('master.bk-users.index'));
        $this->assertFalse($this->bk->fresh()->is_active);

        // Toggle kembali ke aktif
        $this->actingAs($this->master)->post(route('master.bk-users.toggle-status', $this->bk));
        $this->assertTrue($this->bk->fresh()->is_active);
    }

    /**
     * Master dapat mengarsipkan (soft-delete) dan memulihkan akun Guru BK.
     */
    public function test_master_can_archive_and_restore_bk_user(): void
    {
        // Arsipkan
        $response = $this->actingAs($this->master)->delete(route('master.bk-users.archive', $this->bk));
        $response->assertRedirect(route('master.bk-users.index'));
        $this->assertSoftDeleted('users', ['id' => $this->bk->id]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'user_archived',
        ]);

        // Pulihkan
        $response = $this->actingAs($this->master)->post(route('master.bk-users.restore', $this->bk->id));
        $response->assertRedirect(route('master.bk-users.index'));
        $this->assertNotSoftDeleted('users', ['id' => $this->bk->id]);
    }

    /**
     * Hapus permanen Guru BK gagal jika kata sandi Master salah.
     */
    public function test_bk_force_delete_fails_with_incorrect_master_password(): void
    {
        $this->bk->delete(); // diarsipkan dulu

        $response = $this->actingAs($this->master)->delete(route('master.bk-users.force-delete', $this->bk->id), [
            'master_password' => 'WrongPassword!',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->bk->id]);
    }

    /**
     * Hapus permanen Guru BK berhasil dengan konfirmasi kata sandi Master yang benar.
     */
    public function test_bk_force_delete_succeeds_with_correct_master_password(): void
    {
        $this->bk->delete();

        $response = $this->actingAs($this->master)->delete(route('master.bk-users.force-delete', $this->bk->id), [
            'master_password' => 'MasterSecret123!',
        ]);

        $response->assertRedirect(route('master.bk-users.index'));
        $this->assertDatabaseMissing('users', ['id' => $this->bk->id]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'user_deleted_permanently',
        ]);
    }

    /**
     * Master dapat mereset kata sandi Guru BK.
     */
    public function test_master_can_reset_bk_password(): void
    {
        $response = $this->actingAs($this->master)->post(route('master.bk-users.reset-password', $this->bk));

        $response->assertRedirect(route('master.bk-users.index'));
        $this->assertTrue($this->bk->fresh()->must_change_password);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'password_reset',
        ]);
    }

    /**
     * Master dapat mereset kata sandi Siswa.
     */
    public function test_master_can_reset_student_password(): void
    {
        $response = $this->actingAs($this->master)->post(route('master.students.reset-password', $this->siswa));

        $response->assertSessionHas('success');
        $this->assertTrue($this->siswa->fresh()->must_change_password);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'password_reset',
        ]);
    }

    /**
     * Master dapat membuat akun Siswa baru.
     */
    public function test_master_can_create_student(): void
    {
        $response = $this->actingAs($this->master)->post(route('master.students.store'), [
            'login_id' => '20269999',
            'name' => 'Fauzan Ahmad',
            'class_id' => $this->class->id,
            'gender' => 'L',
        ]);

        $response->assertRedirect(route('master.students.create'));
        $this->assertDatabaseHas('users', [
            'login_id' => '20269999',
            'name' => 'Fauzan Ahmad',
            'class_id' => $this->class->id,
            'gender' => 'L',
            'role' => 'siswa',
            'must_change_password' => true,
        ]);
    }

    /**
     * Master dapat mengarsipkan dan memulihkan akun Siswa.
     */
    public function test_master_can_archive_and_restore_student(): void
    {
        // Arsipkan
        $this->actingAs($this->master)->delete(route('master.students.archive', $this->siswa));
        $this->assertSoftDeleted('users', ['id' => $this->siswa->id]);

        // Pulihkan
        $this->actingAs($this->master)->post(route('master.students.restore', $this->siswa->id));
        $this->assertNotSoftDeleted('users', ['id' => $this->siswa->id]);
    }

    /**
     * Hapus permanen Siswa membutuhkan konfirmasi kata sandi Master.
     */
    public function test_student_force_delete_requires_master_password(): void
    {
        $this->siswa->delete();

        // Salah password
        $this->actingAs($this->master)->delete(route('master.students.force-delete', $this->siswa->id), [
            'master_password' => 'WrongPassword',
        ])->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $this->siswa->id]);

        // Benar password
        $this->actingAs($this->master)->delete(route('master.students.force-delete', $this->siswa->id), [
            'master_password' => 'MasterSecret123!',
        ])->assertRedirect(route('master.students.index'));

        $this->assertDatabaseMissing('users', ['id' => $this->siswa->id]);
    }

    /**
     * Guru BK dan Siswa tidak boleh mengakses rute manajemen akun master.
     */
    public function test_non_master_cannot_access_user_management(): void
    {
        $this->actingAs($this->bk)->get(route('master.students.index'))->assertStatus(403);
        $this->actingAs($this->bk)->get(route('master.bk-users.index'))->assertStatus(403);

        $this->actingAs($this->siswa)->get(route('master.students.index'))->assertStatus(403);
        $this->actingAs($this->siswa)->get(route('master.bk-users.index'))->assertStatus(403);
    }

    /**
     * Master dapat membuka dan memfilter halaman log aktivitas sistem.
     */
    public function test_master_can_view_and_filter_activity_logs(): void
    {
        $response = $this->actingAs($this->master)->get(route('master.activity-logs.index'));
        $response->assertStatus(200);
        $response->assertSee('Log Aktivitas & Audit Keamanan', false);

        // Filter aksi
        $filterResponse = $this->actingAs($this->master)->get(route('master.activity-logs.index', ['action' => 'login_success']));
        $filterResponse->assertStatus(200);
    }
}
