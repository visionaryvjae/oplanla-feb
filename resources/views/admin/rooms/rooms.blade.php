{{-- resources/views/admin/rooms.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <form action="{{ route('admin.rooms.index') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or Description..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Property type</label>
                    <select name="property_type" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Properties</option>
                        <option value="Guest House" {{ request('property_type') == 'Guest House' ? 'selected' : '' }}>Guest House</option>
                        <option value="Hotel" {{ request('property_type') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                        <option value="Lodge" {{ request('property_type') == 'Lodge' ? 'selected' : '' }}>Lodge</option>
                        <option value="Townhouse" {{ request('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="Hostel" {{ request('property_type') == 'Hostel' ? 'selected' : '' }}>Hostel</option>
                        <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="B&B" {{ request('property_type') == 'B&B' ? 'selected' : '' }}>B&B</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Availability</label>
                    <select name="available" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select Availability</option>
                        <option value="available" {{ request('available') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="not available" {{ request('not available') == 'available' ? 'selected' : '' }}>Not available</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Number of Beds</label>
                    <input type="number" name="num_beds" value="{{ request('num_beds') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Filter
                    </button>
                    <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4">
                <div class="mt-2 ml-4">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $pagetitle }}</h1>
                    <p class="mt-1 text-sm text-gray-600">A list of all rooms available at your properties.</p>
                </div>
                <div class="mt-4 ml-4 flex-shrink-0">
                    <a href="{{ route('admin.rooms.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add New Room
                    </a>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">{{ session('success') }}</div>
        @endif

        <div class="flex flex-col">
            <div class="-my-2 sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hotel & Room No.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guests</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Is Rental</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facilities</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($rooms as $room)
                                    <tr class="hover:bg-gray-50 cursor-pointer" data-room-id="{{ $room->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $room->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $room->provider->provider_name }}</div>
                                            <div class="text-sm text-gray-500">Room {{ $room->room_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $room->room_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R {{ number_format($room->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ $room->num_people }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($room->available)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($room->rental)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs" title="{{ $room->room_facilities }}">
                                            {{ $room->room_facilities ?? 'No facilities listed' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                            You haven't added any rooms yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{-- Card layout for mobile screens --}}
                        <div class="grid grid-cols-1 gap-4 px-4 py-4 md:hidden">
                            @forelse ($rooms as $room)
                                <div class="bg-white p-4 rounded-lg border shadow-sm space-y-3 cursor-pointer" data-room-id="{{ $room->id }}">
                                    <div class="items-center flex justify-between mb-2">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $room->provider->provider_name }}</p>
                                            <!--<p class="text-xs text-gray-500">Room {{ $room->room_number }} (ID: #{{$room->id}})</p>-->
                                        </div>
                                        <div>
                                             @if ($room->available)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Not Available</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4 text-center">
                                        <div class="flex flex-col w-full items-start justify-start">
                                            <div>
                                                <p class="text-xs text-left text-gray-500">Room Type</p>
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $room->room_type }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-left text-gray-500">Price</p>
                                                <p class="text-sm font-medium text-gray-800">R {{ number_format($room->price, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Facilities</p>
                                        <p class="text-sm text-gray-800 truncate">{{ $room->room_facilities ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="py-4 px-6 text-center text-gray-500">
                                    You haven't added any rooms yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // MODIFIED: This script now targets any element with data-room-id, making it work for mobile and desktop.
    document.addEventListener("DOMContentLoaded", function () {
        const clickableElements = document.querySelectorAll("[data-room-id]");
        clickableElements.forEach(function (elem) {
            elem.addEventListener("click", function () {
                const roomId = this.getAttribute("data-room-id");
                window.location.href = `/admin/room/${roomId}`;
            });
        });
    });
</script>
@endsection
