# TASKS: SISPERKA
**Sistem Pelaporan Perundungan MTs Soebono Mantofani**

Acuan utama: [`docs/prd.md`](./prd.md). Jika ada pertentangan antara file ini dan PRD, **PRD yang benar**; perbarui file ini.

---

## Cara Memakai File Ini

**Aturan kerja untuk agent dan developer:**

1. Kerjakan **satu fase dalam satu waktu**, sesuai urutan. Jangan melompat ke fase berikutnya.
2. Sebelum menulis kode fase baru, **buat rencana singkat dan tunggu persetujuan**.
3. Tandai tugas selesai dengan `[x]` hanya setelah kode berjalan **dan** diuji.
4. Setiap fase diakhiri dengan **Gerbang Fase** (daftar cek). Jangan lanjut sebelum semua centang dan disetujui pemilik proyek.
5. Jika menemukan hal yang tidak jelas atau bertentangan dengan PRD, **berhenti dan tanyakan**, jangan menebak.
6. Gunakan **data palsu** untuk pengujian; jangan pernah memakai data siswa asli.
7. Kode, nama tabel/kolom, dan komentar memakai konvensi Laravel; teks antarmuka memakai **Bahasa Indonesia** yang sederhana dan ramah anak.
8. **Aturan migrasi:** selama pengembangan dan **belum ada data asli**, migrasi bawaan boleh diubah dan database boleh dibuat ulang dengan `php artisan migrate:fresh` (tunjukkan rencana dan tunggu persetujuan). **Setelah peluncuran atau setelah ada data asli**, migrasi yang sudah berjalan tidak boleh diubah (buat migrasi baru) dan `migrate:fresh` **dilarang**.
9. Jangan menjalankan skrip dari internet (`curl | bash`, `iex DownloadString`) dan jangan menginstal ulang PHP/Composer/Node. Jika lingkungan belum siap, berhenti dan beri tahu pemilik proyek.

**Keterangan:** `FR-xx` = nomor kebutuhan di PRD · **P0** wajib MVP · **P1** Rilis 2 · **P2** Rilis 3

**Aturan keamanan yang berlaku di SEMUA fase** (jangan dilanggar):
- Pemeriksaan peran dan kepemilikan data dilakukan **di server** pada setiap route/controller, bukan hanya menyembunyikan menu.
- Siswa hanya boleh mengakses laporan miliknya sendiri. Laporan memakai **UUID**.
- **Master tidak boleh** melihat isi laporan maupun identitas pelapor.
- Tidak ada password, kunci, atau kredensial di kode; semua lewat `.env`.
- Semua input divalidasi; semua output di-escape; query terparameter.
- Notifikasi **hanya di dalam website**, tanpa email/WhatsApp/push.

---

## Ringkasan Progres

| Fase | Nama | Prioritas | Status |
|---|---|---|---|
| 0 | Persiapan dan fondasi proyek | P0 | ✅ |
| 1 | Autentikasi, peran, dan sesi | P0 | ✅ |
| 2 | Modul Master: akun, impor Excel, kelas | P0 | ⬜ |
| 3 | Modul Siswa: membuat dan memantau laporan | P0 | ⬜ |
| 4 | Modul Guru BK: kelola laporan dan kategori | P0 | ⬜ |
| 5 | Statistik, unduh laporan, dan notifikasi | P0 | ⬜ |
| 6 | Beranda publik dan halaman informasi | P0 | ⬜ |
| 7 | Penguatan keamanan dan pengujian | P0 | ⬜ |
| 8 | Deploy dan peluncuran | P0 | ⬜ |
| 9 | Rilis 2 (fitur P1) | P1 | ⬜ |
| 10 | Rilis 3 (fitur P2) | P2 | ⬜ |

Legenda: ⬜ belum · 🟨 sedang dikerjakan · ✅ selesai

---

## FASE 0: Persiapan dan Fondasi Proyek

