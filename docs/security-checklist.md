# Security Checklist: SISPERKA

Daftar cek keamanan yang **harus lulus sebelum peluncuran** (Fase 7 dan 8 di [`tasks.md`](./tasks.md)). Acuan: bagian 9.1 [`prd.md`](./prd.md).

**Cara memakai:** centang `[x]` hanya setelah diuji, bukan hanya setelah kode ditulis. Isi kolom bukti/catatan bila perlu. Ulangi daftar ini setiap ada perubahan besar dan setiap semester.

**Tingkat:** 🔴 Kritis (blokir peluncuran) · 🟠 Penting · 🟡 Disarankan

---

## A. Autentikasi dan Sesi

- [ ] 🔴 Seluruh situs hanya bisa diakses lewat **HTTPS**; HTTP dialihkan ke HTTPS
- [ ] 🔴 Password disimpan dengan hash (bcrypt/argon2), tidak pernah teks biasa
- [ ] 🔴 **Wajib ganti password** pada login pertama dan setelah reset; route lain terblokir sebelum diganti
- [ ] 🔴 Aturan password: minimal 8 karakter, tidak boleh sama dengan NIS/username
- [ ] 🔴 **Rate limiting login**: percobaan gagal berulang memicu pembatasan/penguncian sementara
- [ ] 🔴 Pesan gagal login **sama** untuk NIS salah dan password salah (tidak membocorkan keberadaan akun)
- [ ] 🔴 Akun **nonaktif/arsip** tidak bisa login
- [ ] 🟠 Sesi diregenerasi setelah login; sesi dihapus saat logout
- [ ] 🟠 **Session timeout** otomatis saat tidak aktif (usulan 30 menit)
- [ ] 🟠 Cookie sesi: `Secure`, `HttpOnly`, `SameSite=Lax` (atau `Strict`)
- [ ] 🟠 Password awal acak (bukan pola yang mudah ditebak seperti NIS atau tanggal lahir)
- [ ] 🟡 Daftar kredensial awal hasil impor hanya bisa diunduh sekali dan tidak tersimpan permanen di server
- [ ] 🟡 2FA untuk Master dan Guru BK (Rilis 3)

## B. Kontrol Akses (Otorisasi)

Semua pemeriksaan dilakukan **di server** (Policy/middleware), bukan hanya menyembunyikan menu.

### Matriks akses yang harus ditegakkan

| Sumber daya | Siswa | Guru BK | Master |
|---|---|---|---|
| Membuat laporan | ✅ | ❌ | ❌ |
| Melihat laporan **miliknya** | ✅ | n/a | ❌ |
| Melihat laporan **orang lain** | ❌ | ✅ | ❌ |
| Melihat bukti laporan | hanya miliknya | ✅ | ❌ |
| Melihat identitas pelapor rahasia | ❌ | ✅ (tercatat di log) | ❌ |
| Catatan internal | ❌ | ✅ | ❌ |
| Mengubah status laporan | ❌ | ✅ | ❌ |
| Mengunduh laporan (PDF/Excel) | ❌ | ✅ (tercatat di log) | ❌ |
| Statistik | ❌ | ✅ | ✅ |
| Kelola kategori | ❌ | ✅ | ❌ |
| Kelola akun Guru BK dan siswa | ❌ | ❌ | ✅ |
| Impor Excel, kenaikan kelas, hapus per kelas | ❌ | ❌ | ✅ |
| Log aktivitas | ❌ | ❌ | ✅ |
| Notifikasi | hanya miliknya | hanya miliknya | hanya miliknya |

Daftar cek:

