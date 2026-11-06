<x-layouts.app title="Detail Laporan">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-5xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- Breadcrumb & Title --}}
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('siswa.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                    Dashboard Siswa
                </a>
                <span class="text-xs text-slate-400">/</span>
                <a href="{{ route('siswa.reports.index') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                    Laporan Saya
                </a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">#LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                        Detail Laporan
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                        Diajukan pada {{ $report->created_at->format('d F Y, H:i') }} WIB
                    </p>
                </div>

                <div class="self-start sm:self-auto">
                    <x-badge :variant="$report->status" class="px-3 py-1.5 text-xs font-bold">
                        {{ $report->status_label }}
                    </x-badge>
                </div>
            </div>
        </div>

        {{-- Penjelasan jika status Ditolak --}}
        @if ($report->status === 'ditolak' && $report->reject_reason)
            <div class="p-5 rounded-2xl bg-rose-50/70 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="text-xs sm:text-sm text-rose-900 dark:text-rose-200">
                    <span class="font-bold block">Penjelasan Status "Tidak Dapat Diproses":</span>
                    <p class="mt-1 leading-relaxed">{{ $report->reject_reason }}</p>
                </div>
            </div>
        @endif

        {{-- Layout 2 Kolom (Kiri: Konten Utama, Kanan: Timeline & Privasi) --}}
        <div class="flex flex-col lg:flex-row lg:items-start gap-6">
            {{-- ── Left Column: Rincian, Kronologi, Lampiran, Komunikasi ── --}}
            <div class="flex-1 flex flex-col gap-6 min-w-0">
                {{-- Header Box: Category, Date, Location --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">
                            #LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="text-slate-300 dark:text-slate-700">•</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $report->reporter_role === 'korban' ? 'bg-amber-100/80 dark:bg-amber-950/50 text-amber-900 dark:text-[#FAD46B]' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                            {{ $report->reporter_role === 'korban' ? 'Sebagai Korban' : 'Sebagai Saksi' }}
                        </span>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                        {{ $report->category->name }}
                    </h2>

                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $report->incident_date->format('d F Y') }}
                        </span>
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $report->location }}
                        </span>
                    </div>
                </div>

                {{-- Kronologi Kejadian --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
                    <div class="border-b border-slate-100 dark:border-slate-800 px-5 sm:px-6 py-3.5 bg-slate-50/70 dark:bg-slate-900/40">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Kronologi Kejadian
                        </h3>
                    </div>
                    <div class="p-5 sm:p-6 space-y-4">
                        <p class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line">
                            {{ $report->description }}
                        </p>

                        @if ($report->accused_name)
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-1">
                                    Pihak Terlibat / Terlapor
                                </span>
                                <p class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $report->accused_name }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Lampiran Berkas Bukti --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
                    <div class="border-b border-slate-100 dark:border-slate-800 px-5 sm:px-6 py-3.5 bg-slate-50/70 dark:bg-slate-900/40 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Lampiran Bukti ({{ $report->attachments->count() }})
                        </h3>
                    </div>
                    <div class="p-5 sm:p-6">
                        @if ($report->attachments->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($report->attachments as $att)
                                    <div class="p-3 rounded-xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900/50 flex items-center justify-between gap-3 hover:border-primary-400 transition">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100/70 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="text-xs font-bold text-slate-900 dark:text-slate-100 truncate block">
                                                    {{ $att->original_name }}
                                                </span>
                                                <span class="text-[11px] text-slate-500 dark:text-slate-400 block">
                                                    {{ $att->formatted_size }}
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ route('siswa.reports.attachment', [$report, $att]) }}" target="_blank" 
                                           class="p-2.5 min-w-[44px] min-h-[44px] inline-flex items-center justify-center rounded-xl text-primary-600 dark:text-[#5AE39D] hover:bg-primary-50 dark:hover:bg-primary-950/50 transition shrink-0" 
                                           title="Buka lampiran"
                                           aria-label="Buka berkas {{ $att->original_name }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                                Tidak ada file bukti yang dilampirkan pada laporan ini.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Komunikasi & Informasi Susulan (FR-36) --}}
                <div x-data="{ 
                        message: '',
                        setTemplate(text) {
                            this.message = text;
                            $nextTick(() => {
                                const ta = document.getElementById('student-message-input');
                                if (ta) { ta.focus(); ta.style.height = 'auto'; ta.style.height = ta.scrollHeight + 'px'; }
                            });
                        }
                    }" 
                    class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4">
                    
                    {{-- Header Komunikasi --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-primary-100/80 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">
                                    Ruang Percakapan &amp; Keterangan Susulan
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Saluran komunikasi langsung, aman, dan rahasia dengan Guru BK.
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-primary-700 dark:text-[#5AE39D] border border-emerald-200/80 dark:border-[#289E70]/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ $report->messages->count() }} Pesan</span>
                        </span>
                    </div>

                    {{-- Privasi & Jaminan Keamanan --}}
                    <div class="px-3.5 py-2 rounded-xl bg-slate-100/80 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 flex items-center justify-between gap-3 text-xs text-slate-600 dark:text-slate-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Percakapan ini bersifat <strong>rahasia</strong> dan hanya dapat diakses oleh Guru BK yang menangani laporanmu.</span>
                        </div>
                        @if($report->is_hidden_identity)
                            <span class="text-[10px] uppercase font-bold tracking-wider text-primary-700 dark:text-[#5AE39D] bg-primary-100/60 dark:bg-primary-950/80 px-2 py-0.5 rounded-md shrink-0">Anonim</span>
                        @endif
                    </div>

                    {{-- Area Feed Pesan Chat --}}
                    <div class="bg-slate-50/70 dark:bg-[#0E1713]/70 rounded-2xl p-4 sm:p-5 border border-slate-200/80 dark:border-slate-800/80 max-h-[460px] overflow-y-auto space-y-4 scrollbar-thin">
                        @forelse ($report->messages as $msg)
                            @php
                                $isStudent = ($msg->sender_role ?? $msg->sender?->role) === 'siswa';
                                $senderDisplayName = $isStudent ? 'Kamu (Pelapor)' : ($msg->sender?->name ?? 'Guru BK');
                                $userInitial = mb_substr($senderDisplayName, 0, 1);
                            @endphp

                            @if($isStudent)
                                {{-- ── PESAN KELUAR: Siswa Pelapor (Kanan / Right Aligned) ── --}}
                                <div class="flex items-end justify-end gap-2 sm:gap-2.5 max-w-[85%] sm:max-w-[75%] ml-auto group">
                                    <div class="flex flex-col items-end max-w-full">
                                        <div class="flex items-center gap-1.5 mb-1 px-1">
                                            <span class="text-[11px] font-bold text-primary-700 dark:text-[#5AE39D]">
                                                Kamu
                                            </span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500">
                                                (Pelapor)
                                            </span>
                                        </div>

                                        {{-- Bubble Siswa (Ketat Menyesuaikan Teks Singkat/Panjang) --}}
                                        <div class="w-fit max-w-full bg-primary-600 dark:bg-primary-700 text-white rounded-2xl rounded-br-xs px-3.5 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm shadow-xs leading-snug break-words text-justify">{!! nl2br(e(trim($msg->message))) !!}</div>

                                        {{-- Waktu (Tanpa Tanda Centang) --}}
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5 px-1">
                                            {{ $msg->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>

                                    {{-- Avatar Siswa --}}
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-primary-700 dark:bg-primary-800 text-white flex items-center justify-center shrink-0 shadow-xs font-bold text-xs ring-2 ring-primary-100 dark:ring-primary-950 mb-3.5" title="Kamu (Siswa Pelapor)">
                                        <span>{{ auth()->check() ? mb_substr(auth()->user()->name, 0, 1) : 'S' }}</span>
                                    </div>
                                </div>
                            @else
                                {{-- ── PESAN MASUK: Guru BK (Kiri / Left Aligned) ── --}}
                                <div class="flex items-end justify-start gap-2 sm:gap-2.5 max-w-[85%] sm:max-w-[75%] mr-auto group">
                                    {{-- Avatar Guru BK --}}
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-[#5AE39D] border border-emerald-300 dark:border-[#289E70] flex items-center justify-center shrink-0 shadow-2xs font-bold text-xs mb-3.5" title="Guru BK MTs Soebono Mantofani">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>

                                    <div class="flex flex-col items-start max-w-full">
                                        <div class="flex items-center gap-1.5 mb-1 px-1">
                                            <span class="text-[11px] font-bold text-slate-900 dark:text-slate-100">
                                                {{ $senderDisplayName }}
                                            </span>
                                            <span class="text-[10px] font-semibold text-emerald-700 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60 px-1.5 py-0.5 rounded">
                                                Guru BK Resmi
                                            </span>
                                        </div>

                                        {{-- Bubble Guru BK (Ketat Menyesuaikan Teks Singkat/Panjang) --}}
                                        <div class="w-fit max-w-full bg-white dark:bg-[#1A2620] text-slate-900 dark:text-slate-100 rounded-2xl rounded-bl-xs px-3.5 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm shadow-2xs border border-slate-200/90 dark:border-slate-800 leading-snug break-words text-justify">{!! nl2br(e(trim($msg->message))) !!}</div>

                                        {{-- Waktu --}}
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5 px-1">
                                            {{ $msg->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="py-8 px-4 text-center flex flex-col items-center justify-center gap-2.5">
                                <div class="w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100">Belum Ada Pesan Masuk</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm leading-relaxed">
                                    Guru BK sedang menelaah laporanmu secara mendalam. Jika Guru BK mengirimkan arahan atau jadwal konseling, pesannya akan tampil di sini.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Form Tambah Pesan Susulan --}}
                    @if (!in_array($report->status, ['selesai', 'ditolak']))
                        {{-- Template Bantuan Siswa (Quick Suggestions) --}}
                        <div class="space-y-1.5 pt-1">
                            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Bantuan Isi Pesan Cepat:</span>
                            </span>
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button" 
                                        @click="setTemplate('Assalamu\'alaikum Bapak/Ibu Guru BK, saya ingin menambahkan bahwa ada saksi tambahan yang melihat peristiwa tersebut, yaitu...')"
                                        class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                    👥 Tambahan Saksi
                                </button>
                                <button type="button" 
                                        @click="setTemplate('Terima kasih atas tanggapannya Bapak/Ibu Guru BK, saya bersedia hadir ke ruang BK saat jam istirahat.')"
                                        class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                    ✅ Konfirmasi Siap Hadir ke BK
                                </button>
                                <button type="button" 
                                        @click="setTemplate('Kondisi saya saat ini sudah lebih tenang, terima kasih atas bantuan dan respon cepat dari Guru BK.')"
                                        class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition cursor-pointer">
                                    🌱 Kabar Kondisi Terkini
                                </button>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('siswa.reports.follow-up', $report) }}" class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-3">
                            @csrf
                            <div>
                                <label for="student-message-input" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tulis Keterangan Susulan ke Guru BK
                                </label>
                                <textarea name="message" id="student-message-input" rows="3" required minlength="3" maxlength="5000" x-model="message"
                                    placeholder="Teringat bukti baru, nama saksi tambahan, atau perkembangan terkini? Tulis dengan tenang di sini..."
                                    class="w-full text-xs sm:text-sm rounded-2xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition leading-relaxed shadow-2xs"></textarea>
                                @error('message')
                                    <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <span>Pesan hanya dapat dibaca oleh tim Guru BK berwenang.</span>
                                </div>

                                <div class="flex items-center gap-2 self-end sm:self-auto">
                                    <button type="button" 
                                            x-show="message.length > 0" 
                                            @click="message = ''" 
                                            class="px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition cursor-pointer" 
                                            style="display: none;">
                                        Bersihkan
                                    </button>
                                    <button type="submit" 
                                            class="inline-flex items-center gap-2 px-5 py-2.5 min-h-[42px] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition cursor-pointer active:scale-[0.98]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        <span>Kirim Informasi Susulan</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400 flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Laporan ini telah berstatus <strong>{{ $report->status_label }}</strong>, sehingga pengiriman pesan tambahan telah ditutup.</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Right Column: Privasi & Timeline Penanganan ── --}}
            <div class="w-full lg:w-80 flex flex-col gap-6 shrink-0">
                {{-- Status Privasi Card --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Privasi Laporan
                    </h3>
                    @if ($report->is_hidden_identity)
                        <div class="p-3.5 rounded-xl bg-primary-50/80 dark:bg-[#1A3326] border border-primary-200 dark:border-[#289E70]">
                            <p class="text-xs font-bold text-primary-900 dark:text-[#5AE39D]">
                                Identitas Dirahasiakan
                            </p>
                            <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                Namamu disamarkan sebagai "Pelapor Rahasia". Hanya Guru BK berwenang yang dapat melihat identitasmu secara aman.
                            </p>
                        </div>
                    @else
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                            <p class="text-xs font-bold text-slate-900 dark:text-slate-100">
                                Identitas Ditampilkan
                            </p>
                            <p class="text-[11px] text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">
                                Nama pelapor tercantum pada berkas pendampingan Guru BK.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Tahapan Penanganan (Timeline) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
                    <div class="border-b border-slate-100 dark:border-slate-800 px-5 py-3.5 bg-slate-50/70 dark:bg-slate-900/40">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Tahapan Penanganan
                        </h3>
                    </div>
                    <div class="p-5">
                        <ol class="relative flex flex-col gap-0" aria-label="Status penanganan laporan">
                            @foreach ($report->statusHistories as $index => $history)
                                @php
                                    $isLast = $loop->last;
                                @endphp
                                <li class="relative flex gap-3">
                                    {{-- Garis vertikal penghubung --}}
                                    @if (!$isLast)
                                        <div class="absolute left-[13px] top-7 bottom-0 w-0.5 bg-primary-500/70 dark:bg-emerald-700" aria-hidden="true"></div>
                                    @endif

                                    {{-- Titik Status --}}
                                    <div class="shrink-0 mt-0.5 z-10">
                                        <div class="w-7 h-7 rounded-full bg-primary-600 text-white flex items-center justify-center shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </div>

                                    {{-- Keterangan --}}
                                    <div class="pb-5 flex-1 min-w-0 {{ $isLast ? 'pb-0' : '' }}">
                                        <p class="text-xs font-bold text-slate-900 dark:text-slate-100 leading-tight">
                                            {{ $history->to_status_label }}
                                        </p>
                                        <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ $history->created_at->format('d/m/Y H:i') }} WIB
                                        </p>
                                        @if ($history->reason)
                                            <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-1 leading-snug">
                                                {{ $history->reason }}
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                {{-- Back button --}}
                <a href="{{ route('siswa.reports.index') }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#16231D] text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 shadow-2xs hover:shadow-xs active:scale-[0.98] transition-all text-center inline-flex items-center justify-center gap-2 group cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Riwayat Laporan</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
