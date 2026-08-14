@extends('admin.layout')

@section('page_title', 'Resolved Archive')

@section('content')
<div class="space-y-8">
    <!-- Header Navigation -->
    <div class="flex items-center gap-4 px-2">
        <a href="{{ route('admin.contacts.index') }}" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white text-gray-400 hover:text-gray-600 border border-gray-100 transition">
            Inbox (Pending)
        </a>
        <a href="{{ route('admin.contacts.resolved') }}" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-[#4F0C2A] text-white shadow-lg transition">
            Archive (Resolved)
        </a>
    </div>

    <!-- Simple Search -->
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.contacts.resolved') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Archive by ID, Email, Name..." class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#F797B6] transition">
            </div>
            <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:opacity-90 transition">Search Archive</button>
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
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400 text-center">Final Status</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400 text-right">Resolved On</th>
                        <th class="px-6 py-4 text-[8px] font-black uppercase tracking-widest text-gray-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-gray-400 bg-gray-100 px-3 py-1 rounded-lg">{{ $contact->request_id }}</span>
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
                                <span class="text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full
                                    @if($contact->status == 'resolved') bg-emerald-100 text-emerald-600 @elseif($contact->status == 'spam') bg-red-100 text-red-600 @else bg-gray-100 text-gray-600 @endif">
                                    {{ $contact->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-[10px] font-black text-gray-900" data-utc="{{ $contact->updated_at->toIso8601String() }}" data-format="date">
                                    {{ $contact->updated_at->format('M d, Y') }}
                                </p>
                                <p class="text-[9px] font-bold text-gray-400" data-utc="{{ $contact->updated_at->toIso8601String() }}" data-format="timeago">
                                    {{ $contact->updated_at->diffForHumans() }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="bg-gray-900 text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-black transition active:scale-95">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest italic">The archive is empty</p>
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
