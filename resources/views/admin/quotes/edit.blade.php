@extends('admin.layout')

@section('page_title', 'Edit Quote')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <form action="{{ route('admin.quotes.update', $quote->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-3 ml-1">Quote Content</label>
                    <textarea name="quote" rows="6" required
                              class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-2xl px-6 py-5 text-gray-900 font-medium transition-all outline-none leading-relaxed">{{ $quote->quote }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-3 ml-1">Category</label>
                    <div class="relative">
                        <select name="category_id" required
                                class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-xl px-6 py-4 text-gray-900 font-medium transition-all outline-none appearance-none cursor-pointer">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $quote->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-6 text-gray-400">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="bg-[#4F0C2A] text-white px-10 py-4 rounded-xl font-black text-sm uppercase tracking-widest shadow-lg shadow-[#4F0C2A]/20 hover:bg-[#3d0a21] transition-all">
                        Update Quote
                    </button>
                    <a href="{{ route('admin.quotes.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-all uppercase tracking-widest px-4">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
