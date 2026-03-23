@extends('layouts.technician')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-4 lg:p-8">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900">Maintenance Dashboard</h1>
            <p class="text-gray-500 font-medium mt-1 text-sm uppercase tracking-wide">Manage jobs, update status, and track deadlines</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search jobs..." class="pl-10 pr-4 py-2 border-none bg-white rounded-xl shadow-sm focus:ring-2 focus:ring-[#23cab5] w-64 text-sm font-medium">
                <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Completed Today --}}
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.333 16a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z"></path></svg>
            </div>
            <p class="text-gray-400 text-sm font-black uppercase tracking-tighter">Completed Today</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-4xl font-black text-gray-900">{{ $tickets->filter(fn($ticket) => $ticket->completed_at && $ticket->completed_at->isToday())->count() }}</h3>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"></path></svg>
                    23%
                </span>
            </div>
        </div>

        

        {{-- Urgent Jobs --}}
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            </div>
            <p class="text-gray-400 text-sm font-black uppercase tracking-tighter">Urgent Tasks</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-4xl font-black text-gray-900">{{ $tickets->whereNull('completed_at')->where('status', 'in_progress')->count() }}</h3>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"></path></svg>
                    13%
                </span>
            </div>
        </div>

        {{-- New Requests --}}
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-teal-50 text-[#23cab5] rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
            </div>
            <p class="text-gray-400 text-sm font-black uppercase tracking-tighter">Pending Assignment</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-4xl font-black text-gray-900">{{ $tickets->whereNull('completed_at')->count() }}</h3>
                <span class="text-xs font-bold text-yellow-500 bg-yellow-50 px-2 py-1 rounded-lg flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"></path></svg>
                    64%
                </span>
            </div>
        </div>
    </div>

    {{-- Tickets Table / List View --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-black text-gray-900">Recent Maintenance Jobs</h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-600 uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-.293.707V17l-4 4v-6.586a1 1 0 01-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter by Status
                </button>
            </div>
        </div>

        @php
            // dd($tickets);
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($tickets as $ticket)
            {{-- Ticket Card --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between px-4 py-4 rounded-3xl transition-all border-2  {{ $ticket->status == 'in_progress' ? 'border-orange-100 bg-orange-50/20' : 'border-gray-50 bg-white hover:border-[#ad68e4]/20' }}">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="flex w-32 h-32 overflow-hidden">
                        <img src="{{ $ticket->job->photo_url ? asset('storage/maintenance/' . $ticket->job->photo_url) : 'https://placehold.co/800x800/ceffe8/38ee81?text='.$ticket->job->category }}" alt="" class="w-32 h-32 rounded-lg object-cover">
                    </div>
                    <div class="flex flex-col space-y-4 items-start md:col-span-2">
                        <div class="w-full">
                            @include('components.status-toast', ['item' => $ticket])
                        </div>    
                        <div class="w-full ">
                            <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                                <h4 class="font-black text-gray-900">{{ $ticket->job->title ?? 'Maintenance Task' }}</h4>
                                @if($ticket->status == 'in_progress')
                                    <span class="md:bg-orange-500 text-orange-500 md:text-white text-[10px] md:px-2 md:py-0.5 rounded-full font-black uppercase tracking-widest">Urgent</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-400 font-bold uppercase tracking-wider">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $ticket->job->room->tenant->name ?? 'Tenant Name' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $ticket->latest_completion_date->format('Y-m-d') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex sm:flex-row md:flex-col md:space-y-2 items-center gap-4 mt-4 md:mt-0">
                    
                    <a href="{{ route('technician.tickets.show', $ticket->id) }}" class="flex items-center justify-center p-2 md:px-4 md:py-2  border-gray-100 border rounded-md hover:border-[#ad68e4] hover:bg-[#ad68e4] hover:text-white text-xs font-black text-gray-600 transition-all active:scale-95">
                        View Details
                    </a>
                    @if ($ticket->completion_photo_path && !$ticket->completed_at)
                        <a href="{{ route('technician.tickets.show', $ticket->id) }}" class="flex items-center justify-center p-2 md:px-4 md:py-2  border-gray-100 border rounded-md bg-[#ad68e4] text-white hover:border-white hover:bg-white hover:text-gray-600 text-xs font-black transition-all active:scale-95">
                            Mark as Complete
                        </a>
                    @endif
                </div>
            </div>
            @empty
                <div class="py-20 text-center">
                    <img src="https://illustrations.popsy.co/gray/status-update.svg" class="w-48 mx-auto mb-4 opacity-50">
                    <p class="text-gray-400 font-bold uppercase tracking-widest">No maintenance tasks assigned yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection