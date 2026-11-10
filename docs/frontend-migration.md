# Rencana & Inventarisasi Migrasi Frontend SIPERKA

Dokumen ini disusun pada **Tahap 1: Inventarisasi** untuk memetakan seluruh aset desain di folder `frontend/` ke dalam view Blade Laravel di project SIPERKA tanpa merusak backend yang sudah berjalan.

---

## 1. Analisis Folder `frontend/`

- **Jenis Framework & Bahasa:** Next.js 16.3.5 (App Router), React 19.2.8, TypeScript, Tailwind CSS v4, PostCSS (`@tailwindcss/postcss`). Halaman menggunakan direktif `"use client"`.
- **Ikonografi:** Pustaka `lucide-react` (SVG outline). Di Laravel Blade akan menggunakan ikon SVG outline inline / komponen SVG lokal yang setara agar bebas dependensi CDN eksternal.
- **Aset Gambar & Font:**
  - Gambar: `frontend/public/logo-sekolah.png` (51 KB) dan `frontend/public/siperka-hero-v3.png` (1.2 MB). Aset ini disalin ke `public/images/` atau `resources/images/`.
  - Font: Font default sistem / Inter / Plus Jakarta Sans. Project Laravel sudah memasang `@fontsource/plus-jakarta-sans` secara mandiri (*self-hosted*).
- **Design System & Token Warna (diekstrak dari `frontend/src/app/globals.css`):**
  - **Brand Utama (Emerald Green):**
    - `primary-50`: `#f0f7f3`
    - `primary-100`: `#eaf5ee`
    - `primary-200`: `#c9e6d8`
    - `primary-300`: `#93ceb5`
    - `primary-400`: `#469a79`
    - `primary-500`: `#1f855f`
    - `primary-600`: `#176B4D` (Brand Utama)
    - `primary-700`: `#12553d` (Hover)
    - `primary-800`: `#0e422f`
    - `primary-900`: `#092c20`
  - **Aksen:**
    - `lime-accent`: `#B8E34B`
    - `gold-accent`: `#F2C94C`
    - `soft-mint`: `#EAF5EE`
  - **Netral (Slate/Warm Grey):**
    - `background`: `#F8FAF9` / Dark: `#0E1713`
    - `foreground`: `#26332C` / Dark: `#F2F7F4`
    - `surface-card`: `#FFFFFF` / Dark: `#16231D`
    - Garis tepi border: `#E2E1D9` / `#CBD5E1`
  - **Status Laporan:**
    - `baru` / Diterima: Latar `#F0F4F2`, Teks `#3D5245`
    - `diverifikasi`: Latar `#EAF5EE`, Teks `#176B4D`
    - `diproses`: Latar `#FEF8E3`, Teks `#8C6708`
    - `selesai`: Latar `#EDF8F1`, Teks `#176B4D`
    - `ditolak`: Latar `#FDF0F0`, Teks `#B91C1C`
- **Komponen Berulang di `frontend/src/components/`:**
  - `AppHeader`, `BottomNavigation`, `Button`, `Card`, `FileUpload`, `Input`, `KpiCard`, `PageContainer`, `PrivacyCard`, `ProgressSteps`, `Select`, `SideNav`, `StatusBadge`, `SummaryCard`, `Textarea`, `ThemeToggle`, `Timeline`.
  - Layout Peran: `AdminLayout`, `GBKLayout`, Siswa (`PageContainer`).

---

## 2. Tabel Pemetaan Halaman & Status

| No | Halaman / Route | View Blade Saat Ini | Desain di `frontend/` | Status Migrasi |
|---|---|---|---|---|
| 1 | Beranda Publik (`GET /`) | `resources/views/welcome.blade.php` | `frontend/src/app/page.tsx` | **Selesai 100%** (`4ef8374`) |
| 2 | Kebijakan Privasi (`GET /kebijakan-privasi`) | `resources/views/privacy.blade.php` | Diadaptasi dari komponen modal/card privasi | **Selesai 100%** (`8cb0649`) |
| 3 | Login Universal (`GET /login`, `POST /login`) | `resources/views/auth/login.blade.php` | `frontend/src/app/login/page.tsx` | **Selesai 100%** (`72bf5f8`) |
| 4 | Tantangan 2FA (`GET /two-factor-challenge`, `POST /two-factor-challenge`) | `resources/views/auth/two-factor-challenge.blade.php` | Diadaptasi dari `frontend/src/components/ui/OTPInput.tsx` | **Selesai 100%** (`10a5b22`) |
| 5 | Ganti Password (`GET /ganti-password`, `PUT /ganti-password`) | `resources/views/auth/change-password.blade.php` | Diadaptasi dari `frontend/src/app/profil/page.tsx` | **Selesai 100%** (`10a5b22`) |
| 6 | Notifikasi (`GET /notifikasi`) | `resources/views/notifications/index.blade.php` | `frontend/src/app/admin/notifikasi/page.tsx` & `frontend/src/app/guru-bk/notifikasi/page.tsx` | **Selesai 100%** (`35946c5`) |
| 7 | Dashboard Siswa (`GET /siswa/dashboard`) | `resources/views/siswa/dashboard.blade.php` | `frontend/src/app/dashboard/page.tsx` | **Selesai 100%** (`b0b9e2f`) |
| 8 | Riwayat Laporan Siswa (`GET /siswa/laporan`) | `resources/views/siswa/reports/index.blade.php` | `frontend/src/app/laporan/page.tsx` | **Selesai 100%** (`e3c3dae`) |
| 9 | Form Buat Laporan Siswa (`GET /siswa/laporan/buat`, `POST /siswa/laporan`) | `resources/views/siswa/reports/create.blade.php` | `frontend/src/app/laporan/buat/page.tsx` | **Selesai 100%** (`e28b9c4`) |
| 10 | Detail Laporan Siswa (`GET /siswa/laporan/{report}`) | `resources/views/siswa/reports/show.blade.php` | `frontend/src/app/laporan/[id]/page.tsx` | **Selesai 100%** (`e3c3dae`) |
| 11 | Bantuan & Kontak Siswa (`GET /siswa/bantuan`) | `resources/views/siswa/bantuan.blade.php` | Diadaptasi konsisten dengan gaya SIPERKA | **Selesai 100%** (`8cb0649`) |
| 12 | Profil Siswa (`GET /siswa/profil`) | `resources/views/siswa/profile.blade.php` | `frontend/src/app/profil/page.tsx` | **Selesai 100%** (`5fbdbb3`) |
| 13 | Dashboard Guru BK (`GET /bk/dashboard`) | `resources/views/bk/dashboard.blade.php` | `frontend/src/app/guru-bk/dashboard/page.tsx` | **Selesai 100%** (`ae93efd`) |
| 14 | Daftar Laporan Guru BK (`GET /bk/laporan`) | `resources/views/bk/reports/index.blade.php` | `frontend/src/app/guru-bk/laporan/page.tsx` | **Selesai 100%** (`47cf7dd`) |
| 15 | Detail & Aksi Laporan BK (`GET /bk/laporan/{report}`) | `resources/views/bk/reports/show.blade.php` | `frontend/src/app/guru-bk/laporan/[id]/page.tsx` | **Selesai 100%** (`47cf7dd`) |
| 16 | Unduh Laporan PDF/Excel (`GET /bk/unduh-laporan`) | `resources/views/bk/reports/download.blade.php` | Diadaptasi dari kartu rekap dan filter BK | **Selesai 100%** (`6eca939`) |
| 17 | Kelola Kategori Perundungan (`GET /bk/kategori`) | `resources/views/bk/categories/index.blade.php` | Diadaptasi konsisten dari tabel data & modal | **Selesai 100%** (`6eca939`) |
| 18 | Statistik Guru BK (`GET /bk/statistik`) | `resources/views/bk/statistics/index.blade.php` | `frontend/src/app/guru-bk/statistik/page.tsx` | **Selesai 100%** (`ee68e23`) |
| 19 | Profil Guru BK (`GET /bk/profil`) | `resources/views/bk/profile/show.blade.php` | `frontend/src/app/guru-bk/profil/page.tsx` | **Selesai 100%** (`ee68e23`) |
| 20 | Setup 2FA Staf (`GET /two-factor-setup`) | `resources/views/auth/two-factor-setup.blade.php` | Diadaptasi konsisten dari profil & OTP setup | **Selesai 100%** (`10a5b22`) |
| 21 | Laporan Periodik Otomatis (`GET /laporan-periodik`) | `resources/views/reports/periodic/index.blade.php` | Diadaptasi dari kartu laporan rekapitulasi | **Selesai 100%** (`cc4f4c8`) |
| 22 | Detail Laporan Periodik (`GET /laporan-periodik/{summary}`) | `resources/views/reports/periodic/show.blade.php` | Diadaptasi konsisten dari detail statistik | **Selesai 100%** (`cc4f4c8`) |
| 23 | Dashboard Master Admin (`GET /master/dashboard`) | `resources/views/master/dashboard.blade.php` | `frontend/src/app/admin/dashboard/page.tsx` | **Selesai 100%** (`ee68e23`) |
| 24 | Manajemen Akun Siswa (`GET /master/students`) | `resources/views/master/students/index.blade.php` | `frontend/src/app/admin/pengguna/page.tsx` | **Selesai 100%** (`10a05a0`) |
| 25 | Form Tambah/Ubah Siswa (`GET /master/students/create`, `edit`) | `resources/views/master/students/create.blade.php`, `edit.blade.php` | Modal di `admin/pengguna` | **Selesai 100%** (`10a05a0`) |
| 26 | Manajemen Akun Guru BK (`GET /master/bk-users`) | `resources/views/master/bk-users/index.blade.php` | `frontend/src/app/admin/pengguna/page.tsx` (filter Guru BK) | **Selesai 100%** (`10a05a0`) |
| 27 | Form Tambah/Ubah Guru BK (`GET /master/bk-users/create`, `edit`) | `resources/views/master/bk-users/create.blade.php`, `edit.blade.php` | Modal `Tambah Guru BK` di `admin/pengguna` | **Selesai 100%** (`10a05a0`) |
| 28 | Master Data: Kelas (`GET /master/classes`) | `resources/views/master/classes/index.blade.php` | Diadaptasi konsisten dari tabel data modern | **Selesai 100%** (`3ef9c53`) |
| 29 | Master Data: Tahun Ajaran (`GET /master/academic-years`) | `resources/views/master/academic-years/index.blade.php` | Diadaptasi konsisten dari tabel data modern | **Selesai 100%** (`3ef9c53`) |
| 30 | Operasi Massal Kelas (`GET /master/class-operations`) | `resources/views/master/class-operations/index.blade.php` | Diadaptasi konsisten dari kartu operasi multi-langkah | **Selesai 100%** (`3ef9c53`) |
| 31 | Impor Pengguna Excel (`GET /master/import`) | `resources/views/master/import/index.blade.php` | `frontend/src/components/ui/FileUpload.tsx` | **Selesai 100%** (`5eccd8f`) |
| 32 | Pratinjau & Hasil Impor (`POST /master/import/preview`, `success`) | `resources/views/master/import/preview.blade.php`, `success.blade.php` | Diadaptasi konsisten dari tabel validasi & hasil | **Selesai 100%** (`5eccd8f`) |
| 33 | Log Audit Aktivitas (`GET /master/activity-logs`) | `resources/views/master/activity-logs/index.blade.php` | Widget riwayat di `admin/dashboard` | **Selesai 100%** (`e8e7e2c`) |
| 34 | Pengaturan Website (`GET /master/settings`) | `resources/views/master/settings/index.blade.php` | Diadaptasi konsisten dari form pengaturan modern | **Selesai 100%** (`e8e7e2c`) |
| 35 | Halaman Error 403 / 404 / 500 | `resources/views/errors/403.blade.php`, `404`, `500` | Diadaptasi konsisten dengan ilustrasi ramah madrasah | **Selesai 100%** (`362a29e`) |
| - | Template Cetak Rekapitulasi PDF BK | `resources/views/bk/reports/export_pdf.blade.php` | Diadaptasi format cetak resmi madrasah | **Selesai 100%** (`2393c70`) |
| - | Registrasi Siswa Mandiri (`/register`) | *Tidak ada di backend* | `frontend/src/app/register/page.tsx` | **Diabaikan (Sesuai Aturan Keamanan SIPERKA)** |
| - | Lupa Password Mandiri (`/lupa-password`) | *Tidak ada di backend* | `frontend/src/app/lupa-password/page.tsx` | **Diabaikan (Siswa Melapor ke Guru BK)** |
| - | Admin Monitoring Laporan (`/admin/laporan`) | *Tidak ada di backend* | `frontend/src/app/admin/laporan/page.tsx` | **Dilarang (Perlindungan Kerahasiaan Korban)** |

---

## 3. Detail Kontrak Setiap Halaman

### 3.1 Beranda Publik (`GET /`)
- **Route / URL:** `route('home')`, URL `/`
- **Method & Form:** Tidak ada form mutasi. Tautan: `route('login')`, `url('/dashboard')`, `route('privacy')`, serta tautan anchor `#tata-cara`, `#alur-penanganan`, `#faq`. Tombol darurat keluar cepat mengarah ke `https://www.google.com`.
- **Data Dinamis:** `Setting::get('school_name')`, `Setting::get('hero_title')`, `Setting::get('hero_subtitle')`, `Setting::get('emergency_contact')`, dll.
- **Role / Auth:** `@auth` menampilkan tombol "Dashboard" / "Buka Dashboard Saya", `@guest` menampilkan tombol "Masuk" / "Masuk & Buat Laporan".

### 3.2 Login Universal (`GET /login`, `POST /login`)
- **Route / URL:** `route('login')` (GET & POST)
- **Method & Form:** `<form method="POST" action="{{ route('login') }}">`, `@csrf`.
- **Atribut Input:**
  - `login_id`: teks (NIS / NIP / Username), `required`, `autofocus`, `value="{{ old('login_id') }}"`.
  - `password`: password, `required`.
  - `remember`: checkbox, optional.
- **Pesan Galat & Flash:** `@error('login_id')`, `@error('password')`, `session('status')`, `session('error')`, `session('warning')`. Pesan kegagalan login generik tanpa membocorkan eksistensi pengguna.

### 3.3 Dashboard Siswa (`GET /siswa/dashboard`)
- **Route / URL:** `route('siswa.dashboard')`, URL `/siswa/dashboard`
- **Variabel Controller:**
  - `$total_reports` (integer)
  - `$active_reports` (integer: baru, diverifikasi, diproses)
  - `$resolved_reports` (integer: selesai)
  - `$recent_reports` (koleksi Eloquent Report dengan relasi `category`, maksimal 5)
