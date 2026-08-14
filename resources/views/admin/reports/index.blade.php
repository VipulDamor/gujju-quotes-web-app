@extends('admin.layout')

@section('page_title', 'Review Reports')

@section('content')
<div class="space-y-8 md:space-y-12">
    <!-- Filter Section (Responsive) -->
    <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div>
                <label for="ip_address" class="block text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">IP Address</label>
                <input type="text" name="ip_address" id="ip_address" value="{{ request('ip_address') }}" placeholder="192.168..."
                    class="w-full bg-gray-50 border-none rounded-xl md:rounded-2xl px-4 py-2.5 md:px-5 md:py-3 text-sm focus:ring-2 focus:ring-red-100 transition">
            </div>

            <div>
                <label for="device_id" class="block text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Device ID</label>
                <input type="text" name="device_id" id="device_id" value="{{ request('device_id') }}" placeholder="Filter ID..."
                    class="w-full bg-gray-50 border-none rounded-xl md:rounded-2xl px-4 py-2.5 md:px-5 md:py-3 text-sm focus:ring-2 focus:ring-red-100 transition">
            </div>

            <div>
                <label for="category_id" class="block text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Category</label>
                <select name="category_id" id="category_id" class="w-full bg-gray-50 border-none rounded-xl md:rounded-2xl px-4 py-2.5 md:px-5 md:py-3 text-sm focus:ring-2 focus:ring-red-100 transition appearance-none cursor-pointer">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="report_option_id" class="block text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Reason</label>
                <select name="report_option_id" id="report_option_id" class="w-full bg-gray-50 border-none rounded-xl md:rounded-2xl px-4 py-2.5 md:px-5 md:py-3 text-sm focus:ring-2 focus:ring-red-100 transition appearance-none cursor-pointer">
                    <option value="">All Reasons</option>
                    @foreach($options as $id => $label)
                        <option value="{{ $id }}" {{ request('report_option_id') == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 lg:col-span-4 flex flex-col sm:flex-row items-center justify-end gap-3 md:gap-4 mt-2">
                <a href="{{ route('admin.reports.index') }}" class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition px-4 py-2">
                    Clear Filters
                </a>
                <button type="submit" class="w-full sm:w-auto bg-red-600 text-white px-8 py-3 rounded-xl md:rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 shadow-lg shadow-red-600/20 transition active:scale-95">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    @forelse($groupedReports as $optionId => $reports)
        <section class="animate-fade-in">
            <div class="flex items-center gap-4 mb-6 px-2">
                <div class="px-3 md:px-4 py-1 md:py-1.5 bg-red-100 text-red-700 rounded-full text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap">
                    Reason: {{ $options[$optionId] ?? 'Unknown' }}
                </div>
                <div class="flex-1 h-px bg-gray-100"></div>
                <div class="text-[8px] md:text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $reports->count() }} Case(s)</div>
            </div>

            <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto custom-scroll">
                    <table class="w-full text-left min-w-[800px]">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 md:px-10 py-4 md:py-5 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400">Reported Quote</th>
                                <th class="px-6 md:px-10 py-4 md:py-5 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 w-1/3">Context & Device</th>
                                <th class="px-6 md:px-10 py-4 md:py-5 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-gray-400 w-48 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reports as $report)
                                <tr class="hover:bg-red-50/20 transition">
                                    <td class="px-6 md:px-10 py-6">
                                        <p class="text-sm md:text-base text-gray-900 font-bold leading-relaxed max-w-sm">"{{ $report->quote_text }}"</p>
                                        <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mt-3 flex items-center gap-2" data-utc="{{ $report->timestamp->toIso8601String() }}" data-format="timeago">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $report->timestamp->diffForHumans() }}
                                        </p>
                                    </td>
                                    <td class="px-6 md:px-10 py-6">
                                        @if($report->additional_details)
                                            @php
                                                $details = json_decode($report->additional_details, true);
                                                $isJson = (json_last_error() == JSON_ERROR_NONE && is_array($details));
                                            @endphp

                                            @if($isJson)
                                                <div class="flex flex-wrap gap-2">
                                                    @if(isset($details['ip_address']))
                                                        <div class="flex items-center gap-1.5 text-[8px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">IP: {{ $details['ip_address'] }}</div>
                                                    @endif
                                                    @if(isset($details['app_version']))
                                                        <div class="flex items-center gap-1.5 text-[8px] font-black text-[#4F0C2A] bg-[#F797B6]/20 px-2.5 py-1 rounded-lg">v{{ $details['app_version'] }}</div>
                                                    @endif
                                                    @if(isset($details['message']))
                                                        <div class="w-full text-xs text-gray-600 bg-gray-50 p-3 rounded-xl italic border-l-2 border-gray-200 mt-2">
                                                            {{ $details['message'] }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-xl italic">{{ $report->additional_details }}</div>
                                            @endif
                                        @else
                                            <span class="text-[10px] text-gray-300 font-bold uppercase italic">No details</span>
                                        @endif
                                    </td>
                                    <td class="px-6 md:px-10 py-6 text-right">
                                        <div class="flex flex-col gap-2 min-w-[120px]">
                                            <form action="{{ route('admin.reports.delete-quote', $report->report_id) }}" method="POST" onsubmit="return confirm('DELETE THE QUOTE FOREVER?')">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-700 transition active:scale-95">
                                                    Delete
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reports.destroy', $report->report_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-gray-100 text-gray-500 px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-200 transition active:scale-95">
                                                    Dismiss
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
            <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 tracking-tight mb-1 italic">Inbox Zero!</h3>
            <p class="text-gray-400 font-bold uppercase text-[9px] tracking-widest">No pending reports for review</p>
        </div>
    @endforelse
</div>
@endsection
