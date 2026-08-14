<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO & Social Media Optimization -->
    <title>Gujju Quotes - Best Gujarati Status App</title>
    <meta name="description" content="Discover a world of inspiring, humorous, and thought-provoking Gujarati quotes. Download our app for daily updates!">
    <meta property="og:title" content="Gujju Quotes - Best Gujarati Status App">
    <meta property="og:description" content="Daily inspirational and motivational Gujarati quotes in your pocket.">
    <meta property="og:image" content="{{ asset('images/app_logo.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/app_logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Professional CDN Setup -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F0004',
                        'on-primary': '#FFFFFF',
                        'primary-container': '#4F0C2A',
                        'on-primary-container': '#F797B6',
                        secondary: '#7B535F',
                        'on-secondary': '#FFFFFF',
                        'secondary-container': '#FFD1DD',
                        'on-secondary-container': '#5E3A45',
                        background: '#FFF8F8',
                        'on-background': '#211A1B',
                        surface: '#FFF8F8',
                        'on-surface': '#211A1B',
                        'surface-variant': '#F5DDE2',
                        'on-surface-variant': '#534347',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-background text-on-background antialiased font-sans overflow-x-hidden; }
        }
        @layer utilities {
            .shadow-material { box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08); }
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-12">
        <!-- Header -->
        <header class="flex items-center justify-between mb-10 md:mb-16">
            <div class="flex items-center gap-3 md:gap-4 overflow-hidden">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden shadow-material border-2 border-primary-container shrink-0">
                    <img src="/images/app_logo.png" alt="Logo" class="w-full h-full object-cover">
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight truncate">Gujju Quotes</h1>
                    <p class="text-[8px] md:text-[10px] text-secondary font-black tracking-widest uppercase opacity-70 truncate">Best Gujarati Status App</p>
                </div>
            </div>
            <nav class="flex items-center gap-4 md:gap-8">
                <a href="#categories" class="hidden sm:block text-gray-500 hover:text-primary transition font-bold text-sm">Categories</a>
                <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank"
                   class="bg-primary-container text-on-primary-container px-4 py-2 md:px-6 md:py-2.5 rounded-xl text-[10px] md:text-xs font-black uppercase shadow-lg hover:scale-105 active:scale-95 transition duration-300">
                    Download App
                </a>
            </nav>
        </header>

        <main>
            <!-- App Promotion Hero Section -->
            <section class="mb-12 md:mb-24 bg-[#4F0C2A] rounded-[2rem] md:rounded-[3rem] p-8 md:p-20 text-white shadow-2xl relative overflow-hidden text-center md:text-left">
                <div class="relative z-10 max-w-3xl">
                    <span class="bg-white/10 px-3 py-1 rounded-full text-[9px] md:text-xs font-black uppercase tracking-widest mb-6 inline-block">Official Mobile App</span>
                    <h2 class="text-3xl sm:text-4xl md:text-6xl font-black mb-6 leading-[1.1] tracking-tight">
                        Inspiration <br class="hidden sm:block"><span class="text-[#F797B6]">In Your Pocket.</span>
                    </h2>
                    <p class="text-sm md:text-xl opacity-80 mb-8 md:mb-12 leading-relaxed font-medium max-w-xl">
                        Download the official Gujju Quotes app for a premium experience with daily updates, offline access, and status downloading.
                    </p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank" class="transition active:scale-95 hover:scale-105">
                            <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play" class="h-16 md:h-24 -ml-4">
                        </a>
                    </div>
                </div>
                <!-- Design Decor -->
                <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 md:w-64 md:h-64 bg-black/20 rounded-full -ml-32 -mb-32 blur-2xl"></div>
            </section>

            <!-- Quote of the Day Section -->
            @if($qotd)
            <section class="mb-16 md:mb-24">
                <div class="flex items-center justify-between mb-8 md:mb-12">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3 md:gap-4">
                        <span class="w-1.5 md:w-2.5 h-8 md:h-10 bg-primary-container rounded-full"></span>
                        Quote Of The Day
                    </h2>
                </div>
                <x-quote-card :quote="$qotd" color="#4F0C2A" />
            </section>
            @endif

            <!-- Categories Section -->
            <section id="categories" class="mb-16 md:mb-24">
                <div class="flex items-center justify-between mb-8 md:mb-12">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3 md:gap-4">
                        <span class="w-1.5 md:w-2.5 h-8 md:h-10 bg-secondary-container rounded-full"></span>
                        Categories
                    </h2>
                </div>
                <div class="flex gap-3 md:gap-4 overflow-x-auto pb-6 no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
                    @foreach($categories as $category)
                        <x-category-chip :category="$category" />
                    @endforeach
                </div>
            </section>

            <!-- Explore Section -->
            <section class="mb-16 md:mb-24">
                <div class="flex items-center justify-between mb-8 md:mb-12 px-1">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3 md:gap-4">
                        <span class="w-1.5 md:w-2.5 h-8 md:h-10 bg-[#F797B6] rounded-full"></span>
                        Explore Quotes
                    </h2>
                    <button id="shuffle-btn" onclick="shuffleQuotes()" class="flex items-center gap-2 text-[#4F0C2A] font-black text-[9px] md:text-xs uppercase tracking-widest hover:opacity-70 transition border border-[#4F0C2A]/10 px-4 py-2 rounded-xl bg-white shadow-sm">
                        <svg id="shuffle-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        <span class="hidden sm:inline">Shuffle</span>
                    </button>
                </div>
                <div id="quotes-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-10 transition-opacity duration-300">
                    @foreach($exploreQuotes as $quote)
                        <x-quote-card :quote="$quote" />
                    @endforeach
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="mt-20 md:mt-40 pb-16 text-center border-t border-gray-100 pt-16">
            <div class="flex flex-col items-center gap-10">
                <div class="flex flex-wrap justify-center gap-6 md:gap-12 text-[10px] md:text-xs font-black uppercase tracking-widest text-gray-400">
                    <a href="/" class="hover:text-primary transition">Home</a>
                    <a href="#categories" class="hover:text-primary transition">Categories</a>
                    <a href="/privacy.html" class="hover:text-primary transition">Privacy Policy</a>
                    <a href="/child-safety.html" class="hover:text-primary transition">Child Safety</a>
                    <a href="{{ route('contact.show') }}" class="hover:text-primary transition">Contact Us</a>
                </div>

                <div class="text-gray-300 text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] leading-relaxed">
                    <p>© {{ date('Y') }} Gujju Quotes App. Developed with ❤️ by One993Techsol.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- AJAX Shuffle Logic & Toast UI -->
    <script>
        let shuffleCount = 0;
        const MAX_SHUFFLES = 2;

        async function shuffleQuotes() {
            if (shuffleCount >= MAX_SHUFFLES) {
                window.open('https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp', '_blank');
                return;
            }

            const grid = document.getElementById('quotes-grid');
            const icon = document.getElementById('shuffle-icon');
            const btn = document.getElementById('shuffle-btn');

            btn.disabled = true;
            icon.classList.add('animate-spin');
            grid.style.opacity = '0.5';

            try {
                const response = await fetch('/api/quotes/random-shuffle');
                const data = await response.json();
                grid.innerHTML = data.html;
                shuffleCount++;

                if (shuffleCount >= MAX_SHUFFLES) {
                    btn.innerHTML = '✨ Open App for More';
                    btn.classList.add('bg-[#4F0C2A]', 'text-white', 'border-transparent');
                }
            } catch (error) {
                console.error('Shuffle failed:', error);
            } finally {
                grid.style.opacity = '1';
                icon.classList.remove('animate-spin');
                btn.disabled = false;
            }
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-8 left-4 right-4 md:left-1/2 md:-translate-x-1/2 md:max-w-sm bg-gray-900 text-white px-6 py-4 rounded-[1.5rem] text-xs font-black uppercase tracking-widest shadow-2xl z-[100] transition-all transform translate-y-20 opacity-0 text-center';
            toast.innerText = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-y-20', 'opacity-0'), 100);
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    </script>
</body>
</html>
