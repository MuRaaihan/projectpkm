# PRD: SIPERKA
**Sistem Pelaporan Perundungan Berbasis Web — MTs Soebono Mantofani**

| | |
|---|---|
| **Versi** | 1.2 (Selesai Implementasi & Pemolesan UI/UX) |
| **Status** | Stabil / Production-Ready |
| **Pemilik produk** | Kepala MTs Soebono Mantofani & Tim Pengembang |
| **Tim pengembang** | Tim Pengembang SIPERKA |
| **Terakhir diperbarui** | November 2026 |

---

## 1. Ringkasan

**SIPERKA** adalah aplikasi web untuk melaporkan kasus perundungan (bullying) di MTs Soebono Mantofani. Siswa melapor melalui akun yang dibuatkan sekolah, dengan pilihan **lapor rahasia** (nama disamarkan dari pihak lain). Guru BK menerima, memverifikasi, menindaklanjuti, dan mencatat penanganan laporan. Akun Master mengelola akun pengguna dan memantau statistik tanpa melihat isi laporan.

**Perkiraan pengguna:** ±400 orang (siswa, guru BK, master).

## 2. Latar Belakang dan Masalah

- Korban dan saksi perundungan sering takut atau malu melapor langsung karena khawatir diketahui teman atau mendapat pembalasan.
- Tanpa kanal resmi, laporan tersebar lewat obrolan lisan atau pesan pribadi sehingga tidak tercatat, sulit dipantau, dan rawan terlewat.
- Madrasah memerlukan data yang rapi untuk evaluasi dan pelaporan (rujukan: Permendikbudristek No. 46 Tahun 2023 dan ketentuan Kemenag untuk madrasah).

## 3. Tujuan dan Indikator Keberhasilan

| Tujuan | Indikator (target awal) |
|---|---|
| Kanal lapor yang aman dan mudah | Siswa dapat mengirim laporan dalam ≤ 3 menit |
| Melindungi identitas pelapor dari siswa lain | 0 kebocoran identitas pelapor rahasia ke pihak tak berwenang |
| Penanganan cepat | ≥ 90% laporan mendapat respons awal ≤ 3×24 jam |
| Penanganan tercatat | 100% laporan memiliki status dan riwayat tindak lanjut |
| Adopsi | ≥ 70% siswa mengetahui cara melapor dalam 3 bulan pertama (survei) |

**Bukan tujuan (non-goals) versi 1:**
- Aplikasi mobile native (cukup web responsif)
- Chat real-time
- Notifikasi di luar website (email, WhatsApp, SMS, push notification). Notifikasi **hanya tampil saat pengguna membuka website**
- Pendaftaran akun mandiri
- Integrasi dengan sistem akademik/Dapodik

## 4. Konsep "Lapor Rahasia"

Karena siswa login memakai akun, sistem ini **bukan anonim penuh**, melainkan **rahasia**:

- Siswa dapat mencentang **"Sembunyikan nama saya"** saat membuat laporan.
- Pada dashboard Guru BK, nama pelapor tampil sebagai **"Pelapor Rahasia"**.
- Guru BK dapat membuka identitas pelapor bila diperlukan penanganan, dengan tombol khusus **"Lihat identitas"**. Setiap pembukaan **tercatat di log audit** (siapa, kapan, laporan apa).
- Siswa lain, dan Master, **tidak pernah** dapat melihat identitas maupun isi laporan.
- Form menampilkan pernyataan jujur: *"Identitasmu tidak terlihat oleh siswa lain, tetapi dapat diketahui Guru BK untuk keperluan penanganan."*

## 5. Pengguna dan Peran

| Peran | Pembuatan akun | Login dengan | Ringkasan hak akses |
|---|---|---|---|
| **Master** | Disiapkan saat instalasi (disarankan minimal 2 akun) | Username | Kelola akun, lihat statistik, kelola master data dan konfigurasi sistem, lihat log aktivitas. **Tidak memiliki menu notifikasi kasus dan tidak dapat melihat isi laporan.** |
| **Guru BK** | Dibuat oleh Master | NIP/Username | Kelola laporan, ubah status, kelola kategori, lihat statistik, unduh laporan, ganti profil, notifikasi |
| **Siswa** | Dibuat oleh Master | **NIS** | Buat laporan, lihat riwayat dan balasan, notifikasi, profil |

Siswa dan Guru BK **tidak dapat mendaftar sendiri**. Hanya ada **satu halaman login** untuk semua peran; setelah masuk, pengguna diarahkan ke dashboard sesuai perannya.

### Persona singkat
- **Raka (siswa kelas 8):** sering diejek, takut melapor langsung. Butuh cara lapor yang tidak diketahui teman.
- **Bu Siti (Guru BK):** butuh daftar laporan rapi, status jelas, dan bukti terkumpul di satu tempat.
- **Admin Master (operator/TU):** butuh cara cepat membuat ratusan akun dan merapikan data tiap tahun ajaran.

## 6. Struktur Halaman

**Publik (sebelum login)**
1. **Beranda**
   - Perkenalan SIPERKA (apa itu, tujuan, jaminan kerahasiaan)
   - Tata cara menggunakan (langkah-langkah bergambar/ikon)
   - Interactive Phone Mockups (pratinjau alur pelaporan ramah anak)
   - Alur penanganan laporan, FAQ singkat, dan tombol **Masuk**
   - **Footer Institusional 4-Kolom:** identitas resmi madrasah & badge Permendikbudristek No. 46/2023, navigasi layanan, kebijakan perlindungan, kontak darurat & jam aktif BK
2. **Login** (satu halaman terpadu untuk semua peran, dilengkapi toggle lihat kata sandi)
3. **Kebijakan Privasi**

**Siswa:** Dashboard · Buat Laporan (Wizard Multi-step) · Riwayat Laporan · Detail Laporan & Obrolan Responsif · Notifikasi · Profil · Bantuan & Kontak BK

**Guru BK:** Dashboard Terpadu · Daftar Laporan · Detail Kasus & Obrolan Responsif · Kelola Kategori · Statistik Visual (Chart.js) · Unduh Laporan (PDF/Excel) · Laporan Periodik · Notifikasi · Profil

**Master:** Dashboard Statistik & Audit · Kelola Akun (Akun Siswa & Akun Guru BK) · Akademik & Kelas (Daftar Kelas, Tahun Ajaran, Kenaikan & Mutasi) · Sistem & Konfigurasi (Impor Siswa Excel, Pengaturan Madrasah & Konten Beranda, Log Audit Aktivitas, Laporan Periodik) · Keamanan 2FA

## 7. Alur Pengguna Utama

### 7.1 Login pertama kali
1. Master membuat akun (manual atau impor Excel) dengan password awal.
2. Pengguna login memakai NIS (siswa) atau NIP/username (guru BK).
3. Sistem **memaksa ganti password** sebelum dapat memakai fitur lain.

### 7.2 Siswa membuat laporan
1. Siswa login → **Buat Laporan**.
2. Mengisi: peran (korban/saksi), kategori, tanggal, lokasi, kronologi, nama terlapor (opsional), bukti (opsional).
3. Memilih apakah **menyembunyikan nama**.
4. Mengirim → laporan berstatus **Baru**, Guru BK menerima notifikasi.
5. Siswa memantau status dan balasan pada **Riwayat Laporan**.

### 7.3 Guru BK menangani laporan
1. Login → melihat laporan baru (diurutkan menurut urgensi dan waktu).
2. Membuka laporan → mengubah status ke **Diverifikasi**.
3. Mencatat tindak lanjut (pemanggilan, mediasi, konseling, rujukan) dan membalas siswa bila perlu.
4. Menutup laporan dengan status **Selesai** (atau **Ditolak** dengan alasan wajib).

### 7.4 Master membuat akun lewat Excel
1. Unduh **template Excel** → isi data → unggah.
2. Sistem menampilkan **pratinjau dan hasil validasi** (data valid, bermasalah, ganda).
3. Master memeriksa lalu mengonfirmasi → akun dibuat; baris gagal dapat diunduh untuk diperbaiki.

## 8. Kebutuhan Fungsional