- [ ] 🔴 Setiap route berada di bawah middleware autentikasi dan peran yang sesuai
- [ ] 🔴 **Siswa tidak bisa membuka laporan, bukti, atau notifikasi siswa lain** (uji IDOR, lihat bagian J)
- [ ] 🔴 **Master tidak bisa membuka isi laporan, identitas pelapor, bukti, maupun mengunduh laporan**
- [ ] 🔴 Pelapor yang memilih "Sembunyikan nama" tampil sebagai "Pelapor Rahasia" di semua tampilan, termasuk daftar, ekspor, dan notifikasi
- [ ] 🔴 Aksi "Lihat identitas" tercatat di `activity_logs` (siapa, kapan, laporan mana)
- [ ] 🔴 Laporan memakai **UUID**, bukan ID berurutan
- [ ] 🟠 Catatan internal tidak pernah muncul di halaman, API, atau ekspor yang bisa dilihat siswa
- [ ] 🟠 Hanya Master yang dapat membuat/mengubah akun; Guru BK tidak dapat mengubah peran
- [ ] 🟠 Mengubah status laporan, balasan, dan catatan hanya dapat dilakukan Guru BK
- [ ] 🟠 Hapus permanen dan hapus per kelas meminta **konfirmasi password Master**
- [ ] 🟠 Halaman 403/404 tidak membocorkan informasi (tidak menjelaskan apakah suatu laporan ada)

## C. Perlindungan Data

- [ ] 🔴 Kolom `description`, `accused_name` (laporan), `message` (balasan), dan `note` (catatan internal) **terenkripsi** di database
- [ ] 🔴 **Tidak ada IP/user-agent** yang tersimpan pada tabel `reports` dan tabel terkait laporan
- [ ] 🔴 `APP_KEY` tersimpan aman dan **dicadangkan terpisah**; hilangnya kunci berarti data tidak terbaca
- [ ] 🔴 `.env` tidak masuk Git; tidak ada kredensial di kode atau riwayat Git
- [ ] 🔴 `APP_DEBUG=false` dan `APP_ENV=production` di server produksi
- [ ] 🟠 Log aplikasi dan log audit **tidak memuat** isi laporan, nama terlapor, atau password
- [ ] 🟠 Notifikasi hanya berisi pesan singkat tanpa detail sensitif
- [ ] 🟠 Data server berada di Indonesia
- [ ] 🟠 Kebijakan retensi data ditetapkan dan didokumentasikan
- [ ] 🟡 Metadata EXIF pada foto bukti dihapus bila memungkinkan

## D. Unggah File Bukti

- [ ] 🔴 File disimpan **di luar folder publik** (disk privat), tidak bisa diakses lewat URL langsung
- [ ] 🔴 Akses file hanya lewat endpoint yang memeriksa otorisasi (pemilik laporan atau Guru BK)
- [ ] 🔴 Validasi **ekstensi + MIME (deteksi server) + ukuran** (JPG, PNG, PDF; maks. 5 MB; maks. 3 file)
- [ ] 🔴 File berbahaya ditolak (`.php`, `.exe`, `.html`, `.svg`, file palsu berekstensi gambar)
- [ ] 🟠 Nama file di disk diacak; nama asli hanya untuk tampilan dan sudah dibersihkan
- [ ] 🟠 File disajikan dengan header `Content-Disposition` dan `X-Content-Type-Options: nosniff`
- [ ] 🟡 Pemindaian antivirus (ClamAV) bila server mendukung

## E. Impor dan Ekspor Excel

- [ ] 🔴 Impor hanya menerima `.xlsx`, maks. 2 MB; makro dan ekstensi lain ditolak
- [ ] 🔴 **Pratinjau dan validasi** sebelum data disimpan (NIS/NIP ganda, kolom kosong, kelas tidak terdaftar)
- [ ] 🔴 **Ekspor Excel tahan injeksi formula**: sel berawalan `=`, `+`, `-`, `@` diberi tanda aman
- [ ] 🟠 Sel berisi formula pada file impor diperlakukan sebagai teks/diabaikan
- [ ] 🟠 Impor diproses dalam batch dan tidak membuat server kehabisan memori (uji 500 baris)
- [ ] 🟠 Setiap impor dan unduhan kredensial tercatat di log (`excel_imported`, `credentials_exported`)
- [ ] 🟠 Unduhan laporan berlabel **"RAHASIA"** dan tercatat di log (`report_downloaded`)

## F. Perlindungan Aplikasi Web

