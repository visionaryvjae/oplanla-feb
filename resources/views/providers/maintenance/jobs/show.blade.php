@extends('layouts.providers')

@section('content')
    <div class="py-12 max-w-7xl mx-auto px-6 md:px-8">
        {{-- back button --}}
        @include('components.back-button', ['route' => route('provider.maintenance.jobs.index'), 'title' => 'Requests'])

        {{-- Header with Status Badge --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900">Review Maintenance Request</h1>
                <p class="text-gray-500 font-medium">Job ID: #{{ $job->id }} &bull; Submitted {{ $job->created_at->diffForHumans() }}</p>
            </div>
            <div>
                @include('components.status-toast', ['item' => $job, 'size'=> 'px-2 py-1', 'uppercase' => ''])
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Left Column: Job Details & Photos --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-purple-50 text-[#ad68e4] rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-gray-900">{{ $job->title }}</h2>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $job->category }} &bull; Room {{ $job->room_id }}</p>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none text-gray-600 mb-8">
                        <p class="font-medium leading-relaxed">{{ $job->description }}</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border border-dashed border-gray-200">
                        <h3 class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Tenant Evidence Photo</h3>
                        @if($job->photo_url)
                            <img src="{{ asset('storage/maintenance/'.$job->photo_url) }}" 
                                class="w-full max-h-96 object-contain rounded-2xl shadow-inner bg-white" alt="Maintenance Issue">
                        @else
                            <div class="py-20 text-center text-gray-300 italic text-sm">No photo provided with this request.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Assignment Form (Create Ticket) --}}
            <div class="space-y-6">
                @if($job->status == 'pending')
                    <div class="bg-gray-900 rounded-xl p-8 text-white shadow-2xl">
                        <h3 class="text-xl font-black mb-6">Assign Technician</h3>
                        
                        <form action="{{ route('provider.maintenance.assign', $job->id) }}" method="POST" class="space-y-5"> {{-- {{ route('provider.tickets.store') }} --}}
                            @csrf
                            <input type="hidden" name="maintenance_job_id" value="{{ $job->id }}">

                            {{-- Technician Selection --}}
                            <div>
                                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Select Technician</label>
                                <select name="maintenance_user_id" class="w-full bg-white/10 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-[#23cab5] py-3 px-4">
                                    <option value="" class="text-gray-900">Choose a professional...</option>
                                    @foreach($technicians as $tech)
                                        <option value="{{ $tech->id }}" class="text-gray-900">{{ $tech->name }} ({{ $tech->specialty }})</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tenant Estimate --}}
                            <div>
                                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Estimated Time (For Tenant)</label>
                                <input type="text" name="tenant_estimate" placeholder="e.g. 2-3 Business Days" 
                                    class="w-full bg-white/10 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-[#23cab5] py-3 px-4 placeholder-gray-500">
                            </div>

                            {{-- Date Range for Technician --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block text-center">Earliest Start</label>
                                    <input type="date" name="earliest_start_date" class="w-full bg-white/10 border-none rounded-xl text-xs font-bold py-3 px-3">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block text-center">Latest Finish</label>
                                    <input type="date" name="latest_completion_date" class="w-full bg-white/10 border-none rounded-xl text-xs font-bold py-3 px-3">
                                </div>
                            </div>

                            <button type="submit" class="w-full py-4 bg-[#23cab5] hover:bg-[#1eb4a1] text-white font-black rounded-xl text-xs uppercase tracking-widest transition-all mt-4 shadow-lg shadow-teal-900/20 active:scale-95">
                                Generate Work Ticket
                            </button>
                        </form>
                    </div>
                @else
                    {{-- If already assigned, show ticket overview --}}
                    <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm space-y-4">
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Active Ticket Info</h3>
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl">
                            <div class="w-10 h-10 bg-[#ccb2e0] text-[#9345d3] rounded-xl flex items-center justify-center font-black">
                                {{ substr($job->ticket->user->name ?? 'T', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-900 uppercase tracking-tighter">{{ $job->ticket->user->name ?? 'Assigned Tech' }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $job->ticket->user->specialty ?? 'General' }} specialist</p>
                            </div>
                        </div>
                        <a href="{{ route('provider.maintenance.tickets.show', $job->ticket->id) }}" class="block w-full text-center py-3 border-2 border-gray-100 text-gray-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-[#ad68e4] hover:text-[#ad68e4] transition-all">
                            View Detailed Ticket
                        </a>
                    </div>
                @endif

                <div class="bg-[#ad68e4] rounded-xl p-8 text-white relative overflow-hidden">
                    <h4 class="font-black text-lg mb-2 relative z-10">Quick Support</h4>
                    <p class="text-xs font-medium text-white/80 relative z-10 leading-relaxed">Need to cancel this job or change the category? Contact the administrative support team.</p>
                    <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-white/10 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                </div>
            </div>
        </div>
    </div>
@endsection