Prioritas: **P0** = wajib rilis pertama, **P1** = penting, **P2** = tahap berikutnya.

### 8.1 Autentikasi dan Akun (semua peran)

| ID | Kebutuhan | Prioritas |
|---|---|---|
| FR-01 | Satu halaman login; siswa memakai **NIS**, guru BK memakai NIP/username, master memakai username | P0 |
| FR-02 | Pengalihan otomatis ke dashboard sesuai peran | P0 |
| FR-03 | **Wajib ganti password** pada login pertama dan setelah reset | P0 |
| FR-04 | Pengguna dapat mengganti password sendiri | P0 |
| FR-05 | Pembatasan percobaan login dan penguncian akun sementara | P0 |
| FR-06 | Logout dan session timeout otomatis akibat tidak aktif | P0 |
| FR-07 | Reset password oleh Master | P0 |
| FR-08 | Autentikasi dua faktor (2FA TOTP RFC 6238) untuk Master dan Guru BK dengan 8 kode pemulihan darurat | P2 (Selesai) |

### 8.2 Modul Master

| ID | Kebutuhan | Prioritas |
|---|---|---|
| FR-09 | Buat, ubah, nonaktifkan/aktifkan, dan hapus akun **Guru BK** (dengan konfirmasi modal SweetAlert2 dan single-submit auto-reset) | P0 |
| FR-10 | Buat, ubah, nonaktifkan/aktifkan, dan hapus akun **Siswa** (dengan konfirmasi modal SweetAlert2 dan single-submit auto-reset) | P0 |
| FR-11 | **Impor akun lewat Excel** (siswa dan guru BK) dengan dropzone modern, template, pratinjau, validasi (NIS/NIP ganda, kolom kosong, format salah), dan eksekusi bulk insert cepat | P0 |
| FR-12 | Hapus akun siswa **per kelas** (dengan konfirmasi modal SweetAlert2 dan password Master) | P0 |
| FR-13 | **Kenaikan kelas / pindah kelas massal** (dengan pratinjau dan konfirmasi interaktif) | P0 |
| FR-14 | Hapus akun bersifat **arsip/nonaktif secara default**; hapus permanen hanya dengan konfirmasi password Master. Laporan lama tetap tersimpan dengan identitas pelapor disamarkan | P0 |
| FR-15 | Dashboard **statistik laporan** (tanpa isi laporan dan tanpa identitas) | P0 |
| FR-16 | Kelola master data: daftar kelas dan tahun ajaran | P0 |
| FR-17 | Kelola konten beranda dan informasi sekolah (footer) | P1 |
| FR-18 | **Log aktivitas** (pembuatan, perubahan, penghapusan akun, impor, login) | P1 |
| FR-19 | Pencarian, filter, dan paginasi daftar akun | P0 |

### 8.3 Modul Guru BK

| ID | Kebutuhan | Prioritas |
|---|---|---|
| FR-20 | Daftar laporan dengan panel filter terpadu (segmented tab status) dan pencarian multi-kriteria pintar: nomor tiket `#LAP-...`, lokasi kejadian, kelas, peran, kategori, dan identitas siswa (hanya non-anonim) | P0 |
| FR-21 | Detail laporan: kronologi, bukti, peran pelapor, terlapor; nama pelapor rahasia tampil sebagai "Pelapor Rahasia" | P0 |
| FR-22 | Tombol **"Lihat identitas"** pelapor rahasia, tercatat di log audit | P0 |
| FR-23 | Ubah status: **Baru → Diverifikasi → Diproses → Selesai / Ditolak**; alasan wajib saat Ditolak; riwayat perubahan status tersimpan | P0 |
| FR-24 | **Catatan internal** dan riwayat tindak lanjut (tidak terlihat siswa) | P0 |
| FR-25 | **Balasan** ke siswa pada laporan (komunikasi per laporan dengan tampilan bubble chat adaptif, teks rata kiri-kanan, dan tanpa centang) | P0 |
| FR-26 | **Kelola kategori** perundungan: tambah, ubah, nonaktifkan. Kategori yang sudah dipakai laporan tidak boleh dihapus | P0 |
| FR-27 | Penetapan tingkat urgensi (rendah/sedang/tinggi) | P1 |
| FR-28 | **Statistik laporan** (per bulan, kategori, status, kelas) | P0 |
| FR-29 | **Unduh laporan** (PDF dan Excel), diberi label "Rahasia" dan tercatat di log | P0 |
| FR-30 | Ganti profil (nama, foto, kontak) dan password | P0 |
| FR-31 | **Notifikasi dalam website** (laporan baru, balasan/informasi susulan dari siswa): ikon lonceng dengan penanda jumlah belum dibaca, tampil saat membuka website | P0 |

