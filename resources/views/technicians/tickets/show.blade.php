@extends('layouts.technician')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900">Ticket #{{ $ticket->id }}</h1>
            <p class="text-gray-500 font-medium">Job: {{ $ticket->job->title ?? 'Maintenance Task' }}</p>
        </div>
        <div>
            @if($ticket->completed_at)
                <span class="flex items-center gap-2 bg-green-50 text-green-600 px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-widest border border-green-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    Job Completed
                </span>
            @else
                @include('components.status-toast', ['item' => $ticket, 'txtSize' => 'text-md', 'size' => 'px-3 py-2'])
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Main Action Panel --}}
        <div class="lg:col-span-2 bg-white rounded-3xl px-3 py-6 md:p-8 border border-gray-100 shadow-sm relative">
            <h2 class="text-xl font-black text-gray-900 mb-6">Work Order & Photo Verification</h2>

            {{-- Photo Comparison Block --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                {{-- Left: Original Problem from user_id photo_url (image_2.png) --}}
                <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-200 text-center relative">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Tenant's Problem Photo</p>
                    @if($ticket->job->photo_url)
                        <img src="{{ asset('storage/maintenance/' . $ticket->job->photo_url) }}" 
                             class="h-48 rounded-xl border border-gray-100 mx-auto object-cover transition-transform hover:scale-105" alt="Original problem photo">
                    @else
                        <div class="h-48 rounded-xl border-2 border-dashed border-gray-100 text-gray-300 flex items-center justify-center italic text-xs">
                            No photo uploaded by tenant
                        </div>
                    @endif
                </div>

                {{-- Right: Completion Proof from maintenance_user_id completion_photo_path (image_1.png) --}}
                <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-200 text-center relative">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Your Work Proof Photo</p>
                    @if($ticket->completion_photo_path)
                        <img src="{{ asset('storage/maintenance/'. $ticket->completion_photo_path) }}" 
                             class="h-48 rounded-xl border border-gray-100 mx-auto object-cover transition-transform hover:scale-105" alt="Completion proof photo">
                    @else
                        {{-- Reuse your previous upload component idea from image_e1d25d.jpg --}}
                        <form action="{{ route('technician.ticket.upload.photo', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="h-48 rounded-xl border-2 border-dashed border-gray-100 text-gray-300 hover:border-[#ad68e4]/50 hover:bg-white hover:text-[#ad68e4] transition-all flex flex-col items-center justify-center cursor-pointer group">
                                <input type="file" name="photo" class="hidden" accept="image/*" capture="environment" onchange="this.form.submit()">
                                <svg class="w-10 h-10 mb-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span class="text-[10px] font-black uppercase tracking-widest">Snap Completion Photo</span>
                            </label>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Action Forms Block --}}
            <div class="flex items-center md:justify-start justify-end gap-4 border-t border-gray-100 pt-8 mt-8">
                @if(!$ticket->completed_at)
                    {{-- Complete Button (Disabled without photo) --}}
                    <form action="{{ route('technician.ticket.complete', $ticket->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition shadow-md
                                {{ $ticket->completion_photo_path ? 'bg-[#23cab5] text-white shadow-teal-100 active:scale-95' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                {{ !$ticket->completion_photo_path ? 'disabled' : '' }}>
                            Mark as Complete
                        </button>
                    </form>
                    
                    @if(!$ticket->completion_photo_path)
                        <p class="text-[11px] text-orange-400 font-black mt-2 uppercase flex items-center gap-1.5 bg-orange-50 px-3 py-1.5 rounded-full border border-orange-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Photo Proof is required for completion
                        </p>
                    @endif
                @endif
            </div>
            
        </div>

        {{-- Sidebar Info Card --}}
        <div class="space-y-6">
            {{-- General Details --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-3">
                <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Location & Details</h4>
                <p class="flex justify-between items-center text-sm font-medium">
                    <span class="text-gray-400">Category:</span> 
                    <span class="bg-gray-100 px-3 py-1 rounded text-xs font-black uppercase text-gray-600">{{ $ticket->job->category ?? 'General' }}</span>
                </p>
                <p class="flex justify-between items-center text-sm font-medium">
                    <span class="text-gray-400">Room:</span> 
                    <span class="font-bold text-gray-900">Room {{ $ticket->job->room_id ?? 'N/A' }}</span>
                </p>
            </div>

            {{-- Schedule Details --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-3">
                <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Assignment Dates</h4>
                <p class="text-sm font-medium"><span class="text-gray-400">Earliest Start:</span> {{ $ticket->earliest_start_date->format('d M Y') }}</p>
                <p class="text-sm font-medium"><span class="text-gray-400">Latest Completion:</span> {{ $ticket->latest_completion_date->format('d M Y') }}</p>
                <p class="text-sm font-medium border-t border-gray-100 pt-3 mt-3"><span class="text-gray-400">Tenant Estimate:</span> <span class="font-bold text-[#ad68e4]">{{ $ticket->tenant_estimate }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection