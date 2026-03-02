@extends('layouts.providers')

@section('content')
    <div class="flex flex-col w-full items-start justify-center space-y-6 p-4">
        @php
            $resolved = $tickets->where('status', 'resolved');
            $inProgress = $tickets->where('status', 'in_progress');
        @endphp
        <div class="space-y-4">
            <h3 class="font-black text-gray-400 uppercase text-xs tracking-widest px-2 flex justify-between">
                New Requests <span>({{ $jobs->count()}})</span>
            </h3>
            <div class="flex justify-center items-center overflow-x-auto gap-4">
                @forelse ($jobs as $job)
                    <div class="max-w-lg bg-white p-4 rounded-2xl shadow-sm border border-l-4 border-l-[#ad68e4] hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4">
                            <img src="{{ $job->photo_url ? asset('storage/maintenance/' . $job->photo_url) : 'https://placehold.co/800x800/aec8ff/3881ff?text='.$job->category }}" alt="Issue Image" class="h-32 rounded-lg object-cover">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-[10px] font-bold bg-[#ad68e4]/10 text-[#ad68e4] px-2 py-0.5 rounded">{{ $job->category }}</span>
                                    <p class="text-[10px] text-gray-400 font-bold">{{ $job->created_at->diffForhumans() }}</p>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-1">{{ $job->title }}</h4>
                                <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $job->description }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t pt-4 mt-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-800">Room {{ $job->room_id }}</span>
                                <span class="text-xs font-bold text-gray-600">user: {{ $job->room->tenant->name }}</span>
                            </div>
                            <a href="{{ route('provider.maintenance.create.ticket', $job->id) }}" class="text-[#68e4ad] font-bold text-xs hover:underline flex items-center gap-1">
                                Assign Ticket <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
            </div>
                
            @endforelse
        </div>
    
        <div class="flex flex-col space-y-4">
            <h3 class="font-black text-gray-400 uppercase text-xs tracking-widest px-2 flex justify-between">
                In Progress <span>({{ $tickets->count() }})</span>
            </h3>
            <div class="grid grid-flow-col overflow-x-auto space-x-4">
                @forelse ($tickets as $ticket)
                    <div class="flex flex-col bg-white px-4 py-3 rounded-2xl shadow-sm border border-l-4 border-l-[#68e4ad]">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                {{-- <img src="/staff1.jpg" class="w-6 h-6 rounded-full border border-[#68e4ad]"> --}}
                                <div class="p-1">
                                    @include('components.user-avatar', ['user' => $ticket->user, 'size' => '2.5rem'])
                                </div>
                                <p class="text-[10px] font-bold text-gray-800">{{ $ticket->user->name }} ({{ $ticket->user->specialty }})</p>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Est: 14:00</span>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">{{ $ticket->job->title }}</h4>
                        <div class="mt-4 flex justify-between items-end">
                            <p class="text-xs text-gray-400">Current Cost: <span class="text-[#ad68e4] font-bold">R {{ number_format($ticket->job->cost ?? 0, 2) }}</span></p>
                            <div class="w-12 h-1 bg-gray-100 rounded-full overflow-hidden">
                                <div class="bg-[#68e4ad] h-full w-2/3"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 italic">No active tickets at the moment.</p>
                @endforelse
            </div>
        </div>
    
        <div class="space-y-4 opacity-70">
            <h3 class="font-black text-gray-400 uppercase text-xs tracking-widest px-2">Resolved</h3>
            </div>
    </div>
@endsection