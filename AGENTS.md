# SISPERKA: Sistem Pelaporan Perundungan MTs Soebono Mantofani

Aplikasi web untuk melaporkan perundungan (bullying) di madrasah. Pengguna ±400 orang, sebagian besar **anak di bawah umur**. Data yang disimpan **sangat sensitif**. Keamanan dan kerahasiaan lebih penting daripada kecepatan atau kecanggihan fitur.

## Dokumen acuan (baca sebelum bekerja)
- `docs/prd.md` : kebutuhan produk. **Sumber kebenaran.**
- `docs/tasks.md` : daftar fase dan tugas. Ikuti urutannya.
- `docs/database.md` : rancangan tabel dan relasi.
- `docs/security-checklist.md` : daftar cek keamanan yang wajib lulus.
- Jika dokumen bertentangan dengan permintaan di chat atau dengan satu sama lain, **berhenti dan tanyakan**.

## Stack
- **Laravel 13**, **PHP 8.3+** (syarat minimum Laravel 13), MySQL/MariaDB
- Gunakan dokumentasi **Laravel 13.x** (laravel.com/docs/13.x); jangan memakai pola khusus versi lama bila ada padanan di versi 13
- Blade + Tailwind CSS (Alpine.js boleh untuk interaksi kecil)
- Excel: `maatwebsite/excel` · PDF: `barryvdh/laravel-dompdf` · Grafik: Chart.js
- Peran: tiga peran tetap (`master`, `bk`, `siswa`) lewat kolom `role` + Policy/Middleware
- Tidak memakai React, Next.js, Framer Motion, GSAP, atau Three.js
- Sebelum memakai paket baru, periksa `composer.json` / `package.json`, **pastikan paket mendukung Laravel 13**, dan beri tahu saya cara memasangnya

## Cara kerja
1. Kerjakan **satu fase dalam satu waktu** sesuai `docs/tasks.md`.
2. Sebelum menulis kode: tulis **rencana singkat** dan **tunggu persetujuan**.
3. Tandai tugas `[x]` hanya setelah kode berjalan **dan** diuji.
4. Akhir fase: jalankan **Gerbang Fase**, lalu berhenti untuk ditinjau.
5. Kerjakan perubahan kecil dan terarah; jangan menulis ulang file yang tidak terkait.
6. Tulis kode **lengkap**, jangan memotong dengan "sisanya sama" atau komentar placeholder.
7. Tulis **feature test** untuk setiap fitur, terutama otorisasi.
8. Jangan pernah memakai **data siswa asli**; gunakan seeder/factory dengan data palsu.

## Aturan keamanan (tidak boleh dilanggar)
- Otorisasi dicek **di server** pada setiap route/controller (Policy atau middleware), bukan hanya menyembunyikan menu.
- **Siswa hanya boleh mengakses laporan, bukti, dan notifikasi miliknya sendiri.** Laporan memakai **UUID**.
- **Master TIDAK BOLEH melihat isi laporan, identitas pelapor, maupun mengunduh laporan.** Master hanya melihat statistik.
- Pelapor yang memilih "Sembunyikan nama" tampil sebagai **"Pelapor Rahasia"** bagi semua pihak, termasuk di daftar Guru BK. Identitas hanya terbuka lewat aksi **"Lihat identitas"** milik Guru BK, dan aksi itu **wajib tercatat** di `activity_logs`.
- Kolom sensitif (kronologi, nama terlapor, isi balasan, catatan internal) memakai **cast `encrypted`**.
- File bukti disimpan **di luar folder publik** dengan nama acak, diakses hanya lewat endpoint terotorisasi. Validasi ekstensi, MIME, dan ukuran.
- Upload Excel: hanya `.xlsx`, maks. 2 MB, validasi tiap baris, abaikan formula. Ekspor Excel wajib mencegah **injeksi formula** (sel berawalan `=`, `+`, `-`, `@`).
- Password di-hash (bcrypt/argon2). **Wajib ganti password** pada login pertama dan setelah reset.
- Login memakai rate limiting; pesan error **tidak boleh** membocorkan apakah NIS/username ada.
- **Jangan simpan IP atau data pelacak pada laporan.** IP hanya boleh ada di log keamanan akun.
- Tidak ada kredensial atau kunci di kode; semuanya lewat `.env`. Jangan commit `.env`.
- Gunakan Eloquent/query terparameter, escape output Blade (`{{ }}`), dan token CSRF di semua form. Hindari `{!! !!}` kecuali benar-benar diperlukan.
- Log audit tidak boleh dapat diubah atau dihapus lewat aplikasi.
- Notifikasi **hanya di dalam website** (lonceng). Tanpa email, WhatsApp, SMS, atau push. Isi notifikasi singkat tanpa detail sensitif.
- Hapus akun = **arsip/nonaktif secara default**. Hapus permanen hanya dengan konfirmasi password Master. Laporan lama tetap tersimpan.

