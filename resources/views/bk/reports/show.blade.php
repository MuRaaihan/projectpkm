<x-layouts.app :title="'Laporan #LAP-' . str_pad($report->id, 4, '0', STR_PAD_LEFT)">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Tombol Kembali & Header Status ───────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <a href="{{ route('bk.reports.index') }}" 
                   class="p-2.5 min-h-[42px] min-w-[42px] inline-flex items-center justify-center text-slate-500 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition cursor-pointer"
                   title="Kembali ke Daftar Laporan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">#LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <x-badge :variant="$report->status">
                            {{ $report->status_label }}
                        </x-badge>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                        Laporan {{ $report->category->name ?? 'Perundungan' }}
                    </h1>
                </div>
            </div>

            <div class="text-xs text-slate-500 dark:text-slate-400 sm:text-right">
                <div>Dikirim pada: <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->created_at->format('d M Y, H:i') }} WIB</span></div>
                @if($report->closed_at)
                    <div class="text-primary-700 dark:text-[#5AE39D] font-bold mt-0.5">Kasus Ditutup: {{ $report->closed_at->format('d M Y, H:i') }} WIB</div>
                @endif
            </div>
        </div>

        {{-- ── Layout 2 Kolom (Kiri: Kasus & Komunikasi, Kanan: Identitas & Aksi) ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri / Utama (2/3) --}}
            <div class="lg:col-span-2 flex flex-col gap-6">
                {{-- Kartu Kronologi & Detail Kejadian (Sesuai InfoRow di Prototype) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-5">
                    <div class="pb-3 border-b border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2.5">
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100 leading-tight">
                                Rincian Kejadian &amp; Kronologi
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Keterangan fakta kejadian yang dilaporkan peserta didik.
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap shrink-0 {{ $report->urgency === 'tinggi' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-900' : ($report->urgency === 'sedang' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-[#FAD46B] border border-amber-200 dark:border-amber-900' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $report->urgency === 'tinggi' ? 'bg-rose-600' : ($report->urgency === 'sedang' ? 'bg-amber-500' : 'bg-slate-400') }}"></span>
                            Urgensi {{ ucfirst($report->urgency) }}
                        </span>
                    </div>

                    {{-- Info Rows Terstruktur --}}
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 text-xs sm:text-sm">
                        {{-- 1. Tanggal Kejadian --}}
                        <div class="flex items-start gap-3.5 py-3">
                            <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tanggal &amp; Waktu Kejadian</p>
                                <p class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5">
                                    {{ $report->incident_date?->translatedFormat('l, d F Y') ?? 'Tidak disebutkan' }}
                                </p>
                            </div>
                        </div>

                        {{-- 2. Lokasi Kejadian --}}
                        <div class="flex items-start gap-3.5 py-3">
                            <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tempat / Lokasi Kejadian</p>
                                <p class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5">
                                    {{ $report->location }}
                                </p>
                            </div>
                        </div>

                        {{-- 3. Pihak Terlapor / Terlibat --}}
                        <div class="flex items-start gap-3.5 py-3">
                            <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pihak yang Terlapor</p>
                                <p class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5">
                                    {{ $report->accused_name ?: 'Tidak disebutkan oleh pelapor' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi Kronologi Lengkap --}}
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-2">Penjelasan Kronologi:</span>
                        <div class="p-4 bg-slate-50/80 dark:bg-slate-900/60 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs sm:text-sm leading-relaxed text-slate-900 dark:text-slate-100 whitespace-pre-line text-justify [text-align-last:left] break-words">{{ trim($report->description ?? '') }}</div>
                    </div>

                    {{-- Berkas Bukti Lampiran --}}
                    <div class="pt-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-2.5">
                            Bukti Lampiran ({{ $report->attachments->count() }} berkas):
                        </span>
                        @if($report->attachments->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($report->attachments as $att)
                                    <div class="flex items-center justify-between p-3.5 bg-slate-50/70 dark:bg-slate-900/50 border border-slate-200/80 dark:border-slate-800 rounded-xl text-xs sm:text-sm">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-primary-100/70 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 dark:text-slate-100 truncate text-xs" title="{{ $att->original_name }}">
                                                    {{ $att->original_name }}
                                                </p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $att->formatted_size }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('bk.reports.attachment', [$report, $att]) }}" target="_blank"
                                           class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 min-h-[34px] text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:bg-primary-50 dark:hover:bg-primary-950/50 rounded-lg transition cursor-pointer">
                                            <span>Buka</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-500 dark:text-slate-400 italic bg-slate-50/50 dark:bg-slate-900/30 p-3.5 rounded-xl border border-dashed border-slate-200 dark:border-slate-800">
                                Tidak ada berkas lampiran yang disertakan pada laporan ini.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Catatan Internal Guru BK (Rahasia - Tidak Terlihat Siswa) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-amber-200/80 dark:border-amber-900/40 p-5 sm:p-6 shadow-xs space-y-4">
                    <div class="pb-3 border-b border-amber-100 dark:border-amber-900/40 flex flex-wrap items-center justify-between gap-2">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100 leading-tight">
                                    Catatan Internal Guru BK
                                </h2>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950/70 text-amber-800 dark:text-[#FAD46B] border border-amber-300 dark:border-amber-800 whitespace-nowrap shrink-0">
                                    Kerahasiaan Tertinggi
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Catatan hasil pemanggilan, mediasi, atau rekam medis psikologis. Hanya dapat dibaca oleh staf konselor.
                            </p>
                        </div>
                    </div>

                    {{-- Form Tambah Catatan Internal --}}
                    <form method="POST" action="{{ route('bk.reports.notes.store', $report) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label for="note" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tambah Catatan Konseling Baru</label>
                            <textarea id="note" name="note" rows="3" required 
                                placeholder="Tuliskan catatan tindak lanjut, hasil mediasi, atau rencana pendampingan konseling..." 
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition leading-relaxed"></textarea>
                            @error('note')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2 min-h-[40px] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs font-bold rounded-xl transition shadow-xs cursor-pointer active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                <span>Simpan Catatan Internal</span>
                            </button>
                        </div>
                    </form>

                    {{-- Riwayat Catatan Internal --}}
                    <div class="pt-3 border-t border-amber-100 dark:border-amber-900/40 space-y-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Riwayat Catatan Internal:</span>
                        @if($report->notes->count() > 0)
                            <div class="space-y-2.5">
                                @foreach($report->notes as $note)
                                    <div class="p-3.5 bg-amber-50/70 dark:bg-[#261A05] border border-amber-200/80 dark:border-amber-900/60 rounded-xl text-xs sm:text-sm">
                                        <div class="flex items-center justify-between text-xs text-amber-900 dark:text-[#FAD46B] font-bold mb-1">
                                            <span>{{ $note->user?->name ?? 'Guru BK' }}</span>
                                            <span class="font-mono text-amber-700/80 dark:text-amber-400/80 text-[11px]">{{ $note->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <div class="text-slate-900 dark:text-slate-100 text-xs sm:text-sm whitespace-pre-line leading-relaxed text-justify [text-align-last:left] break-words">{{ trim($note->note ?? '') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                                Belum ada catatan internal yang dibuat.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Balasan Resmi ke Siswa Pelapor (Modern Chat Interface) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4"
                     x-data="{ 
                         message: '',
                         setTemplate(text) {
                             this.message = text;
                             this.$nextTick(() => {
                                 const el = document.getElementById('message-input');
                                 if (el) { el.focus(); }
                             });
                         }
                     }">
                    {{-- Header Chat --}}
                    <div class="pb-3 border-b border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-2xl bg-primary-100 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100 leading-tight">
                                    Komunikasi Resmi dengan Siswa Pelapor
                                </h2>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    Kanal pesan dua arah resmi antara Guru BK dan peserta didik.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-bold bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-[#5AE39D] border border-primary-200/80 dark:border-primary-900 whitespace-nowrap shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Saluran Aktif
                            </span>
                            <span class="inline-flex items-center text-xs font-mono font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-xl whitespace-nowrap shrink-0">
                                {{ $report->messages->count() }} Pesan
                            </span>
                        </div>
                    </div>

                    {{-- Informasi Privasi Pesan jika Pelapor Rahasia --}}
                    @if($report->is_hidden_identity)
                        <div class="px-4 py-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 flex items-center justify-between gap-3 text-xs text-slate-600 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Pelapor memilih <strong>identitas rahasia</strong>. Jagalah kerahasiaan identitas siswa dalam percakapan.</span>
                            </div>
                            @if(!$identityRevealed)
                                <span class="text-[10px] uppercase font-bold tracking-wider text-primary-700 dark:text-[#5AE39D] bg-primary-100/60 dark:bg-primary-950/80 px-2 py-0.5 rounded-md shrink-0">Anonim</span>
                            @else
                                <span class="text-[10px] uppercase font-bold tracking-wider text-amber-700 dark:text-[#FAD46B] bg-amber-100/60 dark:bg-amber-950/80 px-2 py-0.5 rounded-md shrink-0">Identitas Terbuka</span>
                            @endif
                        </div>
                    @endif

                    {{-- Area Pesan Chat (Scrollable Feed) --}}
                    <div class="bg-slate-50/70 dark:bg-[#0E1713]/70 rounded-2xl p-4 sm:p-5 border border-slate-200/80 dark:border-slate-800/80 max-h-[460px] overflow-y-auto space-y-4 scrollbar-thin">
                        @forelse($report->messages as $msg)
                            @php
                                $isSiswa = ($msg->sender_role ?? $msg->sender?->role) === 'siswa';
                                $senderDisplayName = $isSiswa
                                    ? (($report->is_hidden_identity && !$identityRevealed) ? 'Pelapor Rahasia' : ($msg->sender?->name ?? 'Siswa Pelapor'))
                                    : ($msg->sender?->name ?? 'Guru BK');
                                $userInitial = mb_substr($senderDisplayName, 0, 1);
                            @endphp

                            @if(!$isSiswa)
                                {{-- ── PESAN KELUAR: Guru BK (Kanan / Right Aligned) ── --}}
                                <div class="flex items-end justify-end gap-2 sm:gap-2.5 max-w-[85%] sm:max-w-[75%] ml-auto group">
                                    <div class="flex flex-col items-end max-w-full">
                                        <div class="flex items-center gap-1.5 mb-1 px-1">
                                            <span class="text-[11px] font-bold text-primary-700 dark:text-[#5AE39D]">
                                                {{ $senderDisplayName }}
                                            </span>
                                            <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500">
                                                (Konselor)
                                            </span>
                                        </div>

                                        {{-- Bubble Guru BK (Ketat Menyesuaikan Teks Singkat/Panjang) --}}
                                        <div class="w-fit max-w-full bg-primary-600 dark:bg-primary-700 text-white rounded-2xl rounded-br-xs px-3.5 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm shadow-xs leading-snug break-words text-justify">{!! nl2br(e(trim($msg->message))) !!}</div>

                                        {{-- Waktu --}}
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5 px-1">
                                            {{ $msg->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>

                                    {{-- Avatar Guru BK --}}
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-primary-700 dark:bg-primary-800 text-white flex items-center justify-center shrink-0 shadow-xs font-bold text-xs ring-2 ring-primary-100 dark:ring-primary-950 mb-3.5" title="{{ $senderDisplayName }} (Guru BK)">
                                        <span>{{ $userInitial }}</span>
                                    </div>
                                </div>
                            @else
                                {{-- ── PESAN MASUK: Siswa Pelapor (Kiri / Left Aligned) ── --}}
                                <div class="flex items-end justify-start gap-2 sm:gap-2.5 max-w-[85%] sm:max-w-[75%] mr-auto group">
                                    {{-- Avatar Siswa --}}
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full {{ ($report->is_hidden_identity && !$identityRevealed) ? 'bg-slate-300 dark:bg-slate-700 text-slate-700 dark:text-slate-200' : 'bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-100' }} flex items-center justify-center shrink-0 shadow-2xs font-bold text-xs mb-3.5" title="{{ $senderDisplayName }}">
                                        @if($report->is_hidden_identity && !$identityRevealed)
                                            <svg class="w-4 h-4 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        @else
                                            <span>{{ $userInitial }}</span>
                                        @endif
                                    </div>

                                    <div class="flex flex-col items-start max-w-full">
                                        <div class="flex items-center gap-1.5 mb-1 px-1">
                                            <span class="text-[11px] font-bold text-slate-900 dark:text-slate-100">
                                                {{ $senderDisplayName }}
                                            </span>
                                            <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400">
                                                (Siswa Pelapor)
                                            </span>
                                        </div>

                                        {{-- Bubble Siswa (Ketat Menyesuaikan Teks Singkat/Panjang) --}}
                                        <div class="w-fit max-w-full bg-white dark:bg-[#1A2620] text-slate-900 dark:text-slate-100 rounded-2xl rounded-bl-xs px-3.5 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm shadow-2xs border border-slate-200/90 dark:border-slate-800 leading-snug break-words text-justify">{!! nl2br(e(trim($msg->message))) !!}</div>

                                        {{-- Waktu --}}
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5 px-1">
                                            {{ $msg->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            {{-- Empty State Ramah --}}
                            <div class="py-10 px-4 text-center flex flex-col items-center justify-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100">Belum Ada Komunikasi Tertulis</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm leading-relaxed">
                                    Mulai percakapan resmi untuk memberikan instruksi konseling, menanyakan saksi/bukti tambahan, atau memberikan pesan dukungan psikologis kepada siswa.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Template Respons Cepat Konselor (Quick Template Chips) --}}
                    <div class="space-y-1.5 pt-1">
                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Template Respon Cepat Konselor:</span>
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            <button type="button" 
                                    @click="setTemplate('Halo, laporanmu sudah kami baca dengan seksama. Mohon tetap tenang dan merasa aman, tim Guru BK segera menindaklanjuti kasus ini.')"
                                    class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                💬 Konfirmasi Diterima &amp; Ditenangkan
                            </button>
                            <button type="button" 
                                    @click="setTemplate('Silakan hadir ke ruang BK saat jam istirahat sekolah untuk sesi pendampingan dan konseling secara langsung bersama Guru BK.')"
                                    class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                📅 Undangan ke Ruang BK
                            </button>
                            <button type="button" 
                                    @click="setTemplate('Apakah kamu memiliki informasi tambahan seperti nama saksi atau bukti pendukung yang belum sempat diceritakan sebelumnya?')"
                                    class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                🔍 Permintaan Keterangan Tambahan
                            </button>
                            <button type="button" 
                                    @click="setTemplate('Proses mediasi dan penanganan telah berjalan dengan baik. Jika ada hal yang membuatmu merasa tidak nyaman lagi, segera hubungi Guru BK ya.')"
                                    class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                ✅ Pemantauan Pasca-Penanganan
                            </button>
                        </div>
                    </div>

                    {{-- Form Kirim Balasan Baru --}}
                    <form method="POST" action="{{ route('bk.reports.messages.store', $report) }}" class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-3">
                        @csrf
                        <div>
                            <label for="message-input" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Tulis Pesan / Instruksi ke Siswa Pelapor
                            </label>
                            <textarea id="message-input" name="message" rows="3" required x-model="message"
                                placeholder="Ketikkan arahan resmi, jadwal konseling, atau pesan perkembangan kasus..." 
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-2xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition leading-relaxed shadow-2xs"></textarea>
                            @error('message')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400">
                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Pesan akan muncul langsung di portal siswa dan notifikasi sistem.</span>
                            </div>

                            <div class="flex items-center gap-2 self-stretch sm:self-auto justify-end">
                                <button type="button" 
                                        x-show="message.length > 0" 
                                        @click="message = ''" 
                                        class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition cursor-pointer" 
                                        style="display: none;">
                                    Bersihkan
                                </button>
                                <button type="submit" 
                                        class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 min-h-[42px] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl transition shadow-xs cursor-pointer active:scale-[0.98]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    <span>Kirim Balasan Resmi</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Kolom Kanan: Identitas Pelapor, Ubah Status, Urgensi, Timeline (1/3) --}}
            <div class="flex flex-col gap-6">
                {{-- Kartu Identitas Pelapor --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 pb-2 border-b border-slate-100 dark:border-slate-800">
                        Identitas Pelapor
                    </h2>

                    @if($report->is_hidden_identity)
                        @if($identityRevealed)
                            {{-- Identitas Telah Dibuka pada Sesi Ini --}}
                            <div class="space-y-3">
                                <div class="p-3 bg-amber-50/80 dark:bg-[#261A05] border border-amber-300 dark:border-amber-800/80 rounded-xl text-xs text-amber-900 dark:text-[#FAD46B]">
                                    <div class="font-bold flex items-center gap-1.5 mb-0.5">
                                        <svg class="w-4 h-4 text-amber-700 dark:text-[#FAD46B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Identitas Terbuka (Audit Aktif)</span>
                                    </div>
                                    <p class="leading-relaxed">Akses identitas pelapor rahasia ini telah dibuka dan dicatat dalam log audit keamanan sistem.</p>
                                </div>

                                <div class="space-y-2 text-xs sm:text-sm pt-1">
                                    <div>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Nama Siswa:</span>
                                        <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter?->name ?? 'Akun telah dihapus' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 block">NIS / ID Siswa:</span>
                                        <span class="font-mono font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter?->login_id ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Kelas Saat Melapor:</span>
                                        <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter_class_name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Identitas Masih Disembunyikan --}}
                            <div class="space-y-3.5">
                                <div class="p-4 bg-slate-50/80 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl text-center space-y-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-primary-50 dark:bg-primary-950/60 text-primary-800 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900">
                                        <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Pelapor Rahasia
                                    </span>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                        Siswa memilih menyembunyikan namanya. Identitas disamarkan demi melindungi privasi dan rasa aman siswa.
                                    </p>
                                </div>

                                <div class="space-y-1.5 text-xs text-slate-600 dark:text-slate-400">
                                    <div>Kelas: <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter_class_name ?? '-' }}</span></div>
                                    <div>Peran: <span class="font-bold text-slate-900 dark:text-slate-100 capitalize">{{ $report->reporter_role }}</span></div>
                                </div>

                                {{-- Tombol Buka Identitas dengan Konfirmasi --}}
                                <form method="POST" action="{{ route('bk.reports.reveal-identity', $report) }}" 
                                      onsubmit="return confirm('Tindakan membuka identitas pelapor rahasia akan dicatat ke dalam log audit keamanan sistem demi menjaga kerahasiaan siswa. Apakah Anda yakin ingin membuka identitas pelapor sekarang?');">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 min-h-[42px] bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer active:scale-[0.98]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Buka Identitas Pelapor</span>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        {{-- Lapor Terbuka --}}
                        <div class="space-y-2 text-xs sm:text-sm">
                            <div>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Nama Siswa:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter?->name ?? $report->reporter_display_name }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block">NIS / ID Siswa:</span>
                                <span class="font-mono font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter?->login_id ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Kelas:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter_class_name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Peran:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-100 capitalize">{{ $report->reporter_role }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Ubah Status Laporan (Sesuai StatusUpdatePanel.tsx) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Tindak Lanjut Kasus
                        </h2>
                        <span class="text-xs font-mono font-bold text-slate-400 dark:text-slate-500">
                            #{{ substr($report->id, 0, 8) }}
                        </span>
                    </div>

                    @if ($report->status === 'selesai')
                        <div class="p-4 rounded-xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800/60 text-center space-y-2.5">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/60 text-emerald-700 dark:text-[#5AE39D] flex items-center justify-center mx-auto shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-600 text-white shadow-2xs mb-1">
                                    Kasus Selesai
                                </span>
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100">
                                    Penanganan kasus telah ditandai selesai.
                                </p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                                    Status kasus ini bersifat final dan tidak dapat diperbarui lagi.
                                </p>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('bk.reports.update-status', $report) }}" 
                              x-data="{ currentStatus: '{{ old('status', $report->status) }}' }" 
                              class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="status_select" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Perbarui Status</label>
                                <div class="relative">
                                    <select id="status_select" name="status" x-model="currentStatus"
                                        class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[42px] cursor-pointer">
                                        <option value="baru">Baru</option>
                                        <option value="diverifikasi">Sudah dibaca (Diverifikasi)</option>
                                        <option value="diproses">Sedang ditangani (Diproses)</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="ditolak">Tidak dapat diproses (Ditolak)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('status')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alasan Wajib Jika Ditolak --}}
                            <div x-show="currentStatus === 'ditolak'" style="display: none;" class="space-y-1">
                                <label for="reject_reason" class="block text-xs font-bold text-rose-700 dark:text-rose-400">
                                    Alasan Tidak Dapat Diproses <span class="text-rose-600">*</span>
                                </label>
                                <textarea id="reject_reason" name="reject_reason" rows="3"
                                    placeholder="Jelaskan alasan yang sopan dan mendidik mengapa laporan ini belum dapat diproses..." 
                                    class="w-full px-3 py-2 text-xs sm:text-sm border border-rose-300 dark:border-rose-800 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500">{{ old('reject_reason', $report->reject_reason) }}</textarea>
                                @error('reject_reason')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 min-h-[42px] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Perbarui Status Laporan</span>
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Tingkat Urgensi Kasus (FR-27) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 pb-2 border-b border-slate-100 dark:border-slate-800">
                        Tingkat Urgensi Kasus
                    </h2>

                    <form method="POST" action="{{ route('bk.reports.update-urgency', $report) }}" class="space-y-3.5">
                        @csrf
                        @method('PUT')

                        <div>
                            <div class="relative">
                                <select id="urgency_select" name="urgency" 
                                    class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[42px] cursor-pointer">
                                    <option value="rendah" {{ old('urgency', $report->urgency) === 'rendah' ? 'selected' : '' }}>Rendah (Perselisihan ringan)</option>
                                    <option value="sedang" {{ old('urgency', $report->urgency) === 'sedang' ? 'selected' : '' }}>Sedang (Ejekan berulang / verbal)</option>
                                    <option value="tinggi" {{ old('urgency', $report->urgency) === 'tinggi' ? 'selected' : '' }}>Tinggi (Kekerasan fisik / intimidasi)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('urgency')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Status saat ini: 
                                <span class="font-bold {{ $report->urgency === 'tinggi' ? 'text-rose-600 dark:text-rose-400' : ($report->urgency === 'sedang' ? 'text-amber-600 dark:text-[#FAD46B]' : 'text-slate-600 dark:text-slate-300') }} capitalize">
                                    {{ $report->urgency }}
                                </span>
                            </span>
                            <button type="submit" 
                                    class="px-4 py-2 min-h-[38px] inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer active:scale-[0.98]">
                                Simpan Urgensi
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Riwayat Status Laporan (Timeline Sesuai Timeline.tsx) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 pb-2 border-b border-slate-100 dark:border-slate-800">
                        Riwayat Perubahan Status
                    </h2>

                    @if($report->statusHistories->count() > 0)
                        <ol class="relative flex flex-col gap-0" aria-label="Riwayat status penanganan">
                            @foreach($report->statusHistories as $history)
                                @php
                                    $isLast = $loop->last;
                                @endphp
                                <li class="relative flex gap-3">
                                    @if(!$isLast)
                                        <div class="absolute left-[11px] top-6 bottom-0 w-0.5 bg-primary-500/50 dark:bg-emerald-700/60" aria-hidden="true"></div>
                                    @endif

                                    <div class="shrink-0 mt-0.5 z-10">
                                        <div class="w-6 h-6 rounded-full bg-primary-600 text-white flex items-center justify-center shadow-2xs">
                                            <svg class="w-3 h-3 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </div>

                                    <div class="pb-4 flex-1 min-w-0 {{ $isLast ? 'pb-0' : '' }}">
                                        <p class="text-xs font-bold text-slate-900 dark:text-slate-100 capitalize">
                                            {{ $history->to_status_label ?? $history->to_status }}
                                        </p>
                                        <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ $history->created_at->format('d/m/Y H:i') }} WIB
                                        </p>
                                        @if($history->changer)
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Oleh: {{ $history->changer->name }}</p>
                                        @endif
                                        @if($history->reason)
                                            <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-1 p-2 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-lg leading-snug">
                                                {{ $history->reason }}
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                            Belum ada riwayat status.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
