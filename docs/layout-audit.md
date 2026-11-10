# Laporan Audit Tata Letak & Kesiapan Mode Gelap (Layout & Dark Mode Audit)
**Sistem Pelaporan Perundungan SIPERKA - MTs Soebono Mantofani**

Dokumen ini disusun pada **Tahap 1: Audit (Tanpa Mengubah Kode)** untuk memetakan seluruh masalah tata letak, inkonsistensi visual pada tiga ukuran layar (360px mobile, 768px tablet, 1280px desktop), serta kesenjangan adaptasi mode gelap (*dark mode*) pada seluruh view aplikasi.

---

## 1. Inventarisasi Halaman Berdasarkan Area

Berdasarkan `php artisan route:list` dan struktur `resources/views`, seluruh halaman dikelompokkan ke dalam 7 area fungsional:

| No | Area / Kelompok | Route / Endpoint | Berkas View Blade |
|:--:|---|---|---|
| **1** | **Publik & Informasi** | `GET /` | `resources/views/welcome.blade.php` |
| | | `GET /kebijakan-privasi` | `resources/views/privacy.blade.php` |
| **2** | **Autentikasi & Keamanan** | `GET /login`, `POST /login` | `resources/views/auth/login.blade.php` |
| | | `GET /two-factor-challenge` | `resources/views/auth/two-factor-challenge.blade.php` |
| | | `GET /two-factor-setup` | `resources/views/auth/two-factor-setup.blade.php` |
| | | `GET /ganti-password` | `resources/views/auth/change-password.blade.php` |
| **3** | **Halaman Kesalahan (Error)** | `403 Forbidden` | `resources/views/errors/403.blade.php` |
| | | `404 Not Found` | `resources/views/errors/404.blade.php` |
| | | `500 Server Error` | `resources/views/errors/500.blade.php` |
| **4** | **Dashboard Siswa** | `GET /siswa/dashboard` | `resources/views/siswa/dashboard.blade.php` |
| | | `GET /siswa/laporan/buat` | `resources/views/siswa/reports/create.blade.php` |
| | | `GET /siswa/laporan` | `resources/views/siswa/reports/index.blade.php` |
| | | `GET /siswa/laporan/{id}` | `resources/views/siswa/reports/show.blade.php` |
| | | `GET /siswa/profil` | `resources/views/siswa/profile.blade.php` |
| | | `GET /siswa/bantuan` | `resources/views/siswa/bantuan.blade.php` |
| **5** | **Dashboard Guru BK** | `GET /bk/dashboard` | `resources/views/bk/dashboard.blade.php` |
| | | `GET /bk/laporan` | `resources/views/bk/reports/index.blade.php` |
| | | `GET /bk/laporan/{id}` | `resources/views/bk/reports/show.blade.php` |
| | | `GET /bk/statistik` | `resources/views/bk/statistics/index.blade.php` |
| | | `GET /bk/profil` | `resources/views/bk/profile/show.blade.php` |
| | | `GET /bk/unduh-laporan` | `resources/views/bk/reports/download.blade.php` |
| | | `Template Ekspor PDF` | `resources/views/bk/reports/export_pdf.blade.php` |
| | | `GET /bk/kategori` | `resources/views/bk/categories/index.blade.php` |
| **6** | **Dashboard Master Admin** | `GET /master/dashboard` | `resources/views/master/dashboard.blade.php` |
| | | `GET /master/students` | `resources/views/master/students/index.blade.php` |
| | | `GET /master/students/create` | `resources/views/master/students/create.blade.php` |
| | | `GET /master/students/{id}/edit` | `resources/views/master/students/edit.blade.php` |
| | | `GET /master/bk-users` | `resources/views/master/bk-users/index.blade.php` |
| | | `GET /master/bk-users/create` | `resources/views/master/bk-users/create.blade.php` |
| | | `GET /master/bk-users/{id}/edit` | `resources/views/master/bk-users/edit.blade.php` |
| | | `GET /master/classes` | `resources/views/master/classes/index.blade.php` |
| | | `GET /master/academic-years` | `resources/views/master/academic-years/index.blade.php` |
| | | `GET /master/class-operations` | `resources/views/master/class-operations/index.blade.php` |
| | | `POST /class-operations/preview` | `resources/views/master/class-operations/preview-promotion.blade.php`|
| | | `GET /master/import` | `resources/views/master/import/index.blade.php` |
| | | `POST /master/import/preview` | `resources/views/master/import/preview.blade.php` |
| | | `POST /master/import/confirm` | `resources/views/master/import/success.blade.php` |
| | | `GET /master/activity-logs` | `resources/views/master/activity-logs/index.blade.php` |
| | | `GET /master/settings` | `resources/views/master/settings/index.blade.php` |
| **7** | **Area Bersama (Shared)** | `GET /notifikasi` | `resources/views/notifications/index.blade.php` |
| | | `GET /laporan-periodik` | `resources/views/reports/periodic/index.blade.php` |
| | | `GET /laporan-periodik/{id}` | `resources/views/reports/periodic/show.blade.php` |

---

## 2. Matriks Temuan Audit Masalah Tata Letak & Mode Gelap

### Kategori Tingkat Keparahan:
- **Kritis**: Merusak keterbacaan (teks tidak terbaca di latar belakang), konten terpotong, atau hilangnya margin sisi layar di perangkat mobile.
- **Tinggi**: Pelanggaran target sentuh sentuh (< 44px), inkonsistensi sistem grid antarmuka, atau komponen inti tidak memiliki pasangan tema gelap.
- **Sedang**: Ketidakseragaman nilai jarak/padding, kontras elemen sekunder, atau penyesuaian sumbu grafik di mode gelap.
- **Rendah**: Class CSS non-standar atau estetika transisi.

---

### Tabel Temuan Per Komponen & Halaman

| No | Komponen / Halaman | Masalah Spesifik yang Teridentifikasi | Viewport Terdampak | Masalah Mode Gelap | Tingkat Keparahan | Status |
|:--:|---|---|:---:|---|:---:|:---:|
| 1 | **Komponen Input Bersama** (`<x-input>`) | Warna label `text-[#0F172A]` dan input `bg-white text-[#0F172A]` ditulis hardcoded tanpa varian `dark:`. Tombol show/hide password `text-[#475569]` tidak kontras. | Semua (360px, 768px, 1280px) | Teks hitam di atas kartu gelap, kontras di bawah 2:1 (gagal WCAG). | **Kritis** | **Terselesaikan** (`8d90671`) |
| 2 | **Komponen Select & Textarea** (`<x-select>`, `<x-textarea>`) | Background `bg-white`, border `#CBD5E1`, dan teks `#0F172A` statis tanpa dukungan `dark:bg-slate-900` / `dark:text-slate-100`. | Semua | Permukaan putih menyilaukan di dalam kartu form mode gelap. | **Kritis** | **Terselesaikan** (`8d90671`) |
| 3 | **Komponen Tabel Data Bersama** (`<x-table>`) | Container tabel memiliki `bg-white border-[#CBD5E1]`, thead `bg-[#F8FAFC] text-[#475569]`, tbody `divide-[#E2E8F0]`, teks default `text-[#0F172A]` tanpa padanan dark. | Semua | Seluruh tabel (Siswa, BK, Kelas, dsb) memutih di mode gelap. | **Kritis** | **Terselesaikan** (`8d90671`) |
| 4 | **Komponen Modal Bersama** (`<x-modal>`) | Kotak dialog modal menggunakan `bg-white border-[#CBD5E1]`, header teks `text-[#0F172A]`, tombol close `text-[#64748B] hover:bg-[#F1F5F9]`, footer `bg-[#F8FAFC]`. | 360px & Desktop | Modal popup tetap terang benderang saat mode gelap diaktifkan. | **Kritis** | **Terselesaikan** (`8d90671`) |
| 5 | **Komponen Alert & Flash** (`<x-alert>`) | Box styling hardcoded palet pastel terang (`bg-[#DCFCE7] text-[#166534]`, `bg-[#FEE2E2]`, dll.) tanpa varian warna gelap kontras rendah. | Semua | Kotak pesan berhasil/gagal terlalu silau di latar gelap. | **Tinggi** | **Terselesaikan** (`8d90671`) |
| 6 | **Komponen Keadaan Kosong** (`<x-empty-state>`) | Lingkaran ikon `bg-[#F0FDFA]`, border kartu dashed `border-[#CBD5E1] bg-white`, dan teks `#0F172A` statis. | Semua | Kartu keadaan kosong tidak menyatu dengan tema gelap. | **Tinggi** | **Terselesaikan** (`8d90671`) |
| 7 | **Inkonsistensi Container Layout Master & BK** | Seluruh view CRUD Master (`master/students/*`, `classes`, `academic-years`, `activity-logs`, `settings`, `class-operations`, `import/*`) dan BK (`categories/index`, `reports/download`) hanya dibungkus `<div class="space-y-6">` tanpa horizontal padding. | 360px (Mobile) | Pada layar 360px, tabel dan kartu menempel 0px ke tepi layar ponsel. | **Kritis** | **Terselesaikan** (`5cb24e0`) |
| 8 | **Halaman Verifikasi 2FA Challenge** (`auth/two-factor-challenge`) | Pembungkus halaman menggunakan `sm:px-6 lg:px-8` tanpa `px-4`. Di layar mobile < 640px tidak ada padding samping sama sekali. | 360px (Mobile) | Kartu form login 2FA menempel ke ujung kiri-kanan layar HP. | **Tinggi** | **Terselesaikan** (`eff8cbe`) |
| 9 | **Target Sentuh Mobile (< 44px)** | Tombol aksi per baris tabel di `master/students/index`, `master/bk-users/index`, `master/classes/index` menggunakan `p-1.5` atau `p-2` (ukuran fisik ~28-32px). Tombol close drawer sidebar staf di mobile juga < 44px. | 360px (Mobile) | Target sentuh terlalu kecil untuk jari jemari pada layar sentuh. | **Tinggi** | **Terselesaikan** (`8d90671`, `5cb24e0`) |
| 10 | **Class CSS Non-Standar** (`slate-850`) | Ditemukan penulisan class `dark:border-slate-850` dan `dark:bg-slate-850` pada `two-factor-setup`, `change-password`, `import/index`, `categories/index`. `slate-850` tidak ada dalam skala warna bawaan Tailwind. | Semua | Warna border fallback ke transparan/kosong. | **Rendah** | **Terselesaikan** (`eff8cbe`, `5cb24e0`) |
| 11 | **Grafik Chart.js pada Dashboard BK & Master** | Garis batas doughnut chart statis `borderColor: '#ffffff'`. Ticks sumbu X/Y dan label legend menggunakan warna default Chart.js yang gelap, sehingga sulit dibaca pada kartu `#16231D`. | Semua | Teks legenda dan angka sumbu grafik redup di mode gelap. | **Sedang** | **Terselesaikan** (`6344ea6`, `5cb24e0`) |
| 12 | **Form Login Multi-Layout Gap Conflict** | Di `auth/login.blade.php`, form memadukan `flex flex-col gap-4.5 space-y-4` secara bersamaan, menyebabkan penumpukan margin vertikal yang tidak terprediksi. | Semua | Spacing antar kolom input di halaman login tidak konsisten. | **Sedang** | **Terselesaikan** (`eff8cbe`) |
| 13 | **Tabel Data Meluber pada Layar Ponsel** | Pada tabel audit log (`master/activity-logs/index`) kolom deskripsi dan alamat IP membuat baris terlalu padat di layar 360px jika wrapper tidak dioptimalkan. | 360px | Potensi geser horizontal yang mengganggu navigasi. | **Sedang** | **Terselesaikan** (`5cb24e0`) |
| 14 | **Komponen Tombol Focus Ring Offset** | `<x-button>` menggunakan `focus:ring-offset-2` tanpa `dark:focus:ring-offset-slate-900`. | Desktop / Keyboard | Saat bernavigasi menggunakan tombol Tab di mode gelap, cincin fokus menampilkan lingkaran putih. | **Sedang** | **Terselesaikan** (`8d90671`) |
| 15 | **Varian Badge Tidak Terdaftar** | Pada `master/activity-logs/index`, kode mencoba memanggil varian `teal` dan `neutral` yang belum terdefinisi di `<x-badge>` (fallback ke default). | Semua | Inkonsistensi semantik warna status audit log. | **Rendah** | **Terselesaikan** (`8d90671`) |
| 16 | **Redundansi Menu Notifikasi Master** | Sidebar Master memuat menu Notifikasi padahal Master tidak menerima laporan/notifikasi kasus perundungan, membingungkan alur kerja admin. | Desktop & Mobile | Tidak ada visual khusus; menu tidak fungsional untuk peran Master. | **Sedang** | **Terselesaikan** |
| 17 | **Struktur Penamaan Sidebar Master Kurang Intuitif** | Label menu `Data Pengguna`, `Data Akademik`, `Impor & Pengaturan` kaku dan kurang mencerminkan aksi yang dilakukan admin. | Desktop & Mobile | Tidak ada masalah kontras; murni kejelasan navigasi pengguna. | **Sedang** | **Terselesaikan** |
| 18 | **Tata Letak Halaman Rekap Laporan Berkala** | Halaman rekapitulasi periodik (`reports/periodic/index` & `show`) kurang terstruktur, kartu metrik dan formulir filter belum rapi. | Semua | Kartu statistik dan tabel agregasi kurang padu di mode gelap. | **Tinggi** | **Terselesaikan** |
| 19 | **Tombol Reset Manual & Tombol Ganda Form Akun** | Form pembuatan siswa/BK memuat tombol reset manual dan dua tombol submit ("Simpan" dan "Simpan & Tambah Baru"), serta form tidak otomatis ter-reset setelah submit. | Desktop & Mobile | Gangguan UX formulir data akun. | **Tinggi** | **Terselesaikan** |
| 20 | **Pemisahan Filter dan Floating Status Laporan Masuk BK** | Status filter (semua, baru, diproses, dst) mengapung di luar kartu filter dan bergeser secara visual di layar kecil, tata letak input filter berantakan. | Semua (360px - 1280px) | Tab mengambang tidak seragam kontrasnya di latar gelap. | **Tinggi** | **Terselesaikan** |
| 21 | **Fitur Pencarian Laporan Masuk Tidak Menemukan Data** | Kueri pencarian hanya mencari ID UUID dan kelas, mengabaikan nomor tiket `#LAP-...`, lokasi kejadian, peran, kategori, dan identitas pelapor. | Semua | Menghambat Guru BK saat mencari laporan tertentu. | **Kritis** | **Terselesaikan** |