- **Aksi Cepat:** Tautan ke `route('siswa.reports.create')` ("Buat Laporan Baru"), `route('siswa.reports.index')` ("Semua Laporan"), `route('siswa.help')` ("Bantuan & Kontak").

### 3.4 Form Buat Laporan Siswa (`GET /siswa/laporan/buat`, `POST /siswa/laporan`)
- **Route / URL:** Form action `route('siswa.reports.store')` (POST), halaman `route('siswa.reports.create')`.
- **Method & Enctype:** `<form method="POST" action="{{ route('siswa.reports.store') }}" enctype="multipart/form-data">`, `@csrf`.
- **Atribut Input (Form Request `StoreReportRequest`):**
  - `reporter_role`: radio / pilihan ("korban" atau "saksi"), `required`, `old('reporter_role')`.
  - `category_id`: select, `required`, options dari `$categories` (`id` -> `name`), `old('category_id')`.
  - `incident_date`: input date, `required`, format `Y-m-d`, maks hari ini, `old('incident_date')`.
  - `location`: input text, `required`, maks 255 karakter, `old('location')`.
  - `description`: textarea (kronologi), `required`, min 20 karakter, maks 3000 karakter, `old('description')`.
  - `accused_name`: input text (opsional, pihak terlibat/terlapor), `old('accused_name')`.
  - `attachments[]`: file input (`multiple`, `.jpg,.jpeg,.png,.pdf`, maks 5 MB per berkas, maks 3 berkas).
  - `is_hidden_identity`: checkbox ("Sembunyikan nama saya dari daftar laporan"). Nilai boolean 1/0.
- **Pernyataan Kerahasiaan:** Wajib tampil permanen di dekat tombol submit: *"Nama kamu tidak terlihat oleh siswa lain. Guru BK tetap dapat mengetahuinya agar bisa membantu kamu dengan tepat."*
- **Penanganan Error:** `@error('field')` di bawah masing-masing kolom dengan teks ramah anak.

### 3.5 Riwayat Laporan Siswa (`GET /siswa/laporan`)
- **Route / URL:** `route('siswa.reports.index')`
- **Variabel Controller:** `$reports` (LengthAwarePaginator dari Report milik user, relasi `category`, `attachments`).
- **Data Tampil:** Nomor/ID Laporan (UUID), Kategori, Tanggal Kejadian, Badge Status (`baru`, `diverifikasi`, `diproses`, `selesai`, `ditolak`), ada tidaknya lampiran bukti, tautan detail ke `route('siswa.reports.show', $report)`.
- **Keadaan Kosong:** Tampilan ramah bila `$reports->isEmpty()`.

### 3.6 Detail Laporan Siswa (`GET /siswa/laporan/{report}`)
- **Route / URL:** `route('siswa.reports.show', $report)`
- **Variabel Controller:** `$report` dengan relasi `category`, `attachments`, `messages.sender`, `statusHistories.changer`.
- **Sub-Form Balasan Siswa:** Form POST ke `route('siswa.reports.follow-up', $report)` dengan input `message` (textarea), `@csrf`.
- **Keamanan:** Catatan internal Guru BK (`notes`) **TIDAK PERNAH** dikirim atau ditampilkan ke siswa.
- **Unduh Lampiran:** Tautan ke `route('siswa.reports.attachment', [$report, $attachment])`.

### 3.7 Profil Siswa (`GET /siswa/profil`, `PUT /siswa/profil/password`)
- **Route / URL:** `route('siswa.profile')`, form password action `route('siswa.profile.password')` dengan method spoofing `@method('PUT')` & `@csrf`.
- **Data User:** `$user` (nama, login_id/NIS, kelas `$user->schoolClass->name`, tanggal bergabung).
- **Input Password:** `current_password`, `password` (baru), `password_confirmation`.

### 3.8 Dashboard Guru BK (`GET /bk/dashboard`)
- **Route / URL:** `route('bk.dashboard')`
- **Variabel Controller:**
  - `$total_reports` (integer)
  - `$new_reports` (integer status `baru`)
  - `$active_reports` (integer status `diverifikasi`, `diproses`)
  - `$resolved_reports` (integer status `selesai`)
  - `$recent_reports` (koleksi 5 laporan terbaru dengan relasi `category`, `reporter`)

### 3.9 Daftar Laporan Guru BK (`GET /bk/laporan`)
- **Route / URL:** `route('bk.reports.index')`
- **Filter Query:** `status`, `urgency`, `category_id`, `class_name`, `date_from`, `date_to`, `q`, `sort`.
- **Variabel Controller:** `$reports` (paginator), `$categories`, `$classes`.
- **Identitas Pelapor:** Jika `$report->is_hidden_identity`, tampilkan badge/label **"Pelapor Rahasia"** dengan ikon gembok.

