@props([
    'headers' => [],
])

<div class="w-full overflow-hidden rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-[#16231D] shadow-xs">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs sm:text-sm text-slate-900 dark:text-slate-100">
            @if (!empty($headers))
                <thead class="bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-4 py-3 sm:px-5 sm:py-3.5 whitespace-nowrap {{ $header === 'Aksi' ? 'text-center' : '' }}">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
