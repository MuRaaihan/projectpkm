# SIPERKA — Sistem Pelaporan Perundungan
### MTs Soebono Mantofani

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=flat&logo=tailwind-css)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-Proprietary-0F766E)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production--Ready-success)](docs/prd.md)

**SIPERKA** adalah aplikasi pelaporan dan penanganan insiden perundungan (*bullying*) berbasis web yang dikembangkan khusus untuk lingkungan **MTs Soebono Mantofani**. Sistem ini dirancang untuk menciptakan ruang bercerita yang aman, ramah anak, dan terpercaya bagi siswa, sekaligus memfasilitasi tim Bimbingan Konseling (Guru BK) dalam menindaklanjuti setiap pengaduan secara terstruktur, rapi, dan terdokumentasi.

Pengembangan sistem ini mengacu langsung pada amanat **Permendikbudristek No. 46 Tahun 2023** tentang Pencegahan dan Penanganan Kekerasan di Lingkungan Satuan Pendidikan (PPKSP) serta mematuhi ketentuan perlindungan data pribadi sesuai **UU No. 27 Tahun 2022 (UU PDP)**.

---

## 🌟 Fitur Utama Berdasarkan Peran

### 1. 🎓 Modul Siswa (Pelapor)
* **Login Mudah & Mandiri**: Masuk menggunakan Nomor Induk Siswa (NIS) terdaftar tanpa perlu registrasi rumit.
* **Formulir Lapor Ramah Anak**: Wizard pelaporan bertahap dengan bahasa yang hangat, menenangkan, dan tidak menghakimi.
* **Opsi "Lapor Rahasia" (`is_hidden_identity`)**: Pilihan untuk menyamarkan nama siswa menjadi *"Pelapor Rahasia"* pada seluruh antarmuka guna melindungi siswa dari risiko perundungan berulang atau pembalasan.
* **Unggah Bukti Privat**: Dukungan unggah berkas bukti foto/dokumen (JPG, PNG, PDF; maks. 5 MB) yang disimpan di direktori privat terisolasi.
* **Riwayat & Komunikasi Berjalan**: Siswa dapat memantau status laporan secara berkala dan berinteraksi langsung dengan Guru BK melalui fitur pesan/kronologi susulan bertampilan *bubble chat* adaptif.
* **Pusat Bantuan & Kontak BK**: Akses cepat ke informasi kontak darurat dan lokasi ruang konseling madrasah.

### 2. 🛡️ Modul Guru BK (Konselor Penanganan)
* **Dashboard Kasus Terpadu**: Pemantauan metrik laporan baru, kasus dalam proses, dan laporan terselesaikan yang dilengkapi visualisasi statistik Chart.js.
* **Segmented Status Tab & Panel Filter 12-Kolom**: Pengelompokan status laporan (*Semua, Baru, Diverifikasi, Diproses, Selesai, Ditolak*) dengan indikator dot berwarna dan badge monospace, dipadukan formulir filter lanjutan.
* **Pencarian Multi-Kriteria Cerdas**: Pencarian komprehensif mencakup nomor tiket (`#LAP-...` dinormalisasi otomatis ke UUID), lokasi kejadian, nama kelas, peran pelapor (korban/saksi), kategori perundungan, serta nama/NIS pelapor non-anonim.
* **Dekripsi Kronologi & Catatan Internal**: Pembacaan kronologi kejadian secara aman, disertai fitur catatan internal privat yang tidak dapat diakses oleh siswa.
* **Tombol "Lihat Identitas" dengan Audit Log**: Pembukaan identitas siswa pelapor rahasia hanya dapat dilakukan dengan konfirmasi khusus dan otomatis tercatat di log audit aktivitas.
* **Kelola Kategori Perundungan**: Manajemen jenis perundungan (Fisik, Verbal, Siber, Sosial, dsb).
* **Unduh Laporan Resmi (PDF & Excel)**: Cetak rekapitulasi penanganan kasus bertanda "RAHASIA" dan format cetak resmi madrasah.

