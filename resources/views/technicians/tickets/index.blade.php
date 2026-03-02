@extends('layouts.technician')

@section('content')
    <div class="py-12 max-w-[90rem] mx-auto md:px-8 px-6">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Please correct the errors below:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif
        <h1 class="text-3xl font-black text-gray-900 mb-8">Service Tickets</h1>
        @php
            // dd($tickets);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tickets as $ticket)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between mb-4">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Ticket #{{ $ticket->id }}</span>
                            <span class="text-xs font-bold text-red-500">Latest: {{ $ticket->latest_completion_date->format('d M') }}</span>
                        </div>
                        <h4 class="text-lg font-black text-gray-900 mb-2">{{ $ticket->job->title }}</h4>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-6">{{ $ticket->job->description }}</p>
                    </div>

                    @if ($ticket->completion_photo_path)
                        <div class="flex w-full rounded-lg overflow-hidden mb-2">
                            <img class="w-full object-cover" src="{{ asset('storage/maintenance/'. $ticket->completion_photo_path) }}" alt="">
                        </div>
                    @endif

                    <div class="space-y-3">
                        @if(!$ticket->completion_photo_path)
                            <form action="{{ route('technician.ticket.upload.photo', $ticket->id) }}" method="POST" enctype="multipart/form-data"> {{-- {{ route('technician.tickets.upload', $ticket->id) }} --}}
                                @csrf
                                <label class="w-full flex items-center justify-center gap-2 py-3 border-2 border-dashed border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                                    <input type="file" 
                                        name="photo" 
                                        class="hidden"
                                        accept="image/*" 
                                        capture="environment"         
                                        onchange="this.form.submit()"
                                    >
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="text-xs font-bold text-gray-500 uppercase">Add Proof (Photo)</span>
                                </label>
                            </form>
                        @else
                            <div class="flex items-center gap-2 text-green-500 text-xs font-bold uppercase py-3 justify-center bg-green-50 rounded-xl">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                Photo Uploaded
                            </div>
                        @endif

                        @if ($ticket->status != 'completed')
                            <form action="{{ route('technician.ticket.complete', $ticket->id) }}" method="POST"> {{-- {{ route('technician.tickets.complete', $ticket->id) }} --}}
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3 rounded-xl font-black text-xs uppercase tracking-widest transition
                                        {{ $ticket->completion_photo_path ? 'bg-[#23b5ca] text-white shadow-teal-100' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                        {{ !$ticket->completion_photo_path ? 'disabled' : '' }}>
                                    Mark as Complete
                                </button>
                                @if(!$ticket->completion_photo_path)
                                    <p class="text-[9px] text-center text-orange-400 font-bold mt-2 uppercase">Please upload a photo first</p>
                                @endif
                            </form>
                        @else
                            <button class="flex items-center justify-center w-full py-3 rounded-xl font-black text-xs uppercase tracking-widest transition bg-[#23ca4d] text-white shadow-teal-100">
                                <img class="w-8 h-8 mx-2" src="https://img.icons8.com/?size=100&id=Ec2YiJY0ZFZ3&format=png&color=FFFFFF" alt="">
                                Ticket completed
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection