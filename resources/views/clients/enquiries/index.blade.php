{{-- @extends('layouts.app') 

@section('content') --}}
<div class="mx-auto w-full py-10 sm:px-6 lg:px-8" style="max-width:90%;">
    @php
        $enquiries = Auth::guard('web')->user()->enquiries;
    @endphp
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 sm:shadow-md">
        <div class="px-6 py-4 border-b border-gray-100 bg-purple-600">
            <h1 class="text-2xl font-bold text-white">My Booking Enquiries</h1>
            <p class="text-purple-100">Track your requests and messages with accommodation providers.</p>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse ($enquiries as $enquiry)
                <a href="{{ route('client.enquiry.show', $enquiry->id) }}" class="block hover:bg-slate-50 transition-colors">
                    <div class="px-6 py-4 flex md:flex-row flex-col items-center md:justify-between justify-center">
                        <div class="flex flex-col md:flex-row items-center space-x-4">
                            <div class="h-12 w-12 rounded-lg bg-purple-100 md:flex hidden items-center justify-center text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <div class="px-2">
                                <p class="text-sm font-bold text-gray-900">Room #{{ $enquiry->room->id }} at {{ $enquiry->room->provider->provider_name }}</p>
                                <p class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($enquiry->message, 45) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col w-full md:flex-col-reverse text-right items-end justify-center">
                            <span class="text-xs text-gray-400 block mt-1">{{ $enquiry->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="py-20 text-center">
                    <p class="text-gray-400">You haven't made any enquiries yet.</p>
                    <a href="{{ route('rentals.landing') }}" class="flex px-4 py-2 mt-4 font-semibold italic items-center justify-center" style="background-color: #ad57e4;">Explore Rooms</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
{{-- @endsection --}}