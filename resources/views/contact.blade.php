<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Gujju Quotes</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F0004',
                        'primary-container': '#4F0C2A',
                        'on-primary-container': '#F797B6',
                        background: '#FFF8F8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-gray-900 font-sans antialiased">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Header -->
        <header class="flex items-center justify-between mb-16">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden shadow-lg border-2 border-primary-container">
                    <img src="/images/app_logo.png" alt="Logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-xl font-black tracking-tight">Gujju Quotes</h1>
            </a>
            <a href="/" class="text-sm font-bold text-gray-500 hover:text-primary transition">Back to Home</a>
        </header>

        <main>
            <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">
                <div class="bg-primary-container p-8 md:p-12 text-center text-white">
                    <h2 class="text-3xl md:text-4xl font-black mb-4">Contact Our Support</h2>
                    <p class="text-on-primary-container opacity-90 font-medium max-w-lg mx-auto">
                        Have a question or feedback? We'd love to hear from you. Fill out the form below and we'll get back to you shortly.
                    </p>
                </div>

                <div class="p-8 md:p-12">
                    @if(session('success'))
                        <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl flex items-center gap-4 animate-fade-in">
                            <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-emerald-700 font-bold">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl flex items-center gap-4">
                             <p class="text-red-700 font-bold">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Your Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-on-primary-container transition">
                                @error('name') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-on-primary-container transition">
                                @error('email') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Category</label>
                                <select name="category" required
                                    class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-on-primary-container appearance-none cursor-pointer transition">
                                    <option value="general">General Inquiry</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="bug_report">Bug Report</option>
                                    <option value="feature_request">Feature Request</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Subject</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" required
                                    class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-on-primary-container transition">
                                @error('subject') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Your Message</label>
                            <textarea name="message" rows="5" required
                                class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-on-primary-container transition"
                                placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-primary-container text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-primary-container/20 hover:scale-[1.02] active:scale-95 transition duration-300">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Contact Info -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                <div class="p-8 bg-white rounded-3xl border border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Email Us Directly</p>
                    <a href="mailto:1993developers@gmail.com" class="text-xl font-black text-primary-container hover:underline">1993developers@gmail.com</a>
                </div>
                <div class="p-8 bg-white rounded-3xl border border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Social Media</p>
                    <p class="text-lg font-bold text-gray-600 italic">Stay connected for daily inspiration</p>
                </div>
            </div>
        </main>

        <footer class="mt-20 text-center">
            <p class="text-gray-300 text-[10px] font-bold uppercase tracking-[0.2em]">© {{ date('Y') }} Gujju Quotes App</p>
        </footer>
    </div>

    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; }
    </style>
</body>
</html>
