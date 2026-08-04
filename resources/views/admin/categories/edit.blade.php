@extends('admin.layout')

@section('page_title', 'Edit Category')

@section('content')
<div class="max-w-xl text-left">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-3 ml-1">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-xl px-6 py-4 text-gray-900 font-medium transition-all outline-none">
                    @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="bg-[#4F0C2A] text-white px-10 py-4 rounded-xl font-black text-sm uppercase tracking-widest shadow-xl shadow-[#4F0C2A]/20 hover:bg-[#3d0a21] transition-all">
                        Update Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-all uppercase tracking-widest px-4">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
