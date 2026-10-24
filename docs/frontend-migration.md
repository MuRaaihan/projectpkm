# Rencana & Inventarisasi Migrasi Frontend SISPERKA

Dokumen ini disusun pada **Tahap 1: Inventarisasi** untuk memetakan seluruh aset desain di folder `frontend/` ke dalam view Blade Laravel di project SISPERKA tanpa merusak backend yang sudah berjalan.

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
| 1 | Beranda Publik (`GET /`) | `resources/views/welcome.blade.php` | `frontend/src/app/page.tsx` | **Ada desain** |
| 2 | Kebijakan Privasi (`GET /kebijakan-privasi`) | `resources/views/privacy.blade.php` | Tidak ada desain khusus (ada modal/card privasi di berbagai halaman) | **Tidak ada desain (tiru gaya)** |
| 3 | Login Universal (`GET /login`, `POST /login`) | `resources/views/auth/login.blade.php` | `frontend/src/app/login/page.tsx` | **Ada desain** |
| 4 | Tantangan 2FA (`GET /two-factor-challenge`, `POST /two-factor-challenge`) | `resources/views/auth/two-factor-challenge.blade.php` | `frontend/src/components/ui/OTPInput.tsx` (komponen OTP) | **Tidak ada desain (tiru gaya)** |
| 5 | Ganti Password (`GET /ganti-password`, `PUT /ganti-password`) | `resources/views/auth/change-password.blade.php` | Terkandung dalam `frontend/src/app/profil/page.tsx` | **Tidak ada desain (tiru gaya)** |
| 6 | Notifikasi (`GET /notifikasi`) | `resources/views/notifications/index.blade.php` | `frontend/src/app/admin/notifikasi/page.tsx` & `frontend/src/app/guru-bk/notifikasi/page.tsx` | **Ada desain** |
| 7 | Dashboard Siswa (`GET /siswa/dashboard`) | `resources/views/siswa/dashboard.blade.php` | `frontend/src/app/dashboard/page.tsx` | **Ada desain** |
| 8 | Riwayat Laporan Siswa (`GET /siswa/laporan`) | `resources/views/siswa/reports/index.blade.php` | `frontend/src/app/laporan/page.tsx` | **Ada desain** |
| 9 | Form Buat Laporan Siswa (`GET /siswa/laporan/buat`, `POST /siswa/laporan`) | `resources/views/siswa/reports/create.blade.php` | `frontend/src/app/laporan/buat/page.tsx` | **Ada desain** |
| 10 | Detail Laporan Siswa (`GET /siswa/laporan/{report}`) | `resources/views/siswa/reports/show.blade.php` | `frontend/src/app/laporan/[id]/page.tsx` | **Ada desain** |
| 11 | Bantuan & Kontak Siswa (`GET /siswa/bantuan`) | `resources/views/siswa/bantuan.blade.php` | Tidak ada halaman khusus (kontak ringkas di profil/beranda) | **Tidak ada desain (tiru gaya)** |
| 12 | Profil Siswa (`GET /siswa/profil`) | `resources/views/siswa/profile.blade.php` | `frontend/src/app/profil/page.tsx` | **Ada desain** |
| 13 | Dashboard Guru BK (`GET /bk/dashboard`) | `resources/views/bk/dashboard.blade.php` | `frontend/src/app/guru-bk/dashboard/page.tsx` | **Ada desain** |
| 14 | Daftar Laporan Guru BK (`GET /bk/laporan`) | `resources/views/bk/reports/index.blade.php` | `frontend/src/app/guru-bk/laporan/page.tsx` | **Ada desain** |
| 15 | Detail & Aksi Laporan BK (`GET /bk/laporan/{report}`) | `resources/views/bk/reports/show.blade.php` | `frontend/src/app/guru-bk/laporan/[id]/page.tsx` | **Ada desain** |
| 16 | Unduh Laporan PDF/Excel (`GET /bk/unduh-laporan`) | `resources/views/bk/reports/download.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 17 | Kelola Kategori Perundungan (`GET /bk/kategori`) | `resources/views/bk/categories/index.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 18 | Statistik Guru BK (`GET /bk/statistik`) | `resources/views/bk/statistics/index.blade.php` | `frontend/src/app/guru-bk/statistik/page.tsx` | **Ada desain** |
| 19 | Profil Guru BK (`GET /bk/profil`) | `resources/views/bk/profile/show.blade.php` | `frontend/src/app/guru-bk/profil/page.tsx` | **Ada desain** |
| 20 | Setup 2FA Staf (`GET /two-factor-setup`) | `resources/views/auth/two-factor-setup.blade.php` | Terkandung dalam profil | **Tidak ada desain (tiru gaya)** |
| 21 | Laporan Periodik Otomatis (`GET /laporan-periodik`) | `resources/views/reports/periodic/index.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 22 | Detail Laporan Periodik (`GET /laporan-periodik/{summary}`) | `resources/views/reports/periodic/show.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 23 | Dashboard Master Admin (`GET /master/dashboard`) | `resources/views/master/dashboard.blade.php` | `frontend/src/app/admin/dashboard/page.tsx` | **Ada desain** |
| 24 | Manajemen Akun Siswa (`GET /master/students`) | `resources/views/master/students/index.blade.php` | `frontend/src/app/admin/pengguna/page.tsx` | **Ada desain** |
| 25 | Form Tambah/Ubah Siswa (`GET /master/students/create`, `edit`) | `resources/views/master/students/create.blade.php`, `edit.blade.php` | Modal di `admin/pengguna` | **Ada desain** |
| 26 | Manajemen Akun Guru BK (`GET /master/bk-users`) | `resources/views/master/bk-users/index.blade.php` | `frontend/src/app/admin/pengguna/page.tsx` (filter Guru BK) | **Ada desain** |
| 27 | Form Tambah/Ubah Guru BK (`GET /master/bk-users/create`, `edit`) | `resources/views/master/bk-users/create.blade.php`, `edit.blade.php` | Modal `Tambah Guru BK` di `admin/pengguna` | **Ada desain** |
| 28 | Master Data: Kelas (`GET /master/classes`) | `resources/views/master/classes/index.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 29 | Master Data: Tahun Ajaran (`GET /master/academic-years`) | `resources/views/master/academic-years/index.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 30 | Operasi Massal Kelas (`GET /master/class-operations`) | `resources/views/master/class-operations/index.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 31 | Impor Pengguna Excel (`GET /master/import`) | `resources/views/master/import/index.blade.php` | `frontend/src/components/ui/FileUpload.tsx` | **Ada desain (komponen file upload)** |
| 32 | Pratinjau & Hasil Impor (`POST /master/import/preview`, `success`) | `resources/views/master/import/preview.blade.php`, `success.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 33 | Log Audit Aktivitas (`GET /master/activity-logs`) | `resources/views/master/activity-logs/index.blade.php` | Widget riwayat di `admin/dashboard` | **Tidak ada desain (tiru gaya)** |
| 34 | Pengaturan Website (`GET /master/settings`) | `resources/views/master/settings/index.blade.php` | Tidak ada halaman khusus | **Tidak ada desain (tiru gaya)** |
| 35 | Halaman Error 403 / 404 / 500 | `resources/views/errors/403.blade.php` | Tidak ada halaman error khusus | **Tidak ada desain (tiru gaya)** |
| - | Registrasi Siswa Mandiri (`/register`) | *Tidak ada di backend* | `frontend/src/app/register/page.tsx` | **Desain tanpa backend (abaikan/dilarang oleh aturan keamanan SISPERKA)** |
| - | Lupa Password Mandiri (`/lupa-password`) | *Tidak ada di backend* | `frontend/src/app/lupa-password/page.tsx` | **Desain tanpa backend (abaikan/dilarang oleh aturan keamanan SISPERKA)** |
| - | Admin Monitoring Laporan (`/admin/laporan`) | *Tidak ada di backend* | `frontend/src/app/admin/laporan/page.tsx` | **Desain tanpa backend (bertentangan langsung dengan aturan privasi Master)** |
| - | Konfirmasi & Sukses Buat Laporan Terpisah (`/laporan/konfirmasi`, `/laporan/sukses`) | *Terintegrasi di form `create` & redirect ke `show`* | `frontend/src/app/laporan/konfirmasi`, `sukses` | **Desain terpisah tanpa route terpisah di backend (sesuaikan di view Blade)** |

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
  - `$report_stats`: statistik agregat (total, per status, per kategori, per kelas).
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
   - *Solusi:* Seluruh markup JSX dan styling Tailwind v4 dikonversi menjadi Blade components (`<x-button>`, `<x-input>`, `<x-card>`, `<x-status-badge>`, `<x-layouts.app>`, dll.) dan Alpine.js untuk reaktivitas ringan (modal, toggle tab, accordion FAQ).
