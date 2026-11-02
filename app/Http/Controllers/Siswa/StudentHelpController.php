<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class StudentHelpController extends Controller
{
    /**
     * Tampilkan halaman bantuan dan kontak darurat untuk siswa (FR-39).
     */
    public function index(): View
    {
        $schoolContacts = [
            'school_name' => Setting::get('school_name', 'MTs Soebono Mantofani'),
            'counseling_location' => Setting::get('counseling_location', 'Ruang Bimbingan & Konseling (BK), Gedung Utama MTs Soebono Mantofani'),
            'counseling_hours' => Setting::get('counseling_hours', 'Senin – Jumat, pukul 07.30 – 14.30 WIB'),
            'school_phone' => Setting::get('school_phone', '(021) 745-1234'),
            'school_email' => Setting::get('school_email', 'bk@mtssoebonomantofani.sch.id'),
        ];

        $nationalHotlines = [
            [
                'name' => 'SAPA 129 (Sahabat Perempuan dan Anak)',
                'provider' => 'Kementerian Pemberdayaan Perempuan dan Perlindungan Anak (KemenPPPA)',
                'hotline' => '129',
                'whatsapp' => '08111-129-129',
                'description' => 'Layanan pengaduan dan pendampingan darurat kekerasan terhadap anak & perempuan, beroperasi 24 jam bebas pulsa.',
            ],
            [
                'name' => 'KPAI (Komisi Perlindungan Anak Indonesia)',
                'provider' => 'Lembaga Independen Negara',
                'hotline' => '(021) 319-01983',
                'whatsapp' => '0821-3677-7833',
                'description' => 'Pengaduan pelanggaran hak dan keselamatan anak di lingkungan keluarga dan sekolah.',
            ],
            [
                'name' => 'Panggilan Darurat Kepolisian',
                'provider' => 'Polri',
                'hotline' => '110',
                'whatsapp' => '-',
                'description' => 'Hubungi jika kamu atau temanmu menghadapi bahaya fisik segera yang mengancam nyawa.',
            ],
        ];

        return view('siswa.bantuan', compact('schoolContacts', 'nationalHotlines'));
    }
}
