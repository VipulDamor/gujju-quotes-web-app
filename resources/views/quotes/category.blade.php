<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} - Gujju Quotes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <header class="mb-12">
            <a href="/" class="inline-flex items-center text-primary font-semibold mb-6 hover:translate-x-[-4px] transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Home
            </a>
            <h1 class="text-3xl font-bold text-primary">{{ $category->name }}</h1>
        </header>

        <main>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($quotes as $quote)
                    <x-quote-card :quote="$quote" />
                @endforeach
            </div>

            <div class="mt-12">
                {{ $quotes->links() }}
            </div>
        </main>
    </div>
</body>
</html>
