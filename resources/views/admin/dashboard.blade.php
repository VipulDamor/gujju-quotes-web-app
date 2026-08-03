@extends('admin.layout')

@section('page_title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 mb-8 md:mb-12">
    <!-- Stat Card -->
    <div class="bg-white p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all">
        <div>
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Total Quotes</p>
            <h3 class="text-2xl md:text-4xl font-black text-gray-900 leading-none">{{ number_format($stats['total_quotes']) }}</h3>
        </div>
        <div class="w-10 h-10 md:w-14 md:h-14 bg-[#4F0C2A]/5 text-[#4F0C2A] rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
            <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all">
        <div>
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Categories</p>
            <h3 class="text-2xl md:text-4xl font-black text-gray-900 leading-none">{{ $stats['total_categories'] }}</h3>
        </div>
        <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-50 text-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
            <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all sm:col-span-2 lg:col-span-1">
        <div>
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Active Reports</p>
            <h3 class="text-2xl md:text-4xl font-black text-red-600 leading-none">{{ $stats['total_reports'] }}</h3>
        </div>
        <div class="w-10 h-10 md:w-14 md:h-14 bg-red-50 text-red-600 rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition animate-pulse">
            <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
    </div>
</div>

<div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-6 md:px-10 md:py-8 border-b border-gray-100 flex items-center justify-between">
        <h4 class="text-base md:text-lg font-black text-gray-900 tracking-tight">Recently Added Quotes</h4>
        <a href="{{ route('admin.quotes.index') }}" class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-[#4F0C2A] hover:underline">View All →</a>
    </div>
    <div class="p-4 md:p-10">
        <div class="space-y-4 md:space-y-6">
            @forelse($stats['recent_quotes'] as $quote)
                <div class="flex items-center gap-4 md:gap-6 p-3 md:p-4 hover:bg-gray-50 rounded-xl md:rounded-2xl transition text-left">
                    <div class="w-1.5 h-10 md:h-12 bg-[#F797B6] rounded-full shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm md:text-base text-gray-900 font-bold leading-relaxed truncate">"{{ $quote->quote }}"</p>
                        <p class="text-[8px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">{{ $quote->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="text-[10px] text-gray-300 font-bold italic shrink-0 whitespace-nowrap">ID: {{ $quote->id }}</div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-10 font-bold italic">No quotes found in database.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