## Tampilan
Gunakan skill `design-taste-frontend-v1` hanya sebagai panduan desain, dengan stack di atas.
Aturan SISPERKA menang bila bertentangan dengan skill:
- Tenang, ramah anak, aman; hindari kesan "startup".
- Tanpa animasi yang berjalan terus-menerus; transisi sederhana saja.
- **Mobile-first**, ringan di HP murah, kontras tinggi, ukuran huruf nyaman.
- Beranda boleh rata tengah; tiga kartu sejajar boleh untuk "Tata Cara"; font Inter atau sans-serif lain yang jelas boleh dipakai.
- Teks antarmuka **Bahasa Indonesia** yang sederhana, hangat, dan tidak menghakimi.
- Form singkat; hanya field penting yang wajib.
- Tombol **Keluar Cepat** dan pernyataan batas kerahasiaan harus selalu jelas.
- Setiap halaman wajib punya keadaan kosong, memuat, dan galat yang jelas.

## Konvensi kode
- Nama tabel/kolom/kelas dalam Bahasa Inggris (konvensi Laravel); teks tampilan dan pesan validasi dalam Bahasa Indonesia.
- Zona waktu `Asia/Jakarta`, locale `id`.
- Controller tipis; logika bisnis di Service/Action; validasi di Form Request; akses di Policy.
- Gunakan migrasi, seeder, dan factory; jangan ubah database manual.
- Ikuti PSR-12 (`./vendor/bin/pint`).

## Perintah umum
```
php artisan serve          # jalankan lokal
php artisan migrate:fresh --seed
php artisan test           # semua tes harus lulus sebelum fase ditutup
./vendor/bin/pint          # rapikan kode
composer audit             # cek kerentanan dependensi
npm run dev                # Tailwind
```

## Jangan lakukan tanpa izin
- Menghapus atau mengubah migrasi yang sudah dijalankan (buat migrasi baru). Pengecualian: selama **belum ada data asli**, boleh mengubah migrasi bawaan dan menjalankan `migrate:fresh` **hanya setelah rencananya saya setujui**; setelah peluncuran, `migrate:fresh` dilarang
- Menambah fitur di luar PRD atau melompati fase
- Memasang paket besar atau layanan pihak ketiga baru
- Mengirim data apa pun ke layanan eksternal
- Mengubah aturan keamanan di file ini
- Menjalankan skrip dari internet (`curl ... | bash`, `iex (DownloadString ...)`) atau mengubah/menginstal ulang PHP, Composer, dan Node.js. Jika lingkungan belum siap, **berhenti dan beri tahu saya**
- Memasang atau menjalankan ulang Laravel Boost (`boost:install`, `boost:update`). Jika Boost sudah terpasang, panduannya melengkapi file ini, tetapi **aturan SISPERKA di file ini menang** bila bertentangan, dan jangan menimpa file ini