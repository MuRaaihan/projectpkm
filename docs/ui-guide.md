# UI Guide: SISPERKA

Panduan tampilan, bahasa, dan perilaku antarmuka SISPERKA. Dipakai oleh developer dan agent AI.

**Urutan prioritas jika ada pertentangan:**
1. [`prd.md`](./prd.md) dan aturan keamanan di [`AGENTS.md`](../AGENTS.md)
2. **Dokumen ini (`ui-guide.md`)**
3. Skill `design-taste-frontend-v1` (hanya inspirasi gaya; lihat bagian 14)

**Stack tampilan:** Laravel Blade + Tailwind CSS (Alpine.js boleh untuk interaksi kecil). Tanpa React/Next.js/Framer Motion/GSAP/Three.js.

---

## 1. Prinsip Desain

SISPERKA dipakai anak-anak yang mungkin sedang takut, sedih, atau malu. Tampilannya harus terasa **aman, tenang, dan mudah**, bukan keren atau ramai.

| Prinsip | Artinya dalam praktik |
|---|---|
| **Aman dan tenang** | Warna lembut, ruang kosong lega, tanpa animasi mencolok, tanpa warna merah berlebihan |
| **Sederhana** | Satu tujuan per layar, form singkat, tombol utama jelas |
| **Jujur** | Selalu terang tentang siapa yang dapat melihat laporan; tidak menjanjikan anonim penuh |
| **Ramah anak** | Kalimat pendek, hangat, tidak menghakimi, tanpa istilah teknis |
| **Mobile-first** | Dirancang untuk layar HP dulu; desktop adalah perluasan |
| **Ringan** | Cepat di HP murah dan kuota terbatas |
| **Dapat diakses** | Kontras tinggi, huruf besar, bisa dipakai tanpa mouse |

---

## 2. Nada dan Bahasa

Semua teks antarmuka memakai **Bahasa Indonesia sederhana**. Sapaan ke siswa: **"kamu"**. Ke Guru BK dan Master: bahasa sopan-netral ("Anda" atau tanpa kata ganti).

### Aturan umum
- Kalimat **pendek** (idealnya ≤ 15 kata). Satu ide per kalimat.
- Hangat dan menenangkan, **tidak menghakimi** dan tidak menyalahkan korban.
- Hindari istilah teknis: ❌ "autentikasi gagal" → ✅ "NIS atau kata sandi belum cocok."
- Gunakan kata **"kata sandi"** (bukan "password") di antarmuka siswa.
- Pesan galat menjelaskan **apa yang terjadi** dan **apa yang bisa dilakukan**, tanpa menyalahkan pengguna.
- Jangan gunakan tanda seru berlebihan, emoji berlebihan, atau bahasa gaul.
- Istilah yang konsisten: **laporan**, **pelapor**, **terlapor**, **Guru BK**, **kategori**, **bukti**.

### Contoh teks (pakai sebagai acuan)

| Konteks | Teks |
|---|---|
| Judul beranda | "Kamu tidak sendirian. Ceritakan di sini, dengan aman." |
| Tombol utama beranda | "Masuk" |
| Tombol buat laporan | "Buat Laporan" |
| Pernyataan kerahasiaan (wajib di form) | "Nama kamu tidak terlihat oleh siswa lain. Guru BK tetap dapat mengetahuinya agar bisa membantu kamu dengan tepat." |
| Label centang | "Sembunyikan nama saya dari daftar laporan" |
| Setelah kirim laporan | "Laporanmu sudah diterima. Terima kasih sudah berani bercerita. Guru BK akan membacanya." |
| Status kosong riwayat | "Belum ada laporan. Kalau ada yang mengganggumu, kamu bisa bercerita kapan saja." |
| Galat login | "NIS atau kata sandi belum cocok. Coba lagi, atau tanyakan ke wali kelas." |
| Akun terkunci | "Terlalu banyak percobaan. Tunggu beberapa menit lalu coba lagi." |
| Wajib ganti kata sandi | "Demi keamanan, buat kata sandi barumu sebelum melanjutkan." |
| Sesi akan habis | "Kamu akan keluar otomatis sebentar lagi karena tidak ada aktivitas." |
| Galat umum | "Maaf, ada gangguan. Laporanmu belum terkirim. Coba lagi sebentar lagi." |
| Konfirmasi hapus (Master) | "Tindakan ini tidak bisa dibatalkan. Masukkan kata sandimu untuk melanjutkan." |
| Kontak darurat | "Butuh bantuan sekarang? Hubungi Guru BK atau orang dewasa yang kamu percaya." |