**Tujuan:** proyek Laravel berjalan di komputer lokal dengan struktur dasar yang rapi.

### Kondisi awal (sudah dikerjakan manual oleh pemilik proyek; verifikasi, jangan diulang)
- [x] Proyek **Laravel 13** sudah dibuat di folder proyek (tidak perlu `composer create-project` lagi)
- [x] Dokumen sudah ada: `AGENTS.md` (root), `docs/prd.md`, `docs/tasks.md`, `docs/database.md`, `docs/security-checklist.md`
- [x] **Taste Skill** terpasang (`design-taste-frontend-v1`; nilai DESIGN_VARIANCE 3, MOTION_INTENSITY 2, VISUAL_DENSITY 4)
- [x] Database MySQL bernama **`db_project`** sudah dibuat
- [x] `php artisan migrate` sudah dijalankan satu kali (hanya migrasi bawaan Laravel, belum ada data asli)

### Lingkungan dan proyek
- [x] Verifikasi lingkungan: **PHP 8.3+** (syarat Laravel 13), Composer, Node.js, dan MySQL/MariaDB (`php -v`, `composer -V`, `node -v`); **jangan** menginstal ulang atau menjalankan skrip internet
- [x] Verifikasi `.env`: `DB_CONNECTION=mysql` (diset `mariadb`), `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=db_project` (bukan SQLite, yang merupakan bawaan Laravel bila `.env` belum diubah)
- [x] Jalankan `php artisan db:show` dan pastikan terhubung ke **MySQL/MariaDB `db_project`**, serta tabel bawaan (`users`, `sessions`, `cache`, `jobs`, dll.) ada di sana. Jika tabel justru ada di `database/database.sqlite`, perbaiki `.env` lalu `php artisan migrate` ulang
- [x] Pastikan `AGENTS.md` berisi aturan SISPERKA dan **tidak** lagi berisi petunjuk bootstrap lama (tag `<laravel-boost-guidelines>`)
- [x] Pastikan Taste Skill terdeteksi agent (panel Customizations atau tanya agent), dan stack tampilan tetap **Blade + Tailwind**
- [x] Inisialisasi Git (bila belum), pastikan `.gitignore` memuat `.env`, `vendor/`, `node_modules/`, file bukti di `storage/`, dan backup; buat commit awal
- [x] Buat `.env.example` tanpa nilai rahasia
- [x] Atur zona waktu `Asia/Jakarta` dan bahasa `id`
- [x] **Jangan** mengubah migrasi bawaan atau menjalankan `migrate:fresh` pada Fase 0 (dilakukan di Fase 1)

### Paket dan tampilan
- [x] Pasang Tailwind CSS (atau Bootstrap, sesuai keputusan)
- [x] Peran memakai kolom `role` + Policy/middleware (Spatie Permission **tidak dipakai** pada versi 1)
- [x] Pasang `maatwebsite/excel` (impor/ekspor Excel); **pastikan versinya mendukung Laravel 13**
- [x] Pasang `barryvdh/laravel-dompdf` (ekspor PDF); **pastikan versinya mendukung Laravel 13**
- [x] Siapkan layout dasar yang responsif (mobile-first): layout publik dan layout dashboard
- [x] Siapkan komponen UI dasar: tombol, form, tabel, kartu, modal konfirmasi, penanda notifikasi, pesan sukses/gagal

### Fondasi
- [x] Pastikan struktur dokumentasi lengkap (`docs/` dan `AGENTS.md`); tidak perlu membuat ulang
- [x] Siapkan kerangka seeder awal: **minimal 2 akun Master** (password dari `.env`/prompt, bukan ditulis di kode); pembuatannya baru dijalankan setelah tabel `users` disesuaikan di Fase 1

**Gerbang Fase 0**
- [x] `php artisan serve` berjalan tanpa error
- [x] `php artisan db:show` menunjukkan **MySQL/MariaDB** dengan database **`db_project`**
- [x] Tabel bawaan berada di `db_project` (bukan SQLite)
- [x] `AGENTS.md` tanpa petunjuk bootstrap lama
- [x] `.env` tidak masuk Git (`git status` bersih dari `.env`)
- [x] Commit Git awal sudah dibuat

---

## FASE 1: Autentikasi, Peran, dan Sesi

**Tujuan:** satu halaman login untuk semua peran, aman, dengan wajib ganti password.
**Kebutuhan PRD:** FR-01 sampai FR-07

### Database
- [x] **Sesuaikan migrasi bawaan Laravel.** Database masih kosong dan belum berisi data asli, jadi **boleh** mengubah migrasi bawaan (`users`, dll.) sesuai `docs/database.md`, lalu menjalankan `php artisan migrate:fresh`. Tunjukkan rencana dan **tunggu persetujuan** sebelum menjalankan `migrate:fresh`
- [x] Buang kolom `email` dan `email_verified_at` dari `users`, serta hapus tabel `password_reset_tokens` (tidak dipakai; reset password dilakukan Master). Pastikan tabel `sessions`, `cache`, dan `jobs` tetap ada
- [x] Migrasi tabel `users`: `role`, `login_id` (unik; NIS/NIP/username), `name`, `password`, `class_id` (nullable), `photo_path`, `phone`, `locked_until`, `is_active`, `must_change_password`, `last_login_at`, `deleted_at` (soft delete)
- [x] Migrasi `academic_years` dan `classes`
- [x] Migrasi `activity_logs`

### Login dan sesi
- [x] Halaman **login tunggal**: siswa memakai **NIS**, guru BK memakai NIP/username, master memakai username (FR-01)
- [x] Setelah login, arahkan ke dashboard sesuai peran (FR-02)
- [x] Tolak login bila akun **nonaktif**
- [x] Pesan error login **tidak membocorkan** apakah NIS/username terdaftar
- [x] **Rate limiting** dan penguncian sementara setelah beberapa kali gagal (FR-05)
- [x] Regenerasi sesi setelah login; **session timeout** otomatis saat tidak aktif (FR-06)
- [x] Cookie sesi `Secure`, `HttpOnly`, `SameSite`
- [x] **Logout** (FR-06)

### Password
- [x] Hash password dengan bcrypt/argon2
- [x] **Wajib ganti password** pada login pertama dan setelah reset: semua route lain diblokir sampai password diganti (FR-03)
- [x] Aturan password: minimal 8 karakter, tidak boleh sama dengan NIS/username
- [x] Halaman **ganti password sendiri** (FR-04)
- [x] Middleware peran: `master`, `bk`, `siswa`, dan halaman 403 yang ramah
- [x] Catat login berhasil/gagal ke `activity_logs`

### Dashboard kerangka
- [x] Dashboard kosong untuk tiap peran (hanya kerangka dan menu)

**Gerbang Fase 1**
- [x] Ketiga peran dapat login dari satu halaman dan masuk ke dashboard yang benar
- [x] Siswa tidak bisa membuka URL dashboard Master/BK (dan sebaliknya)
- [x] Login pertama memaksa ganti password
- [x] Uji: 5+ kali salah password memicu pembatasan
- [x] Uji: akun nonaktif tidak bisa login

---

## FASE 2: Modul Master (Akun, Impor Excel, Kelas)

**Tujuan:** Master dapat mengelola seluruh akun dengan cepat dan aman.
**Kebutuhan PRD:** FR-09 sampai FR-16, FR-19

### Master data
- [ ] CRUD **tahun ajaran** (satu yang aktif) (FR-16)
- [ ] CRUD **kelas** (nama kelas, terkait tahun ajaran) (FR-16)

### Akun Guru BK
- [ ] Daftar akun Guru BK dengan pencarian, filter, paginasi (FR-19)
- [ ] Tambah, ubah, aktifkan/nonaktifkan akun Guru BK (FR-09)
- [ ] Hapus akun Guru BK (arsip default; hapus permanen hanya dengan konfirmasi password Master) (FR-09, FR-14)
- [ ] **Reset password** oleh Master (password sementara acak; tandai `must_change_password`) (FR-07)

