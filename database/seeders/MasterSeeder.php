<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membuat minimal 2 akun Master.
     * Password diambil dari .env atau digenerate acak bila belum ditentukan.
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
            $isRandom = empty($master['password']);
            $plainPassword = $master['password'] ?: 'Master123!';

            User::updateOrCreate(
                ['login_id' => $master['login_id']],
                [
                    'name' => $master['name'],
                    'role' => 'master',
                    'password' => Hash::make($plainPassword),
                    'is_active' => true,
                    'must_change_password' => true,
                ]
            );

            if ($isRandom) {
                $this->command?->info('Akun Master #'.($index + 1)." created: {$master['login_id']} | password awal: Master123!");
            }
        }
    }
}