### 8.4 Modul Siswa

| ID | Kebutuhan | Prioritas |
|---|---|---|
| FR-32 | Buat laporan: peran (korban/saksi), kategori (dari daftar milik BK), tanggal, lokasi, kronologi, nama terlapor (opsional) | P0 |
| FR-33 | Opsi **"Sembunyikan nama saya"** disertai pernyataan batas kerahasiaan | P0 |
| FR-34 | Unggah bukti (JPG, PNG, PDF; maks. 5 MB per file, maks. 3 file) | P0 |
| FR-35 | **Riwayat laporan** milik sendiri beserta status dan balasan BK | P0 |
| FR-36 | Menambah informasi susulan pada laporan yang masih berjalan | P1 |
| FR-37 | **Notifikasi dalam website** (perubahan status, balasan BK): ikon lonceng dengan penanda jumlah belum dibaca, tampil saat membuka website | P0 |
| FR-37a | Notifikasi hanya berisi pesan singkat tanpa detail sensitif (mis. "Ada laporan baru"), tidak dikirim ke email, WhatsApp, maupun kanal lain di luar website | P0 |
| FR-38 | **Profil akun** (lihat data, ganti password) | P0 |
| FR-39 | Halaman bantuan dan kontak darurat | P1 |

### 8.5 Beranda Publik

| ID | Kebutuhan | Prioritas |
|---|---|---|
| FR-40 | Beranda berisi perkenalan, tata cara penggunaan, alur penanganan, FAQ, dan tombol Masuk | P0 |
| FR-41 | Footer institusional 4-kolom informasi sekolah (nama, alamat, kontak resmi, jam layanan BK, legalitas) | P0 |
| FR-42 | Tombol **Keluar Cepat** *(Dihapus/Nonaktif atas pertimbangan institusional madrasah untuk mencegah redirect tak sengaja bagi siswa)* | P1 (Nonaktif) |
| FR-43 | Halaman Kebijakan Privasi | P0 |

## 9. Kebutuhan Non-Fungsional

### 9.1 Keamanan dan Privasi (prioritas tertinggi)

**Autentikasi dan sesi**
- HTTPS di seluruh halaman, cookie sesi `Secure`, `HttpOnly`, `SameSite`.
- Password di-hash dengan bcrypt/argon2; kebijakan password minimal (panjang ≥ 8 karakter dan bukan sama dengan NIS/username); password awal acak atau terjadwal, wajib diganti.
- Pembatasan percobaan login (rate limiting) dan penguncian sementara; pesan error login tidak membocorkan apakah NIS/username ada.
- Session timeout otomatis, sesi diregenerasi setelah login.

**Kontrol akses**
- **Role-Based Access Control** di sisi server pada setiap permintaan, bukan hanya menyembunyikan menu.
- Siswa **hanya dapat mengakses laporan miliknya sendiri**. Wajib diuji terhadap manipulasi ID di URL (IDOR). Gunakan ID acak (UUID) pada laporan.
- Master tidak memiliki akses ke isi laporan maupun identitas pelapor.
- Guru BK hanya dapat membuka identitas pelapor rahasia melalui aksi tercatat.

**Perlindungan data**
- Enkripsi kolom sensitif di database: isi kronologi, identitas pelapor, nama terlapor, catatan internal.
- Bukti unggahan disimpan **di luar direktori publik** dengan nama acak dan hanya diakses lewat endpoint yang terotorisasi.
- Validasi file unggahan (ekstensi, MIME, ukuran) dan penghapusan metadata gambar (EXIF) bila memungkinkan.
- Backup otomatis harian, dienkripsi, disimpan minimal 14 hari, dan pemulihan diuji berkala.
- Kebijakan retensi data (usulan: laporan disimpan 5 tahun lalu diarsipkan).

