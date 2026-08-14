<!DOCTYPE html>
<html lang="en" class="h-full">
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
</head>
<body class="bg-[#FDF7F9] antialiased h-full flex overflow-hidden text-gray-900 font-['Figtree']">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity duration-300"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-[#0F0004] text-white flex flex-col shrink-0 h-full shadow-2xl z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <!-- Brand Section -->
        <div class="p-8 border-b border-white/5 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <img src="/images/app_logo.png" alt="Logo" class="w-10 h-10 rounded-xl shadow-lg border border-white/10 group-hover:rotate-3 transition-transform">
                <div>
                    <h1 class="font-black text-lg tracking-tight leading-none text-white text-nowrap">Gujju <span class="text-accent italic">Admin</span></h1>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">one993techsol</p>
                </div>
            </a>
            <!-- Close button for mobile -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-8 px-4 space-y-1 overflow-y-auto">
            <div class="px-4 mb-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-600">Core Management</div>

            @php
                $baseLink = "flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group ";
                $active = "bg-[#4F0C2A] text-white shadow-xl shadow-[#4F0C2A]/20 border border-white/5 font-bold";
                $inactive = "text-gray-400 hover:text-white hover:bg-white/5 font-semibold";
            @endphp

            <a href="{{ route('admin.dashboard') }}" class="{{ $baseLink }} {{ request()->routeIs('admin.dashboard') ? $active : $inactive }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.quotes.index') }}" class="{{ $baseLink }} {{ request()->routeIs('admin.quotes.*') ? $active : $inactive }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span class="text-sm">Quotes Collection</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="{{ $baseLink }} {{ request()->routeIs('admin.categories.*') ? $active : $inactive }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span class="text-sm">Categories</span>
            </a>

            <a href="{{ route('admin.contacts.index') }}" class="{{ $baseLink }} {{ request()->routeIs('admin.contacts.*') ? $active : $inactive }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span class="text-sm flex-1">Contact Requests</span>
                @php
                    $newContacts = \App\Models\ContactRequest::active()->where('status', 'new')->count();
                @endphp
                @if($newContacts > 0)
                    <span class="px-2 py-0.5 bg-accent text-primary text-[8px] font-black rounded-full">{{ $newContacts }}</span>
                @endif
            </a>

            <a href="{{ route('admin.reports.index') }}" class="{{ $baseLink }} {{ request()->routeIs('admin.reports.*') ? $active : $inactive }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span class="text-sm flex-1">Review Reports</span>
                @if(isset($reportCount) && $reportCount > 0)
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                @endif
            </a>

            <div class="px-4 mt-10 mb-6 text-[10px] font-black uppercase tracking-[0.3em] text-gray-600">Settings</div>

            <a href="{{ route('admin.password.edit') }}" class="{{ $baseLink }} {{ request()->routeIs('admin.password.edit') ? $active : $inactive }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span class="text-sm">Update Password</span>
            </a>
        </nav>

        <!-- User Profile Area -->
        <div class="p-4 mt-auto bg-black/20">
            <div class="bg-white/5 rounded-3xl p-5 border border-white/5">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-[#4F0C2A] rounded-2xl flex items-center justify-center font-black text-[#F797B6] text-xs shadow-xl">AD</div>
                    <div class="min-w-0">
                        <p class="text-xs font-black text-white truncate">Administrator</p>
                        <p class="text-[9px] text-gray-500 font-bold uppercase truncate">System Lead</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 border border-red-500/10 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-full relative">
        <!-- Top Bar -->
        <header class="h-16 md:h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 px-4 md:px-10 flex items-center justify-between shrink-0 sticky top-0 z-40">
            <div class="flex items-center gap-4 overflow-hidden">
                <!-- Hamburger Button for Mobile -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-maroon transition shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex flex-col min-w-0">
                    <p class="text-[8px] md:text-[9px] font-black text-gray-400 uppercase tracking-[0.4em] mb-0.5 truncate">Control Center</p>
                    <h2 class="text-sm md:text-xl font-black text-gray-900 tracking-tight italic truncate uppercase">@yield('page_title', 'Dashboard')</h2>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-100 rounded-full shadow-sm">
                    <span class="w-1 h-1 md:w-1.5 md:h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-emerald-600">SECURE</span>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 bg-gray-100 border border-gray-100 rounded-xl flex items-center justify-center font-black text-maroon text-[10px] md:text-xs shadow-sm uppercase">AD</div>
            </div>
        </header>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-4 md:p-10 bg-[#FDF7F9]">
            <div class="max-w-7xl mx-auto lg:mx-0">
                {{-- Global Success Message --}}
                @if(session('success'))
                    <div class="auto-hide-alert max-w-4xl mb-6 md:mb-10 p-4 md:p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-3xl shadow-sm flex items-center gap-4 animate-fade-in">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="font-black text-[10px] uppercase tracking-widest text-emerald-900 leading-none mb-1">Success</p>
                            <p class="text-emerald-700 font-bold text-xs md:text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Global Error Message --}}
                @if(session('error'))
                    <div class="auto-hide-alert max-w-4xl mb-6 md:mb-10 p-4 md:p-5 bg-red-50 border-l-4 border-red-500 rounded-r-3xl shadow-sm flex items-center gap-4 animate-fade-in">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-red-500 text-white rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <p class="font-black text-[10px] uppercase tracking-widest text-red-900 leading-none mb-1">System Error</p>
                            <p class="text-red-700 font-bold text-xs md:text-sm">{{ session('error') }}</p>
                            @if(session('error_code'))
                                <span class="inline-block mt-2 px-2 py-0.5 bg-red-100 text-[8px] font-black text-red-600 rounded">CODE: {{ session('error_code') }}</span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="auto-hide-alert max-w-4xl mb-6 md:mb-10 p-4 md:p-5 bg-amber-50 border-l-4 border-amber-500 rounded-r-3xl shadow-sm flex flex-col gap-3 animate-fade-in">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="font-black text-[10px] uppercase tracking-widest text-amber-900">Check Form Requirements</p>
                        </div>
                        <ul class="ml-12 md:ml-14 list-disc space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-amber-700 font-bold text-xs md:text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.auto-hide-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Convert UTC times to Local Time or Time Ago
            const timeElements = document.querySelectorAll('[data-utc]');

            function getTimeAgo(date) {
                const seconds = Math.floor((new Date() - date) / 1000);
                const intervals = {
                    year: 31536000,
                    month: 2592000,
                    week: 604800,
                    day: 86400,
                    hour: 3600,
                    minute: 60,
                    second: 1
                };

                for (let key in intervals) {
                    const counter = Math.floor(seconds / intervals[key]);
                    if (counter > 0) {
                        return counter === 1 ? `1 ${key} ago` : `${counter} ${key}s ago`;
                    }
                }
                return "just now";
            }

            timeElements.forEach(el => {
                const utcDate = el.getAttribute('data-utc');
                if (!utcDate) return;

                const date = new Date(utcDate);
                if (isNaN(date.getTime())) return;

                const format = el.getAttribute('data-format') || 'datetime';

                if (format === 'timeago') {
                    el.innerText = getTimeAgo(date);
                    // Add full date as tooltip
                    el.title = date.toLocaleString();
                    return;
                }

                let options = {};
                if (format === 'date') {
                    options = { year: 'numeric', month: 'short', day: '2-digit' };
                } else if (format === 'time') {
                    options = { hour: '2-digit', minute: '2-digit', hour12: true };
                } else {
                    options = {
                        year: 'numeric', month: 'short', day: '2-digit',
                        hour: '2-digit', minute: '2-digit', hour12: true
                    };
                }

                el.innerText = date.toLocaleString(undefined, options);
            });
        });
    </script>

    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
    </style>
</body>
</html>