### Akun Siswa
- [ ] Daftar akun siswa dengan pencarian, filter kelas, paginasi (FR-19)
- [ ] Tambah, ubah, aktifkan/nonaktifkan akun siswa (FR-10)
- [ ] Hapus akun siswa: **arsip/nonaktif secara default**; hapus permanen hanya dengan konfirmasi password Master (FR-10, FR-14)
- [ ] Reset password siswa oleh Master (FR-07)
- [ ] Laporan milik akun yang diarsipkan/dihapus **tetap tersimpan**, identitas pelapor **disamarkan** (FR-14)

### Impor Excel
- [ ] Sediakan **template Excel** siswa (`NIS`, `Nama Lengkap`, `Kelas`, `Jenis Kelamin`, `Password Awal` opsional) dan Guru BK (`NIP/Username`, `Nama Lengkap`, `No. HP`, `Password Awal` opsional) (FR-11)
- [ ] Unggah file: hanya `.xlsx`, maksimal 2 MB, tolak makro/ekstensi lain
- [ ] **Pratinjau dan validasi sebelum disimpan**: NIS/NIP wajib dan unik, kelas harus terdaftar, kolom kosong, format salah (FR-11)
- [ ] Tampilkan ringkasan: jumlah valid, bermasalah, dan ganda
- [ ] Konfirmasi Master → buat akun; password awal acak bila kosong; set `must_change_password`
- [ ] Unduh **daftar baris gagal** untuk diperbaiki
- [ ] Abaikan sel berisi formula; proses dalam batch (target 500 baris ≤ 1 menit)
- [ ] Ekspor daftar kredensial awal untuk dibagikan (sekali unduh, dicatat di log, tidak disimpan sebagai file permanen)

### Operasi massal kelas
- [ ] **Hapus akun siswa per kelas** dengan konfirmasi password Master (FR-12)
- [ ] **Kenaikan kelas / pindah kelas massal** dengan pratinjau sebelum dijalankan (FR-13)

### Log
- [ ] Catat ke `activity_logs`: pembuatan, perubahan, penghapusan akun, impor, reset password

**Gerbang Fase 2**
- [ ] Impor 400 akun siswa palsu berhasil; data ganda dan salah format terdeteksi
- [ ] Hapus per kelas dan kenaikan kelas berjalan, dan diminta konfirmasi
- [ ] Hapus akun tidak menghilangkan laporan lama (diuji pada Fase 3)
- [ ] Master tidak punya akses ke fitur laporan (route diblokir)

---

## FASE 3: Modul Siswa (Membuat dan Memantau Laporan)

**Tujuan:** siswa dapat melapor dengan mudah dan rahasia, serta memantau perkembangannya.
**Kebutuhan PRD:** FR-32 sampai FR-39 (P0: FR-32 sampai FR-35, FR-37, FR-38)

### Database
- [ ] Migrasi `categories`: `nama`, `deskripsi`, `is_active`, `dibuat_oleh`
- [ ] Migrasi `reports`: `id` (UUID), `reporter_id`, `is_hidden_identity`, `reporter_role` (korban/saksi), `category_id`, `incident_date`, `location`, `description` (**terenkripsi**), `accused_name` (**terenkripsi**, nullable), `urgency`, `status`, `reject_reason`
- [ ] Migrasi `report_attachments`, `report_messages`, `report_notes` (terenkripsi), `report_status_histories`
- [ ] Seeder kategori awal (fisik, verbal, siber, sosial/pengucilan, lainnya)

