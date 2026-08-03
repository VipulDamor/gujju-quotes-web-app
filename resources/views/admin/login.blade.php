<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6 antialiased">
    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center mx-auto mb-6">
                <img src="/images/app_logo.png" alt="Logo" class="w-10 h-10">
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Admin Login</h1>
            <p class="text-gray-500 text-sm mt-2">Sign in to manage your collection</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-10 border border-gray-100">
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-xl px-5 py-4 text-gray-900 font-medium transition-all outline-none">
                        @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                               class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-xl px-5 py-4 text-gray-900 font-medium transition-all outline-none">
                    </div>

                    <button type="submit" class="w-full bg-[#4F0C2A] text-white py-4 rounded-xl font-black text-sm uppercase tracking-widest shadow-lg shadow-[#4F0C2A]/20 hover:bg-[#3d0a21] transition-all">
                        Sign In
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center mt-8">
            <a href="/" class="text-xs font-bold text-gray-400 hover:text-[#4F0C2A] transition uppercase tracking-widest">← Back to website</a>
        </div>
    </div>
</body>
</html>
