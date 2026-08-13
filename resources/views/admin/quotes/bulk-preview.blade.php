@extends('admin.layout')

@section('page_title', 'Verify Bulk Quotes')

@section('content')
<div class="max-w-5xl text-left">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-1 italic">Scan Results</h3>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">
                Found <span id="quote-count" class="text-[#4F0C2A]">{{ count($quotes) }}</span> quotes for category: <span class="text-[#4F0C2A]">{{ $category->name }}</span>
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.quotes.bulk.create') }}" class="px-6 py-3 border border-gray-200 rounded-xl text-xs font-black uppercase tracking-widest text-gray-400 hover:bg-gray-50 transition">
                ← Start Over
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 w-20">#</th>
                        <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Quote Content</th>
                        <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 w-32 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="preview-body">
                    @foreach($quotes as $index => $quoteData)
                        <tr class="hover:bg-gray-50 transition group" id="row-{{ $index }}">
                            <td class="px-10 py-6 text-xs font-black text-gray-300">
                                @if(isset($quoteData['line']))
                                    L{{ $quoteData['line'] }}
                                @else
                                    #{{ $index + 1 }}
                                @endif
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

    <form action="{{ route('admin.quotes.bulk.store') }}" method="POST" id="publish-form">
        @csrf
        <button type="submit" id="submit-btn" class="w-full bg-[#4F0C2A] text-white py-6 rounded-[2.5rem] font-black text-lg uppercase tracking-widest shadow-2xl shadow-[#4F0C2A]/30 hover:scale-[1.02] active:scale-95 transition-all">
            🚀 Publish Verified Quotes to {{ $category->name }}
        </button>
    </form>

    <p class="text-center mt-8 text-gray-400 text-[10px] font-black uppercase tracking-widest">
        Quotes will be instantly live on the mobile app and website after publishing.
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
