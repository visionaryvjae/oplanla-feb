{{-- 3. resources/views/bookings/request_change_form.blade.php (For User) --}}
@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg">
        <form action="{{ route('booking.request.store', $booking->id) }}" method="POST">
            @csrf
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Request a Change</h1>
                <p class="mt-1 text-sm text-gray-600">For booking #{{ $booking->id }} at {{ $booking->bookingRooms->room->provider->provider_name }}</p>
            </div>
            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">What would you like to change?</label>
                    <div class="mt-1">
                        <textarea rows="4" name="message" id="message" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Please describe the changes you would like to make (e.g., change dates, number of guests, etc.)." required>{{ old('message') }}</textarea>
                    </div>
                    <div style="margin-top:1rem;">
                        <label for="check_in_time" class="block text-xs font-bold text-gray-700 uppercase">Check-in Date</label>
                        <input type="datetime" id="check_in_time" name="check_out_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{$booking->check_in_time }}">
                    </div> 
                    <p class="mt-2 text-sm text-gray-500">An admin will review your request and contact you. Submitting this request does not guarantee the change.</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 text-right">
                <a href="{{ route('booking.show.single', $booking->id) }}" class="text-sm font-medium text-gray-600 mr-4">Cancel</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Submit Request</button>
            </div>
        </form>
    </div>
</div>
@endsection