### 3.10 Detail & Tanggapan Laporan Guru BK (`GET /bk/laporan/{report}`)
- **Route / URL:** `route('bk.reports.show', $report)`
- **Variabel Controller:** `$report` (relasi lengkap termasuk `notes.user`), `$identityRevealed` (boolean dari session).
- **Aksi & Form di Halaman:**
  1. *Buka Identitas:* `POST route('bk.reports.reveal-identity', $report)`, modal peringatan bahwa aksi dicatat ke audit log.
  2. *Ubah Status:* `PUT route('bk.reports.update-status', $report)`, input `status`, `reason`.
  3. *Ubah Urgensi:* `PUT route('bk.reports.update-urgency', $report)`, input `urgency` (`rendah`, `sedang`, `tinggi`).
  4. *Tambah Catatan Internal:* `POST route('bk.reports.notes.store', $report)`, input `note`.
  5. *Kirim Balasan Resmi:* `POST route('bk.reports.messages.store', $report)`, input `message`.
  6. *Unduh Bukti:* `GET route('bk.reports.attachment', [$report, $attachment])`.

### 3.11 Dashboard Master Admin (`GET /master/dashboard`)
- **Route / URL:** `route('master.dashboard')`
- **Variabel Controller:**
  - `$students_count`, `$bk_count`, `$classes_count`, `$active_year`
  - `$report_stats`: statistik agregat (`total_reports`, `new_reports`, `active_reports`, `resolved_reports`, `rejected_reports`, `monthly_trend`, `category_distribution`, `status_distribution`, `grade_distribution`).
- **Aturan Privasi Mutlak:** Master **TIDAK** menerima daftar laporan, isi kronologi, maupun identitas siswa pelapor.

### 3.12 Manajemen Pengguna Siswa & BK (`master/students`, `master/bk-users`)
- **Route:** Resource controller standar dengan aksi `toggleStatus`, `archive`, `restore`, `forceDelete`, `resetPassword`.
- **Form Modal:** Konfirmasi aksi destruktif (misal force delete meminta konfirmasi password Master).

### 3.13 Impor Excel (`master/import`)
- **Alur 3 Langkah:**
  1. Form Upload (`GET master/import` -> `POST master/import/preview` dengan file `.xlsx`).
  2. Pratinjau Validasi (`master/import/preview.blade.php` menampilkan rekap valid, galat per baris, dan duplikasi).
  3. Konfirmasi Impor (`POST master/import/confirm` -> `master/import/success.blade.php` menampilkan daftar akun baru & kredensial awal dengan tombol unduh CSV/Excel satu kali).

---

## 4. Konflik Utama & Keputusan Desain

1. **Konflik Arsitektur (Next.js vs Laravel Blade):**
   - *Temuan:* Folder `frontend/` dibuat menggunakan Next.js + React.
   - *Solusi:* Seluruh markup JSX dan styling Tailwind v4 dikonversi menjadi Blade components (`<x-button>`, `<x-input>`, `<x-card>`, `<x-badge>`, `<x-table>`, `<x-modal>`, `<x-layouts.app>`, dll.) dan Alpine.js untuk reaktivitas ringan (modal, toggle tab, accordion FAQ).
2. **Halaman Desain Tanpa Backend (Dilarang Masuk):**
   - `frontend/src/app/admin/laporan`: Master dilarang oleh PRD & security checklist melihat daftar laporan. Halaman ini **TIDAK dibuat** di backend.
   - `frontend/src/app/register`: Registrasi mandiri siswa dilarang karena semua akun dibuat via data resmi madrasah. Halaman ini **diabaikan**.
   - `frontend/src/app/lupa-password`: Lupa password mandiri via email diabaikan; siswa diarahkan ke Guru BK/Wali Kelas.
3. **Penyatuan Alur Buat Laporan:**
   - Di Next.js terdapat 3 rute browser terpisah (`/laporan/buat`, `/laporan/konfirmasi`, `/laporan/sukses`) menggunakan `sessionStorage`.
   - Di Laravel, alur disatukan dalam 1 formulir terstruktur menggunakan Alpine.js 3-step wizard yang melakukan POST langsung ke `siswa.reports.store`, lalu redirect ke `siswa.reports.show` dengan pesan sukses flash.
4. **Desain Sistem & Aset:**
   - Token tema warna Emerald Green (`#176B4D`), aksen Lime (`#B8E34B`), dan status badge disinkronkan ke dalam `resources/css/app.css`.
   - Gambar `siperka-hero-v3.png` dan `logo-sekolah.png` dipindahkan ke `public/images/`.

---

## 5. Log Eksekusi & Commit Per Fitur (`feat/frontend-redesign`)

Semua perubahan dilakukan di branch `feat/frontend-redesign` secara granular per fitur/halaman:

1. `4ef8374` - `feat(frontend): fondasi design system dan migrasi beranda publik (welcome.blade.php)`
2. `72bf5f8` - `feat(frontend): migrasi halaman login universal (auth/login.blade.php)`
3. `b0b9e2f` - `feat(frontend): migrasi dashboard siswa (siswa/dashboard.blade.php)`
4. `e28b9c4` - `feat(frontend): migrasi form buat laporan siswa multi-step (siswa/reports/create.blade.php)`
5. `e3c3dae` - `feat(frontend): migrasi riwayat dan detail laporan siswa (siswa/reports/index & show)`
6. `5fbdbb3` - `feat(frontend): migrasi profil siswa (siswa/profile.blade.php)`
7. `ae93efd` - `feat(frontend): migrasi dashboard guru bk (bk/dashboard.blade.php)`
8. `47cf7dd` - `feat(frontend): migrasi daftar dan detail laporan guru bk (bk/reports/index & show)`
9. `ee68e23` - `feat(frontend): migrasi statistik bk, profil bk, dan dashboard master`
10. `35946c5` - `feat(frontend): migrasi halaman notifikasi pengguna (notifications/index.blade.php)`
11. `10a05a0` - `feat(frontend): migrasi halaman manajemen akun siswa dan guru bk master`
12. `8cb0649` - `feat(frontend): migrasi halaman kebijakan privasi dan pusat bantuan siswa`
13. `6eca939` - `feat(frontend): migrasi halaman kelola kategori perundungan dan unduh rekap laporan bk`
14. `3ef9c53` - `feat(frontend): migrasi halaman master data kelas, tahun ajaran, dan operasi massal kelas`
15. `5eccd8f` - `feat(frontend): migrasi halaman impor akun massal excel (index, preview, success)`
16. `e8e7e2c` - `feat(frontend): migrasi halaman log aktivitas dan pengaturan madrasah master`
17. `10a5b22` - `feat(frontend): migrasi halaman keamanan autentikasi dua faktor (2fa) dan ubah kata sandi`
18. `cc4f4c8` - `feat(frontend): migrasi halaman laporan periodik otomatis (index, show)`
19. `362a29e` - `feat(frontend): migrasi halaman kesalahan sistem 403, 404, dan 500`
20. `2393c70` - `feat(frontend): template cetak rekapitulasi laporan pdf bk`
21. `d3140f9` - `chore: bersihkan layout lama digantikan komponen x-layouts`
22. `cfebc87` - `feat(frontend): tambahkan dependensi chart.js dan konfigurasi app.js`
23. `8d90671` - `feat(ui): standarisasi komponen dasar blade dan layout bersama untuk tata letak dan mode gelap`
24. `fd3a8ca` - `feat(ui): perapihan tata letak dan mode gelap halaman publik dan error`
25. `eff8cbe` - `feat(ui): perapihan tata letak dan mode gelap modul autentikasi dan keamanan 2fa`
26. `d46dfd7` - `feat(ui): perapihan tata letak responsif dan mode gelap dashboard siswa`
27. `6344ea6` - `feat(ui): perapihan tata letak dan mode gelap dashboard guru bk`
28. `5cb24e0` - `feat(ui): perapihan tata letak dan mode gelap panel master admin dan modul bersama`
29. `d88802f` - `fix(auth): bersihkan elemen informasi login, hilangkan footer publik, dan aktifkan toggle mata kata sandi`
30. `95f1014` - `feat(ui): sesuaikan tampilan halaman publik dan phone mockups dengan frontend Next.js`
31. `6027daf` - `feat(ui): hapus bagian alur penanganan dan faq lama pada landing page publik`
32. `b30132e` - `feat(ui): hapus bagian fitur peran dan privasi pada halaman publik sesuai permintaan`
33. `bd46daf` - `feat(ui): hilangkan fitur dan tombol keluar cepat dari seluruh layout dan halaman`
34. `7fbf8c3` & `edce3db` - `feat(ui): desain ulang footer publik dengan tata letak grid institusional 4-kolom profesional`
35. `58fbec9` - `feat: integrasi sweetalert2, navigasi sidebar siswa responsif, auto-read notifikasi, dan optimasi arsitektur`
36. `feat(ui): pemolesan berkelanjutan antarmuka obrolan, dashboard bk, sidebar master, standarisasi dropdown chevron, dan grup tombol aksi tabel`
37. `feat(ui): pembersihan notifikasi master, penataan ulang semantik navigasi master, penyempurnaan form akun, segmented filter bk, dan pemulihan pencarian multi-kriteria laporan`

---

## 7. Pemolesan Lanjutan Antarmuka & UX (Tahap Pasca-Migrasi)

Setelah migrasi komponen dasar selesai, dilakukan serangkaian pemolesan visual dan interaktivitas berdasarkan umpan balik pengguna nyata:

