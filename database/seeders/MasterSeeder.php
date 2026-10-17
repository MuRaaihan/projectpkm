<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * CATATAN: Seeder ini disiapkan sebagai kerangka pada Fase 0.
     * Eksekusi resminya dilakukan pada Fase 1 setelah skema tabel `users`
     * disesuaikan (menambahkan kolom role, login_id, dll).
     * Password diambil dari .env atau digenerate secara acak bila kosong.
     * Password TIDAK PERNAH ditulis secara langsung di kode.
     */
    public function run(): void
    {
        $masters = [
            [
                'login_id' => env('MASTER_1_LOGIN_ID', 'master1'),
                'name' => env('MASTER_1_NAME', 'Master Admin 1'),
                'password' => env('MASTER_1_PASSWORD'),
            ],
            [
                'login_id' => env('MASTER_2_LOGIN_ID', 'master2'),
                'name' => env('MASTER_2_NAME', 'Master Admin 2'),
                'password' => env('MASTER_2_PASSWORD'),
            ],
        ];

        foreach ($masters as $index => $master) {
            $password = $master['password'] ?: Str::password(12);

            // Pada Fase 1, saat kolom `role` dan `login_id` sudah ada di tabel `users`,
            // seeder ini akan membuat / mengupdate akun master secara aman.
            /*
            \App\Models\User::updateOrCreate(
                ['login_id' => $master['login_id']],
                [
                    'name' => $master['name'],
                    'role' => 'master',
                    'password' => Hash::make($password),
                    'is_active' => true,
                    'must_change_password' => true,
                ]
            );
            */

            if (empty($master['password'])) {
                $this->command?->warn('Akun Master #'.($index + 1)." ({$master['login_id']}) password acak sementara: {$password}");
            }
        }
    }
}