### Label status laporan

| Status (database) | Label tampil | Penjelasan singkat untuk siswa |
|---|---|---|
| `baru` | Baru | "Laporanmu sudah masuk." |
| `diverifikasi` | Sudah dibaca | "Guru BK sudah membaca dan memeriksa laporanmu." |
| `diproses` | Sedang ditangani | "Guru BK sedang menindaklanjuti." |
| `selesai` | Selesai | "Laporanmu sudah selesai ditangani." |
| `ditolak` | Tidak dapat diproses | "Laporan ini belum bisa ditindaklanjuti. Lihat alasannya di bawah." |

> Status "Ditolak" **tidak boleh** memakai warna merah atau kata yang terkesan menyalahkan. Pakai warna netral dan sertakan alasan yang sopan.

---

## 3. Warna

Palet tenang berbasis **teal** (hijau kebiruan) dengan netral **slate**. Semua pasangan teks/latar di bawah sudah dihitung memenuhi **WCAG AA** (teks ≥ 4,5:1; komponen UI ≥ 3:1).

### Token warna

| Token | Hex | Pemakaian |
|---|---|---|
| `primary-50` | `#F0FDFA` | Latar lembut, banner info |
| `primary-600` | `#0F766E` | Tombol utama, tautan, fokus. Putih di atasnya: **5,47:1** |
| `primary-700` | `#115E59` | Hover tombol utama. Putih di atasnya: **7,58:1** |
| `bg` | `#F8FAFC` | Latar halaman |
| `surface` | `#FFFFFF` | Kartu, form, header |
| `text` | `#0F172A` | Teks utama (**17:1** di atas latar) |
| `text-muted` | `#475569` | Teks pendukung (**7,2:1**) |
| `border` | `#CBD5E1` | Garis kartu/tabel (dekoratif) |
| `border-input` | `#64748B` | Garis kolom isian (≥ 3:1) |
| `success` | `#15803D` | Pesan berhasil (teks **5,0:1**) |
| `warning` | `#92400E` | Peringatan, pada latar `#FFFBEB` (**6,8:1**) |
| `danger` | `#B91C1C` | Galat dan aksi berbahaya (**6,5:1**) |
| `info` | `#0369A1` | Informasi, pada latar `#F0F9FF` (**5,6:1**) |

### Warna badge status

| Status | Latar | Teks | Kontras |
|---|---|---|---|
| Baru | `#E0F2FE` | `#075985` | 6,6:1 |
| Sudah dibaca | `#E0E7FF` | `#3730A3` | 8,1:1 |
| Sedang ditangani | `#FEF3C7` | `#92400E` | 6,4:1 |
| Selesai | `#DCFCE7` | `#166534` | 6,5:1 |
| Tidak dapat diproses | `#F1F5F9` | `#334155` | 9,5:1 |

### Aturan warna
- **Jangan mengandalkan warna saja.** Status selalu disertai **teks** (dan ikon bila perlu).
- Merah (`danger`) hanya untuk galat nyata dan aksi destruktif (hapus). Bukan untuk status laporan atau halaman siswa pada umumnya.
- Tidak ada gradien mencolok, efek neon, atau latar gelap pekat. **Mode gelap tidak wajib** di versi 1.
- Tombol utama: **satu per layar**.

### Konfigurasi Tailwind

Tailwind v4 (bawaan terbaru), di `resources/css/app.css`:

```css
@import "tailwindcss";

@theme {
  --font-sans: "Plus Jakarta Sans", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;

  --color-primary-50: #F0FDFA;
  --color-primary-600: #0F766E;
  --color-primary-700: #115E59;

  --color-bg: #F8FAFC;
  --color-surface: #FFFFFF;
  --color-ink: #0F172A;
  --color-ink-muted: #475569;
  --color-line: #CBD5E1;
  --color-line-input: #64748B;

  --color-ok: #15803D;
  --color-warn: #92400E;
  --color-bad: #B91C1C;
  --color-note: #0369A1;
}
```

Jika proyek memakai Tailwind v3, pindahkan token yang sama ke `theme.extend.colors` di `tailwind.config.js`.

---

## 4. Tipografi

- **Font:** *Plus Jakarta Sans* (ramah dan terbaca), dengan cadangan font sistem. **Host sendiri** (mis. paket `@fontsource/plus-jakarta-sans`), **jangan** memuat dari Google Fonts atau CDN luar, demi privasi, kecepatan, dan CSP.
- Muat hanya bobot yang dipakai (400, 600, 700) dan subset Latin.

| Elemen | Mobile | Desktop | Bobot |
|---|---|---|---|
| Judul halaman (h1) | 28 px | 36 px | 700 |
| Judul bagian (h2) | 22 px | 28 px | 700 |
| Sub-judul (h3) | 18 px | 20 px | 600 |
| **Teks isi** | **16 px (minimum)** | 16–17 px | 400 |
| Teks pendukung | 14 px | 14 px | 400 |
| Label form | 15 px | 15 px | 600 |

- **Tinggi baris** 1,5–1,65 untuk teks isi; lebar baris teks maksimal ±65 karakter.
- Tidak ada teks penting di bawah 14 px.
- Hindari huruf kapital semua untuk kalimat panjang.

---

## 5. Jarak, Bentuk, dan Ukuran

- **Skala jarak** kelipatan 4 px (4, 8, 12, 16, 24, 32, 48, 64). Antar-bagian beranda: 48–64 px.
- **Sudut membulat** lembut: kartu 12 px, tombol dan input 10 px, badge penuh (pill).
- **Bayangan** sangat tipis; cukup garis `border` + latar putih untuk kartu.
- **Target sentuh minimal 44 × 44 px** untuk semua tombol dan tautan penting.
- Kolom isian tinggi minimal 44 px, font 16 px (agar tidak memicu zoom otomatis di iOS).
- Jarak aman di bagian bawah halaman HP agar konten tidak tertutup bar sistem.

---

## 6. Tata Letak dan Navigasi

- **Mobile-first**: tulis gaya dasar untuk layar kecil, lalu tambah `md:` dan `lg:`.
- Titik patah: HP (< 640 px), tablet (≥ 768 px), desktop (≥ 1024 px).
- Lebar konten maksimum: **1100 px** (beranda), **720 px** (form dan detail laporan).
- Tidak ada **scroll horizontal** pada badan halaman. Tabel lebar discroll di dalam wadahnya sendiri atau diubah menjadi kartu di HP.

### Navigasi per peran

| Peran | Mobile | Desktop |
|---|---|---|
| Publik | Header sederhana: nama + tombol **Masuk** | Sama, dengan tautan Beranda/Tata Cara/FAQ |
| **Siswa** | **Bilah navigasi bawah** 3–4 item: Beranda, Buat Laporan, Riwayat, Profil; lonceng di header | Header dengan menu horizontal |
| **Guru BK** | Menu hamburger + lonceng di header | Sidebar kiri: Dashboard, Laporan, Kategori, Statistik, Unduh, Profil |
| **Master** | Menu hamburger | Sidebar kiri: Dashboard, Akun BK, Akun Siswa, Impor Excel, Kelas, Master Data, Konten, Log, Profil |

- **Header** selalu menampilkan: nama aplikasi, **lonceng notifikasi** (dengan jumlah belum dibaca), dan menu akun (**Profil**, **Keluar**).
- Tombol **Keluar Cepat** (bila diaktifkan di Rilis 2) tampil tetap di pojok pada halaman yang relevan.

---

## 7. Komponen

### Tombol
| Jenis | Gaya | Dipakai untuk |
|---|---|---|
| Utama | Latar `primary-600`, teks putih | Satu aksi utama per layar (Kirim Laporan, Masuk) |
| Sekunder | Garis `primary-600`, latar putih | Aksi pendukung (Batal, Kembali) |
| Teks/tautan | Teks `primary-600`, garis bawah saat hover/fokus | Aksi ringan |
| Bahaya | Latar `danger`, teks putih | Hapus permanen (selalu dengan konfirmasi) |

- Keadaan wajib: normal, hover, **fokus**, nonaktif, dan **memuat** (spinner kecil + teks "Mengirim...").
- Cegah klik ganda saat memproses (nonaktifkan tombol).

### Form
- Label **di atas** kolom isian, selalu terlihat (bukan hanya placeholder).
- Tandai kolom wajib dengan teks "(wajib)" atau tanda bintang plus keterangan.
- Pesan galat **di bawah kolom**, berwarna `danger`, disertai ikon, dan dihubungkan via `aria-describedby`.
- Pertahankan isi form saat galat validasi (jangan mengosongkan kronologi yang sudah ditulis).
- Atribut `autocomplete` yang tepat: `username` (login), `current-password`, `new-password`.
- Kolom kata sandi punya tombol **tampilkan/sembunyikan**.
- Area kronologi: tinggi awal ±140 px, ada penghitung karakter, batas wajar (mis. 2000 karakter).

### Unggah bukti
- Tampilkan batas jelas: "JPG, PNG, atau PDF · maks. 5 MB · maks. 3 file".
- Daftar file terpilih dengan tombol hapus; pratinjau gambar kecil.
- Galat ramah: "File ini terlalu besar. Pilih file di bawah 5 MB."
- Jangan membuka atau menampilkan bukti otomatis dalam ukuran besar tanpa tindakan pengguna.

### Kartu laporan (riwayat/daftar)
Berisi: kategori, tanggal, **badge status**, dan potongan singkat **tanpa** isi sensitif (hindari menampilkan kronologi di daftar). Seluruh kartu dapat disentuh.

### Tabel (Guru BK dan Master)
- **Desktop:** tabel dengan header tetap, baris selang-seling lembut, aksi di kolom akhir.
- **HP:** ubah setiap baris menjadi **kartu** bertumpuk; jangan memaksa tabel lebar.
- Pencarian dan filter di atas; paginasi di bawah (jangan scroll tak terbatas).

### Badge status
Pill kecil dengan teks + warna (lihat bagian 3). Teks selalu ada.

### Modal dan konfirmasi
- Aksi destruktif (hapus permanen, hapus per kelas, kenaikan kelas) memakai **modal konfirmasi** yang menjelaskan **dampaknya**, jumlah data terdampak, dan meminta **kata sandi Master**.
- Modal bisa ditutup dengan tombol Batal dan tombol `Esc`; fokus terkunci di dalam modal.
- Tombol aksi berbahaya **tidak** menjadi fokus awal; tombol Batal yang menjadi fokus awal.

### Notifikasi (lonceng)
- Ikon lonceng di header dengan **penanda angka** jumlah belum dibaca.
- Klik membuka daftar singkat (panel/halaman): judul singkat, waktu, tanda belum dibaca.
- Isi **tanpa detail sensitif** (mis. "Ada laporan baru", "Status laporanmu berubah").
- Hanya muncul saat website dibuka; tidak ada popup yang mengganggu.

### Pesan umpan balik (toast/alert)
- Berhasil, galat, dan info memakai komponen alert di dalam halaman; toast hanya untuk konfirmasi ringan dan hilang ≥ 6 detik.
- Pesan penting (galat) **tidak** hilang otomatis.
- Gunakan `role="status"` / `aria-live="polite"` agar terbaca pembaca layar.

