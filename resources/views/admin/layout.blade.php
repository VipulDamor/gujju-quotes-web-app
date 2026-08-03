<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Gujju Quotes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F0004',
                        accent: '#F797B6',
                        maroon: '#4F0C2A',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 antialiased flex min-h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-72 bg-primary text-white flex flex-col shrink-0 h-screen shadow-2xl relative z-50">
        <!-- Logo Section -->
        <div class="p-8 border-b border-white/5">
            <a href="/" class="flex items-center gap-4 group">
                <img src="/images/app_logo.png" alt="Logo" class="w-10 h-10 rounded-xl shadow-lg border border-white/10 group-hover:rotate-3 transition-transform">
                <div>
                    <h1 class="font-black text-lg tracking-tight leading-none text-white">Gujju <span class="text-accent">Admin</span></h1>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">One993Techsol</p>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-8 px-4 space-y-2 overflow-y-auto custom-scroll">
            <p class="px-4 text-[10px] font-black text-gray-600 uppercase tracking-widest mb-4">Core Management</p>

            @php
                $linkClass = "flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group ";
                $activeClass = "bg-accent/10 text-accent font-bold shadow-sm";
                $inactiveClass = "text-gray-400 hover:text-white hover:bg-white/5";
            @endphp

            <a href="{{ route('admin.dashboard') }}"
               class="{{ $linkClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-sm">Overview</span>
            </a>

            <a href="{{ route('admin.quotes.index') }}"
               class="{{ $linkClass }} {{ request()->routeIs('admin.quotes.*') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span class="text-sm">Quotes Collection</span>
            </a>

            <a href="{{ route('admin.reports.index') }}"
               class="{{ $linkClass }} {{ request()->routeIs('admin.reports.*') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span class="text-sm">Review Reports</span>
                @if(isset($reportCount) && $reportCount > 0)
                    <span class="ml-auto w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                @endif
            </a>

            <div class="px-8 mt-6 mb-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-600">Settings</div>

            <a href="{{ route('admin.password.edit') }}"
               class="{{ $linkClass }} {{ request()->routeIs('admin.password.edit') ? $activeClass : $inactiveClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span class="text-sm">Update Password</span>
            </a>
        </nav>

        <!-- User Section -->
        <div class="p-6 border-t border-white/5 bg-black/20">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-9 h-9 bg-maroon rounded-lg flex items-center justify-center font-black text-white text-xs shadow-inner">AD</div>
                <div class="min-w-0">
                    <p class="text-xs font-black text-white truncate">Administrator</p>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest truncate">Secure Access</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 bg-white/5 hover:bg-red-500/20 text-red-400 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all border border-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-screen">
        <!-- Dashboard Header -->
        <header class="h-20 bg-white border-b border-gray-100 px-10 flex items-center justify-between shrink-0">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-1">Gujju Management</p>
                <h2 class="text-xl font-black text-gray-900 tracking-tight italic">@yield('page_title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-full">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600">Authenticated</span>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-1 overflow-y-auto p-10 custom-scroll">
            @if(session('success'))
                <div class="max-w-4xl mb-10 p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl shadow-sm animate-pulse">
                    <p class="text-emerald-800 font-bold text-sm leading-relaxed">{{ session('success') }}</p>
                </div>
            @endif

            <div class="max-w-6xl">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
