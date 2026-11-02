<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Perundungan Fisik',
                'description' => 'Kekerasan atau kontak fisik yang menyakiti, seperti memukul, menendang, mendorong, atau merusak barang pribadi.',
                'is_active' => true,
            ],
            [
                'name' => 'Perundungan Verbal',
                'description' => 'Ucapan yang merendahkan, mengejek, menghina kekurangan fisik/keluarga, memanggil dengan julukan buruk, atau mengancam.',
                'is_active' => true,
            ],
            [
                'name' => 'Perundungan Siber (Cyberbullying)',
                'description' => 'Pelecehan lewat media sosial, pesan singkat, teror pesan, penyebaran foto/video tanpa izin, atau fitnah di internet.',
                'is_active' => true,
            ],
            [
                'name' => 'Perundungan Sosial / Pengucilan',
                'description' => 'Tindakan mengucilkan secara sengaja, menyebarkan rumor jahat, atau menghasut teman-teman untuk menjauhi korban.',
                'is_active' => true,
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Bentuk perlakuan tidak menyenangkan, intimidasi, atau pemalakan yang tidak tercakup dalam kategori lain.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }
    }
}
