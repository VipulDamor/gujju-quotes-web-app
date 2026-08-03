<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO & Social Media Optimization -->
    <title>{{ Str::limit($quote->quote, 50) }} | Gujju Quotes</title>
    <meta name="description" content="{{ $quote->quote }}">
    <meta property="og:title" content="Inspirational Gujarati Quote">
    <meta property="og:description" content="{{ $quote->quote }}">
    <meta property="og:image" content="{{ asset('images/app_logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" href="{{ asset('images/app_logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

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
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-background text-gray-900 antialiased font-sans overflow-x-hidden; }
        }
        @layer utilities {
            .shadow-material { box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 py-4 sticky top-0 z-50 shrink-0">
        <div class="max-w-4xl mx-auto px-4 md:px-6 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="/images/app_logo.png" alt="Logo" class="w-8 h-8 rounded-lg shadow-sm">
                <span class="font-black text-gray-900 text-base md:text-lg tracking-tight">Gujju Quotes</span>
            </a>
            <a href="/" class="text-xs font-black uppercase tracking-widest text-[#4F0C2A] hover:opacity-70 transition px-2 py-1">Back</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center p-4 md:p-12">
        <div class="max-w-2xl w-full">
            <!-- Professional Quote Display -->
            <div class="bg-[#4F0C2A] text-white rounded-[2rem] md:rounded-[2.5rem] p-8 md:p-20 shadow-2xl relative overflow-hidden text-center mb-8 md:mb-12 transition duration-500">
                <div class="relative z-10">
                    <svg class="w-8 h-8 md:w-12 md:h-12 text-[#F797B6] mb-6 md:mb-10 mx-auto opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM2.017 21L2.017 18C2.017 16.8954 2.91243 16 4.017 16H7.017C7.56928 16 8.017 15.5523 8.017 15V9C8.017 8.44772 7.56928 8 7.017 8H3.017C2.46472 8 2.017 8.44772 2.017 9V11C2.017 11.5523 1.56928 12 1.017 12H0.017V5H10.017V15C10.017 18.3137 7.33072 21 4.017 21H2.017Z"/></svg>

                    <h1 class="text-xl md:text-4xl font-bold leading-relaxed mb-6 md:mb-10 px-2 italic">
                        {{ $quote->quote }}
                    </h1>

                    <div class="inline-block px-5 py-2 bg-white/10 rounded-full text-[9px] md:text-xs font-black uppercase tracking-widest text-[#F797B6]">
                        {{ $quote->category->name ?? 'Wisdom' }}
                    </div>
                </div>

                <!-- Decorative Background -->
                <div class="absolute top-0 right-0 w-48 h-48 md:w-64 md:h-64 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 md:w-48 md:h-48 bg-black/20 rounded-full -ml-16 -mb-16 blur-2xl"></div>
            </div>

            <!-- CTA Section -->
            <div class="text-center space-y-6">
                <p class="text-gray-400 font-black uppercase tracking-[0.2em] text-[8px] md:text-[10px]">Premium features on mobile</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-stretch sm:items-center px-2">
                    <a href="https://play.google.com/store/apps/details?id=com.one993techsol.gujju_bestgujaratistatusapp" target="_blank"
                       class="flex-1 sm:flex-none flex items-center justify-center gap-3 bg-[#4F0C2A] px-8 py-4 md:px-12 md:py-5 rounded-2xl md:rounded-[2rem] font-black text-white text-xs md:text-sm uppercase tracking-widest shadow-2xl hover:scale-[1.02] active:scale-95 transition-all">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        Get App to Share
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="p-8 md:p-12 text-center text-gray-300 text-[8px] md:text-[10px] font-black uppercase tracking-widest shrink-0">
        © {{ date('Y') }} Gujju Quotes App. All rights reserved.
    </footer>
</body>
</html>
