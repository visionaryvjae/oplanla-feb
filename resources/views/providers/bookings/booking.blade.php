{{-- resources/views/provider/booking.blade.php --}}
@extends('layouts.providers')

@section('content')
{{-- The original script is preserved to maintain functionality --}}
<script>
    function getRoom_bookingIdFromUrl(buttonClass, routeTemplate) {
        const url = window.location.href;
        const room_bookingidMatch = url.match(/provider\/room_booking\/(\d+)/);
        if (room_bookingidMatch && room_bookingidMatch[1]) {
            let room_bookingId = parseInt(room_bookingidMatch[1], 10);
            const element = document.querySelector(buttonClass);
            if (element) {
                if(element.tagName === 'FORM') {
                    element.action = routeTemplate.replace('__ROOM_booking_ID__', room_bookingId);
                } else if (element.tagName === 'A') {
                    element.href = routeTemplate.replace('__ROOM_booking_ID__', room_bookingId);
                }
                else if(element.tagName === 'BUTTON'){
                    closest('a').element.href = routeTemplate.replace('__ROOM_booking_ID__', room_bookingId);
                }
            }
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        getRoom_bookingIdFromUrl('.btn-edit-link', "{{ route('provider.room.booking.edit', '__ROOM_booking_ID__') }}");
        getRoom_bookingIdFromUrl('.form-end-booking', "{{ route('provider.room.booking.end', '__ROOM_booking_ID__') }}");
        getRoom_bookingIdFromUrl('.btn-cancel-link', "{{ route('provider.room.booking.cancel', '__ROOM_booking_ID__') }}");
    });
</script>

<style>
    .btn-cancel{
        /* @apply inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500; */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border: 1px solid transparent;
        border-radius: 0.375rem;
        background-color: #f59e0b;
        color: #ffffff;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        outline: none;
    }

    .btn-cancel:hover {
        background-color: #d97706; /* yellow-600 */
    }

    .btn-cancel:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.5), 
                    0 0 0 4px #ffffff, 
                    0 0 0 6px #f59e0b; /* ring-2 + ring-offset-2 simulation */
        /* Or simpler: */
        /* box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.5); */
    }
</style>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4">
                <div class="mt-2 ml-4">
                    <h1 class="text-2xl font-bold text-gray-800">Booking #{{ $room_booking->id }}</h1>
                    <div class="mt-1 flex items-center">
                        <p class="text-sm text-gray-600 truncate">{{ $room_booking->user_name }} at {{ $room_booking->provider_name }}</p>
                        <span class="ml-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($room_booking->status == 'confirmed') bg-green-100 text-green-800 @elseif($room_booking->status == 'booking ended') bg-gray-100 text-gray-800 @elseif($room_booking->status == 'booking canceled') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($room_booking->status) }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 ml-4 flex-shrink-0 flex space-x-2">
                    @php $isCompleted = in_array($room_booking->status, ['booking ended', 'booking canceled']); @endphp
                    <a href="#" class="btn-edit-link inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Edit</a>
                    <form action="#" method="POST" class="form-end-booking">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 @if($isCompleted) opacity-50 cursor-not-allowed @endif" @if($isCompleted) disabled @endif>End Booking</button>
                    </form>
                    <form action="#" method="GET" class="btn-cancel-link">
                        @csrf
                        <button class="btn-cancel @if($isCompleted) opacity-50 cursor-not-allowed @endif" @if($isCompleted) disabled @endif>Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900">Booking Details</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <label for="booking_price" class="block text-sm font-medium text-gray-700">Booking Price</label>
                            <input type="text" name="booking_price" id="booking_price" value="R {{ number_format($room_booking->booking_price, 2) }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-50 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="user_name" class="block text-sm font-medium text-gray-700">Guest Name</label>
                            <input type="text" name="user_name" id="user_name" value="{{ $room_booking->user_name }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-50 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="check_in_time" class="block text-sm font-medium text-gray-700">Check-In Time</label>
                            <input type="text" name="check_in_time" id="check_in_time" value="{{ (new DateTime($room_booking->check_in_time))->format('F j, Y, g:i a') }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-50 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="check_out_time" class="block text-sm font-medium text-gray-700">Check-Out Time</label>
                            <input type="text" name="check_out_time" id="check_out_time" value="{{ (new DateTime($room_booking->check_out_time))->format('F j, Y, g:i a') }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-50 cursor-not-allowed">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="booking_address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="booking_address" id="booking_address" value="{{ $room_booking->booking_address }}" disabled class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-50 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium text-gray-900">Rooms</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach(explode(',', $room_booking->room_types) as $room)
                            <li class="p-3 bg-gray-50 rounded-md text-sm text-gray-800">{{ trim($room) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
