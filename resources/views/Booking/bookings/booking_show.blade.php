{{-- resources/views/booking_show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            {{ session('success') }}
        </div>
    @endif
    


    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4">
                <div class="mt-2 ml-4">
                    <h1 class="text-2xl font-bold text-gray-800">Your Booking at {{ $booking->provider_name }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Booking ID: #{{ $booking->id }}</p>
                </div>
                <div class="mt-4 ml-4 flex-shrink-0 flex space-x-2">
                    <form action="{{ route('booking.request.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to request cancellation?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">Request Cancellation</button>
                    </form>
                    <a href="{{ route('booking.request.create', $booking->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Request Change</a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 px-6 py-5">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($booking->status) }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                    <dd class="mt-1 text-sm text-gray-900">R {{ number_format($booking->booking_price, 2) }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Check-in</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ (new DateTime($booking->check_in_time))->format('D, M j, Y, g:ia') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Check-out</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ (new DateTime($booking->check_out_time))->format('D, M j, Y, g:ia') }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Rooms</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->room_type }}</dd>
                </div>
            </dl>
        </div>
        {{-- You can add the image gallery back here if desired --}}
    </div>
</div>
@endsection