### Form laporan
- [ ] Halaman **Buat Laporan**: peran (korban/saksi), kategori (dari daftar aktif), tanggal, lokasi, kronologi, nama terlapor (opsional) (FR-32)
- [ ] Opsi **"Sembunyikan nama saya"** dengan pernyataan jujur: *"Identitasmu tidak terlihat oleh siswa lain, tetapi dapat diketahui Guru BK untuk keperluan penanganan."* (FR-33)
- [ ] **Unggah bukti**: JPG, PNG, PDF; maks. 5 MB per file; maks. 3 file (FR-34)
- [ ] Validasi file (ekstensi + MIME + ukuran); nama file diacak; simpan **di luar folder public**; hapus metadata EXIF bila memungkinkan
- [ ] Endpoint khusus untuk menampilkan bukti dengan **otorisasi** (hanya pemilik laporan dan Guru BK)
- [ ] Rate limiting pada pengiriman laporan; (opsional) Cloudflare Turnstile
- [ ] Status awal laporan: **Baru**; catat ke `report_status_histories`

### Memantau laporan
- [ ] **Riwayat Laporan**: hanya laporan milik siswa yang login (FR-35)
- [ ] **Detail laporan**: status, riwayat status, dan balasan BK (catatan internal **tidak** tampil)
- [ ] **Profil akun**: lihat data dan ganti password (FR-38)
- [ ] Dashboard siswa: ringkasan laporan dan tombol Buat Laporan

**Gerbang Fase 3**
- [ ] Siswa dapat membuat laporan (dengan dan tanpa sembunyikan nama) dan melihat riwayatnya
- [ ] **Uji IDOR:** siswa A mengganti ID/UUID di URL untuk membuka laporan atau bukti siswa B → **harus ditolak**
- [ ] File berbahaya (`.php`, `.exe`, file palsu berekstensi gambar) ditolak
- [ ] Isi kronologi di database terlihat terenkripsi (bukan teks biasa)
- [ ] Akun siswa yang diarsipkan: laporannya tetap ada dan identitasnya disamarkan

---

## FASE 4: Modul Guru BK (Kelola Laporan dan Kategori)

**Tujuan:** Guru BK dapat menerima, menangani, dan menutup laporan dengan jejak yang jelas.
**Kebutuhan PRD:** FR-20 sampai FR-26, FR-30

### Daftar dan detail laporan
- [ ] **Daftar laporan** dengan pencarian dan filter (status, kategori, kelas, tanggal), urut terbaru (FR-20)
- [ ] **Detail laporan**: kronologi, bukti, peran pelapor, terlapor (FR-21)
- [ ] Pelapor yang menyembunyikan nama tampil sebagai **"Pelapor Rahasia"** (FR-21)
- [ ] Tombol **"Lihat identitas"**: membuka identitas pelapor dan **mencatat ke log audit** (siapa, kapan, laporan mana) (FR-22)

### Penanganan
- [ ] **Ubah status**: Baru → Diverifikasi → Diproses → Selesai / Ditolak (FR-23)
- [ ] **Alasan wajib** saat memilih Ditolak (FR-23)
- [ ] Simpan riwayat setiap perubahan status (siapa, kapan, alasan)
- [ ] **Catatan internal** dan riwayat tindak lanjut (mediasi, pemanggilan, rujukan); tidak terlihat siswa (FR-24)
- [ ] **Balasan ke siswa** pada laporan (satu arah per laporan, bukan chat real-time) (FR-25)

### Kategori
- [ ] **Kelola kategori**: tambah, ubah, nonaktifkan (FR-26)
- [ ] Kategori yang sudah dipakai laporan **tidak boleh dihapus**, hanya dinonaktifkan (FR-26)
- [ ] Kategori nonaktif tidak muncul di form siswa, tetapi tetap tampil pada laporan lama

### Profil
- [ ] **Ganti profil** (nama, foto, kontak) dan password (FR-30)

