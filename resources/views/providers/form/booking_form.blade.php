{{-- resources/views/provider/booking_form.blade.php --}}
@extends('layouts.providers')

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8 my-6">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">{{ $action }} {{ $table }}</h1>
            <p class="mt-1 text-sm text-gray-600">Please fill out the details below.</p>
        </div>

        <form method="POST" action="{{ $actionUrl }}" id="main_form" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-8">
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

                {{-- Room Form --}}
                @if ($table == 'Room')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                            <input type="text" name="room_number" id="room_number" value="{{ old('room_number') ?? $room->room_number }}" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price (R)</label>
                            <input type="number" name="price" id="price" value="{{ old('price') ?? $room->price }}" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md" step="0.01">
                        </div>
                        <div>
                            <label for="num_people" class="block text-sm font-medium text-gray-700">Max Guests</label>
                            <input type="number" name="num_people" id="num_people" value="{{ old('num_people') ?? $room->num_people }}" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                            <select name="room_type" id="room_type" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">-- Select room type --</option>
                                <option value="Conference Room" @selected(old('room_type', $room->room_type) == 'Conference Room')>Conference Room</option>
                                <option value="Small Single Room" @selected(old('room_type', $room->room_type) == 'Small Single Room')>Small Single Room</option>
                                <option value="Small Double Room" @selected(old('room_type', $room->room_type) == 'Small Double Room')>Small Double Room</option>
                                <option value="Standard Single Room" @selected(old('room_type', $room->room_type) == 'Standard Single Room')>Standard Single Room</option>
                                <option value="Standard Double Room" @selected(old('room_type', $room->room_type) == 'Standard Double Room')>Standard Double Room</option>
                                <option value="Deluxe Single Room" @selected(old('room_type', $room->room_type) == 'Deluxe Single Room')>Deluxe Single Room</option>
                                <option value="Deluxe Double Room" @selected(old('room_type', $room->room_type) == 'Deluxe Double Room')>Deluxe Double Room</option>
                                <option value="Executive Suite" @selected(old('room_type', $room->room_type) == 'Executive Suite')>Executive Suite</option>
                                <option value="Junior Suite" @selected(old('room_type', $room->room_type) == 'Junior Suite')>Junior Suite</option>
                                <option value="Presidential Suite" @selected(old('room_type', $room->room_type) == 'Presidential Suite')>Presidential Suite</option>
                                <option value="Family Room" @selected(old('room_type', $room->room_type) == 'Family Room')>Family Room</option>
                                <option value="Connecting Rooms" @selected(old('room_type', $room->room_type) == 'Connecting Rooms')>Connecting Rooms</option>
                                <option value="Studio Room" @selected(old('room_type', $room->room_type) == 'Studio Room')>Studio Room</option>
                                <option value="Apartment-Style Room" @selected(old('room_type', $room->room_type) == 'Apartment-Style Room')>Apartment-Style Room</option>
                                <option value="Penthouse Suite" @selected(old('room_type', $room->room_type) == 'Penthouse Suite')>Penthouse Suite</option>
                                <option value="Accessible Room" @selected(old('room_type', $room->room_type) == 'Accessible Room')>Accessible Room (ADA Compliant)</option>
                                <option value="Ocean View Room" @selected(old('room_type', $room->room_type) == 'Ocean View Room')>Ocean View Room</option>
                                <option value="Mountain View Room" @selected(old('room_type', $room->room_type) == 'Mountain View Room')>Mountain View Room</option>
                                <option value="Interior Room" @selected(old('room_type', $room->room_type) == 'Interior Room')>Interior Room (No Window)</option>
                                <option value="Loft Room" @selected(old('room_type', $room->room_type) == 'Loft Room')>Loft Room</option>
                                <option value="Boutique Room" @selected(old('room_type', $room->room_type) == 'Boutique Room')>Boutique Room</option>
                                <option value="Eco-Friendly Room" @selected(old('room_type', $room->room_type) == 'Eco-Friendly Room')>Eco-Friendly Room</option>
                                <option value="Honeymoon Suite" @selected(old('room_type', $room->room_type) == 'Honeymoon Suite')>Honeymoon Suite</option>
                                <option value="Business Room" @selected(old('room_type', $room->room_type) == 'Business Room')>Business Room</option>
                                <option value="Rental House" @selected(old('room_type', $room->room_type) == 'Rental House')>Rental House</option>
                            </select>
                        </div>
                        <div>
                            <label for="available" class="block text-sm font-medium text-gray-700">Availability</label>
                            <select name="available" id="available" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">-- Select room type --</option>
                                <option value="1" @selected(old('available', $room->available) == 1)>Available</option>
                                <option value="0" @selected(old('available', $room->available) == 0)>Not Available</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="property_type" class="block text-sm font-medium text-gray-700">Property Type</label>
                            <select name="property_type" id="property_type" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">-- Select property type --</option>
                                <option value="Guest House" @selected(old('property_type', $room->property_type) == 'Guest House')>Guest House</option>
                                <option value="Hotel" @selected(old('property_type', $room->property_type) == 'Hotel')>Hotel</option>
                                <option value="Lodge" @selected(old('property_type', $room->property_type) == 'Lodge')>Lodge</option>
                                <option value="Apartment" @selected(old('property_type', $room->property_type) == 'Apartment')>Apartment</option>
                                <option value="B&B" @selected(old('property_type', $room->property_type) == 'B&B')>B&B</option>
                                <option value="Hostel" @selected(old('property_type', $room->property_type) == 'Hostel')>Hostel</option>
                                <option value="Hostel" @selected(old('property_type', $room->property_type) == 'Rental House')>Rental House</option>
                            </select>
                        </div>

                        <div>
                            <label for="num_beds" class="block text-sm font-medium text-gray-700">Number of beds</label>
                            <input type="number" name="num_beds" id="num_beds" value="{{ old('num_beds') ?? $room->num_beds }}" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="num_bathrooms" class="block text-sm font-medium text-gray-700">Number of bathrooms</label>
                            <input type="number" name="num_bathrooms" id="num_bathrooms" value="{{ old('num_bathrooms') ?? $room->num_bathrooms }}" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="rental_price" class="block text-sm font-medium text-gray-700">Rental Price</label>
                            <input type="number" name="rental_price" id="rental_price" value="{{ old('rental_price') ?? $room->rental_price }}" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="furnishing" class="block text-sm font-medium text-gray-700">Furnishing of room</label>
                            <select name="furnishing" id="furnishing" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="" disabled>-- Select room type --</option>
                                <option value="furnished" @selected(old('furnishing', $room->furnishing) == 1)>Furnished</option>
                                <option value="unfurnished" @selected(old('furnishing', $room->furnishing) == 0)>Unfurnished</option>
                                <option value="partially furnished" @selected(old('furnishing', $room->furnishing) == 0)>Partially Furnished</option>
                            </select>
                        </div>

                        <div>
                            <label for="rental" class="block text-sm font-medium text-gray-700">Is Rental</label>
                            <input type="checkbox" name="rental" id="rental" value="1" class="mt-1 block shadow-sm sm:text-sm border-gray-300" {{ old('rental') ?? $room->rental }}>
                        </div>
                        
                        <div>
                            @if ($action == 'CreateProvider')
                                <input type="hidden" name="providers_id" value="{{ $providerId }}">
                            @else
                                <label for="providers_id" class="block text-sm font-medium text-gray-700">Provider ID</label>
                                <select name="providers_id" id="providers_id" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @foreach($providers as $provider)
                                        <option value="{{$provider->id}}">{{ $provider->id }} - {{ $provider->provider_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Facilities</h3>
                        <p class="text-sm text-gray-500">Select the facilities available in this room.</p>
                        <div class="mt-2">
                            <input type="text" id="facility-input" placeholder="Search for a facility..." class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <ul id="suggestions" class="hidden mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10"></ul>
                        </div>
                        <div id="selected-facilities" class="mt-2 space-x-2 space-y-2">
                            {{-- Selected facilities will appear here --}}
                        </div>
                        <input type="hidden" name="room_facilities" id="room_facilities" value="{{ old('room_facilities', $room->room_facilities) }}">
                    </div>
                    @if ($action == 'CreateProvider')
                        <input type="hidden" name="providers_id" value="{{ $providerId }}">
                    @endif
                @endif

                {{-- Booking Form --}}
                @if ($table == 'Booking')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="users_id" class="block text-sm font-medium text-gray-700">User</label>
                            <select name="users_id" id="users_id" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">-- Select user --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('users_id', $booking->users_id) == $user->id)>{{ $user->name }} (ID: {{ $user->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Booking Status</label>
                            <select name="status" id="status" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="pending check in" @selected(old('status', $booking->status) == 'pending check in')>Pending Check In</option>
                                <option value="booking canceled" @selected(old('status', $booking->status) == 'booking canceled')>Booking Canceled</option>
                                <option value="booking ended" @selected(old('status', $booking->status) == 'booking ended')>Booking Ended</option>
                                <option value="currently occupying" @selected(old('status', $booking->status) == 'currently occupying')>Currently Occupying</option>
                            </select>
                        </div>
                        <div>
                            <label for="check_in_time" class="block text-sm font-medium text-gray-700">Check-in Date & Time</label>
                            <input type="datetime-local" name="check_in_time" id="check_in_time" value="{{ old('check_in_time', $booking->check_in_time) }}" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="check_out_time" class="block text-sm font-medium text-gray-700">Check-out Date & Time</label>
                            <input type="datetime-local" name="check_out_time" id="check_out_time" value="{{ old('check_out_time', $booking->check_out_time) }}" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                @endif

                {{-- Image Form --}}
                @if ($table == 'Image')
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700">Category / Area</label>
                        <input type="text" name="area" id="area" value="{{ old('area') ?? $photo->area }}" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g., Lobby, Standard Room, Pool Area">
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($action != 'Create' && $photo->image)
                            <p class="mt-2 text-sm text-gray-500">Current image: {{ $photo->image }}</p>
                            <input type="hidden" name="image-name" value="{{ $photo->image }}">
                        @endif
                    </div>
                @endif
            </div>

            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="submit" id="submit-button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $action }} {{ $table }}
                </button>
            </div>
        </form>
    </div>
</div>

@include('components.facilities')

@endsection
