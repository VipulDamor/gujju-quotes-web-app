@extends('admin.layout')

@section('page_title', 'Quotes Collection')

@section('content')
<div class="flex flex-col md:flex-row gap-4 md:gap-6 justify-between items-center mb-8 md:mb-10">
    <form action="{{ route('admin.quotes.index') }}" method="GET" class="w-full md:w-96 relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search quotes..."
               class="w-full bg-white border-gray-100 rounded-xl md:rounded-2xl px-12 py-3 md:py-4 text-sm font-bold shadow-sm focus:ring-2 focus:ring-accent/10 focus:border-[#4F0C2A] transition-all outline-none">
        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </form>

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.quotes.bulk.create') }}" class="bg-white border border-gray-100 text-[#4F0C2A] px-8 py-3 md:py-4 rounded-xl md:rounded-2xl font-black text-xs md:text-sm uppercase tracking-widest shadow-sm hover:bg-gray-50 transition-all text-center">
            Bulk Upload
        </a>
        <a href="{{ route('admin.quotes.create') }}"
           class="bg-[#4F0C2A] text-white px-8 py-3 md:py-4 rounded-xl md:rounded-2xl font-black text-xs md:text-sm uppercase tracking-widest shadow-xl shadow-[#4F0C2A]/20 hover:scale-[1.02] transition-all text-center">
            + Add Quote
        </a>
    </div>
</div>

<div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto custom-scroll">
        <table class="w-full text-left min-w-[600px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 md:px-10 py-4 md:py-5 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400">Quote Content</th>
                    <th class="px-6 md:px-10 py-4 md:py-5 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400">Category</th>
                    <th class="px-6 md:px-10 py-4 md:py-5 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($quotes as $quote)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 md:px-10 py-4 md:py-6">
                            <p class="text-sm md:text-base text-gray-900 font-bold leading-relaxed max-w-lg lg:max-w-2xl">"{{ $quote->quote }}"</p>
                        </td>
                        <td class="px-6 md:px-10 py-4 md:py-6">
                            <span class="inline-block px-3 md:px-4 py-1 md:py-1.5 bg-[#F797B6]/10 text-[#4F0C2A] rounded-full text-[8px] md:text-[10px] font-black uppercase tracking-widest whitespace-nowrap">
                                {{ $quote->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="px-6 md:px-10 py-4 md:py-6 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2 md:gap-4">
                                <a href="{{ route('admin.quotes.edit', $quote->id) }}" class="p-2 text-gray-400 hover:text-blue-600 transition active:scale-90">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST" onsubmit="return confirm('Delete this quote forever?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition active:scale-90">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 flex flex-col items-center gap-4">
    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
        Showing {{ $quotes->firstItem() }} to {{ $quotes->lastItem() }} of {{ $quotes->total() }} Quotes
    </div>
    <div class="w-full flex justify-center">
        {{ $quotes->links() }}
    </div>
</div>
@endsection