**Perlindungan aplikasi**
- Proteksi bawaan terhadap SQL injection (query terparameter), XSS (escape output), dan CSRF (token).
- **Validasi impor Excel**: batasi tipe dan ukuran file, tolak makro, validasi setiap baris, dan abaikan sel yang berpotensi menjalankan formula.
- **Ekspor Excel dilindungi dari injeksi formula** (awali sel yang berawalan `=`, `+`, `-`, `@` dengan tanda aman).
- Header keamanan (CSP, X-Frame-Options, HSTS), pembatasan ukuran request, dan rate limiting pada form laporan agar tidak dispam.
- Dependensi diperbarui rutin; mode debug dimatikan di produksi; kredensial disimpan di variabel lingkungan.

**Audit**
- Log audit tidak dapat diubah oleh pengguna biasa dan mencatat: login (berhasil/gagal), pembukaan identitas pelapor, perubahan status, unduh laporan, pembuatan/penghapusan akun, impor Excel, reset password.

**Kepatuhan**
- Mengikuti **UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi**; karena pengguna utama adalah anak, perlu persetujuan sekolah/orang tua dan kebijakan privasi yang jelas.
- Server data berada di Indonesia.

### 9.2 Performa dan Kapasitas
- Mendukung ±400 pengguna terdaftar dan ±50 pengguna bersamaan.
- Halaman utama termuat ≤ 3 detik pada koneksi seluler 4G.
- Impor Excel hingga 500 baris diproses dalam waktu wajar (≤ 1 menit).

### 9.3 Ketersediaan
- Target ketersediaan ≥ 99% di luar pemeliharaan terjadwal.

### 9.4 Kegunaan (UX)
- **Mobile-first**, nyaman digunakan di layar HP.
- Bahasa Indonesia sederhana, ramah anak, dan tidak menghakimi.
- Form singkat; hanya field penting yang wajib.
- Aksesibilitas dasar (kontras warna, ukuran huruf, label form).

### 9.5 Pemeliharaan
- Memakai framework populer, kode terdokumentasi, dan tersedia panduan pengguna untuk Master, Guru BK, dan siswa.

## 10. Rekomendasi Teknologi

| Kebutuhan | Pilihan |
|---|---|
| Framework | Laravel 13 (PHP 8.3+) |
| Database | MySQL / MariaDB |
| Autentikasi dan peran | Laravel Auth (login kustom NIS/NIP/username) + kolom `role` dengan Policy/middleware |
| Tampilan | Tailwind CSS (atau Bootstrap) |
| Impor/Ekspor Excel | Laravel Excel (Maatwebsite) |
| Ekspor PDF | DomPDF |
| Grafik statistik | Chart.js |
| Anti-spam | Cloudflare Turnstile dan rate limiting |
| Hosting | VPS lokal Indonesia (1–2 vCPU, 2 GB RAM); wajib mendukung **PHP 8.3+** |
| Domain | Subdomain `.sch.id` (mis. `siperka.mtssoebonomantofani.sch.id`) |
| SSL | Let's Encrypt |

> Pilihan akhir dapat menyesuaikan keahlian tim yang akan merawat sistem.

## 11. Model Data (Draf Awal)

**users** — id, role (master/bk/siswa), login_id (unik; NIS/NIP/username), name, password, class_id (nullable), photo_path, phone, locked_until, is_active, must_change_password, last_login_at, timestamps, deleted_at (soft delete/arsip)

**classes** — id, nama_kelas, tahun_ajaran_id, timestamps

**academic_years** — id, nama, is_active

**categories** — id, nama, deskripsi, is_active, dibuat_oleh, timestamps

**reports** — id (UUID), reporter_id (relasi ke users), is_hidden_identity, reporter_role (korban/saksi), category_id, incident_date, location, description (terenkripsi), accused_name (terenkripsi, nullable), urgency, status, reject_reason (nullable), timestamps

