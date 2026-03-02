{{-- resources/views/provider/bookings.blade.php --}}
@extends('layouts.providers')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <form action="{{ route('room.booking.index.provider') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Users</label>
                    <select name="client" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Users</option>
                        @foreach($users as $client)
                            <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>{{ $client->name }} - {{ $client->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Status</label>
                    <select name="status" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Status</option>
                        <option value="pending check in" {{ request('status') == 'pending check in' ? 'selected' : '' }}>Pending Check-in</option>
                        <option value="currently occupying" {{ request('status') == 'currently occupying' ? 'selected' : '' }}>Currently Occupying</option>
                        <option value="booking ended" {{ request('status') == 'booking ended' ? 'selected' : '' }}>Booking Ended</option>
                        <option value="booking canceled" {{ request('status') == 'booking canceled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Filter
                    </button>
                    <a href="{{ route('room.booking.index.provider') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">{{ $pagetitle }}</h1>
            <p class="mt-1 text-sm text-gray-600">A list of all current and past bookings for your properties.</p>
        </div>

        @if(session('error'))
            <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest & Hotel</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Types</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($bookings as $booking)
                                    @php
                                        $roomsCount = explode(',', $booking->bookingRooms->room->room_type);
                                        $datestr = new DateTime($booking->check_in_time);
                                        $datestrOut = new DateTime($booking->check_out_time);
                                        $formattedCheckIn = $datestr->format('M d, Y, g:ia');
                                        $formattedCheckOut = $datestrOut->format('M d, Y, g:ia');
                                        $providerName = $booking->bookingRooms->room->provider->provider_name;
                                    @endphp

                                    {{-- The main row that is clickable --}}
                                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href = '{{ route('provider.room.booking.show', $booking->id) }}';">
                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ count($roomsCount) }}">
                                            <div class="text-sm font-medium text-gray-900">#{{ $booking->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ count($roomsCount) }}">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->bookingRooms ? $providerName : 'unknown provider' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ count($roomsCount) }}">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($booking->status == 'confirmed' || $booking->status == 'pending check in') bg-green-100 text-green-800 @elseif($booking->status == 'booking ended') bg-gray-100 text-gray-800 @elseif($booking->status == 'booking canceled') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" rowspan="{{ count($roomsCount) }}">
                                            R {{ number_format($booking->booking_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ count($roomsCount) }}">
                                            <div class="text-sm text-gray-900">In: {{ $formattedCheckIn }}</div>
                                            <div class="text-sm text-gray-500">Out: {{ $formattedCheckOut }}</div>
                                        </td>
                                        {{-- First room type on the main row --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $roomsCount[0] }}</td>
                                    </tr>

                                    {{-- Subsequent room types on their own rows --}}
                                    @for ($i = 1; $i < count($roomsCount); $i++)
                                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href = '{{ route('provider.room.booking.show', $booking->id) }}';">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $roomsCount[$i] }}</td>
                                        </tr>
                                    @endfor
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                            No bookings found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
