@extends('admin.layout')

@section('page_title', 'Verify Bulk Quotes')

@section('content')
<div class="max-w-5xl text-left">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-1 italic">Scan Results</h3>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">
                Reviewing for category: <span class="text-[#4F0C2A]">{{ $category->name }}</span>
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.quotes.bulk.create') }}" class="px-6 py-3 border border-gray-200 rounded-xl text-xs font-black uppercase tracking-widest text-gray-400 hover:bg-gray-50 transition">
                ← Start Over
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] flex items-center justify-between group">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600 mb-1">New Unique Quotes</p>
                <h3 class="text-3xl font-black text-emerald-900 leading-none" id="quote-count">{{ count($quotes) }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>

        @if(count($duplicates) > 0)
        <div class="bg-amber-50 border border-amber-100 p-6 rounded-[2rem] flex items-center justify-between group">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-amber-600 mb-1">Duplicates Skipped</p>
                <h3 class="text-3xl font-black text-amber-900 leading-none">{{ count($duplicates) }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        @endif
    </div>

    <!-- Main Preview Table (Valid Quotes) -->
    <div class="mb-6">
        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4 px-2">Ready to Publish</h4>
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 w-20">Line</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Quote Content</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 w-32 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="preview-body">
                        @foreach($quotes as $index => $quoteData)
                            <tr class="hover:bg-gray-50 transition group" id="row-{{ $index }}">
                                <td class="px-10 py-6 text-xs font-black text-gray-300">
                                    L{{ $quoteData['line'] }}
                                </td>
                                <td class="px-10 py-6">
                                    <p class="text-gray-900 font-bold leading-relaxed">"{{ $quoteData['text'] }}"</p>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <button onclick="removeQuote({{ $index }})" class="p-2 text-gray-300 hover:text-red-500 transition active:scale-90">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Duplicate List (If Any) -->
    @if(count($duplicates) > 0)
    <div class="mb-12 opacity-60">
        <h4 class="text-xs font-black uppercase tracking-widest text-amber-500 mb-4 px-2 flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            Duplicates Identified (Will be ignored)
        </h4>
        <div class="bg-amber-50 border border-amber-100 rounded-[2rem] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-amber-100">
                        @foreach($duplicates as $dup)
                            <tr class="hover:bg-amber-100/50 transition">
                                <td class="px-10 py-4 text-xs font-black text-amber-300 w-20">L{{ $dup['line'] }}</td>
                                <td class="px-10 py-4">
                                    <p class="text-amber-800 text-sm font-medium italic">"{{ $dup['text'] }}"</p>
                                </td>
                                <td class="px-10 py-4 text-right">
                                    <span class="text-[9px] font-black uppercase bg-amber-200 text-amber-700 px-2 py-1 rounded">
                                        {{ $dup['reason'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.quotes.bulk.store') }}" method="POST" id="publish-form">
        @csrf
        <button type="submit" id="submit-btn" class="w-full bg-[#4F0C2A] text-white py-6 rounded-[2.5rem] font-black text-lg uppercase tracking-widest shadow-2xl shadow-[#4F0C2A]/30 hover:scale-[1.02] active:scale-95 transition-all">
            🚀 Publish {{ count($quotes) }} Unique Quotes to {{ $category->name }}
        </button>
    </form>

    <p class="text-center mt-8 text-gray-400 text-[10px] font-black uppercase tracking-widest">
        The system has automatically filtered out {{ count($duplicates) }} duplicates.
    </p>
</div>

<script>
    async function removeQuote(index) {
        if (!confirm('Remove this quote from the import list?')) return;

        const row = document.getElementById(`row-${index}`);
        row.style.opacity = '0.5';

        try {
            const response = await fetch('{{ route("admin.quotes.bulk.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ index: index })
            });

            const data = await response.json();
            if (data.status === 'success') {
                row.remove();
                document.getElementById('quote-count').innerText = data.count;
                document.getElementById('submit-btn').innerText = `🚀 Publish ${data.count} Unique Quotes to {{ $category->name }}`;

                if (data.count === 0) {
                    window.location.href = '{{ route("admin.quotes.bulk.create") }}';
                }
            }
        } catch (error) {
            console.error('Removal failed:', error);
            row.style.opacity = '1';
        }
    }
</script>
@endsection