### Keadaan halaman (wajib untuk setiap halaman)
| Keadaan | Perilaku |
|---|---|
| **Memuat** | Kerangka ringan (skeleton) atau spinner kecil + teks; hindari layar kosong |
| **Kosong** | Ilustrasi sederhana/ikon + kalimat hangat + aksi berikutnya (lihat contoh teks) |
| **Galat** | Pesan ramah + tombol "Coba lagi"; jangan menampilkan jejak teknis |
| **Tidak berwenang (403)** | "Halaman ini tidak tersedia untuk akunmu." + tombol kembali; tidak membocorkan keberadaan data |
| **Tidak ditemukan (404)** | "Halaman tidak ditemukan." + tombol ke beranda |
| **Sesi habis** | Arahkan ke login dengan pesan jelas |

---

## 8. Rancangan Halaman Utama

### 8.1 Beranda (publik)
Urutan bagian dari atas:
1. **Header**: nama SISPERKA + tombol **Masuk** (+ tombol Keluar Cepat di Rilis 2).
2. **Hero**: judul hangat, satu kalimat penjelasan, tombol **Masuk**, dan pernyataan kerahasiaan singkat.
3. **Apa itu SISPERKA**: 2–3 kalimat tentang tujuan.
4. **Tata cara menggunakan**: **3–4 langkah** bernomor dengan ikon (Masuk dengan NIS → Isi laporan → Pantau status → Guru BK menindaklanjuti). Boleh tiga kartu sejajar di desktop; ditumpuk di HP.
5. **Jaminan kerahasiaan**: apa yang dapat dan tidak dapat dilihat siapa (jujur).
6. **Alur penanganan laporan**: langkah dan perkiraan waktu respons.
7. **FAQ** singkat (akordeon sederhana).
8. **Footer informasi sekolah**: nama, alamat, kontak, jam layanan Guru BK, tautan Kebijakan Privasi.

Hero **boleh rata tengah**. Ilustrasi sederhana (SVG ringan); tanpa foto siswa asli.

### 8.2 Login
- Satu kartu di tengah: judul, kolom **NIS / NIP / Username**, kolom **Kata sandi** (dengan tombol tampil), tombol **Masuk**.
- Teks bantuan: "Lupa kata sandi? Hubungi wali kelas atau Master."
- Pesan galat identik untuk semua jenis kegagalan (lihat bagian 2). Tidak ada tautan "daftar".

### 8.3 Dashboard siswa
- Sapaan singkat + tombol besar **Buat Laporan**.
- Ringkasan laporan terakhir (kartu + badge status) dan jumlah notifikasi baru.
- Kartu **Butuh bantuan?** berisi kontak Guru BK.

### 8.4 Form buat laporan
Urutan field (singkat, satu kolom):
1. Peran kamu: **Korban / Saksi** (pilihan besar)
2. Kategori (daftar aktif)
3. Kapan kejadiannya (tanggal)
4. Di mana (lokasi)
5. Ceritakan apa yang terjadi (kronologi)
6. Siapa yang terlibat (opsional)
7. Bukti (opsional)
8. **Sembunyikan nama saya** (centang) + **pernyataan kerahasiaan** yang selalu terlihat di dekat tombol
9. Tombol utama **Kirim Laporan**

Nuansa: paragraf pembuka hangat ("Ceritakan dengan caramu sendiri. Tidak ada jawaban yang salah."). Tampilkan kemajuan bila form panjang, namun jaga tetap satu halaman.

### 8.5 Detail laporan (siswa)
Status (badge + penjelasan), garis waktu perubahan status, balasan Guru BK, kolom balasan/informasi susulan. **Catatan internal tidak pernah tampil.**

### 8.6 Dashboard dan daftar laporan (Guru BK)
- Dashboard: kartu ringkasan (Baru, Diproses, Selesai bulan ini), daftar laporan terbaru.
- Daftar: pencarian + filter (status, kategori, kelas, tanggal), tabel/kartu, badge status.
- Nama pelapor rahasia tampil **"Pelapor Rahasia"** dengan ikon gembok; tombol **Lihat identitas** terpisah dan memberi peringatan bahwa aksi ini dicatat.

### 8.7 Master
- Dashboard statistik (kartu angka + grafik sederhana). **Tanpa isi laporan dan tanpa identitas.**
- Halaman akun: tabel dengan pencarian, filter kelas, aksi (ubah, nonaktifkan, reset kata sandi, arsipkan).
- Impor Excel: unggah → **pratinjau validasi** (jumlah valid/bermasalah/ganda, daftar galat) → konfirmasi.
- Operasi massal (hapus per kelas, kenaikan kelas): selalu lewat modal konfirmasi berisi jumlah terdampak.

### 8.8 Statistik
Grafik **sederhana dan terbaca**: batang untuk kategori/kelas, garis untuk tren bulanan, angka ringkasan di atas. Muat Chart.js **hanya** di halaman statistik. Beri alternatif tabel/angka agar bisa dibaca tanpa grafik.

---

## 9. Gerakan dan Animasi

- Transisi **sederhana dan singkat**: 150–200 ms untuk hover, fokus, buka/tutup akordeon.
- **Tidak ada animasi yang berjalan terus-menerus** (looping, melayang, denyut).
- Tidak ada animasi parallax, animasi saat scroll yang berat, atau efek magnet kursor.
- Hormati `prefers-reduced-motion`: matikan transisi non-esensial.
- Spinner dan skeleton hanya saat benar-benar menunggu.

---

## 10. Aksesibilitas

- **Kontras** sesuai token di bagian 3; jangan memakai abu-abu muda untuk teks.
- **Indikator fokus** terlihat jelas (cincin `primary-600` 2–3 px dengan jarak) pada semua elemen interaktif; jangan menghapus `outline` tanpa pengganti.
- Seluruh fitur dapat dipakai dengan **keyboard** (Tab, Enter, Esc); urutan tab logis.
- Setiap input punya `<label>`; galat terhubung dengan `aria-describedby`; area dinamis memakai `aria-live`.
- Gunakan elemen HTML semantik (`<header>`, `<nav>`, `<main>`, `<button>`, `<table>`); tombol aksi memakai `<button>`, bukan `<div>`.
- `<html lang="id">`; gambar informatif punya `alt`, gambar dekoratif `alt=""`.
- Tautan "Lewati ke konten utama" di awal halaman.
- Jangan memakai ikon tanpa teks untuk aksi penting; bila perlu beri `aria-label`.
- Uji dengan zoom 200% dan layar 360 px lebar.

---

## 11. Privasi dan Keamanan di Tampilan

- **"Pelapor Rahasia"** tampil konsisten di semua tempat bila nama disembunyikan (daftar, detail, ekspor, notifikasi).
- Pernyataan batas kerahasiaan **selalu terlihat** pada form laporan dan di FAQ.
- **Jangan menaruh data sensitif di URL, judul halaman, atau teks notifikasi.** URL laporan memakai UUID.
- Halaman setelah login diberi `noindex`, dan respons memakai `Cache-Control: no-store` agar tidak tersimpan di cache/riwayat bersama.
- **Peringatan sesi habis** beberapa saat sebelum logout otomatis; setelah logout, tombol Kembali di browser tidak boleh menampilkan konten sensitif.
- **Tanpa sumber luar**: tidak ada font/skrip/gambar dari CDN pihak ketiga, tanpa analitik atau pelacak (selaras dengan CSP dan privasi anak). Ikon memakai SVG lokal.
- Layar sensitif (daftar kata sandi awal hasil impor) hanya tampil sekali, dengan peringatan.
- Aksi yang dicatat di log (lihat identitas, unduh laporan) menampilkan **peringatan singkat** sebelum dijalankan.

---

## 12. Performa

- Target: halaman utama termuat **≤ 3 detik di 4G**; ukuran awal ringan.
- Gambar: SVG untuk ilustrasi; format modern (WebP) untuk raster; `loading="lazy"`; ukuran eksplisit agar tidak melompat.
- Font self-hosted, subset Latin, `font-display: swap`.
- JavaScript minimal: Alpine.js secukupnya; **Chart.js hanya di halaman statistik**.
- Hindari pustaka UI besar. Tailwind di-purge otomatis lewat build produksi.
- Uji pada **HP Android entry-level** dan koneksi lambat (throttling "Slow 4G").

---

## 13. Ikon dan Gambar

- Satu set ikon SVG lokal yang konsisten (mis. Heroicons atau Lucide), gaya garis (outline), ukuran 20–24 px.
- Ilustrasi sederhana, lembut, dan netral; **tanpa wajah siswa asli**, tanpa gambar yang menggambarkan kekerasan atau memicu trauma.
- Hindari ikon tengkorak, tanda silang merah besar, atau citra menakutkan.

---

## 14. Menimpa Skill `design-taste-frontend-v1`

Skill ini dipakai sebagai inspirasi kerapian visual. Bila bertentangan, **panduan ini menang**:

| Kecenderungan skill | Keputusan SISPERKA |
|---|---|
| `DESIGN_VARIANCE` 8 (tata letak asimetris, tak biasa) | Pakai **3**: tata letak rapi, mudah diprediksi |
| `MOTION_INTENSITY` 6 (animasi kaya, mikro-interaksi terus-menerus) | Pakai **2**: transisi singkat saja |
| `VISUAL_DENSITY` 4 | Tetap **4**, namun beri ruang lega untuk ketenangan |
| Default React/Next.js/Framer Motion | **Dilarang.** Laravel Blade + Tailwind (+ Alpine.js) |
| Hindari hero rata tengah | **Boleh** rata tengah |
| Hindari tiga kartu sejajar | **Boleh** untuk bagian "Tata Cara" |
| Hindari font Inter/umum | Pakai **Plus Jakarta Sans** (self-hosted), sans-serif cadangan |
| Animasi tak berhenti di tiap kartu | **Dilarang** |
| Gaya "premium/startup", gelap, neon, gradien | **Dilarang**; tampilan tenang, lembut, sederhana |
| Memuat font/skrip dari CDN | **Dilarang**; semua aset lokal |

---

## 15. Definisi Selesai untuk Setiap Halaman

Sebuah halaman UI dianggap selesai bila:

- [ ] Tampil baik di **360 px** (HP kecil), tablet, dan desktop; tanpa scroll horizontal
- [ ] Teks isi ≥ 16 px; target sentuh ≥ 44 px
- [ ] Kontras sesuai token; status tidak hanya mengandalkan warna
- [ ] Ada keadaan **memuat, kosong, galat** yang ramah
- [ ] Teks dalam **Bahasa Indonesia** sederhana, hangat, tidak menghakimi
- [ ] Bisa dipakai dengan **keyboard**; fokus terlihat; label dan `aria` benar
- [ ] Tidak ada data sensitif di URL/judul/notifikasi; nama pelapor rahasia tersamarkan
- [ ] Tidak ada sumber luar (CDN, font, analitik) dan tidak ada animasi berjalan terus-menerus
- [ ] Hanya satu tombol utama per layar; aksi destruktif memakai konfirmasi
- [ ] Sudah dicek di **HP sungguhan** (atau mode responsif) dan lolos `security-checklist.md` bagian terkait

---

## 16. Pertanyaan Terbuka

- [ ] Apakah madrasah memiliki **logo** dan **warna identitas** yang harus dipakai? (Jika ya, sesuaikan `primary` dan tetap cek kontrasnya.)
- [ ] Apakah ada **nama atau wajah maskot** yang disukai sekolah (opsional)?
- [ ] Apakah tampilan perlu menyertakan **bahasa/nuansa keagamaan** (mis. salam pembuka) pada beranda?
- [ ] **Teks FAQ, "Tata Cara", dan jaminan kerahasiaan** perlu ditinjau Guru BK dan kepala madrasah.
- [ ] Apakah siswa diizinkan memakai **mode gelap** (belum diwajibkan di versi 1)?