**Gerbang Fase 4**
- [ ] Guru BK dapat memproses laporan dari Baru sampai Selesai/Ditolak, termasuk balasan dan catatan
- [ ] Nama pelapor rahasia tidak tampil di daftar; membuka identitas tercatat di `activity_logs`
- [ ] Siswa tidak dapat melihat catatan internal
- [ ] Master tetap tidak bisa membuka laporan (diuji ulang)
- [ ] Kategori yang dipakai tidak bisa dihapus

---

## FASE 5: Statistik, Unduh Laporan, dan Notifikasi

**Tujuan:** pemantauan, pelaporan resmi, dan pemberitahuan dalam website.
**Kebutuhan PRD:** FR-15, FR-28, FR-29, FR-31, FR-37, FR-37a

### Statistik
- [ ] Dashboard **statistik Master**: jumlah laporan per bulan, kategori, status, kelas; **tanpa** isi laporan dan identitas (FR-15)
- [ ] Dashboard **statistik Guru BK** dengan data yang sama dan filter periode (FR-28)
- [ ] Grafik (Chart.js) dan ringkasan angka

### Unduh laporan
- [ ] **Unduh PDF** dan **Excel** untuk laporan Guru BK, dengan filter periode/status/kategori (FR-29)
- [ ] Beri label **"RAHASIA"** pada hasil unduhan
- [ ] **Catat setiap unduhan** ke log audit (FR-29)
- [ ] Lindungi ekspor Excel dari **injeksi formula** (sel berawalan `=`, `+`, `-`, `@` diberi tanda aman)
- [ ] Hanya Guru BK yang dapat mengunduh; Master tidak

### Notifikasi dalam website
- [ ] Migrasi `notifications`: `user_id`, `tipe`, `judul`, `isi`, `tautan`, `read_at`
- [ ] Notifikasi untuk Guru BK: **laporan baru**, informasi susulan dari siswa (FR-31)
- [ ] Notifikasi untuk siswa: **perubahan status**, **balasan BK** (FR-37)
- [ ] Ikon **lonceng** dengan penanda jumlah belum dibaca di header; tampil saat website dibuka
- [ ] Halaman daftar notifikasi, tandai dibaca, dan tautan langsung ke laporan
- [ ] Isi notifikasi **singkat tanpa detail sensitif** (mis. "Ada laporan baru") (FR-37a)
- [ ] **Tidak ada** pengiriman email/WhatsApp/push

**Gerbang Fase 5**
- [ ] Statistik Master tidak memuat teks laporan maupun nama pelapor
- [ ] Unduhan berlabel Rahasia dan tercatat di log
- [ ] Notifikasi muncul saat pengguna membuka website dan tidak memuat detail sensitif
- [ ] Siswa hanya menerima notifikasi miliknya sendiri

---

## FASE 6: Beranda Publik dan Halaman Informasi

**Tujuan:** halaman sebelum login yang menjelaskan SISPERKA dan membangun kepercayaan.
**Kebutuhan PRD:** FR-40, FR-41, FR-43 (FR-42 di Fase 9)

- [ ] **Beranda**: perkenalan SISPERKA (apa itu, tujuan, jaminan kerahasiaan) (FR-40)
- [ ] Bagian **Tata Cara Menggunakan** dengan langkah-langkah bergambar/ikon (FR-40)
- [ ] Bagian **alur penanganan laporan** dan **FAQ** singkat (FR-40)
- [ ] Tombol **Masuk** yang jelas menuju halaman login
- [ ] **Footer informasi sekolah**: nama, alamat, kontak, jam layanan BK (FR-41)
- [ ] Halaman **Kebijakan Privasi** (FR-43)
- [ ] Tampilan mobile-first, bahasa ramah anak, kontras dan ukuran huruf memadai
- [ ] Judul halaman, favicon, dan meta dasar

**Gerbang Fase 6**
- [ ] Beranda tampil baik di HP dan desktop
- [ ] Semua tautan berfungsi; tombol Masuk menuju login
- [ ] Halaman publik **tidak** memuat data laporan atau pengguna

---

## FASE 7: Penguatan Keamanan dan Pengujian

