@extends('layouts.providers')

@section('content')

@include('providers.meters.components.action-buttons')

    <div class="max-w-7xl w-full">
        <div class="flex w-full justify-start mb-2">
            <a href="{{ route('provider.meters.index') }}" class="inline-flex items-center text-sm font-semibold hover:text-purple-800 transition-colors mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Meters
            </a>
        </div>

        <div class="max-w-7xl w-full mx-auto py-10 px-4 bg-white shadow-lg rounded-lg sm:px-6 lg:px-8 min-h-screen">
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-sm" role="alert">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="mb-6 bg-teal-50 border-l-4 border-teal-400 text-teal-700 p-4 rounded-md shadow-sm" role="alert">{{ session('success') }}</div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Meter Profile</h1>
                    <p class="text-gray-500">Managing technical data for <span class="text-teal-600 font-medium">{{ $meter->serial_number }}</span></p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="#" class="btn-edit inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Edit Details
                    </a>
                    <form action="#" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700" onclick="return confirm('Delete this meter?');">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-teal-400 to-teal-500 px-6 py-4">
                            <h3 class="text-white font-bold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                                Technical Details
                            </h3>
                        </div>
                        <div class="p-6">
                            <dl class="divide-y divide-gray-100">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Internal ID</dt>
                                    <dd class="text-sm font-bold text-gray-900">#{{ $meter->id }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Utility Type</dt>
                                    <dd class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700 uppercase">
                                        {{ $meter->type ?? 'Electricity' }}
                                    </dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Multiplier</dt>
                                    <dd class="text-sm font-bold text-teal-600">x {{ number_format($meter->multiplier, 2) }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Last Reading</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ $meter->lastReading->reading_value ?? 0 }} {{ $meter->type == 'electricity' ? 'kWh' : 'KL' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Provider ID</dt>
                                    <dd class="text-sm font-bold text-gray-900">{{ $meter->providers_id ?? 'N/A' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Added On</dt>
                                    <dd class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($meter->created_at)->format('d M Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="bg-purple-600 rounded-3xl p-6 text-white shadow-lg shadow-purple-200">
                        <h4 class="text-xs font-bold uppercase tracking-widest opacity-75 mb-1">Property Link</h4>
                        <p class="text-xl font-bold mb-4">{{ $meter->room->property->name ?? $meter->provider->provider_name ?? 'Primary Facility' }}</p>
                        <div class="flex items-start text-sm opacity-90">
                            <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $meter->room->property->address ?? $meter->provider->booking_address ?? 'Location details not set' }}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="relative h-full min-h-[400px] bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        @php
                            $displayImage = $meter->provider->photos->where('area', 'display')->first()->image ?? null;
                        @endphp
                        
                        <img class="absolute inset-0 w-full h-full object-cover" 
                            src="{{ $displayImage ? asset('storage/images/' . $displayImage) : asset('storage/images/no-image.png') }}" 
                            alt="Room environment">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 p-8 w-full">
                            <div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-6 text-white">
                                <h2 class="text-2xl font-bold mb-2">Room Overview</h2>
                                <p class="text-white/80 leading-relaxed line-clamp-3">
                                    {{ $meter->provider->description ?? 'No additional description available for this property area.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection