@extends('admin.layout')

@section('page_title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <!-- Stat Card -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Total Quotes</p>
            <h3 class="text-4xl font-black text-gray-900 leading-none">{{ number_format($stats['total_quotes']) }}</h3>
        </div>
        <div class="w-14 h-14 bg-[#4F0C2A]/5 text-[#4F0C2A] rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Categories</p>
            <h3 class="text-4xl font-black text-gray-900 leading-none">{{ $stats['total_categories'] }}</h3>
        </div>
        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Active Reports</p>
            <h3 class="text-4xl font-black text-red-600 leading-none">{{ $stats['total_reports'] }}</h3>
        </div>
        <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition animate-pulse">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-100 flex items-center justify-between">
        <h4 class="text-lg font-black text-gray-900 tracking-tight">Recently Added Quotes</h4>
        <a href="{{ route('admin.quotes.index') }}" class="text-[10px] font-black uppercase tracking-widest text-[#4F0C2A] hover:underline">View All Quotes →</a>
    </div>
    <div class="p-10">
        <div class="space-y-6">
            @forelse($stats['recent_quotes'] as $quote)
                <div class="flex items-center gap-6 p-4 hover:bg-gray-50 rounded-2xl transition text-left">
                    <div class="w-2 h-12 bg-[#F797B6] rounded-full"></div>
                    <div class="flex-1">
                        <p class="text-gray-900 font-bold leading-relaxed line-clamp-1">"{{ $quote->quote }}"</p>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">{{ $quote->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="text-xs text-gray-300 font-bold italic">ID: {{ $quote->id }}</div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-10 font-bold italic">No quotes found in database.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