### 3. ⚙️ Modul Master Admin (Tata Kelola Akun & Sistem)
* **Kelola Akun Terstruktur**: Pengelolaan akun Siswa dan Guru BK dengan formulir ramah pengguna (satu tombol submit utama, peniadaan tombol reset manual, dan auto-reset bersih setelah penyimpanan).
* **Impor Massal Excel Berkecepatan Tinggi**: Unggah berkas Excel dengan *dropzone* drag-and-drop interaktif, validasi duplikasi NIS/NIP seketika, pratinjau data, serta pemrosesan *chunked bulk insert* (< 1 detik untuk ratusan data).
* **Akademik & Kelas**: Manajemen Tahun Ajaran aktif, Daftar Kelas per tingkat, serta fitur Kenaikan Kelas & Mutasi Siswa massal dengan pratinjau sebelum eksekusi.
* **Sistem & Konfigurasi**: Pengaturan identitas madrasah, jam layanan BK, narasi beranda publik, dan kebijakan retensi data.
* **Log Audit Aktivitas (Append-Only)**: Pencatatan otomatis setiap aksi penting (login, perubahan akun, pembukaan identitas, ekspor data, mutasi kelas) tanpa fitur edit/hapus log demi akuntabilitas.
* **Rekap Laporan Berkala**: Kompilasi statistik agregasi otomatis per bulan/semester (tanpa memuat identitas maupun kronologi).
* **Integrasi SweetAlert2**: Dialog konfirmasi modern dan elegan untuk setiap aksi destruktif (hapus akun, reset sandi, hapus kelas, mutasi).

---

## 🔒 Prinsip Keamanan & Privasi (Golden Rules)

1. **Pemisahan Peran Tegas (RBAC di Server)**:
   * Siswa **hanya dapat mengakses laporan miliknya sendiri** (terproteksi dari celah IDOR melalui primary key UUID).
   * Master Admin **dilarang keras dan diblokir secara mutlak** dari melihat isi kronologi laporan, identitas pelapor, maupun bukti kasus.
   * Master Admin **tidak memiliki menu notifikasi kasus** agar tidak terjadi tumpang tindih dengan ranah konseling Guru BK.
2. **Kepatuhan Privasi Pelapor (FR-02)**:
   * Siswa yang memilih opsi rahasia tidak akan pernah bocor identitasnya melalui pencarian nama/NIS pada filter Guru BK.
3. **Enkripsi Data Sensitif**:
   * Kolom kronologi (`description`), nama terlapor (`accused_name`), pesan tindak lanjut (`message`), dan catatan internal (`note`) dienkripsi pada level database menggunakan enkripsi AES-256 bawaan Laravel (`encrypted` cast).
4. **Penyimpanan Berkas Privat**:
   * Berkas bukti disimpan di luar direktori web publik (`storage/app/private`), dengan nama acak (*hashed*), dan hanya disajikan melalui endpoint berotorisasi ketat.
5. **Proteksi Back Button Pasca-Logout (Anti-Bfcache)**:
   * Dilengkapi header OWASP `Cache-Control: no-cache, no-store, max-age=0, must-revalidate`, header `Clear-Site-Data: "cache"`, dan deteksi client-side `pageshow` agar halaman dashboard tidak dapat dibuka kembali melalui tombol Back browser setelah pengguna logout.
6. **Autentikasi Dua Faktor (2FA TOTP RFC 6238 Mandiri)**:
   * Fitur 2FA offline untuk staf Master dan Guru BK yang tidak bergantung pada layanan pihak ketiga luar negeri, dilengkapi 8 kode pemulihan darurat terenkripsi.

---

## 💻 Tumpukan Teknologi (Tech Stack)

