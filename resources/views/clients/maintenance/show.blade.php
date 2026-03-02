@extends('layouts.tenant')

@section('content')
    <div class="py-12 max-w-[90rem] mx-auto px-6 md:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('tenant.maintenance.index') }}" class="text-sm font-bold text-black hover:text-[#ad68e4] hover:underline flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to History
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Job #{{ $job->id }}: {{ $job->title }}</h1>
            </div>
            
            @include('components.status-toast', ['item' => $job, 'size' => 'px-4 py-2', 'txtSize' => 'text-md uppercase'])
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6" style="color: #ad68e4;">Issue Description</h3>
                        
                        <div class="prose max-w-none text-gray-700">
                            <p class="text-lg leading-relaxed">{{ $job->description }}</p>
                        </div>

                        @if($job->image_path)
                            <div class="mt-8 pt-8 border-t border-gray-50">
                                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Evidence / Photos</h3>
                                <div class="relative group w-full max-w-md">
                                    <img src="{{ asset('storage/' . $job->image_path) }}" 
                                         class="rounded-xl shadow-md border border-gray-100 hover:opacity-95 transition-opacity">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6">Activity Log</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-2 h-2 rounded-full bg-[#e468ad] mt-2"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Request Created</p>
                                <p class="text-xs text-gray-500">{{ $job->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @if($job->ticket)
                            <div class="flex gap-4">
                                <div class="w-2 h-2 rounded-full bg-[#e4ad68] mt-2"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Provider Assigned</p>
                                    <p class="text-xs text-gray-500">{{ $job->ticket->earliest_start_date->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @if($job->ticket->status == 'completed')
                                <div class="flex gap-4">
                                    <div class="w-2 h-2 rounded-full bg-[#68e4ad] mt-2"></div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">Ticket Completed</p>
                                        <p class="text-xs text-gray-500">{{ $job->ticket->completed_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6">Service Summary</h3>
                    
                    @if($job->ticket)
                    <div class="space-y-5">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">Assigned Provider</span>
                            <span class="text-gray-900 font-black text-base">{{ $job->room->provider->provider_name ?? 'Professional Services Ltd' }}</span>
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase block">Technician</span>
                            <div class="flex items-center mt-1">
                                @include('components.user-avatar', ['user' => $job->ticket->user, 'size' => '2rem'])
                                <span class="text-gray-900 font-bold">{{ $job->ticket->user->   name ?? 'Technician TBD' }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-50">
                                <span class="text-xs font-bold text-gray-400 uppercase block">Estimated maintenance schedule</span>
                                <span class="text-gray-900 font-black">
                                    {{ $job->ticket->tenant_estimate ? $job->ticket->tenant_estimate : 'Awaiting Schedule' }}
                                </span>
                            </div>
                    </div>
                    @else
                    <div class="text-center py-6">
                        <div class="bg-purple-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-[#ad68e4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-900">Awaiting Assignment</p>
                        <p class="text-xs text-gray-500 mt-1">We are currently finding a technician for your request.</p>
                    </div>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <button class="w-full py-3 rounded-xl border-2 border-gray-100 text-gray-600 font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Message Admin
                        </button>
                        
                        @if($job->status == 'pending')
                        <button class="w-full py-3 rounded-xl border-2 border-red-50 text-red-500 font-bold hover:bg-red-50 transition-colors">
                            Cancel Request
                        </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection