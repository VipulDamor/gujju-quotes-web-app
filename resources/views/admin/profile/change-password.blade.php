@extends('admin.layout')

@section('page_title', 'Update Password')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <div class="mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-2">Reset Password</h3>
            <p class="text-gray-400 text-sm font-medium uppercase tracking-widest">Update your administrator access credentials</p>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            <div class="space-y-8">
                <div>
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Current Password</label>
                    <input type="password" name="current_password" required
                           class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-2xl px-6 py-4 text-gray-900 font-bold transition-all outline-none">
                </div>

                <div class="h-px bg-gray-50"></div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">New Password</label>
                    <input type="password" name="new_password" required
                           class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-2xl px-6 py-4 text-gray-900 font-bold transition-all outline-none">
                    @error('new_password') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required
                           class="w-full bg-gray-50 border border-gray-200 focus:border-[#4F0C2A] focus:ring-2 focus:ring-[#4F0C2A]/10 rounded-2xl px-6 py-4 text-gray-900 font-bold transition-all outline-none">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#4F0C2A] text-white py-5 rounded-[2rem] font-black text-sm uppercase tracking-widest shadow-xl shadow-[#4F0C2A]/20 hover:scale-[1.02] transition-all active:scale-95">
                        Update Password
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Security Note -->
    <div class="mt-8 p-6 bg-[#F797B6]/10 rounded-2xl border border-[#F797B6]/20">
        <div class="flex items-start gap-4">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-[#4F0C2A] shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <p class="text-xs text-[#4F0C2A] font-bold leading-relaxed opacity-70">
                Changing your password will sign out your sessions on other devices for security. Make sure to choose a strong password with at least 8 characters.
            </p>
        </div>
    </div>
</div>
@endsection
