@props([
    'headers' => [],
])

<div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            @if (!empty($headers))
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-4 py-3 sm:px-6">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-slate-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