---

## 3. Rencana Solusi Sistematis (Tahap 2 & 3)

### A. Penyeragaman Sistem Tata Letak (Design System Layout)
1. **Penyatuan Container Standar Halaman:**
   - Semua halaman di dalam `<x-layouts.app>` distandarisasi menggunakan pembungkus konsisten:
     ```html
     <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
     ```
     Untuk form tunggal (seperti ganti password, profil, buat laporan), menggunakan `max-w-2xl` atau `max-w-4xl` yang tetap memiliki padding `px-4 sm:px-6 lg:px-8`.
2. **Skala Spacing Konsisten (Kelipatan 4px/8px):**
   - Padding kartu: `p-4 sm:p-6`
   - Jarak antar bagian: `space-y-6` atau `gap-6`
   - Jarak label ke input: `mb-1.5`
   - Tinggi target sentuh mobile: Semua tombol dan tautan interaktif minimal `min-h-[44px] min-w-[44px]`.
3. **Responsivitas Tabel:**
   - Semua tabel data dibungkus dalam container `<div class="overflow-x-auto">` dengan styling baris yang rapi, teks panjang menggunakan `truncate` atau `max-w-xs`, dan tooltip.

### B. Arsitektur Mode Gelap Terpadu
1. **Perbaikan Komponen Bersama:**
   - `<x-input>`, `<x-select>`, `<x-textarea>`: Ditambahkan pasangan class lengkap:
     `bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 border-slate-300 dark:border-slate-700 placeholder:text-slate-400 dark:placeholder:text-slate-500`.
   - `<x-table>`: Ditambahkan:
     `bg-white dark:bg-[#16231D] border-slate-200 dark:border-slate-800 divide-slate-100 dark:divide-slate-800`, thead `bg-slate-50/80 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400`.
   - `<x-modal>`: Ditambahkan:
     `bg-white dark:bg-[#16231D] border-slate-200 dark:border-slate-800`, footer `bg-slate-50/60 dark:bg-slate-900/40 border-slate-100 dark:border-slate-800`.
   - `<x-alert>`: Disesuaikan dengan tone redup kontras tinggi khusus mode gelap (`dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800`, dsb).
