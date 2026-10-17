<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data palsu khusus untuk pengujian lokal.
     */
    public function run(): void
    {
        // 1. Tahun Ajaran Aktif
        $academicYear = AcademicYear::firstOrCreate(
            ['name' => '2026/2027'],
            [
                'is_active' => true,
                'starts_on' => '2026-07-15',
                'ends_on' => '2027-06-20',
            ]
        );

        // 2. Kelas Contoh
        $class8A = SchoolClass::firstOrCreate(
            [
                'academic_year_id' => $academicYear->id,
                'name' => 'VIII-A',
            ],
            [
                'grade_level' => 8,
            ]
        );

        // 3. Akun Guru BK Contoh
        User::updateOrCreate(
            ['login_id' => '198501012010012001'],
            [
                'name' => 'Ibu Rahayu, S.Psi.',
                'role' => 'bk',
                'password' => Hash::make('GuruBK123!'),
                'is_active' => true,
                'must_change_password' => false,
                'phone' => '081234567890',
            ]
        );

        // 4. Akun Siswa Aktif Contoh (must_change_password = true)
        User::updateOrCreate(
            ['login_id' => '12345'],
            [
                'name' => 'Ahmad Raka Pratama',
                'role' => 'siswa',
                'class_id' => $class8A->id,
                'gender' => 'L',
                'password' => Hash::make('Siswa123!'),
                'is_active' => true,
                'must_change_password' => true,
            ]
        );

        // 5. Akun Siswa Nonaktif (untuk uji penolakan login akun nonaktif)
        User::updateOrCreate(
            ['login_id' => '12346'],
            [
                'name' => 'Siswa Nonaktif',
                'role' => 'siswa',
                'class_id' => $class8A->id,
                'gender' => 'P',
                'password' => Hash::make('Siswa123!'),
                'is_active' => false,
                'must_change_password' => false,
            ]
        );
    }
}
