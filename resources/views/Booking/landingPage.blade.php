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
                100,
                200,
                300,
                400,
                500,
                600,
                700,
                800,
                900,
                1000,
                1500,
                2000,
                2500,
                3000,
                3500,
                4000
            ];

            $maxPrices = [
                300,
                400,
                500,
                600,
                700,
                800,
                900,
                1000,
                1500,
                2000,
                2500,
                3000,
                3500,
                4000,
                4500,
                5000,
                5500,
                6000
            ];
        @endphp
        @include('Booking.welcome-components.SearchBar')
        <div id="loading-indicator" style="display: none; text-align: center; padding: 2rem;">
            <p>Loading...</p>
        </div>
        <div class="room-content" id="room-results-container" >
            {{-- landing page form --}}
            @if (isset($rooms) && $rooms->count() > 0)
                @include('Booking.Rooms._rooms-list', ['rooms' => $rooms ?? [], 'pagetitle' => 'Filtered Rooms'])
            @else
                <div class="trending-destinations" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; border-radius:0.5rem; margin:1.5rem 0rem;">@include('Booking.welcome-components.TrendingDestinations')</div>
                
                <div class="new-providers" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; border-radius:0.5rem; margin:1.5rem 0rem; padding: 0rem 2rem;">@include('Booking.welcome-components.NewProviders')</div>
                
                <div class="room-type filter" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; border-radius:0.5rem; margin:1.5rem 0rem; padding: 0rem 2rem;">@include('Booking.welcome-components.RoomTypes')</div>
                
                <div class="province-conference-rooms" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; border-radius:0.5rem; margin:1.5rem 0rem; padding: 0rem 2rem;">@include('Booking.welcome-components.ConferenceRooms')</div>
            @endif
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{asset('css/landing.css')}}">
    @endpush

@endsection