<x-layouts.app title="Notifikasi Saya">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-3xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Header Halaman ───────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    Notifikasi Pemberitahuan
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Pembaruan status laporan, respon konseling, dan aktivitas akun di SIPERKA.
                </p>
            </div>

            @if(auth()->user()->unreadNotificationsCount() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 min-h-[44px] rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Tandai Semua Dibaca</span>
                    </button>
                </form>
            @endif
        </div>

        {{-- ── Daftar Notifikasi ────────────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
            @if($notifications->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($notifications as $notif)
                        @php
                            $isRead = $notif->isRead();
                        @endphp
                        <a href="{{ route('notifications.read', $notif) }}" 
                           class="block p-4 sm:p-5 transition hover:bg-slate-50/80 dark:hover:bg-slate-900/40 {{ $isRead ? 'bg-white dark:bg-[#16231D]' : 'bg-primary-50/50 dark:bg-primary-950/20' }}">
                            <div class="flex items-start gap-3.5">
                                {{-- Ikon Tipe --}}
                                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center {{ $isRead ? 'bg-slate-100 dark:bg-slate-800 text-slate-500' : 'bg-primary-100 dark:bg-primary-950/80 text-primary-700 dark:text-[#5AE39D]' }}">
                                    @if($notif->type === 'report_created')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @elseif($notif->type === 'status_updated')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @elseif($notif->type === 'message_received')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    @endif
                                </div>

                                {{-- Isi Konten Notifikasi --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <h2 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 truncate">
                                            {{ $notif->title }}
                                        </h2>
                                        @if(!$isRead)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-600 text-white shrink-0">
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                        {{ $notif->message }}
                                    </p>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1.5 block">
                                        {{ $notif->created_at->diffForHumans() }} ({{ $notif->created_at->format('d M Y, H:i') }} WIB)
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($notifications->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @else
                <div class="p-8 sm:p-12 text-center flex flex-col items-center justify-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-slate-100">Belum Ada Pemberitahuan</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">
                        Pemberitahuan resmi terkait perkembangan laporan dan pesan konseling akan muncul di sini.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