| Komponen | Teknologi | Keterangan |
|---|---|---|
| **Framework Backend** | [Laravel 13](https://laravel.com) | PHP 8.3+ modern, arsitektur MVC bersih |
| **Basis Data** | [MariaDB](https://mariadb.org) / MySQL | Charset `utf8mb4`, engine InnoDB |
| **Gaya & Desain Antarmuka** | [Tailwind CSS v4](https://tailwindcss.com) | Konfigurasi `@theme` modern, mobile-first |
| **Tipografi** | Plus Jakarta Sans | Mandiri (*self-hosted* via `@fontsource/plus-jakarta-sans`) |
| **Interaktivitas UI** | [SweetAlert2](https://sweetalert2.github.io) | Dialog konfirmasi modal & flash toast otomatis |
| **Grafik & Visualisasi** | [Chart.js](https://www.chartjs.org) | Visualisasi statistik interaktif di dashboard BK & Master |
| **Impor & Ekspor Excel** | [Laravel Excel](https://maatwebsite.nl) | `maatwebsite/excel` v3 |
| **Pembuatan Dokumen PDF**| [DomPDF](https://github.com/barryvdh/laravel-dompdf) | `barryvdh/laravel-dompdf` v3 |
| **Mode Gelap (Dark Mode)**| Tailwind CSS `dark:` | Sakelar tema global tersimpan di `localStorage` |

---

## 🚀 Panduan Instalasi Lokal

### Prasyarat Sistem
* **PHP >= 8.3** (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `gd`, `zip`, `xml`)
* **Composer >= 2.x**
* **Node.js >= 18.x** & **NPM**
* **MariaDB >= 10.4** atau **MySQL >= 8.0**

### Langkah Pemasangan

1. **Kloning Repositori**:
   ```bash
   git clone https://github.com/MuRaaihan/projectpkm.git
   cd projectpkm
   ```

2. **Pasang Dependensi Backend & Frontend**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Berkas Lingkungan (`.env`)**:
   Salin berkas contoh `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka berkas `.env` dan sesuaikan kredensial database Anda:
   ```env
   DB_CONNECTION=mariadb
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_project
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Buat Kunci Aplikasi (*Application Key*)**:
   ```bash
   php artisan key:generate
   ```
   > ⚠️ **PENTING:** Simpan `APP_KEY` dengan aman. Kunci ini digunakan untuk mengenkripsi dan mendekripsi kronologi laporan. Jika kunci berubah, data terenkripsi tidak dapat dibaca kembali.

5. **Jalankan Migrasi Database & Seeder Dasar**:
   ```bash
   php artisan migrate --seed
   ```

6. **(Opsional) Pasang Data Demo Pengujian Lokal**:
   Untuk mengisi kelas contoh, akun Guru BK contoh, dan akun siswa contoh:
   ```bash
   php artisan db:seed --class=DemoSeeder
   ```

7. **Kompilasi Aset Frontend**:
   * Mode pengembangan (*hot reload*):
     ```bash
     npm run dev
     ```
   * Mode produksi (*production build*):
     ```bash
     npm run build
     ```

8. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka peramban dan akses: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Kredensial Pengujian (Data Demo)

| Peran | ID Masuk (*Login ID*) | Kata Sandi Awal | Keterangan |
|---|---|---|---|
| **Master Admin** | `master1` | `Master123!` | Kelola akun & sistem (wajib ganti sandi saat login pertama) |
| **Guru BK** | `198501012010012001` | `GuruBK123!` | Penanganan kasus & konseling |
| **Siswa** | `12345` | `SiswaMTS!` | Ahmad Raka Pratama (Kelas VIII-A) |

---

## 🧪 Pengujian Otomatis (*Automated Testing*)

Proyek ini dilengkapi rangkaian pengujian otomatis Feature Test dan Unit Test yang ketat untuk memastikan tidak ada celah keamanan (IDOR, kebocoran pelapor rahasia, otorisasi peran) maupun regresi fungsional.

Jalankan seluruh pengujian:
```bash
php artisan test
```

Menjalankan pengujian modul spesifik:
```bash
# Pengujian modul Guru BK & Pencarian Laporan
php artisan test --filter=BkReportManagementTest

# Pengujian manajemen akun Master & Kenaikan Kelas
php artisan test --filter=MasterAccountManagementTest

# Pengujian impor Excel massal
php artisan test --filter=ExcelImportTest
```

---

## 📂 Struktur Dokumentasi Proyek

Dokumentasi lengkap dan spesifikasi perancangan sistem tersimpan di folder [`docs/`](docs/):

* 📋 [`docs/prd.md`](docs/prd.md) — *Product Requirements Document* (PRD), alur pengguna, dan matriks hak akses.
* 📝 [`docs/tasks.md`](docs/tasks.md) — Daftar tugas bertahap (Fase 0 s.d. Fase 11) dan catatan keputusan tim pengembang.
* 🗄️ [`docs/database.md`](docs/database.md) — Skema basis data, ERD, tipe kolom terenkripsi, dan urutan migrasi.
* 🎨 [`docs/ui-guide.md`](docs/ui-guide.md) — Panduan desain, palet warna, tipografi, komponen Blade, dan aksesibilitas ramah anak.
* 🔐 [`docs/security-checklist.md`](docs/security-checklist.md) — Daftar periksa keamanan pra-rilis (OWASP, IDOR, CSP, sanitasi berkas).
* 🔄 [`docs/frontend-migration.md`](docs/frontend-migration.md) — Riwayat migrasi dari prototype Next.js ke Laravel Blade native.
* 📐 [`docs/layout-audit.md`](docs/layout-audit.md) — Laporan audit tata letak multi-device (360px HP, tablet, desktop) dan mode gelap.

---

## 📜 Hak Cipta & Lisensi

Sistem Informasi & Pelaporan Perundungan (**SIPERKA**) dikembangkan khusus untuk **MTs Soebono Mantofani**. Seluruh hak cipta dan kepemilikan kode dilindungi untuk kepentingan madrasah dan perlindungan peserta didik.
