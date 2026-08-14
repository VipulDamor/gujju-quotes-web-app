@extends('admin.layout')

@section('page_title', 'Request: ' . $contact->request_id)

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between px-2">
        <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-[#4F0C2A] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to List
        </a>
        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('SOFT DELETE THIS REQUEST?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600 transition">Delete Request</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- User & Message Card -->
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 md:p-10">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 bg-gray-50 px-3 py-1.5 rounded-full mb-4 inline-block">Support Ticket</span>
                        <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">{{ $contact->subject }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Created At</p>
                        <p class="text-sm font-black text-gray-900">{{ $contact->created_at->format('M d, Y - h:i A') }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-[1.5rem] p-6 md:p-8 mb-8">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        Original Message
                    </p>
                    <div class="text-gray-700 text-lg leading-relaxed font-medium whitespace-pre-wrap italic">
                        "{{ $contact->message }}"
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-8 border-t border-gray-100">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-4">Requester Information</p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black uppercase">{{ substr($contact->name ?? 'A', 0, 1) }}</div>
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $contact->name ?? 'Anonymous User' }}</p>
                                    <p class="text-[10px] font-bold text-gray-400">{{ $contact->email }}</p>
                                </div>
                            </div>
                            @if($contact->phone)
                                <p class="text-xs font-bold text-gray-600 ml-14">📞 {{ $contact->phone }}</p>
                            @endif
                            <p class="text-[10px] font-black uppercase tracking-widest ml-14 {{ $contact->is_logged_in ? 'text-emerald-500' : 'text-gray-300' }}">
                                ● {{ $contact->is_logged_in ? 'Logged In User (ID: ' . $contact->user_id . ')' : 'Guest' }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-4">Application Environment</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[8px] font-black text-gray-400 uppercase mb-1">App Version</p>
                                <p class="text-xs font-black text-gray-900">v{{ $contact->app_version }}</p>
                            </div>
                            <div>
                                <p class="text-[8px] font-black text-gray-400 uppercase mb-1">Platform</p>
                                <p class="text-xs font-black text-gray-900 uppercase">{{ $contact->platform }} ({{ $contact->os_version }})</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[8px] font-black text-gray-400 uppercase mb-1">Device Model</p>
                                <p class="text-xs font-black text-gray-900">{{ $contact->device_manufacturer }} {{ $contact->device_model }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resolution Card -->
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 md:p-10">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Resolution Center
                </p>

                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Status</label>
                            <select name="status" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#F797B6] appearance-none cursor-pointer">
                                @foreach(['new', 'in_progress', 'resolved', 'closed', 'spam'] as $s)
                                    <option value="{{ $s }}" {{ $contact->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Priority</label>
                            <select name="priority" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#F797B6] appearance-none cursor-pointer">
                                @foreach(['low', 'normal', 'high', 'urgent'] as $p)
                                    <option value="{{ $p }}" {{ $contact->priority == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Admin Response (Immutable Audit Logged)</label>
                        <textarea name="admin_response" rows="4" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-[#F797B6] transition" placeholder="Write your response to the user...">{{ $contact->admin_response }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Internal Notes (Private)</label>
                        <textarea name="internal_notes" rows="2" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-[#F797B6] transition" placeholder="Add notes for other admins...">{{ $contact->internal_notes }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <button type="submit" class="bg-[#4F0C2A] text-white px-10 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition active:scale-95 shadow-lg shadow-[#4F0C2A]/20">
                            Save Resolution Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar / Logs -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-6">Technical Metadata</p>
                <div class="space-y-4">
                    <div>
                        <p class="text-[8px] font-bold text-gray-400 uppercase">IP Address</p>
                        <p class="text-xs font-black text-gray-900">{{ $contact->ip_address }}</p>
                    </div>
                    <div>
                        <p class="text-[8px] font-bold text-gray-400 uppercase">User Agent</p>
                        <p class="text-[10px] font-medium text-gray-500 italic break-all leading-relaxed">{{ $contact->user_agent }}</p>
                    </div>
                    <div>
                        <p class="text-[8px] font-bold text-gray-400 uppercase">Location Info</p>
                        <p class="text-xs font-black text-gray-900">{{ $contact->country }} ({{ $contact->language }})</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-6 flex items-center justify-between">
                    Audit Log
                    <span class="text-[8px] font-bold bg-gray-50 px-2 py-0.5 rounded">{{ $contact->logs->count() }} events</span>
                </p>
                <div class="space-y-6">
                    @forelse($contact->logs as $log)
                        <div class="relative pl-4 border-l-2 border-gray-100">
                            <div class="absolute -left-[5px] top-0 w-2 h-2 bg-gray-200 rounded-full"></div>
                            <p class="text-[9px] font-black text-gray-900 mb-1">{{ str_replace('_', ' ', $log->action) }}</p>
                            <p class="text-[8px] text-gray-400 font-bold mb-2">{{ $log->created_at->diffForHumans() }} by {{ $log->admin->name ?? 'System' }}</p>
                            @if($log->old_value || $log->new_value)
                                <div class="text-[8px] font-medium text-gray-500 bg-gray-50 p-2 rounded-lg">
                                    <span class="line-through text-red-300">{{ $log->old_value ?? 'NULL' }}</span> → <span class="text-emerald-500">{{ $log->new_value }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-[10px] text-gray-300 font-bold italic py-4">No activity yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
