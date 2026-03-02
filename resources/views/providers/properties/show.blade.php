@extends('layouts.providers')

@section('content')
    <div class="py-12 max-w-[90rem] mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('provider.properties.index') }}" class="text-sm font-medium hover:text-purple-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Properties
            </a>
        </div>
        <nav class="flex mb-4 text-sm font-bold uppercase tracking-widest text-gray-400">
            <a href="{{ route('provider.properties.index') }}" class="hover:text-[#ad68e4]">Properties</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $property->name }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-gray-900">{{ $property->name }}</h1>
                <p class="flex items-center gap-2 text-gray-500 mt-2">
                    <svg class="w-5 h-5 text-[#ad68e4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $property->address }}
                </p>
            </div>
            <div class="flex gap-3">
                <button class="px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50">Edit Property</button>
                <button class="px-6 py-3 bg-[#ad68e4] text-white rounded-xl font-bold shadow-lg shadow-purple-100">+ Add Room</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Inventory</p>
                        <p class="text-2xl font-black text-gray-900">{{ $property->rooms->count() }} Rooms</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Occupancy</p>
                        <p class="text-2xl font-black text-[#23cab5]">
                            {{ number_format(($property->rooms->where('rental', true)->where('available', false)->count() / max($property->rooms->count(), 1)) * 100) }}%
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Maintenance</p>
                        <p class="text-2xl font-black text-orange-500">2 Active</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="font-black text-gray-900 uppercase tracking-tighter">Room Inventory</h3>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4">Room No.</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($property->rooms as $room)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">Room {{ $room->room_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $room->room_type ?? 'Standard' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        {{ $room->available ? 'bg-yellow-50 text-yellow-600' : 'bg-blue-50 text-blue-600' }}">
                                        {{ $room->available ? 'Vacant' : 'Occupied' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#" class="text-[#ad68e4] font-bold text-sm">Manage</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Assigned Manager</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-[#ad68e4] font-black">
                            {{ substr($property->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-black text-gray-900">{{ $property->provider->name ?? 'Not Assigned' }}</p>
                            <p class="text-xs text-gray-500 italic">Property Provider</p>
                        </div>
                    </div>
                    <button class="w-full mt-6 py-3 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest">Contact Provider</button>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-48 bg-gray-100 flex items-center justify-center relative">
                        <div class="text-center p-6">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Map View Unavailable</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-sm font-black text-gray-900 mb-2">Location Details</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Located in a prime residential area with easy access to main transit routes and local amenities.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection