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
        <form class="content-container" action="{{ route('rooms.filter') }}" method="GET">
            @csrf

            <div class="rounded-lg pt-2" style="width:70%;">
                <!-- Navigation Tabs -->
                {{-- <nav class="flex space-x-4 mb-4 text-sm font-medium" style="align-items:center; justify-content:space-around">
                    <a href="#" class="text-red-500 border-b-2 border-red-500 pb-1">Buy</a>
                    <a href="#" class="text-gray-700 hover:text-red-500">Rent</a>
                    <a href="#" class="text-gray-700 hover:text-red-500">Developments</a>
                    <a href="#" class="text-gray-700 hover:text-red-500">Agents</a>
                    <a href="#" class="text-gray-700 hover:text-red-500">Sold Prices</a>
                </nav> --}}

                <!-- Search Bar -->
                <div class="search-bar flex flex-row sm:flex-row gap-3 mb-2">
                    <div class="flex relative flex-grow w-full rounded-sm">
                        <input
                            type="text"
                            id="location"
                            placeholder="Search for a City, Suburb or Web Reference"
                            class="w-full rounded-lg py-3 px-6 focus:outline-none focus:ring-2 focus:ring-red-800"
                            style="border:none; padding:0.25rem 2rem;" 
                        />
                        {{-- border-top-right-radius: 0; border-bottom-right-radius:0;  --}}
                        {{-- <button class="flex items-center justify-center bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-100 whitespace-nowrap" style="padding: 0rem 1rem; border-top-left-radius:0; border-bottom-left-radius:0; background-color:#ddd">
                            <img class="mr-2" width="25" height="25" src="https://img.icons8.com/ios-glyphs/30/map-marker.png" alt="map-marker"/> Map
                        </button> --}}
                    </div>
                    
                    <button type="submit" class="bg-red-500 hover:bg-black  text-white white-6 py-3 rounded-lg font-semibold transition duration-200" style="background-color:#68E4AD; padding:0.75rem 2rem;">
                        Search
                    </button>
                    <div class="suggestions-container" id="suggestions-container"></div>
                </div>
                

                <!-- Filters -->
                <div class="px-3 pt-1 rounded-md flex flex-wrap gap-3">
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
                    <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="">
                        <select 
                            class="select-input w-full px-3 py-2 text-white" 
                            name="property_type"
                            id="property_type"
                        >
                            <option class="option-input" value="">Property Type</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type }}">{{ $type }} Room</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="">
                        <select 
                            class="select-input w-full px-3 py-2 text-white"
                            name="min_price"
                            id="min_price"
                        >
                            <option class="option-input" value="">Min Price</option>
                            @foreach($minPrices as $price)
                                <option value="{{ $price }}">R{{ number_format($price) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="">
                        <select 
                            class="select-input w-full px-3 py-2 text-white" 
                            name="max_price"
                            id="max_price"
                        >
                            <option class="option-input" value="">Max Price</option>
                            @foreach($maxPrices as $price)
                                <option value="{{ $price }}">R{{ number_format($price) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <div class="pt-2 px-2"><span id="room-count" style="font-size: 0.75rem; color: rgb(278, 193, 154)">0 properties</span></div> --}}
            </div>
        </form>
        <div class="room-content">
            <div class="trending-destinations" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%;; border-radius:0.5rem; margin:1.5rem 0rem;">@include('Booking.welcome-components.TrendingDestinations')</div>
            <div class="room-type filter" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%;; border-radius:0.5rem; margin:1.5rem 0rem;">@include('Booking.welcome-components.RoomTypes')</div>
            <div class="province-search" style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%;; border-radius:0.5rem; margin:1.5rem 0rem;"></div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{asset('css/landing.css')}}">
    @endpush

    <script>
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

        // Get the search input element
        const searchInput = document.getElementById('location');
        const suggestionsContainer = document.getElementById('suggestions-container');

        // Initialize the Mapbox Geocoder
        const geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            countries: 'ZA', // Restrict to South Africa
            language: 'en',
            types: 'country,region,place,postcode,district,locality,neighborhood,street',
            placeholder: 'Search for a location in South Africa'
        });

        console.log('Geocoder initialized:', geocoder);

        // Ensure Mapbox access token is loaded
        geocoder.addTo(searchInput);

        // Handle typing events to show suggestions
        searchInput.addEventListener('input', () => {
            const query = searchInput.value;

            // Fetch suggestions from Mapbox Search API
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${mapboxgl.accessToken}&types=country,place,postcode,district,locality,neighborhood,address&limit=5&country=ZA`)
                .then(response => response.json())
                .then(data => {
                    // Clear previous suggestions
                    suggestionsContainer.innerHTML = '';

                    // Display suggestions
                    data.features.forEach(feature => {
                        const suggestion = document.createElement('div');
                        suggestion.textContent = feature.place_name;
                        suggestion.classList.add('suggestion');
                        suggestion.addEventListener('click', () => {
                            searchInput.value = feature.place_name; // Update search input
                            suggestionsContainer.innerHTML = ''; // Clear suggestions
                        });
                        suggestionsContainer.appendChild(suggestion);
                    });

                    if (data.features.length > 0) {
                        suggestionsContainer.style.display = 'block';
                    } else {
                        suggestionsContainer.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching suggestions:', error);
                });
            });

            document.addEventListener('click', (event) => {
                if (!suggestionsContainer.contains(event.target)) {
                    suggestionsContainer.style.display = 'none';
                }
            });
    </script>


    <script>
        // Event listener for form submission
        document.getElementById('landingForm').addEventListener('submit', function(event) {

            // Get values from input fields
            const checkInTime = document.getElementById('check_in_time').value;
            const checkOutTime = document.getElementById('check_out_time').value;

            // Calculate the difference in milliseconds
            const diffInMs = Math.abs(checkOutTime - checkInTime);

            // Convert milliseconds to days (1 day = 24 * 60 * 60 * 1000 ms)
            const days = Math.ceil(diffInMs / (1000 * 60 * 60 * 24))-1;

            console.log(`The check in time is: ${checkInTime}\nThe check out time is: ${checkOutTime}`)

            // Store values in localStorage
            localStorage.setItem('checkInTime', checkInTime);
            localStorage.setItem('checkOutTime', checkOutTime);
            localStorage.setItem('nightsMultiplier');
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
        const propertyType = document.getElementById('property-type');
        const minPrice = document.getElementById('min-price');
        const maxPrice = document.getElementById('max-price');
        const roomCountSpan = document.getElementById('room-count');

        // Function to fetch room count based on filters
        function fetchRoomCount() {
            const filters = {
                property_type: propertyType.value,
                min_price: minPrice.value,
                max_price: maxPrice.value,
            };

            axios.get('booking/rooms-count', { params: filters })
                .then(response => {
                    roomCountSpan.textContent = `${response.data.num_rooms} properties`;
                })
                .catch(error => {
                    console.error('Error fetching room count:', error);
                });
        }

        // Attach event listeners to all comboboxes
        [propertyType, minPrice, maxPrice, bedrooms].forEach(select => {
            select.addEventListener('change', fetchRoomCount);
        });

        // Initial fetch when the page loads
        fetchRoomCount();
    });
    </script> --}}
@endsection