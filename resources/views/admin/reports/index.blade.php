@extends('admin.layout')

@section('page_title', 'Review Reports')

@section('content')
<div class="space-y-12">
    <!-- Filter Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label for="ip_address" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">IP Address</label>
                <input type="text" name="ip_address" id="ip_address" value="{{ request('ip_address') }}" placeholder="Filter by IP..."
                    class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-red-100 transition">
            </div>

            <div>
                <label for="device_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Device ID</label>
                <input type="text" name="device_id" id="device_id" value="{{ request('device_id') }}" placeholder="Filter by Device ID..."
                    class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-red-100 transition">
            </div>

            <div>
                <label for="category_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Category</label>
                <select name="category_id" id="category_id" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-red-100 transition">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="report_option_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Reason</label>
                <select name="report_option_id" id="report_option_id" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-red-100 transition">
                    <option value="">All Reasons</option>
                    @foreach($options as $id => $label)
                        <option value="{{ $id }}" {{ request('report_option_id') == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-4 flex items-center justify-end gap-4">
                <a href="{{ route('admin.reports.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition">
                    Clear Filters
                </a>
                <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 shadow-lg shadow-red-600/20 transition active:scale-95">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    @forelse($groupedReports as $optionId => $reports)
        <section>
            <div class="flex items-center gap-4 mb-6">
                <div class="px-4 py-1.5 bg-red-100 text-red-700 rounded-full text-[10px] font-black uppercase tracking-[0.2em]">
                    Reason: {{ $options[$optionId] ?? 'Unknown' }}
                </div>
                <div class="flex-1 h-px bg-gray-100"></div>
                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $reports->count() }} Case(s)</div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Reported Quote</th>
                                <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 w-1/3">Additional Details</th>
                                <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 w-48">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reports as $report)
                                <tr class="hover:bg-red-50/20 transition">
                                    <td class="px-10 py-6">
                                        <p class="text-gray-900 font-bold leading-relaxed">"{{ $report->quote_text }}"</p>
                                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-2 flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $report->timestamp }}
                                        </p>
                                    </td>
                                    <td class="px-10 py-6">
                                        @if($report->additional_details)
                                            @php
                                                $details = json_decode($report->additional_details, true);
                                                $isJson = (json_last_error() == JSON_ERROR_NONE && is_array($details));
                                            @endphp

                                            @if($isJson)
                                                <div class="space-y-3">
                                                    @if(isset($details['ip_address']))
                                                        <div class="flex items-center gap-2 text-[10px] font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg w-fit">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                                                            IP: {{ $details['ip_address'] }}
                                                        </div>
                                                    @endif

                                                    @if(isset($details['deviceID']))
                                                        <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 border border-gray-100 px-3 py-1.5 rounded-lg w-fit truncate max-w-[200px]" title="{{ $details['deviceID'] }}">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                            ID: {{ $details['deviceID'] }}
                                                        </div>
                                                    @endif

                                                    @if(isset($details['app_version']))
                                                        <div class="flex items-center gap-2 text-[10px] font-black text-[#4F0C2A] bg-[#F797B6]/20 px-3 py-1.5 rounded-lg w-fit">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"/></svg>
                                                            v{{ $details['app_version'] }}
                                                        </div>
                                                    @endif

                                                    @if(isset($details['message']))
                                                        <div class="text-sm text-gray-600 bg-gray-50 p-4 rounded-2xl italic border-l-4 border-gray-200">
                                                            {{ $details['message'] }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500 bg-gray-50 p-4 rounded-2xl italic">
                                                    {{ $report->additional_details }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-300 italic">No extra details provided</span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-6">
                                        <div class="flex flex-col gap-2">
                                            <form action="{{ route('admin.reports.delete-quote', $report->report_id) }}" method="POST" onsubmit="return confirm('DELETE THE QUOTE FOREVER?')">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 shadow-md shadow-red-600/10 transition active:scale-95">
                                                    Delete Quote
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reports.destroy', $report->report_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-gray-100 text-gray-500 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 transition active:scale-95">
                                                    Dismiss Report
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @empty
        <div class="py-20 text-center">
            <div class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-2 italic">Peace and Quiet.</h3>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">No pending reports for your review</p>
        </div>
    @endforelse
</div>
@endsection
