<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} | Gujju Quotes</title>

    <link rel="icon" type="image/png" href="{{ asset('images/app_logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

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
                        background: '#FFF8F8',
                        secondary: '#7B535F',
                        'on-secondary': '#FFFFFF',
                        'secondary-container': '#FFD1DD',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-background text-gray-900 antialiased font-sans; }
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
        <!-- Header (Unified) -->
        <header class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-4 hover:opacity-80 transition">
                    <div class="w-12 h-12 rounded-full overflow-hidden shadow-material border-2 border-primary-container">
                        <img src="/images/app_logo.png" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Gujju Quotes</h1>
                        <p class="text-[10px] text-secondary font-black tracking-widest uppercase opacity-70">Best Gujarati Status App</p>
                    </div>
                </a>
            </div>
            <nav class="hidden md:flex gap-8 items-center">
                <a href="/" class="text-gray-500 hover:text-primary transition font-bold text-sm">Home</a>
                <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank"
                   class="bg-primary-container text-on-primary-container px-6 py-2.5 rounded-xl text-xs font-black uppercase shadow-lg hover:scale-105 transition duration-300">
                    Download App
                </a>
            </nav>
        </header>

        <main>
            <div class="mb-12 text-center md:text-left">
                <a href="/" class="inline-flex items-center text-primary font-bold mb-6 hover:translate-x-[-4px] transition text-sm uppercase tracking-widest gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Collection
                </a>
                <h2 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight mb-4">
                    {{ $category->name }}
                </h2>
                <div class="inline-flex items-center gap-2 bg-[#F797B6]/20 text-[#4F0C2A] text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full">
                    Web Preview Selection
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach($quotes as $quote)
                    <x-quote-card :quote="$quote" />
                @endforeach

                <!-- Hook Card -->
                <div class="rounded-3xl p-8 border-2 border-dashed border-[#F797B6] flex flex-col items-center justify-center text-center bg-white/50 shadow-sm relative group">
                    <div class="w-16 h-16 bg-[#4F0C2A] text-white rounded-2xl flex items-center justify-center mb-6 shadow-xl group-hover:scale-110 transition duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">500+ More</h3>
                    <p class="text-sm text-gray-500 mb-8 font-medium leading-relaxed">Unlock the complete collection of <strong>{{ $category->name }}</strong> quotes in our mobile app.</p>
                    <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank"
                       class="w-full bg-[#4F0C2A] text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg hover:shadow-[#4F0C2A]/30 transition duration-300">
                        Get Full App
                    </a>
                </div>
            </div>
        </main>

        <footer class="mt-32 pb-20 text-center border-t border-gray-100 pt-16">
            <div class="flex flex-col items-center gap-8">
                <div class="flex flex-wrap justify-center gap-10 text-sm font-black uppercase tracking-widest text-gray-400">
                    <a href="/" class="hover:text-primary transition">Home</a>
                    <a href="/privacy.html" class="hover:text-primary transition">Privacy Policy</a>
                    <a href="/child-safety.html" class="hover:text-primary transition">Child Safety</a>
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
                showToast('Quote copied to clipboard!');
            });
        }
        function shareQuote(text) {
            if (navigator.share) {
                navigator.share({ title: 'Gujju Quote', text: text, url: window.location.href });
            } else { copyQuote(text); }
        }
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-2xl text-sm font-bold shadow-2xl z-[100] transition-all transform translate-y-20 opacity-0';
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
