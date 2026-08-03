@props(['category'])

<a href="{{ route('quotes.by-category', $category->id) }}"
   class="inline-block px-4 py-2 rounded-full border border-outline-variant bg-surface-variant text-on-surface-variant hover:bg-primary hover:text-on-primary transition duration-200 text-sm font-medium whitespace-nowrap">
    {{ $category->name }}
</a>
