<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClassOperationTest extends TestCase
{
    use RefreshDatabase;

    protected User $master;

    protected User $bk;

    protected SchoolClass $classA;

    protected SchoolClass $classB;

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

        $this->classA = SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'VII-A',
            'grade_level' => 7,
        ]);

        $this->classB = SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'VIII-A',
            'grade_level' => 8,
        ]);
    }

    /**
     * Non-master dilarang mengakses modul operasi massal kelas.
     */
    public function test_non_master_cannot_access_class_operations(): void
    {
        $this->actingAs($this->bk)->get(route('master.class-operations.index'))->assertStatus(403);
    }

    /**
     * Pengarsipan massal siswa per kelas gagal jika kata sandi Master salah.
     */
    public function test_bulk_archive_class_students_fails_with_wrong_password(): void
    {
        User::factory()->count(5)->create([
            'role' => 'siswa',
            'class_id' => $this->classA->id,
        ]);

        $response = $this->actingAs($this->master)->post(route('master.class-operations.archive-students'), [
            'class_id' => $this->classA->id,
            'master_password' => 'WrongPassword',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(5, User::where('class_id', $this->classA->id)->count());
    }

    /**
     * Pengarsipan massal siswa per kelas berhasil dengan konfirmasi kata sandi Master.
     */
    public function test_bulk_archive_class_students_succeeds_with_correct_password(): void
    {
        User::factory()->count(5)->create([
            'role' => 'siswa',
            'class_id' => $this->classA->id,
        ]);

        $response = $this->actingAs($this->master)->post(route('master.class-operations.archive-students'), [
            'class_id' => $this->classA->id,
            'master_password' => 'MasterSecret123!',
        ]);

        $response->assertSessionHas('success');
        // Siswa aktif jadi 0 karena sudah di-soft-delete (arsip)
        $this->assertEquals(0, User::where('class_id', $this->classA->id)->count());
        $this->assertEquals(5, User::onlyTrashed()->where('class_id', $this->classA->id)->count());

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'class_users_archived',
        ]);
    }

    /**
     * Pratinjau kenaikan kelas menampilkan daftar siswa.
     */
    public function test_preview_class_promotion(): void
    {
        User::factory()->count(3)->create([
            'role' => 'siswa',
            'class_id' => $this->classA->id,
        ]);

        $response = $this->actingAs($this->master)->post(route('master.class-operations.preview-promotion'), [
            'from_class_id' => $this->classA->id,
            'to_class_id' => $this->classB->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('VII-A');
        $response->assertSee('VIII-A');
        $response->assertSee('Pindahkan 3 Siswa Sekarang');
    }

    /**
     * Eksekusi kenaikan / perpindahan kelas massal memindahkan seluruh siswa ke kelas baru.
     */
    public function test_promote_class_moves_students_to_new_class(): void
    {
        $students = User::factory()->count(4)->create([
            'role' => 'siswa',
            'class_id' => $this->classA->id,
        ]);

        $response = $this->actingAs($this->master)->post(route('master.class-operations.promote'), [
            'from_class_id' => $this->classA->id,
            'to_class_id' => $this->classB->id,
        ]);

        $response->assertRedirect(route('master.class-operations.index'));
        $response->assertSessionHas('success');

        $this->assertEquals(0, User::where('class_id', $this->classA->id)->count());
        $this->assertEquals(4, User::where('class_id', $this->classB->id)->count());

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'class_promoted',
        ]);
    }
}