**Tujuan:** memastikan sistem aman dan benar sebelum dipakai pengguna nyata.
**Acuan:** PRD bagian 9.1 dan 18

### Pengamanan aplikasi
- [ ] Aktifkan header keamanan: CSP, X-Frame-Options, X-Content-Type-Options, HSTS
- [ ] Pastikan perlindungan CSRF aktif pada semua form
- [ ] Audit semua query (tanpa SQL mentah yang tidak terparameter) dan escape output (XSS)
- [ ] Batasi ukuran request dan terapkan rate limiting pada login, form laporan, dan impor
- [ ] `APP_DEBUG=false` dan `APP_ENV=production` pada produksi
- [ ] Jalankan `composer audit`; perbarui dependensi yang rentan
- [ ] Pastikan folder bukti tidak dapat diakses langsung lewat URL
- [ ] Pastikan log audit tidak dapat diubah/dihapus oleh pengguna biasa
- [ ] Kebijakan retensi data (usulan 5 tahun) dan prosedur pengarsipan

### Pengujian otomatis (feature test)
- [ ] Tes login: benar, salah, akun nonaktif, penguncian, wajib ganti password
- [ ] Tes otorisasi per peran untuk **setiap route**
- [ ] **Tes IDOR**: siswa tidak dapat mengakses laporan/bukti/notifikasi siswa lain
- [ ] Tes: Master tidak dapat mengakses laporan, identitas, maupun unduhan laporan
- [ ] Tes: identitas pelapor rahasia tersembunyi di daftar dan pembukaannya tercatat
- [ ] Tes unggah file berbahaya dan impor Excel salah format
- [ ] Tes ekspor Excel tidak mengeksekusi formula

### Uji manual dan UAT
- [ ] Uji manual per peran dengan data palsu (siswa, Guru BK, Master)
- [ ] Uji di HP Android dan iPhone, serta berbagai ukuran layar
- [ ] **UAT**: uji coba terbatas dengan Guru BK dan beberapa siswa; catat masukan
- [ ] Perbaiki masukan utama dari UAT
- [ ] Lengkapi `docs/security-checklist.md` dan tandai seluruh butirnya

**Gerbang Fase 7**
- [ ] Semua tes otomatis lulus
- [ ] Tidak ada temuan keamanan tingkat tinggi yang terbuka
- [ ] Guru BK menyatakan alur kerja dapat dipakai
- [ ] Seluruh kriteria penerimaan MVP di PRD bagian 18 terpenuhi

---

## FASE 8: Deploy dan Peluncuran

**Tujuan:** sistem berjalan di server produksi dan siap dipakai sekolah.

