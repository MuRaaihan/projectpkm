@props([
    'headers' => [],
])

<div class="w-full overflow-hidden rounded-xl border border-[#CBD5E1] bg-white shadow-xs">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-[#0F172A]">
            @if (!empty($headers))
                <thead class="bg-[#F8FAFC] border-b border-[#CBD5E1] text-xs sm:text-sm font-semibold text-[#475569] uppercase tracking-wider">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-4 py-3 sm:px-6 sm:py-3.5">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-[#E2E8F0]">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
