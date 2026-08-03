<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gujju Quotes - Best Gujarati Status App</title>

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
            body { @apply bg-background text-on-background antialiased font-sans; }
        }
        @layer utilities {
            .shadow-material { box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08); }
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <header class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full overflow-hidden shadow-material border-2 border-primary-container">
                    <img src="/images/app_logo.png" alt="Logo" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=GQ&background=4F0C2A&color=fff'">
                </div>
                <div>
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">Gujju Quotes</h1>
                    <p class="text-[10px] text-secondary font-black tracking-widest uppercase opacity-70">Best Gujarati Status App</p>
                </div>
            </div>
            <nav class="hidden md:flex gap-8 items-center">
                <a href="/" class="text-primary font-bold border-b-2 border-primary pb-1">Home</a>
                <a href="#categories" class="text-gray-500 hover:text-primary transition font-bold text-sm">Categories</a>
                <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank"
                   class="bg-primary-container text-on-primary-container px-6 py-2.5 rounded-xl text-xs font-black uppercase shadow-lg hover:scale-105 transition duration-300">
                    Download App
                </a>
            </nav>
        </header>

        <main>
            <!-- App Promotion Hero Section -->
            <section class="mb-20 bg-[#4F0C2A] rounded-[3rem] p-10 md:p-16 text-white shadow-2xl relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="bg-white/10 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-6 inline-block">Official Mobile App</span>
                    <h2 class="text-4xl md:text-6xl font-black mb-6 leading-[1.1] tracking-tight">
                        Inspiration <br><span class="text-[#F797B6]">In Your Pocket.</span>
                    </h2>
                    <p class="text-xl opacity-80 mb-10 leading-relaxed font-medium">
                        Download the official Gujju Quotes app for a premium experience with daily updates and offline access.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank" class="transition hover:scale-105">
                            <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play" class="h-20 -ml-4">
                        </a>
                    </div>
                </div>
                <!-- Design Decor -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/20 rounded-full -ml-32 -mb-32 blur-2xl"></div>
            </section>

            <!-- Quote of the Day Section -->
            @if($qotd)
            <section class="mb-20">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                        <span class="w-2.5 h-10 bg-primary-container rounded-full"></span>
                        Quote Of The Day
                    </h2>
                </div>
                <x-quote-card :quote="$qotd" color="#4F0C2A" />
            </section>
            @endif

            <!-- Categories Section -->
            <section id="categories" class="mb-20">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                        <span class="w-2.5 h-10 bg-secondary-container rounded-full"></span>
                        Categories
                    </h2>
                </div>
                <div class="flex gap-4 overflow-x-auto pb-6 no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
                    @foreach($categories as $category)
                        <x-category-chip :category="$category" />
                    @endforeach
                </div>
            </section>

            <!-- Explore Section -->
            <section class="mb-20">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                        <span class="w-2.5 h-10 bg-[#F797B6] rounded-full"></span>
                        Explore Quotes
                    </h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($exploreQuotes as $quote)
                        <x-quote-card :quote="$quote" />
                    @endforeach
                </div>
            </section>
        </main>

        <footer class="mt-32 pb-20 text-center border-t border-gray-100 pt-16">
            <div class="flex flex-col items-center gap-8">
                <div class="flex gap-10 text-sm font-black uppercase tracking-widest text-gray-400">
                    <a href="/" class="hover:text-primary transition">Home</a>
                    <a href="#categories" class="hover:text-primary transition">Categories</a>
                    <a href="/privacy.html" class="hover:text-primary transition">Privacy Policy</a>
                </div>
                <div class="text-gray-400 text-xs font-bold">
                    <p>© {{ date('Y') }} Gujju Quotes App. Crafted by One993Techsol.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function copyQuote(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Quote copied to clipboard!');
            });
        }
        function shareQuote(text) {
            if (navigator.share) {
                navigator.share({
                    title: 'Gujju Quote',
                    text: text + '\n\nShared from Gujju Quotes App',
                    url: window.location.href
                });
            } else {
                copyQuote(text);
            }
        }
    </script>
</body>
</html>
