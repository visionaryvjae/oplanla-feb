@extends('layouts.providers')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
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
        <a href="{{ route('provider.enquiries.index') }}" class="text-sm font-medium hover:text-purple-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Enquiries
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-2">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 flex flex-col">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">Message History</h2>
                    <span class="text-xs font-mono text-gray-400">Enquiry #{{ $enquiry->id }}</span>
                </div>

                <div class="p-6 space-y-6 bg-slate-50/50 overflow-y-auto">
                    <div class="flex justify-start">
                        <div class="bg-white border border-gray-200 text-gray-800 rounded-2xl rounded-tl-none px-6 py-4 max-w-lg" style="max-width: 80%;">
                            <p class="text-xs font-bold text-purple-600 mb-1 uppercase tracking-tighter">{{ $enquiry->user->name }} (Initial Request)</p>
                            <p class="text-sm leading-relaxed">{{ $enquiry->message }}</p>
                            <span class="text-[10px] text-gray-400 block mt-2">{{ $enquiry->created_at->format('H:i | M d, Y') }}</span>
                        </div>
                    </div>

                    @foreach($enquiry->replies as $reply)
                        @if($reply->provider_user_id)
                            <div class="flex justify-end">
                                <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-lg shadow-sm" style="background-color: #bd97f4; max-width:80%;">
                                    <p class="text-xs font-bold opacity-70 mb-1 uppercase tracking-tighter">You (Provider)</p>
                                    <p class="text-sm leading-relaxed">{{ $reply->message }}</p>
                                    <span class="text-[10px] opacity-50 block mt-2 text-right">{{ $reply->created_at->format('H:i | M d') }}</span>
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
                            <div class="flex justify-start">
                                <div class="bg-white border border-gray-200 text-gray-800 rounded-2xl rounded-tl-none px-6 py-4 max-w-lg shadow-sm" style="max-width: 80%;">
                                    <p class="text-xs font-bold text-purple-600 mb-1 uppercase tracking-tighter">{{ $enquiry->user->name }}</p>
                                    <p class="text-sm leading-relaxed">{{ $reply->message }}</p>
                                    <span class="text-[10px] text-gray-400 block mt-2">{{ $reply->created_at->format('H:i | M d') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">Send a Response</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('provider.enquiry.reply.store', $enquiry->id) }}" method="POST">
                        @csrf
                        <textarea 
                            name="message"
                            rows="4" 
                            class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 placeholder-gray-400"
                            placeholder="Type your reply to the client..."
                            required
                        ></textarea>
                        
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="hover:bg-[#bd27d4] text-white font-bold py-2 px-8 rounded-lg transition-colors shadow-sm" style="background-color: #ad67e4;">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 space-y-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Actions</h3>
                @if ($enquiry->user->documents)
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border-2 font-bold rounded-lg border-[#33ea93] text-[#33ea93] transition-all">
                        Sent document prompt
                    </button>

                @elseif($enquiry->user->documents && $enquiry->user->documents->all_documents_verified)
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border-2 font-bold rounded-lg bg-[#33ea93] text-white transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Documents uploaded and Verified
                    </button>

                @else
                    <form action="{{ route('provider.enquiry.request.documents.upload', $enquiry->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border-2 border-[#33ea93] text-[#33ea93] font-bold rounded-lg hover:bg-[#33ea93] hover:text-white transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Request to upload documents
                        </button>
                    </form>
                @endif

                @if ($enquiry->user->role == 'tenant')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border-2 font-bold rounded-lg bg-purple-600 text-white transition-all" disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        User is Tenant
                    </button>
                @else
                    <form action="{{ route('provider.enquiry.mark.potential.tenant', $enquiry->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border-2 border-purple-600 text-purple-600 font-bold rounded-lg hover:bg-purple-600 hover:text-white transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Mark Tenant
                        </button>
                    </form>
                @endif
            </div>

            @php
                //dd($enquiry->user->avatar->avatar);
                $avatar = $enquiry->user->avatar->avatar ?? null;
            @endphp
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Client Information</h3>
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-xl">
                        <img class="w-full h-full rounded-full" src="{{ $avatar ? asset('storage/avatars/'. $avatar) : substr($enquiry->user->name, 0, 1) }}" >
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-gray-800">{{ $enquiry->user->name }}</p>
                        <p class="text-xs text-gray-500">Registered Client</p>
                    </div>
                </div>
                <div class="space-y-2 border-t pt-4">
                    <p class="text-sm text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $enquiry->user->email }}
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Room Interest</h3>
                <div class="space-y-3 text-sm">
                    <p><span class="text-gray-400">Room ID:</span> <span class="font-bold text-gray-800">#{{ $enquiry->room->id }}</span></p>
                    <p><span class="text-gray-400">Property:</span> <span class="font-bold text-gray-800">{{ $enquiry->room->provider->provider_name ?? 'Main Site' }}</span></p>
                    <div class="mt-2">
                        @if ($enquiry->room->available)
                            <span class="px-2 py-1 text-[10px] font-bold bg-green-100 text-green-700 uppercase rounded-full">Available</span>
                        @else
                            <span class="px-2 py-1 text-[10px] font-bold bg-red-100 text-red-700 uppercase rounded-full">Not Available</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection