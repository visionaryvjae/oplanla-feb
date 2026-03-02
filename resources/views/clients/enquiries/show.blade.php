@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4" style="width:100%;">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        session()->forget('success'); // Explicitly remove the message
    @endphp

    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm font-medium hover:text-purple-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="flex md:flex-row flex-col items-center md:justify-between justify-center pb-3 mb-8 border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Enquiry for Room #{{ $enquiry->room->id }}</h1>
            <p class="text-gray-500 text-sm">Conversation with the Provider</p>
        </div>
        <div class="bg-amber-500 text-white px-4 py-2 rounded-lg font-bold shadow-sm md:mt-0 mt-2" style="background-color: #ade467;">
            R{{ number_format($enquiry->room->rental_price ?? 0, 2) }} <span class="text-xs font-normal">/mo</span>
        </div>
    </div>

    <div class="space-y-6 mb-10">
        
        <div class="flex justify-end">
            <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-lg shadow-sm" style="background-color: #bd97f4; max-width: 80%;">
                <p class="text-xs font-bold opacity-70 mb-1 uppercase tracking-tighter">You (Original Request)</p>
                <p class="text-sm leading-relaxed">{{ $enquiry->message }}</p>
                <span class="text-[10px] opacity-50 block mt-2 text-right">{{ $enquiry->created_at->format('H:i | M d') }}</span>
            </div>
        </div>

        @foreach($enquiry->replies as $reply)
            @if($reply->provider_user_id)
                <div class="flex justify-start">
                    <div class="bg-white border border-gray-200 text-gray-800 rounded-2xl rounded-tl-none px-6 py-4 max-w-lg shadow-sm" style="max-width: 80%;">
                        <p class="text-xs font-bold text-purple-600 mb-1 uppercase tracking-tighter">{{$reply->provider_user->name}} (accommodation provider)</p>
                        <p class="text-sm leading-relaxed">{{ $reply->message }}</p>
                        <span class="text-[10px] text-gray-400 block mt-2">{{ $reply->created_at->format('H:i | M d') }}</span>
                    </div>
                </div>
            @elseif($reply->admin_id)
                <div class="flex justify-end">
                    <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-lg shadow-sm" style="background-color: #97bdf4; max-width:80%;">
                        <p class="text-xs font-bold opacity-70 mb-1 uppercase tracking-tighter">Admin</p>
                        <p class="text-sm leading-relaxed">{{ $reply->message }}</p>
                        <span class="text-[10px] opacity-50 block mt-2 text-right">{{ $reply->created_at->format('H:i | M d') }}</span>
                    </div>
                </div>
            @else
                <div class="flex justify-end">
                    <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-lg shadow-sm" style="background-color: #bd97f4; max-width: 80%;">
                        <p class="text-xs font-bold opacity-70 mb-1 uppercase tracking-tighter">You</p>
                        <p class="text-sm leading-relaxed">{{ $reply->message }}</p>
                        <span class="text-[10px] opacity-50 block mt-2 text-right">{{ $reply->created_at->format('H:i | M d') }}</span>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-100">
        <form action="{{ route('client.enquiry.reply.store', $enquiry->id) }}" method="POST">
            @csrf
            <textarea name="message" rows="3" class="w-full border-none focus:ring-0 text-gray-700 placeholder-gray-400" placeholder="Type a follow-up message..." required></textarea>
            <div class="flex justify-end pt-2 border-t mt-2">
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-2 rounded-xl font-bold transition-all transform active:scale-95 shadow-md" style="background-color: #ad67e4;">
                    Send
                </button>
            </div>
        </form>
    </div>
</div>
@endsection