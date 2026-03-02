@extends('layouts.app')

@section('content')

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
        $propertyTypes = [
            "Guest House",
            "Hotel",
            "Townhouse",
            "Lodge",
            "Apartment",
            "B&B",
            "Hostel"
        ];
    
        $minPrices = [
            300,
            500,
            700,
            900,
            1000
        ];
    
        $maxPrices = [
            2000,
            3000,
            4000,    
            5000
        ];
    @endphp
    
    <style>
        .select-input{
            border: none; background-color: #AD68E4;
        }

        .option-input{
            background-color: #AD68E4
        }

        .option-input:hover{
            background-color: #68E4AD;
        }
        
    </style>

    <div class="main-container">
        @include('Booking.Rooms.room-components.search-bar', compact('rental'))
        <div style="margin-bottom: 2rem; width:70%; align-items:flex-start;">
            <h1 class="heading text-gray-900" style="text-align: left;">{{ $pagetitle }}</h1>
        </div>
        <div class="rooms-container">

            <div class="rooms-display grid gap-6" >
                @forelse ($rooms as $room)
                    @php
                        $images =  $room->provider->photos;
                        $firstImage = $room->provider->photos->isNotEmpty() ? $room->provider->photos->first()->image : 'default-room.jpg';

                        // dd($room->provider->review);
                        $roundedRating = $room->provider->review ? round($room->provider->review?->sum('rating') * 2) / 2 : 0;
                    @endphp
                    <div data-room-id="{{$room->id}}" class="room-card bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 flex flex-col" 
                        style="
                            max-width:30rem;
                            border-radius: 0.5rem;
                            overflow: hidden;
                            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));

                        "
                    >
                        <img src="{{ asset('storage/images/' . $firstImage) }}" class="h-48" alt="room display image" style="max-height:10rem; object-fit: cover">
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800">{{$room->room_type}} - @ {{$room->provider->provider_name}}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{$room->num_beds}} bedrooms • {{$room->num_baths}} bathrooms</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-yellow-500 flex">
                                        @if ($room->provider->review->count() > 0)
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $roundedRating)
                                                    {{-- Full Star --}}
                                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.125rem; height:1.125rem; color: #68e4ad;">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @elseif ($i - 0.5 == $roundedRating)
                                                    {{-- Half Star --}}
                                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.125rem; height:1.125rem; color: #68e4ad;">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0v15z"/>
                                                    </svg>
                                                @else
                                                    {{-- Empty Star --}}
                                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" style="width:1.125rem; height:1.125rem; color: rgb(209 213 219 / var(--tw-text-opacity, 1));">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        @else
                                            <p class="text-xs text-gray-500 ml-2">not reviewed yet</p>
                                        @endif
                                    </span>
                                    <span class="text-xs text-gray-500 ml-2">({{ $room->provider->review->count() }} reviews)</span>
                                </div>
                            </div>
                            <div class="mt-4 flex md:flex-row flex-col justify-between items-center">
                                <p class="text-xl font-bold text-gray-900">ZAR {{$rental ? $room->rental_price : $room->price * config('app.markup')}} <span class="text-sm font-normal text-gray-500">/ 
                                    @if($room->room_type == "Conference Room")
                                        hour
                                    @elseif($rental)
                                        month
                                    @else
                                        night
                                    @endif
                                </span></p>
                                <a href="{{ $rental ? route('rental.show', $room->id) : route('room.show', $room->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-[#ad68e4] rounded-lg hover:bg-gray-800 justify-center" style="background-color: #000;">View</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="room-card flex px-8 w-full">
                        <p class="text-2xl font-bold" style="color:rgb(152, 152, 152);">No rooms available at the moment. Please check back later.</p>
                    </div>
                @endforelse
            </div>
            <!-- Pagination Links -->
            <div class="pagination-links">
                {!! $rooms->links() !!}
            </div>
        </div>

        @push('styles') <!-- If your layout has a 'styles' section -->
            <link rel="stylesheet" href="{{ asset('css/rooms.css') }}">
            <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        @endpush

       @include('Booking.Rooms.room-components.room-select', compact('rental'))
        
    </div>
@endsection