2. **Adaptasi Chart.js:**
   - Menambahkan event listener / deteksi kelas `.dark` pada inisialisasi Chart.js di dashboard BK dan Master Admin agar warna sumbu, teks legenda, dan garis pembatas secara dinamis beralih antara warna terang dan warna gelap yang nyaman di mata.
3. **Perlindungan Dokumen Cetak (@media print):**
   - Halaman cetak `bk/reports/export_pdf.blade.php` dipastikan tetap 100% monokrom/terang dan bebas dari styling dark mode saat dicetak.

---

## 4. Status Pelaksanaan & Riwayat Commit

- [x] **Tahap 1: Audit Lengkap Kode & Halaman** &mdash; *Selesai (Matriks temuan dan panduan implementasi disusun)*
- [x] **Tahap 2: Pembaharuan Komponen Dasar Blade & Token CSS** &mdash; *Commit `8d90671`*
- [x] **Tahap 3: Perbaikan Halaman Publik, Login, & Error** &mdash; *Commit `fd3a8ca` & `eff8cbe`*
- [x] **Tahap 4: Perbaikan Dashboard Siswa** &mdash; *Commit `d46dfd7`*
- [x] **Tahap 5: Perbaikan Dashboard Guru BK** &mdash; *Commit `6344ea6`*
- [x] **Tahap 6: Perbaikan Dashboard Master Admin & Modul Bersama** &mdash; *Commit `5cb24e0`*
- [x] **Tahap 7: Verifikasi Build (`npm run build`), Pengujian (`php artisan test`), dan Pemeriksaan Kontras WCAG AA** &mdash; *124/124 tests passed (566 assertions), 0 failures, 0 errors, asset Vite 100% lulus kompilasi.*
- [x] **Permintaan Tambahan 1: Pembersihan Keamanan Halaman Login & Perbaikan Toggle Password** &mdash; *Commit `d88802f` (Hilangkan footer publik pada login, hapus badge, netralkan teks portal terpadu, dan perbaiki toggle mata sandi mandiri).*
- [x] **Permintaan Tambahan 2: Porting Desain Halaman Publik Lengkap dari Frontend Next.js** &mdash; *Commit `95f1014` (Hero badge & headline bergaris aksen, 3 kartu pilar, 6 phone mockup interaktif dengan Dynamic Island dan detail UI realistis, kartu peran madrasah, linimasa alur penanganan, FAQ terpadu, dan navigasi seluler responsif).*
- [x] **Permintaan Tambahan 3: Pembersihan Bagian Publik Lama (Alur Penanganan, FAQ, & Footer Lama)** &mdash; *Commit `6027daf` (Menghapus section alur penanganan dan FAQ lama, membersihkan tautan navbar #alur-penanganan dan #faq, serta memperbarui footer beranda ke tata letak terpusat modern yang selaras dengan frontend Next.js).*
- [x] **Permintaan Tambahan 4: Penghapusan Bagian Fitur Peran & Kebijakan Privasi dari Halaman Publik** &mdash; *Commit `b30132e` (Menghapus section ekosistem fitur peran dan kartu panduan privasi dari welcome.blade.php, serta menyederhanakan menu navigasi navbar dan footer hanya untuk Beranda, Tentang, dan Cara Kerja).*
- [x] **Permintaan Tambahan 6: Desain Ulang Footer Institusional Profesional** &mdash; *Commit `7fbf8c3` & `edce3db` (Mengubah layout footer menjadi grid institusional 4-kolom berstandar tinggi: identitas madrasah & badge legalitas Permendikbudristek No. 46/2023, navigasi layanan terstruktur, tautan kebijakan perlindungan & batas kerahasiaan siswa, kotak kontak resmi & jam operasional BK dengan indikator status aktif, serta sub-footer hak cipta dengan tombol kembali ke atas).*
- [x] **Permintaan Tambahan 7: Penghapusan Fitur & Tombol Keluar Cepat** &mdash; *Commit `bd46daf` & `0233da6` (Menghilangkan tombol Quick Exit dari seluruh layout dan antarmuka untuk mencegah pengalihan yang tidak disengaja).*
- [x] **Permintaan Tambahan 8: Integrasi SweetAlert2 & Navigasi Responsif Siswa** &mdash; *Commit `58fbec9` (Notifikasi flash toast modern, konfirmasi dialog elegan, drawer sidebar siswa responsif dengan bottom nav, dan auto-read notifikasi saat membuka detail).*
- [x] **Permintaan Tambahan 9: Optimalisasi Gelembung Obrolan (Chat Bubbles)** &mdash; *(Mengatur lebar bubble chat dinamis mengikuti teks `w-fit`, menghilangkan ikon centang status, menghilangkan padding vertikal berlebih, dan menerapkan perataan teks rata kiri-kanan `text-justify` pada `siswa/reports/show` dan `bk/reports/show`).*
- [x] **Permintaan Tambahan 10: Perapihan Kolom Aksi Kategori Kasus BK** &mdash; *(Memposisikan kolom aksi ke tengah `text-center`, menyusun grup tombol Ubah dan Hapus dengan border terstruktur, dan memindahkan modal dialog ke luar tag tabel `bk/categories/index`).*
- [x] **Permintaan Tambahan 11: Pembersihan & Perapihan Dashboard Guru BK** &mdash; *(Menghapus duplikasi log catatan konseling/investigasi yang tidak diperlukan, serta merapikan tautan `[Buka seluruh daftar kasus Guru BK]` menjadi tombol aksi kartu yang terintegrasi pada desktop dan mobile).*
- [x] **Permintaan Tambahan 12: Standardisasi Tombol Navigasi Kembali Siswa** &mdash; *(Memperbarui tautan `[← Kembali ke Dashboard Saya]` pada `siswa/bantuan` dan `siswa/reports/show` dengan ikon panah SVG interaktif bertransisi hover, latar kartu elegan, dan breadcrumb navigasi).*
- [x] **Permintaan Tambahan 13: Harmonisasi Panel Master Admin & Standarisasi Dropdown** &mdash; *(Menata ulang sidebar akun Master ke dalam 4 seksi semantik dengan indikator aktif hijau seragam, memodernisasi seluruh dropdown menu Master & komponen `<x-select>` dengan ikon chevron SVG kustom, serta merapikan tombol aksi pada Master Kelas dan Tahun Ajaran dengan isolasi modal di luar tabel).*
- [x] **Permintaan Tambahan 14: Restrukturisasi Navigasi Sidebar Master & Eliminasi Menu Notifikasi** &mdash; *(Menghapus menu Notifikasi dari sidebar Master karena Master tidak menangani laporan kasus, serta memperbarui penamaan semantik menu menjadi `Kelola Akun`, `Akademik & Kelas`, dan `Sistem & Konfigurasi` agar lebih intuitif bagi pengguna).*
- [x] **Permintaan Tambahan 15: Perapihan Tata Letak Halaman Rekap Laporan Berkala** &mdash; *(Memperbaiki struktur antarmuka halaman `reports/periodic/index` dan `show` dengan tata letak kartu KPI modern, formulir filter terstruktur, tabel agregasi terpusat, dan integrasi tombol cetak/ekspor responsif).*
- [x] **Permintaan Tambahan 16: Integrasi SweetAlert2 pada Seluruh Dashboard Master** &mdash; *(Menstandarisasi dialog konfirmasi aksi kritis seperti hapus siswa, reset password, hapus kelas, dan kenaikan kelas menggunakan modal interaktif SweetAlert2, serta mengintegrasikan pesan flash session dengan notifikasi toast elegan).*
- [x] **Permintaan Tambahan 17: Penyempurnaan Formulir Pembuatan Akun Siswa & BK** &mdash; *(Menghapus tombol Reset Form manual, mengeliminasi tombol simpan ganda menjadi satu tombol submit utama "Simpan Akun Siswa" / "Simpan Akun Guru BK", dan menyetel auto-reset formulir pasca-simpan via controller redirect).*
- [x] **Permintaan Tambahan 18: Redesain Terpadu Panel Filter & Segmented Status Laporan Masuk BK** &mdash; *(Menyatukan bar tab status laporan dan formulir filter lanjutan ke dalam satu wadah kartu terpadu `bk/reports/index.blade.php`. Tab status dirancang sebagai segmented bar dengan indikator dot warna status dan badge hitungan monospace. Formulir filter ditata dalam 12-kolom grid yang presisi).*
- [x] **Permintaan Tambahan 19: Perbaikan Fitur Pencarian Multi-Kriteria Laporan Masuk BK** &mdash; *(Memulihkan dan memperluas cakupan kueri pencarian `BkReportController@index`: mendukung pencarian nomor tiket dengan format `#LAP-...`, lokasi kejadian `location`, kelas, peran, kategori perundungan, serta nama dan NIS siswa pelapor non-anonim dengan tetap menjamin kerahasiaan identitas pelapor rahasia sesuai aturan FR-02).*

