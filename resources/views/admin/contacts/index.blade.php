@extends('admin.layout')

@section('page_title', 'Contact Requests')

@section('content')
<div class="space-y-8">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">New Messages</p>
                <h3 class="text-3xl font-black text-[#4F0C2A]">{{ $stats['new'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-[#F797B6]/20 text-[#4F0C2A] rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Active Messages</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $stats['active'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-4 px-2">
        <a href="{{ route('admin.contacts.index') }}" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ !request()->routeIs('admin.contacts.resolved') ? 'bg-[#4F0C2A] text-white shadow-lg' : 'bg-white text-gray-400 hover:text-gray-600 border border-gray-100' }}">
            Inbox (Pending)
        </a>
        <a href="{{ route('admin.contacts.resolved') }}" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ request()->routeIs('admin.contacts.resolved') ? 'bg-[#4F0C2A] text-white shadow-lg' : 'bg-white text-gray-400 hover:text-gray-600 border border-gray-100' }}">
            Archive (Resolved)
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.contacts.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ID, Email, Name..." class="w-full bg-gray-50 border-none rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#F797B6] transition">
            </div>
            <div>
                <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Status</label>
                <select name="status" class="w-full bg-gray-50 border-none rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#F797B6] appearance-none">
                    <option value="">All Status</option>
                    @foreach(['new', 'in_progress', 'resolved', 'closed', 'spam'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Priority</label>
                <select name="priority" class="w-full bg-gray-50 border-none rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#F797B6] appearance-none">
                    <option value="">All Priority</option>
                    @foreach(['low', 'normal', 'high', 'urgent'] as $p)
                        <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[8px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Category</label>
                <select name="category" class="w-full bg-gray-50 border-none rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#F797B6] appearance-none">
                    <option value="">All Categories</option>
                    @foreach(['general', 'feedback', 'bug_report', 'feature_request', 'account', 'payment', 'content', 'copyright', 'privacy', 'other'] as $c)
                        <option value="{{ $c }}" {{ request('category') == $c ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $c)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-[#4F0C2A] text-white px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:opacity-90 transition">Apply Filters</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[1.5rem] border border-gray-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400">Request ID</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400">User</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400">Category</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400 text-center">Status / Priority</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400 text-right">Date</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-[#4F0C2A] bg-[#F797B6]/20 px-3 py-1 rounded-lg">{{ $contact->request_id }}</span>
                                <p class="text-xs font-bold text-gray-900 mt-2 truncate max-w-[200px]">{{ $contact->subject }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-black text-gray-900">{{ $contact->name ?? 'Anonymous' }}</p>
                                <p class="text-[10px] font-bold text-gray-400">{{ $contact->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[9px] font-black uppercase tracking-widest text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md">
                                    {{ str_replace('_', ' ', $contact->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1.5">
                                    <span class="text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full
                                        @if($contact->status == 'new') bg-blue-100 text-blue-600 @elseif($contact->status == 'resolved') bg-emerald-100 text-emerald-600 @else bg-gray-100 text-gray-600 @endif">
                                        {{ $contact->status }}
                                    </span>
                                    <span class="text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full
                                        @if($contact->priority == 'urgent') bg-red-100 text-red-600 @elseif($contact->priority == 'high') bg-orange-100 text-orange-600 @else bg-gray-100 text-gray-400 @endif">
                                        {{ $contact->priority }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-[10px] font-black text-gray-900" data-utc="{{ $contact->created_at->toIso8601String() }}" data-format="date">
                                    {{ $contact->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-[9px] font-bold text-gray-400" data-utc="{{ $contact->created_at->toIso8601String() }}" data-format="timeago">
                                    {{ $contact->created_at->diffForHumans() }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="bg-gray-900 text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-black transition active:scale-95">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest italic">No requests found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
