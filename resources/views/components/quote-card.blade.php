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
        <span class="text-[10px] opacity-75 uppercase tracking-widest font-black">
            {{ $quote->category->name ?? 'Wisdom' }}
        </span>
        <div class="flex items-center gap-1.5 opacity-60 group-hover:opacity-100 transition">
             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
             <span class="text-[10px] font-black uppercase tracking-tighter">Open in App</span>
        </div>
    </div>
</div>