**report_attachments** — id, report_id, file_path (acak), file_type, file_size, timestamps

**report_messages** — id, report_id, sender_id, sender_role, message, timestamps

**report_notes** — id, report_id, user_id, note (terenkripsi, internal), timestamps

**report_status_histories** — id, report_id, from_status, to_status, user_id, reason, timestamps

**notifications** — id, user_id, tipe, judul, isi, tautan, read_at, timestamps

**activity_logs** — id, user_id, action, subject_type, subject_id, keterangan, ip_address (hanya untuk log keamanan akun, tidak ditampilkan di laporan), timestamps

**site_contents** — id, kunci, nilai (konten beranda, info sekolah, FAQ)

## 12. Template Excel Impor Akun

**Siswa:** `NIS` · `Nama Lengkap` · `Kelas` · `Jenis Kelamin` · `Password Awal` (opsional; jika kosong dibuat otomatis)

**Guru BK:** `NIP/Username` · `Nama Lengkap` · `No. HP` · `Password Awal` (opsional)

**Aturan validasi:** NIS/NIP wajib dan unik, kelas harus terdaftar di master data, format file `.xlsx`, ukuran maksimal 2 MB, dan baris bermasalah ditampilkan sebelum penyimpanan dengan opsi mengunduh daftar kesalahan.

## 13. Kebijakan Penanganan (Non-Teknis, Disiapkan Paralel)

- [ ] SK pembentukan **Tim TPPK** dan penetapan Guru BK pengelola SIPERKA
- [ ] **SOP penanganan laporan** (siapa memproses, batas respons 3×24 jam, alur eskalasi)
- [ ] Aturan **perlindungan pelapor** dari pembalasan
- [ ] Jalur rujukan kasus berat (psikolog, P2TP2A, kepolisian)
- [ ] Rencana **sosialisasi** ke siswa, guru, dan orang tua
- [ ] Kebijakan privasi dan persetujuan orang tua/wali
- [ ] Penunjukan Guru BK/admin cadangan agar laporan tidak tertahan
- [ ] Prosedur serah terima password awal siswa (mis. dibagikan wali kelas secara tertutup)

## 14. Lingkup Rilis

### MVP (Rilis 1)
Semua kebutuhan **P0**: satu halaman login dengan ganti password wajib, manajemen akun dan impor Excel, kenaikan/pindah kelas, pembuatan laporan rahasia, kelola laporan dan status, kategori, balasan, catatan internal, statistik, unduh laporan, notifikasi dalam aplikasi, beranda publik dan footer, serta seluruh pengamanan inti.

### Rilis 2
Kebutuhan **P1**: tingkat urgensi, log aktivitas lengkap, informasi susulan siswa, kelola konten beranda, quick exit, halaman bantuan.

### Rilis 3
Kebutuhan **P2**: 2FA dan laporan periodik otomatis.

## 15. Rencana Pengerjaan

| Tahap | Kegiatan | Estimasi |
|---|---|---|
| 1 | Analisis kebutuhan dan finalisasi PRD bersama BK dan kepala madrasah | 1 minggu |
| 2 | Desain alur dan wireframe/UI | 1–2 minggu |
| 3 | Pengembangan: autentikasi, manajemen akun, impor Excel | 2 minggu |
| 4 | Pengembangan: laporan, status, kategori, notifikasi, statistik, unduh | 3 minggu |
| 5 | Pengujian internal dan uji keamanan (akses antar-peran, upload, impor) | 1–2 minggu |
| 6 | Uji coba terbatas (UAT) dengan guru BK dan beberapa siswa | 1–2 minggu |
| 7 | Peluncuran dan sosialisasi | 1 minggu |
| 8 | Evaluasi dan perbaikan | Tiap semester |

**Total perkiraan:** ±10–13 minggu hingga peluncuran.

## 16. Estimasi Biaya

| Komponen | Perkiraan |
|---|---|
| Hosting VPS | Rp50.000–150.000 / bulan |
| Domain `.sch.id` | Sesuai ketentuan penyedia/sekolah |
| Pengembangan (bila memakai freelancer) | Rp8–20 juta (sekali bayar, tergantung cakupan) |

