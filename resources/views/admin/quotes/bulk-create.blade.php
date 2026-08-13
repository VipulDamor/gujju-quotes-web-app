@extends('admin.layout')

@section('page_title', 'Bulk Quote Upload')

@section('content')
<div class="max-w-4xl text-left">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <!-- Validation Error List -->
        @if(session('bulk_errors'))
            <div class="mb-10 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-2xl animate-fade-in">
                <div class="flex items-center gap-3 mb-4 text-red-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <p class="font-black text-xs uppercase tracking-widest">Formatting Errors Found in File</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                    @foreach(session('bulk_errors') as $error)
                        <div class="flex items-center gap-2 text-xs font-bold text-red-600 bg-white/50 px-3 py-1.5 rounded-lg border border-red-100">
                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
                <p class="mt-6 text-[10px] text-red-400 font-bold uppercase tracking-widest italic">Please fix these lines and upload again.</p>
            </div>
        @endif

        <form action="{{ route('admin.quotes.bulk.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-10">
                <!-- Step 1: Category -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-4 ml-1">Step 1: Select Category</label>
                    <select name="category_id" required
                            class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-2xl px-6 py-4 text-gray-900 font-bold transition-all outline-none appearance-none cursor-pointer">
                        <option value="">Choose a category for this batch...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="h-px bg-gray-100"></div>

                <!-- Step 2: Data Input -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Text Area Option -->
                    <div class="space-y-4">
                        <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Option A: Paste Text</label>
                        <textarea name="quotes_text" rows="8"
                                  class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-2xl px-6 py-5 text-gray-900 font-medium transition-all outline-none leading-relaxed"
                                  placeholder="Enter quotes here..."></textarea>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse"></span>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Auto-detecting: New Line, ###, or |||</p>
                        </div>
                    </div>

                    <!-- File Upload Option -->
                    <div class="space-y-4">
                        <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Option B: Upload File</label>
                        <div class="relative group">
                            <input type="file" name="quotes_file" accept=".csv,.txt"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="border-2 border-dashed border-gray-200 group-hover:border-[#F797B6] rounded-2xl p-10 flex flex-col items-center justify-center transition-colors bg-gray-50/50">
                                <svg class="w-10 h-10 text-gray-300 group-hover:text-[#F797B6] mb-4 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Click or Drag CSV/TXT</p>
                                <p class="text-[9px] text-gray-300 mt-2">Single column, no header</p>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="/demo_quotes.csv" download class="text-[10px] font-black text-[#4F0C2A] bg-[#F797B6]/20 px-4 py-2 rounded-lg hover:bg-[#F797B6]/30 transition uppercase tracking-widest">
                                📥 Download Demo CSV
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#4F0C2A] text-white py-5 rounded-[2rem] font-black text-sm uppercase tracking-widest shadow-xl shadow-[#4F0C2A]/20 hover:scale-[1.02] transition-all active:scale-95">
                        Scan & Preview Quotes →
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Pro Tip -->
    <div class="mt-8 p-6 bg-[#F797B6]/10 rounded-2xl border border-[#F797B6]/20">
        <div class="flex items-start gap-4">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-[#4F0C2A] shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-[#4F0C2A] mb-1">Professional Tip</p>
                <p class="text-xs text-[#4F0C2A] font-bold leading-relaxed opacity-70">
                    If your quotes contain special characters like quotes (") or commas (,), we recommend using the **CSV file upload** or the **### separator** for the best accuracy.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