- [ ] 🔴 **CSRF**: semua form dan permintaan ubah-data memakai token
- [ ] 🔴 **SQL injection**: tidak ada query mentah tanpa parameter (periksa `DB::raw`, `whereRaw`)
- [ ] 🔴 **XSS**: output Blade memakai `{{ }}`; `{!! !!}` tidak dipakai untuk input pengguna
- [ ] 🟠 **Mass assignment**: model memakai `$fillable`; `role`, `is_active`, `status` tidak bisa diubah lewat request siswa
- [ ] 🟠 **Header keamanan**: `Content-Security-Policy`, `X-Frame-Options` (atau `frame-ancestors`), `X-Content-Type-Options`, `Referrer-Policy`, `Strict-Transport-Security`
- [ ] 🟠 **Rate limiting** pada login, pembuatan laporan, balasan, dan impor
- [ ] 🟠 Pembatasan ukuran request (body dan unggahan) di Nginx/Apache dan PHP
- [ ] 🟠 Validasi semua input di server (Form Request), termasuk panjang maksimum dan nilai enum
- [ ] 🟠 Redirect tidak menerima URL eksternal dari input pengguna (open redirect)
- [ ] 🟠 Tidak ada halaman/route debug (`/telescope`, `/_ignition`, `phpinfo`) yang aktif di produksi
- [ ] 🟡 Cloudflare Turnstile pada form laporan bila terjadi spam
- [ ] 🟡 Tombol **Keluar Cepat** berfungsi dan tidak meninggalkan jejak (Rilis 2)

## G. Log Audit

- [ ] 🔴 Dicatat: login berhasil/gagal, logout, ganti/reset password
- [ ] 🔴 Dicatat: **pembukaan identitas pelapor**, perubahan status, unduhan laporan
- [ ] 🔴 Dicatat: pembuatan, perubahan, arsip, dan penghapusan akun; impor Excel; kenaikan kelas; hapus per kelas
- [ ] 🟠 Log **tidak dapat diubah atau dihapus** lewat aplikasi (tidak ada route/fitur edit/hapus log)
- [ ] 🟠 Log tidak memuat data sensitif (lihat bagian C)
- [ ] 🟡 Peninjauan log berkala oleh Master (usulan: tiap bulan)

## H. Infrastruktur dan Server