## 17. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Siswa tidak percaya identitasnya aman | Laporan sedikit | Pernyataan jujur di form, sosialisasi, log audit pembukaan identitas |
| Siswa melihat laporan siswa lain (celah akses) | Kebocoran data serius | RBAC di server, UUID, uji IDOR sebelum rilis |
| Laporan tidak ditindaklanjuti | Kepercayaan hilang | SOP, batas waktu respons, notifikasi, BK cadangan |
| Password awal bocor/ditebak | Akun diambil alih | Password acak, wajib ganti saat login pertama, penguncian akun |
| File Excel/unggahan berbahaya | Kompromi server | Validasi ketat, penyimpanan di luar direktori publik, batas ukuran |
| Data lama hilang saat hapus akun/kelas | Riwayat rusak | Arsip default, konfirmasi password, laporan tetap tersimpan |
| Laporan palsu atau iseng | Beban kerja BK | Verifikasi, rate limiting, status Ditolak dengan alasan |
| Developer tidak tersedia setelah rilis | Sistem tak terawat | Framework populer, dokumentasi, serah terima |

## 18. Kriteria Penerimaan MVP

- [ ] Satu halaman login berfungsi untuk Master, Guru BK, dan Siswa (siswa memakai **NIS**) dan mengarahkan sesuai peran.
- [ ] Pengguna dipaksa mengganti password pada login pertama.
- [ ] Master dapat membuat, mengubah, menonaktifkan, dan menghapus akun; impor Excel dengan pratinjau dan validasi berjalan.
- [ ] Master dapat menghapus akun siswa per kelas dan melakukan kenaikan kelas massal.
- [ ] Siswa dapat membuat laporan (dengan opsi sembunyikan nama), mengunggah bukti, dan melihat riwayat serta balasan.
- [ ] Siswa tidak dapat membuka laporan siswa lain (lolos uji IDOR).
- [ ] Guru BK melihat "Pelapor Rahasia", dapat membuka identitas, dan pembukaan itu tercatat di log.
- [ ] Guru BK dapat mengubah status, menulis catatan internal, membalas siswa, mengelola kategori, melihat statistik, dan mengunduh laporan.
- [ ] Master hanya melihat statistik, tidak dapat melihat isi laporan.
- [ ] Notifikasi dalam aplikasi muncul untuk laporan baru, perubahan status, dan balasan.
- [ ] Beranda menampilkan perkenalan, tata cara penggunaan, dan footer informasi sekolah.
- [ ] Seluruh halaman berjalan di HTTPS dan nyaman di layar HP.
- [ ] Backup harian berjalan dan pemulihan telah diuji.
- [ ] Uji coba dengan pengguna nyata selesai dan masukan utama sudah ditangani.

## 19. Pertanyaan Terbuka

1. Siapa penanggung jawab utama sistem dan siapa yang memegang akun Master?
2. Berapa jumlah Guru BK dan apakah Tim TPPK sudah dibentuk resmi?
3. Berapa lama data laporan harus disimpan?
4. Apakah ada format laporan khusus dari Kemenag/Dinas yang harus dipenuhi pada fitur unduh?
5. Bagaimana mekanisme pembagian password awal ke siswa (wali kelas, cetak kartu, dll.)?
6. Apakah siswa yang lupa password cukup menghubungi Master/wali kelas?
7. Apakah diperlukan persetujuan orang tua tertulis sebelum siswa memakai sistem?
8. Siapa yang akan membangun dan merawat sistem (internal atau freelancer)?
9. Apakah sekolah sudah memiliki domain dan hosting?

## 20. Lampiran

- Permendikbudristek No. 46 Tahun 2023 tentang Pencegahan dan Penanganan Kekerasan di Lingkungan Satuan Pendidikan
- UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi
- Regulasi Kemenag terkait penanganan kekerasan di madrasah _(lengkapi sesuai pedoman terbaru)_

---

*Dokumen ini adalah draf dan akan diperbarui seiring hasil analisis kebutuhan bersama pihak madrasah.*