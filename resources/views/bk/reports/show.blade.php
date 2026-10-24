<x-layouts.app :title="'Laporan #LAP-' . str_pad($report->id, 4, '0', STR_PAD_LEFT)">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Tombol Kembali & Header Status ───────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <a href="{{ route('bk.reports.index') }}" 
                   class="p-2 min-h-[44px] min-w-[44px] inline-flex items-center justify-center text-slate-500 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition"
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
                    <div class="text-emerald-700 dark:text-[#5AE39D] font-bold mt-0.5">Ditutup: {{ $report->closed_at->format('d M Y, H:i') }} WIB</div>
                @endif
            </div>
        </div>

        {{-- ── Layout 2 Kolom (Kiri: Kasus & Komunikasi, Kanan: Identitas & Aksi) ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri / Utama --}}
            <div class="lg:col-span-2 flex flex-col gap-6">
                {{-- Kartu Kronologi & Detail Kejadian --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-5">
                    <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                            Kronologi Kejadian Siswa
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Rincian aduan yang disampaikan langsung oleh peserta didik.
                        </p>
                    </div>

                    {{-- Ringkasan Parameter Kejadian --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 p-4 bg-slate-50/80 dark:bg-slate-900/50 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs sm:text-sm">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Waktu Kejadian</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 mt-1 block">
                                {{ $report->incident_date?->translatedFormat('d F Y') ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Tempat / Lokasi</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 mt-1 block">
                                {{ $report->location }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Peran Pelapor</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 mt-1 block capitalize">
                                {{ $report->reporter_role === 'korban' ? 'Korban Langsung' : 'Saksi yang Mengetahui' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Nama / Pihak Terlapor</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 mt-1 block">
                                {{ $report->accused_name ?: 'Tidak disebutkan oleh pelapor' }}
                            </span>
                        </div>
                    </div>

                    {{-- Penjelasan Kronologi --}}
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-2">Penjelasan Kronologi:</span>
                        <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs sm:text-sm leading-relaxed text-slate-900 dark:text-slate-100 whitespace-pre-wrap">
                            {{ $report->description }}
                        </div>
                    </div>

                    {{-- Berkas Bukti Lampiran --}}
                    <div class="pt-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-2">
                            Bukti Lampiran ({{ $report->attachments->count() }}):
                        </span>
                        @if($report->attachments->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($report->attachments as $att)
                                    <div class="flex items-center justify-between p-3 bg-slate-50/70 dark:bg-slate-900/50 border border-slate-200/80 dark:border-slate-800 rounded-xl text-xs sm:text-sm">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100/70 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 dark:text-slate-100 truncate text-xs" title="{{ $att->original_name }}">
                                                    {{ $att->original_name }}
                                                </p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $att->formatted_size }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('bk.reports.attachment', [$report, $att]) }}" target="_blank"
                                           class="shrink-0 inline-flex items-center gap-1 px-3 py-1.5 min-h-[36px] text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:bg-primary-50 dark:hover:bg-primary-950/50 rounded-lg transition">
                                            <span>Buka</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                                Tidak ada berkas bukti yang dilampirkan pada laporan ini.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Catatan Internal Guru BK (Rahasia - Tidak Pernah Terlihat Siswa) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4">
                    <div class="pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                                    Catatan Internal Guru BK
                                </h2>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-[#FAD46B] border border-amber-300 dark:border-amber-800">
                                    Rahasia
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Catatan konseling, pemanggilan, atau mediasi. Catatan ini RAHASIA dan tidak dapat dibaca oleh siswa.
                            </p>
                        </div>
                    </div>

                    {{-- Form Tambah Catatan Internal --}}
                    <form method="POST" action="{{ route('bk.reports.notes.store', $report) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label for="note" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tambah Catatan Konseling</label>
                            <textarea id="note" name="note" rows="3" required 
                                placeholder="Tuliskan catatan tindak lanjut, hasil mediasi, atau rencana pendampingan..." 
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition leading-relaxed"></textarea>
                            @error('note')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 min-h-[40px] bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold rounded-xl transition card-hover shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                <span>Simpan Catatan Internal</span>
                            </button>
                        </div>
                    </form>

                    {{-- Riwayat Catatan Internal --}}
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Riwayat Catatan Internal:</span>
                        @if($report->notes->count() > 0)
                            <div class="space-y-2.5">
                                @foreach($report->notes as $note)
                                    <div class="p-3.5 bg-amber-50/70 dark:bg-[#261A05] border border-amber-200/80 dark:border-amber-900/60 rounded-xl text-xs sm:text-sm">
                                        <div class="flex items-center justify-between text-xs text-amber-900 dark:text-[#FAD46B] font-bold mb-1">
                                            <span>{{ $note->user?->name ?? 'Guru BK' }}</span>
                                            <span class="font-mono text-amber-700/80 dark:text-amber-400/80 text-[11px]">{{ $note->created_at->format('d M Y, H:i') }} WIB</span>
                                        </div>
                                        <div class="text-slate-900 dark:text-slate-100 text-xs sm:text-sm whitespace-pre-wrap leading-relaxed">
                                            {{ $note->note }}
                                        </div>
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

                {{-- Balasan Resmi ke Siswa Pelapor --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4">
                    <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                            Balasan Resmi ke Siswa Pelapor
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Pesan atau arahan resmi dari Guru BK yang akan muncul di halaman detail laporan peserta didik.
                        </p>
                    </div>

                    {{-- Daftar Riwayat Pesan --}}
                    @if($report->messages->count() > 0)
                        <div class="space-y-3">
                            @foreach($report->messages as $msg)
                                @php
                                    $isSiswa = ($msg->sender_role ?? $msg->sender?->role) === 'siswa';
                                    $senderLabel = $isSiswa
                                        ? (($report->is_hidden_identity && !$identityRevealed) ? 'Pelapor Rahasia' : ($msg->sender?->name ?? 'Siswa Pelapor'))
                                        : ($msg->sender?->name ?? 'Guru BK');
                                @endphp
                                <div class="p-3.5 rounded-xl border {{ !$isSiswa ? 'bg-primary-50/80 dark:bg-primary-950/40 border-primary-200 dark:border-primary-900 ml-2 sm:ml-6' : 'bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 mr-2 sm:mr-6' }}">
                                    <div class="flex items-center justify-between text-xs font-bold mb-1 {{ !$isSiswa ? 'text-primary-800 dark:text-[#5AE39D]' : 'text-slate-700 dark:text-slate-300' }}">
                                        <span>{{ $senderLabel }} ({{ !$isSiswa ? 'Guru BK' : 'Pelapor' }})</span>
                                        <span class="font-mono text-slate-500 dark:text-slate-400 text-[11px]">{{ $msg->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-900 dark:text-slate-100 whitespace-pre-wrap leading-relaxed">
                                        {{ $msg->message }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                            Belum ada pesan resmi yang dikirimkan ke siswa.
                        </p>
                    @endif

                    {{-- Form Kirim Balasan Baru --}}
                    <form method="POST" action="{{ route('bk.reports.messages.store', $report) }}" class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-3">
                        @csrf
                        <div>
                            <label for="message" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tulis Balasan / Arahan ke Siswa</label>
                            <textarea id="message" name="message" rows="3" required 
                                placeholder="Ketikkan pesan dukungan, arahan jadwal konseling, atau informasi perkembangan penanganan..." 
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition leading-relaxed"></textarea>
                            @error('message')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 min-h-[40px] bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold rounded-xl transition card-hover shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span>Kirim Balasan ke Siswa</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Kolom Kanan: Identitas Pelapor, Ubah Status, Urgensi, Timeline --}}
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
                                        <span>Identitas Terbuka (Audit Log Aktif)</span>
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
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 min-h-[42px] bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white text-xs font-bold rounded-xl shadow-xs transition">
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

                {{-- Ubah Status Laporan (FR-23) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 pb-2 border-b border-slate-100 dark:border-slate-800">
                        Ubah Status Penanganan
                    </h2>

                    <form method="POST" action="{{ route('bk.reports.update-status', $report) }}" 
                          x-data="{ currentStatus: '{{ old('status', $report->status) }}' }" 
                          class="space-y-3.5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status_select" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Status Baru</label>
                            <select id="status_select" name="status" x-model="currentStatus"
                                class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition min-h-[42px]">
                                <option value="baru">Baru</option>
                                <option value="diverifikasi">Sudah dibaca (Diverifikasi)</option>
                                <option value="diproses">Sedang ditangani (Diproses)</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Tidak dapat diproses (Ditolak)</option>
                            </select>
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

                        {{-- Catatan Opsional untuk Riwayat --}}
                        <div x-show="currentStatus !== 'ditolak'" class="space-y-1">
                            <label for="status_note" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                Catatan Riwayat (Opsional)
                            </label>
                            <input type="text" id="status_note" name="status_note" 
                                placeholder="Contoh: Telah memanggil pelapor ke ruang BK" 
                                class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600">
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 min-h-[44px] bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold rounded-xl shadow-xs transition card-hover">
                            <span>Perbarui Status Laporan</span>
                        </button>
                    </form>
                </div>

                {{-- Tingkat Urgensi Kasus (FR-27) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-3.5">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 pb-2 border-b border-slate-100 dark:border-slate-800">
                        Tingkat Urgensi Kasus
                    </h2>

                    <form method="POST" action="{{ route('bk.reports.update-urgency', $report) }}" class="space-y-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <select id="urgency_select" name="urgency" 
                                class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition min-h-[44px]">
                                <option value="rendah" {{ old('urgency', $report->urgency) === 'rendah' ? 'selected' : '' }}>Rendah (Perselisihan ringan)</option>
                                <option value="sedang" {{ old('urgency', $report->urgency) === 'sedang' ? 'selected' : '' }}>Sedang (Ejekan berulang / sosial)</option>
                                <option value="tinggi" {{ old('urgency', $report->urgency) === 'tinggi' ? 'selected' : '' }}>Tinggi (Kekerasan fisik / pemalakan)</option>
                            </select>
                            @error('urgency')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Saat ini: 
                                <span class="font-bold {{ $report->urgency === 'tinggi' ? 'text-rose-600 dark:text-rose-400' : ($report->urgency === 'sedang' ? 'text-amber-600 dark:text-[#FAD46B]' : 'text-slate-600 dark:text-slate-300') }} capitalize">
                                    {{ $report->urgency }}
                                </span>
                            </span>
                            <button type="submit" class="px-4 py-2 min-h-[44px] inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                                Simpan Urgensi
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Riwayat Status Laporan (Timeline) --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs space-y-3">
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
                                        <div class="absolute left-[11px] top-6 bottom-0 w-0.5 bg-primary-500/70 dark:bg-emerald-700" aria-hidden="true"></div>
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