### 7.1 Optimalisasi Bubble Obrolan (Chat Messaging)
- **Ukuran Dinamis Mengikuti Teks (`w-fit`)**: Mengubah bubble dari lebar statis menjadi adaptif terhadap panjang pesan (`w-fit max-w-[85%] sm:max-w-[75%]`). Teks pendek (seperti kata "sabar") kini memiliki bubble yang ramping dan proporsional.
- **Pembersihan Ikon Status**: Menghapus tanda centang pengiriman/baca pada bubble obrolan untuk tampilan yang lebih bersih dan tenang.
- **Eliminasi Spacing Vertikal Berlebih**: Merapikan margin dan padding (`px-3.5 py-2.5 rounded-2xl`) sehingga bubble pas membungkus isi pesan tanpa ruang kosong yang tidak perlu.
- **Perataan Teks Rata Kiri-Kanan (`text-justify`)**: Menambahkan styling `text-justify break-words leading-relaxed` pada seluruh gelembung pesan siswa dan konselor BK agar blok paragraf tampil rapi dan simetris.

### 7.2 Perapihan Manajemen Kasus Guru BK
- **Kategori Kasus (`bk/categories/index.blade.php`)**: Kolom Aksi diratakan ke tengah (`text-center`), tombol aksi "Ubah" dan "Hapus" diperbarui dengan ikon, label, border terstruktur, dan isolasi modal dialog ke luar tabel.
- **Dashboard Guru BK (`bk/dashboard.blade.php`)**:
  - Menghapus bagian duplikasi "Log Catatan Konseling & Investigasi" yang tidak diperlukan.
  - Memperbarui tombol `[Buka seluruh daftar kasus Guru BK]` menjadi tombol aksi terintegrasi di bagian bawah kartu kasus aktif pada layar desktop dan perangkat bergerak.

### 7.3 Pembaruan Navigasi Siswa
- **Tombol Kembali ke Dashboard**: Pada halaman Bantuan (`siswa/bantuan.blade.php`) dan Detail Laporan (`siswa/reports/show.blade.php`), tombol navigasi kembali diperbarui dari teks mentah `&larr;` menjadi tombol kartu modern dengan ikon panah SVG interaktif (animasi translasi kiri saat hover) serta jalur navigasi breadcrumb.

### 7.4 Harmonisasi Panel Master Admin
- **Struktur Semantik Sidebar Master**: Navigasi sidebar dibagi menjadi 4 seksi yang jelas:
  1. `Menu Utama`: Dashboard
  2. `Manajemen Pengguna`: Akun Siswa, Akun Guru BK, Impor Excel
  3. `Akademik`: Master Kelas, Tahun Ajaran, Kenaikan Kelas
  4. `Audit & Sistem`: Notifikasi, Laporan Periodik, Log Audit Aktivitas, Pengaturan Web
- **Indikator Aktif Hijau Bersama**: Seluruh menu aktif pada akun Master kini memiliki penanda pill hijau `bg-primary-600 dark:bg-[#5AE39D] rounded-r-full` yang konsisten dengan sidebar Guru BK.
- **Modernisasi Seluruh Dropdown (`<x-select>` & Standalone Select)**:
  - Komponen `<x-select>` global diperbarui dengan `appearance-none`, `cursor-pointer`, dan ikon panah chevron SVG kustom.
  - Seluruh elemen dropdown di menu Master (`master/classes`, `master/students`, `master/activity-logs`, `master/class-operations`, serta form create/edit siswa) distandarisasi dengan styling serupa dan focus ring tema madrasah.
- **Tombol Aksi Master Kelas & Tahun Ajaran**:
  - Kolom header dan baris Aksi diposisikan ke tengah (`text-center`).
  - Menggantikan tombol ikon longgar dengan grup tombol terstruktur (tombol Ubah bernuansa netral/emerald dan tombol Hapus bernuansa rose-red).
  - Modal form edit dipindahkan keluar dari perulangan `<table>` agar struktur HTML sepenuhnya valid dan terbebas dari masalah layout shift.

### 7.5 Pembersihan Menu & Reorganisasi Navigasi Master
- **Penghapusan Menu Notifikasi Master**: Menghapus menu Notifikasi dari sidebar Master (`resources/views/components/layouts/app.blade.php`) dan menonaktifkan rute terkait karena Master bertugas mengelola akun dan konfigurasi sistem madrasah, bukan mengelola atau menerima notifikasi insiden pelaporan siswa.
- **Penyempurnaan Label Navigasi Semantik**:
  - `Data Pengguna` diubah menjadi `Kelola Akun` (`Akun Siswa`, `Akun Guru BK`).
  - `Data Akademik` diubah menjadi `Akademik & Kelas` (`Tahun Ajaran`, `Daftar Kelas`, `Kenaikan & Mutasi`).
  - `Impor & Pengaturan` diubah menjadi `Sistem & Konfigurasi` (`Impor Siswa`, `Pengaturan Sistem`).