2. **Halaman Desain Tanpa Backend (Dilarang Masuk):**
   - `frontend/src/app/admin/laporan`: Master dilarang oleh PRD & security checklist melihat daftar laporan. Halaman ini **TIDAK dibuat** di backend.
   - `frontend/src/app/register`: Registrasi mandiri siswa dilarang karena semua akun dibuat via data resmi madrasah. Halaman ini **diabaikan**.
   - `frontend/src/app/lupa-password`: Lupa password mandiri via email diabaikan; siswa diarahkan ke Guru BK/Wali Kelas.
3. **Penyatuan Alur Buat Laporan:**
   - Di Next.js terdapat 3 rute browser terpisah (`/laporan/buat`, `/laporan/konfirmasi`, `/laporan/sukses`) menggunakan `sessionStorage`.
   - Di Laravel, alur disatukan dalam 1 formulir terstruktur (dapat menggunakan progress step interaktif via Alpine.js) yang melakukan POST langsung ke `siswa.reports.store`, lalu redirect ke `siswa.reports.show` dengan pesan sukses flash.
4. **Desain Sistem & Aset:**
   - Token tema warna Emerald Green (`#176B4D`), aksen Lime (`#B8E34B`), dan status badge disinkronkan ke dalam `resources/css/app.css`.
   - Gambar `siperka-hero-v3.png` dan `logo-sekolah.png` dipindahkan ke `public/images/`.

---

## 5. Rencana Eksekusi Bertahap

- **Tahap 2:** Fondasi Desain (CSS theme tokens di `resources/css/app.css`, komponen Blade dasar, layout `public` dan `app`, serta penyalinan aset gambar).
- **Tahap 3:** Migrasi halaman yang ada desainnya:
  - Step 3.1: Beranda Publik (`welcome.blade.php`) & Kebijakan Privasi (`privacy.blade.php`)
  - Step 3.2: Login Universal (`auth/login.blade.php`)
  - Step 3.3: Dashboard Siswa (`siswa/dashboard.blade.php`)
  - Step 3.4: Form Buat Laporan Siswa (`siswa/reports/create.blade.php`)
  - Step 3.5: Riwayat & Detail Laporan Siswa (`siswa/reports/index.blade.php`, `show.blade.php`)
  - Step 3.6: Profil Siswa (`siswa/profile.blade.php`)
  - Step 3.7: Dashboard Guru BK (`bk/dashboard.blade.php`)
  - Step 3.8: Daftar & Detail Laporan Guru BK (`bk/reports/index.blade.php`, `show.blade.php`)
  - Step 3.9: Statistik Guru BK (`bk/statistics/index.blade.php`)
  - Step 3.10: Profil Guru BK (`bk/profile/show.blade.php`)
  - Step 3.11: Dashboard Master Admin (`master/dashboard.blade.php`)
  - Step 3.12: Manajemen Pengguna Siswa & BK (`master/students/*`, `master/bk-users/*`)
  - Step 3.13: Notifikasi (`notifications/index.blade.php`)
- **Tahap 4:** Halaman yang belum ada desainnya (tiru gaya):
  - Step 4.1: Master Data Kelas & Tahun Ajaran
  - Step 4.2: Operasi Massal Kelas & Impor Excel
  - Step 4.3: Kelola Kategori & Unduh Laporan Resmi BK
  - Step 4.4: 2FA Setup & Challenge
  - Step 4.5: Laporan Periodik Otomatis & Log Audit & Pengaturan Website
  - Step 4.6: Halaman Error (403, 404, 500)
- **Tahap 5 & 6:** Pembersihan, verifikasi tes otomatis (`php artisan test`), build (`npm run build`), dan dokumentasi changelog.
