<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gujju Quotes - Best Gujarati Status App</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background antialiased font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <header class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full overflow-hidden shadow-material border-2 border-primary-container">
                    <img src="/images/app_logo.png" alt="Logo" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=Gujju+Quotes&background=4F0C2A&color=fff'">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-primary">Gujju Quotes</h1>
                    <p class="text-xs text-secondary font-medium tracking-tighter uppercase">Best Gujarati Status App</p>
                </div>
            </div>
            <nav class="hidden md:flex gap-8 items-center">
                <a href="/" class="text-primary font-semibold border-b-2 border-primary pb-1">Home</a>
                <a href="#categories" class="text-on-surface-variant hover:text-primary transition font-medium">Categories</a>
                <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank"
                   class="bg-primary-container text-on-primary-container px-5 py-2 rounded-xl text-sm font-bold shadow-sm hover:shadow-material transition duration-300">
                    Download App
                </a>
            </nav>
        </header>

        <main>
            <!-- App Promotion Hero Section -->
            <section class="mb-16 bg-gradient-to-br from-primary-container to-[#6A163C] rounded-[2rem] p-8 md:p-12 text-white shadow-material overflow-hidden relative">
                <div class="relative z-10 max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">
                        Experience Gujju Quotes on the go!
                    </h2>
                    <p class="text-lg opacity-90 mb-8 leading-relaxed">
                        Get daily motivation, beautiful statuses, and unique Gujarati quotes directly on your phone. Download now for a seamless experience.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank" class="transition hover:scale-105">
                            <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play" class="h-16 -ml-3">
                        </a>
                    </div>
                </div>
                <!-- Abstract Design Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary/20 rounded-full -ml-10 -mb-10 blur-2xl"></div>
            </section>

            <!-- Quote of the Day Section -->
            @if($qotd)
            <section class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-primary-container rounded-full"></span>
                        Quote Of The Day
                    </h2>
                </div>
                <x-quote-card :quote="$qotd" color="#4F0C2A" />
            </section>
            @endif

            <!-- Categories Section -->
            <section id="categories" class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-secondary-container rounded-full"></span>
                        Browse Categories
                    </h2>
                </div>
                <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
                    @foreach($categories as $category)
                        <x-category-chip :category="$category" />
                    @endforeach
                </div>
            </section>

            <!-- Explore Section -->
            <section class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-on-primary-container rounded-full"></span>
                        Discover More
                    </h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($exploreQuotes as $quote)
                        <x-quote-card :quote="$quote" />
                    @endforeach
                </div>
            </section>
        </main>

        <footer class="mt-24 pb-12 text-center border-t border-surface-variant pt-12">
            <div class="flex flex-col items-center gap-6">
                <div class="flex gap-8 text-sm font-medium text-on-surface-variant">
                    <a href="/" class="hover:text-primary transition">Home</a>
                    <a href="#categories" class="hover:text-primary transition">Categories</a>
                    <a href="/privacy.html" class="hover:text-primary transition">Privacy Policy</a>
                </div>
                <div class="text-on-surface-variant/60 text-xs">
                    <p>© {{ date('Y') }} Gujju Quotes App. Developed by one993Techsol.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function copyQuote(text) {
            navigator.clipboard.writeText(text).then(() => {
                // You could add a toast notification here for more professional feel
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
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }
    </style>
</body>
</html>