- [ ] 🔴 Firewall aktif; hanya port 80/443 (dan SSH yang diamankan) terbuka
- [ ] 🔴 Port database (3306) **tidak terbuka ke publik**
- [ ] 🔴 Akun database khusus aplikasi dengan hak seperlunya (bukan `root`)
- [ ] 🔴 **Backup database dan folder bukti harian**, dienkripsi, disimpan minimal 14 hari
- [ ] 🔴 **Pemulihan backup sudah diuji** minimal satu kali
- [ ] 🟠 Login SSH memakai kunci, bukan password; login root dimatikan
- [ ] 🟠 Sistem operasi, PHP, dan web server rutin diperbarui
- [ ] 🟠 Izin folder benar: hanya `storage/` dan `bootstrap/cache/` yang dapat ditulis; folder web root menuju `public/`
- [ ] 🟠 File sensitif (`.env`, `.git`, `composer.json`, `storage/`) tidak dapat diakses lewat browser
- [ ] 🟠 Sertifikat SSL diperpanjang otomatis (Let's Encrypt)
- [ ] 🟠 Minimal **2 akun Master**; password awal sudah diganti
- [ ] 🟡 Pemantauan uptime, ruang disk, dan log error

## I. Dependensi dan Kode

- [ ] 🔴 `composer audit` dan `npm audit` tidak menunjukkan kerentanan tinggi/kritis yang belum ditangani
- [ ] 🟠 Hanya paket yang dibutuhkan yang terpasang; paket yang tidak dipakai dibuang
- [ ] 🟠 Versi paket dikunci (`composer.lock`, `package-lock.json` ikut di Git)
- [ ] 🟠 Skill/aturan agent (`AGENTS.md`, `SKILL.md`) sudah ditinjau dan tidak berisi instruksi berbahaya
- [ ] 🟡 Kode hasil AI ditinjau manusia sebelum digabung, terutama bagian otorisasi, upload, dan impor
- [ ] 🟡 Rutin memperbarui dependensi (usulan: tiap bulan)

## J. Skenario Uji Wajib (Manual dan Otomatis)

Gunakan **data palsu**. Setiap skenario harus punya feature test otomatis bila memungkinkan.

### J1. IDOR (paling penting)
1. Login sebagai **siswa A**, buat laporan, catat UUID-nya.
2. Login sebagai **siswa B**; buka `/laporan/{uuid-siswa-A}` → **harus 403/404**.
3. Coba URL bukti, balasan, dan notifikasi milik siswa A dari akun siswa B → **harus ditolak**.
4. Ulangi dengan mengubah ID pada setiap permintaan POST/PUT/DELETE (balasan, susulan) → **harus ditolak**.

### J2. Batas peran Master
1. Login sebagai **Master**; buka daftar laporan, detail laporan, bukti, dan fitur unduh laporan via URL langsung → **harus 403**.
2. Pastikan halaman statistik Master **tidak memuat** teks laporan atau nama pelapor.

### J3. Kerahasiaan identitas
1. Siswa membuat laporan dengan "Sembunyikan nama".
2. Guru BK melihat daftar → tampil "Pelapor Rahasia".
3. Guru BK menekan "Lihat identitas" → nama muncul **dan** ada baris `identity_revealed` di log.
4. Ekspor PDF/Excel dari Guru BK → pelapor tetap tersamarkan sesuai aturan.
5. Periksa database langsung: kolom kronologi **terenkripsi** (bukan teks terbaca).

### J4. Login dan password
1. Login pertama → dipaksa ganti password; coba buka halaman lain sebelum ganti → **diblokir**.
2. 5+ kali password salah → **dibatasi/dikunci**.
3. Login dengan NIS tidak terdaftar dan password salah → pesan error **identik**.
4. Akun nonaktif/arsip → **tidak bisa login**.
5. Sesi tidak aktif melewati batas waktu → **otomatis keluar**.

### J5. Unggah file
1. Unggah `shell.php`, `a.exe`, `x.html`, `x.svg` → **ditolak**.
2. Ganti nama `shell.php` menjadi `foto.jpg` lalu unggah → **ditolak** (MIME tidak cocok).
3. Unggah file > 5 MB atau lebih dari 3 file → **ditolak**.
4. Coba akses `/storage/...` langsung ke file bukti → **tidak bisa**.

### J6. Impor/ekspor Excel
1. Impor file dengan NIS ganda, kelas tak terdaftar, baris kosong → **terdeteksi di pratinjau**.
2. Impor file `.xlsm` atau `.xls` → **ditolak**.
3. Isi nama siswa dengan `=HYPERLINK("http://contoh.com","klik")` lalu ekspor → sel **tidak menjadi formula aktif**.
4. Impor 500 baris → selesai tanpa error memori.

### J7. Mass assignment dan input
1. Siswa mengirim field tambahan `status=selesai` atau `role=master` saat membuat laporan/profil → **diabaikan**.
2. Kirim kronologi berisi `<script>alert(1)</script>` → tampil sebagai teks, **tidak dieksekusi**.
3. Kirim kategori yang sudah nonaktif atau tidak ada → **ditolak validasi**.

### J8. Penghapusan data
1. Arsipkan akun siswa yang punya laporan → laporan tetap ada; pelapor tampil "Akun diarsipkan".
2. Hapus permanen (dengan konfirmasi password Master) → laporan tetap ada; `reporter_id` menjadi `NULL`.
3. Coba hapus kategori yang dipakai → **ditolak**.
4. Kenaikan kelas → snapshot kelas pada laporan lama **tidak berubah**.

## K. Penandatanganan Peluncuran

| Item | Penanggung jawab | Tanggal | Tanda tangan / catatan |
|---|---|---|---|
| Semua butir 🔴 lulus | | | |
| Semua tes otomatis lulus (`php artisan test`) | | | |
| Skenario J1–J8 diuji manual | | | |
| Backup dan pemulihan teruji | | | |
| Peninjauan oleh Guru BK dan kepala madrasah | | | |

**Peluncuran hanya boleh dilakukan jika semua butir 🔴 sudah tercentang.**

---

## Riwayat Peninjauan

| Tanggal | Peninjau | Hasil | Tindak lanjut |
|---|---|---|---|
| | | | |