@extends('layouts.providers')

@section('content')
    <div class="py-12 max-w-7xl mx-auto px-6 md:px-8">
        {{-- back button --}}
        @include('components.back-button', ['route' => route('provider.maintenance.tickets.index'), 'title' => 'Tickets'])
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-8 border-b border-gray-100">
            <div>
                <h1 class="text-3xl font-black text-gray-900">Maintenance Oversight</h1>
                <p class="text-gray-500 font-medium mt-1">Ticket #{{ $ticket->id }} &raquo; Job: {{ $ticket->job->title ?? 'Maintenance Task' }}</p>
            </div>
            <div>
                @include('components.status-toast', ['item' => $ticket, 'size' => 'px-3 py-2', 'txtSize' => 'text-md font-semibold'])
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            {{-- General Info Card --}}
            <div class="lg:col-span-2 bg-white rounded-xl p-8 border border-gray-100 shadow-sm relative overflow-hidden space-y-3">
                <h3 class="text-sm font-black text-[#ad68e4] uppercase tracking-widest mb-6">Job Summary</h3>
                <p class="font-black text-gray-900 text-lg">{{ $ticket->job->title }}</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $ticket->job->description }}</p>
                <p class="flex justify-between items-center text-sm font-medium border-t border-gray-100 pt-3 mt-3">
                    <span class="text-gray-400">Room <span class="text-[#ad68e4]">#</span></span> 
                    <span class="font-bold text-gray-900">Room {{ $ticket->job->room_id ?? 'N/A' }}</span>
                </p>
                @if($ticket->completed_at)
                    <p class="text-xs text-gray-400 font-bold uppercase pt-2">Finalized: <span class="text-[#55b78b]">{{ $ticket->completed_at->format('d M Y, H:i') }}</span></p>
                @endif
            </div>

            {{-- Schedule Card --}}
            <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm text-center relative flex flex-col items-center justify-center">
                <div class="w-16 h-16 {{ $ticket->completed_at ? 'bg-green-50 text-green-500' : ' bg-red-50 text-red-500' }} rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                @if ($ticket->completed_at)
                    <h3 class="text-xl font-black text-gray-900">Completed: <br> {{ $ticket->completed_at->diffForHumans() }}</h3>
                @else
                    <h3 class="text-xl font-black text-gray-900">{{ $ticket->latest_completion_date->diffForHumans() }}</h3>    
                    <p class="text-[10px] font-black uppercase text-red-500 tracking-widest mt-1">Remaining to Deadline</p>
                <p class="text-[11px] font-bold text-gray-400 mt-3">{{ $ticket->earliest_start_date->format('d M') }} &ndash; {{ $ticket->latest_completion_date->format('d M Y') }}</p>
                @endif
            </div>

            {{-- Assignments Card --}}
            <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm relative overflow-hidden space-y-3">
                <h3 class="text-sm font-black text-[#ad68e4] uppercase tracking-widest mb-6">Assignment Flow</h3>
                <p class="text-sm font-medium"><span class="text-gray-400">Category:</span> <span class="text-xs font-bold bg-[#ad68e4]/10 text-[#ad68e4] px-3 py-1 rounded-full">{{ $ticket->job->category ?? 'General' }}</span></p>
                {{-- Need to eager-load 'user' relationship on MaintenanceTicket model --}}
                <p class="text-sm font-medium"><span class="text-gray-400">Technician:</span> <strong class="text-gray-900">{{ $ticket->user->name ?? 'Technician' }}</strong></p>
                {{-- Need to eager-load 'user' relationship on MaintenanceTicket model --}}
                <p class="text-sm font-medium"><span class="text-gray-400">Tenant:</span> <strong class="text-gray-900">{{ $ticket->job->room->tenant->name ?? 'Tenant' }}</strong></p>
                {{-- Need to eager-load property/owner relationships to show this reliably --}}
                <p class="text-sm font-medium"><span class="text-gray-400">Property Owner:</span> <strong class="text-gray-900">(You)</strong></p>
            </div>
        </div>

        {{-- Read-only Photo Gallery Section --}}
        <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm">
            <h2 class="text-xl font-black text-gray-900 mb-8">Service Photo Documentation</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Problem Photo --}}
                <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-200 text-center relative">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Original Problem (Tenant Post)</p>
                    @if($ticket->job->photo_url)
                        <img src="{{ asset('storage/maintenance/'.$ticket->job->photo_url) }}" 
                            class="w-full max-h-96 object-contain rounded-2xl shadow-inner bg-white" alt="Maintenance Issue">
                    @else
                        <div class="h-64 rounded-xl border-2 border-dashed border-gray-100 text-gray-300 flex items-center justify-center italic text-sm">
                            No photo provided by tenant
                        </div>
                    @endif
                </div>

                {{-- Completion Photo --}}
                <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-200 text-center relative">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Completion Proof (Technician Upload)</p>
                    @if($ticket->completion_photo_path)
                        <img src="{{ asset('storage/maintenance/' . $ticket->completion_photo_path) }}" 
                            class="h-64 rounded-xl border border-gray-100 mx-auto object-cover transition-transform hover:scale-105" alt="Completion photo">
                    @else
                        <div class="h-64 rounded-xl border-2 border-dashed border-gray-100 text-gray-300 flex items-center justify-center italic text-sm">
                            Waiting for technician upload
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection