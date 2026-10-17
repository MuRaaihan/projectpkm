<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataTest extends TestCase
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
     * Non-master tidak boleh mengakses rute tahun ajaran & kelas.
     */
    public function test_non_master_cannot_access_master_data_routes(): void
    {
        // Tamu dialihkan ke login
        $this->get(route('master.academic-years.index'))->assertRedirect('/login');
        $this->get(route('master.classes.index'))->assertRedirect('/login');

        // BK menerima 403
        $this->actingAs($this->bk)->get(route('master.academic-years.index'))->assertStatus(403);
        $this->actingAs($this->bk)->get(route('master.classes.index'))->assertStatus(403);

        // Siswa menerima 403
        $this->actingAs($this->siswa)->get(route('master.academic-years.index'))->assertStatus(403);
        $this->actingAs($this->siswa)->get(route('master.classes.index'))->assertStatus(403);
    }

    /**
     * Master dapat melihat daftar tahun ajaran.
     */
    public function test_master_can_view_academic_years(): void
    {
        AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->master)->get(route('master.academic-years.index'));

        $response->assertStatus(200);
        $response->assertSee('2026/2027');
    }

    /**
     * Master dapat membuat tahun ajaran baru.
     */
    public function test_master_can_create_academic_year(): void
    {
        $response = $this->actingAs($this->master)->post(route('master.academic-years.store'), [
            'name' => '2026/2027',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('master.academic-years.index'));
        $this->assertDatabaseHas('academic_years', [
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->master->id,
            'action' => 'academic_year_created',
        ]);
    }

    /**
     * Mengaktifkan tahun ajaran baru otomatis menonaktifkan tahun ajaran lainnya.
     */
    public function test_only_one_academic_year_can_be_active(): void
    {
        $year1 = AcademicYear::create([
            'name' => '2025/2026',
            'is_active' => true,
        ]);

        $this->actingAs($this->master)->post(route('master.academic-years.store'), [
            'name' => '2026/2027',
            'is_active' => '1',
        ]);

        $this->assertFalse($year1->fresh()->is_active);
        $this->assertTrue(AcademicYear::where('name', '2026/2027')->first()->is_active);
    }

    /**
     * Master dapat memperbarui tahun ajaran.
     */
    public function test_master_can_update_academic_year(): void
    {
        $year = AcademicYear::create([
            'name' => '2025/2026',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->master)->put(route('master.academic-years.update', $year), [
            'name' => '2025/2026 Revisi',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('master.academic-years.index'));
        $this->assertDatabaseHas('academic_years', [
            'id' => $year->id,
            'name' => '2025/2026 Revisi',
            'is_active' => true,
        ]);
    }

    /**
     * Master tidak dapat menghapus tahun ajaran yang memiliki kelas terhubung.
     */
    public function test_master_cannot_delete_academic_year_with_classes(): void
    {
        $year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'VII-A',
            'grade_level' => 7,
        ]);

        $response = $this->actingAs($this->master)->delete(route('master.academic-years.destroy', $year));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('academic_years', ['id' => $year->id]);
    }

    /**
     * Master dapat membuat data kelas.
     */
    public function test_master_can_create_class(): void
    {
        $year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->master)->post(route('master.classes.store'), [
            'academic_year_id' => $year->id,
            'name' => 'VII-B',
            'grade_level' => 7,
        ]);

        $response->assertRedirect(route('master.classes.index', ['academic_year_id' => $year->id]));
        $this->assertDatabaseHas('classes', [
            'academic_year_id' => $year->id,
            'name' => 'VII-B',
            'grade_level' => 7,
        ]);
    }

    /**
     * Nama kelas harus unik dalam satu tahun ajaran yang sama.
     */
    public function test_class_name_must_be_unique_within_same_academic_year(): void
    {
        $year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'VIII-A',
            'grade_level' => 8,
        ]);

        $response = $this->actingAs($this->master)->post(route('master.classes.store'), [
            'academic_year_id' => $year->id,
            'name' => 'VIII-A',
            'grade_level' => 8,
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Master tidak dapat menghapus kelas jika terdapat siswa di dalamnya.
     */
    public function test_master_cannot_delete_class_with_students(): void
    {
        $year = AcademicYear::create([
            'name' => '2026/2027',
            'is_active' => true,
        ]);

        $class = SchoolClass::create([
            'academic_year_id' => $year->id,
            'name' => 'IX-A',
            'grade_level' => 9,
        ]);

        User::factory()->create([
            'role' => 'siswa',
            'class_id' => $class->id,
        ]);

        $response = $this->actingAs($this->master)->delete(route('master.classes.destroy', $class));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('classes', ['id' => $class->id]);
    }
}
