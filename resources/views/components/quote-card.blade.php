@props(['quote', 'color' => null])

@php
    $colors = [
        '#1DB954', '#0288D1', '#FF5722', '#7B1FA2', '#FFC107',
        '#00796B', '#795548', '#303F9F', '#D32F2F', '#388E3C',
        '#3F51B5', '#F57C00', '#512DA8', '#009688', '#8BC34A',
        '#2196F3', '#673AB7', '#00BCD4', '#E91E63', '#F44336'
    ];
    $bgColor = $color ?? $colors[array_rand($colors)];
@endphp

<div class="rounded-2xl p-6 shadow-material flex flex-col justify-between transition-transform duration-300 hover:scale-[1.02] group cursor-pointer relative"
     style="background-color: {{ $bgColor }}; color: white;"
     onclick="window.location.href='{{ route('quotes.show', $quote->id) }}'">
    <div class="mb-4">
        <p class="text-lg font-medium leading-relaxed italic group-hover:underline decoration-white/30 underline-offset-4">
            "{{ $quote->quote }}"
        </p>
    </div>
    <div class="flex justify-between items-center mt-4">
        <span class="text-xs opacity-75 uppercase tracking-wider font-semibold">
            {{ $quote->category->name ?? 'Quote' }}
        </span>
        <div class="flex gap-3 relative z-20">
            <button onclick="event.stopPropagation(); copyQuote('{{ addslashes($quote->quote) }}')" class="hover:opacity-100 opacity-80 transition p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
            </button>
            <button onclick="event.stopPropagation(); shareQuote('{{ addslashes($quote->quote) }}')" class="hover:opacity-100 opacity-80 transition p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 100-2.684 3 3 0 000 2.684zm0 12.684a3 3 0 100-2.684 3 3 0 000 2.684z" /></svg>
            </button>
        </div>
    </div>
</div>