### 7.6 Perapihan Tata Letak Rekap Laporan Berkala
- Memperbaiki antarmuka halaman rekapitulasi periodik (`resources/views/reports/periodic/index.blade.php` dan `show.blade.php`):
  - Penataan kartu ringkasan metrik statistik KPI dengan angka agregasi yang jelas.
  - Formulir pemilihan periode laporan dalam grid terpadu yang rapi.
  - Tabel ringkasan data yang presisi dan ramah perangkat layar kecil.
  - Penataan tombol ekspor dan cetak laporan yang responsif.

### 7.7 Integrasi SweetAlert2 pada Seluruh Dashboard Master
- Menghubungkan library SweetAlert2 di bundle JS aplikasi (`resources/js/app.js`) dengan helper global `window.showConfirmDialog()` dan `window.showNotification()`.
- Menggantikan dialog konfirmasi bawaan peramban (`confirm()`) dengan modal SweetAlert2 bertema tenang untuk seluruh aksi destruktif Master (Hapus Siswa, Hapus Guru BK, Reset Password, Hapus Kelas, Hapus Tahun Ajaran, Kenaikan Kelas).
- Otomatisasi pemicuan toast SweetAlert2 untuk seluruh pesan flash session (`success`, `error`, `warning`, `info`).

### 7.8 Penyempurnaan Formulir Pembuatan Akun Siswa & Guru BK
- **Penghapusan Tombol Reset Manual**: Menghapus tombol *Reset Form* manual dari view `master/students/create.blade.php` dan `master/bk-users/create.blade.php` untuk menghindari kebingungan pengguna.
- **Eliminasi Tombol Ganda**: Menghapus tombol sekunder *"Simpan & Tambah Siswa Baru"*, menyisakan satu tombol submit utama yang tegas (*"Simpan Akun Siswa"* / *"Simpan Akun Guru BK"*).
- **Auto-Reset Pasca-Simpan**: Menyesuaikan controller (`StudentUserController@store` dan `BkUserController@store`) agar setelah akun berhasil disimpan, sistem melakukan pengalihan kembali ke route create dengan flash message `success`, sehingga seluruh field input otomatis ter-reset bersih ke kondisi awal.

### 7.9 Redesain Panel Filter & Segmented Status Laporan Masuk Guru BK
- **Penyatuan Kontainer Filter**: Menggabungkan tab status laporan dan formulir filter lanjutan yang sebelumnya terpisah menjadi satu kontainer kartu terpadu (`resources/views/bk/reports/index.blade.php`).
- **Segmented Tab Status Control**: Baris status laporan dirancang sebagai segmented tab bar di bagian atas kartu dengan dot indikator berwarna status, badge hitungan font monospace, dan status aktif yang kontras.
- **Grid Filter 12-Kolom Presisi**: Menata kolom filter ke dalam sistem grid 12 kolom (Pencarian 5-col, Kategori 3-col, Urgensi 2-col, Kelas 2-col) dilengkapi baris aksi pencarian yang bersih dengan tombol *Terapkan Filter* dan *Reset*.

### 7.10 Pemulihan & Optimalisasi Fitur Pencarian Multi-Kriteria Laporan Masuk
- Mengidentifikasi akar masalah fitur pencarian di mana pencarian sering kali mengembalikan hasil kosong karena kueri lama hanya memeriksa UUID mentah dan nama kelas.
- Memperluas kueri pencarian pada `BkReportController@index`:
  - Normalisasi otomatis nomor tiket UI (`#LAP-...` atau `LAP-...`) ke format UUID database.
  - Pencarian lokasi kejadian (`location`).
  - Pencarian nama kelas pelapor (`reporter_class_name`).
  - Pencarian peran pelapor (`reporter_role`: korban / saksi).
  - Pencarian kategori perundungan (`category.name`).
  - Pencarian nama dan NIS pelapor non-anonim (`reporter.name`, `reporter.login_id`).
  - Menjaga kepatuhan privasi (FR-02): pelapor dengan identitas dirahasiakan (`is_hidden_identity = true`) dilindungi secara ketat agar tidak dapat ditemukan melalui pencarian nama siswa.
  - Menambahkan pengujian otomatis komprehensif pada `tests/Feature/BkReportManagementTest.php` dengan hasil 100% kelulusan (15 tes, 87 asersi).

---

## 8. Hasil Verifikasi & Jaminan Kualitas Akhir

### 8.1 Uji Build Kompilasi Frontend (`npm run build`)
- **Status:** **SUKSES 100% (Exit Code 0)**
- **Aset Kompilasi Produksi (Vite + Tailwind CSS v4):**
  - CSS: `public/build/assets/app-*.css` (~183 kB, Gzip ~26 kB)
  - JS: `public/build/assets/app-*.js` (~338 kB, Gzip ~110 kB)
  - Semua font dan aset lokal termuat tanpa dependensi eksternal.

### 8.2 Integritas Kontrak Backend (Golden Rule)
- Kontrak controller, route, model, migrasi, policy, dan otorisasi server tetap **100% utuh dan tidak terpengaruh**. Seluruh pembaruan dilakukan murni di lapisan view Blade, CSS, dan reaktivitas antarmuka.