### Infrastruktur
- [ ] Siapkan VPS lokal Indonesia (1–2 vCPU, 2 GB RAM) dan hardening dasar (firewall, update, login SSH aman)
- [ ] Pasang **PHP 8.3+**, MySQL/MariaDB, web server (Nginx/Apache); pastikan versi PHP di server sama dengan di lokal
- [ ] Domain/subdomain `.sch.id` dan **SSL (Let's Encrypt)** aktif; paksa HTTPS
- [ ] Deploy kode, isi `.env` produksi, jalankan migrasi dan seeder
- [ ] Buat akun Master awal (**minimal 2**) dengan password kuat; ganti password awal
- [ ] Atur permission folder `storage/` dan cache, serta jadwal (scheduler/cron) bila ada

### Backup dan pemantauan
- [ ] **Backup database otomatis harian**, dienkripsi, disimpan minimal 14 hari
- [ ] **Uji pemulihan backup** minimal satu kali
- [ ] Pemantauan sederhana (uptime, ruang disk, log error)

### Peluncuran
- [ ] Lengkapi `README.md` (cara menjalankan, akun Master awal, cara backup)
- [ ] Siapkan **panduan pengguna** singkat untuk siswa, Guru BK, dan Master
- [ ] Susun **SOP penanganan** (batas respons 3×24 jam, **jadwal cek rutin Guru BK** karena notifikasi hanya di dalam website, alur rujukan)
- [ ] Impor akun siswa dan Guru BK asli; bagikan password awal secara tertutup
- [ ] **Sosialisasi** ke siswa, guru, dan orang tua
- [ ] Rilis dan pantau minggu pertama

**Gerbang Fase 8**
- [ ] Situs diakses lewat HTTPS pada domain sekolah
- [ ] Backup harian berjalan dan pemulihan terbukti berhasil
- [ ] Guru BK dan Master dapat login dan memakai sistem
- [ ] SOP dan sosialisasi sudah dilakukan

---

## FASE 9: Rilis 2 (Fitur P1)

- [ ] **FR-17:** Master dapat mengelola konten beranda dan informasi sekolah (footer)
- [ ] **FR-18:** Halaman **log aktivitas** lengkap untuk Master (filter dan pencarian)
- [ ] **FR-27:** Tingkat urgensi laporan (rendah/sedang/tinggi) dan pengurutan berdasarkan urgensi
- [ ] **FR-36:** Siswa dapat menambah informasi susulan pada laporan yang masih berjalan
- [ ] **FR-39:** Halaman bantuan dan kontak darurat untuk siswa
- [ ] **FR-42:** Tombol **Keluar Cepat** yang mengalihkan ke situs netral
- [ ] Evaluasi masukan pengguna dan perbaikan dari bulan pertama pemakaian

---

## FASE 10: Rilis 3 (Fitur P2)

- [ ] **FR-08:** Autentikasi dua faktor (2FA) untuk Master dan Guru BK
- [ ] Laporan periodik otomatis (bulanan/semester); belum memiliki nomor FR di PRD
- [ ] Evaluasi tahunan: kenaikan kelas, peninjauan kebijakan retensi, dan audit keamanan ulang

---

## Catatan Berjalan

Gunakan bagian ini untuk mencatat keputusan, kendala, atau hal yang perlu ditanyakan ke pemilik proyek.

| Tanggal | Fase | Catatan / Keputusan |
|---|---|---|
| 17 Okt 2026 | 0 | Stack: **Laravel 13, PHP 8.3+**. Peran memakai kolom `role` (tanpa Spatie). Kolom login bernama `login_id` |
| 17 Okt 2026 | 0 | Database MySQL bernama `db_project`. Migrasi bawaan sudah dijalankan sekali; akan disesuaikan di Fase 1 dengan `migrate:fresh` (belum ada data asli) |
| 17 Okt 2026 | 0 | `AGENTS.md` bawaan Laravel (petunjuk bootstrap Boost) diganti dengan aturan SISPERKA. Laravel Boost **opsional**; jangan dijalankan tanpa cadangan `AGENTS.md` |
| 17 Okt 2026 | 0 | Taste Skill v1 terpasang di folder skills; nilai diturunkan menjadi 3 / 2 / 4. Aturan SISPERKA di `AGENTS.md` menang bila bertentangan |
| | | |

### Pertanyaan terbuka dari PRD yang perlu dijawab (blokir beberapa tugas)
- [ ] Siapa penanggung jawab sistem dan pemegang akun Master? _(Fase 0, 8)_
- [ ] Mekanisme pembagian password awal ke siswa (wali kelas, kartu cetak, dll.)? _(Fase 2, 8)_
- [ ] Bagaimana siswa yang lupa password meminta reset (ke Master atau wali kelas)? _(Fase 2)_
- [ ] Lama penyimpanan data laporan (retensi)? _(Fase 7)_
- [ ] Format laporan khusus dari Kemenag/Dinas untuk fitur unduh? _(Fase 5)_
- [ ] Perlu persetujuan orang tua tertulis sebelum siswa memakai sistem? _(Fase 8)_
- [ ] Apakah sekolah sudah memiliki domain dan hosting? _(Fase 8)_ (Server wajib mendukung **PHP 8.3+**)