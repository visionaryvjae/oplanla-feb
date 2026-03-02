@extends('layouts.app')

@section('content')

<script>
    // Function to get the provider ID from the URL
            function getproviderIdFromUrl() {
                const url = window.location.href; // Get the current URL
                // Match the provider ID pattern: /providers/{id} where {id} is one or more digits
                const provideridMatch = url.match(/\/provider\/(\d+)/);
                if (provideridMatch && provideridMatch[1]) {
                    let providerId = parseInt(provideridMatch[1], 10); // Extract and parse the provider ID
                    let providerIdInputField = document.getElementById('providers_id');

                    // Check if providerId was found and the input field exists
                    if (providerId !== null && providerIdInputField) {
                        providerIdInputField.value = providerId; // Set the value of the hidden input
                        console.log("provider ID set in hidden input:", providerId); // For debugging
                    } else {
                        console.log("provider ID not found in URL or hidden input field not found."); // For debugging
                    }
                }
            }
</script>

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

    <div class="main-container">
        <div class="title-container">
            <h1 class="title">
                {{$provider->provider_name}}</h1>
            <div class="address-container">
                <img class="location-img" src="https://img.icons8.com/color/48/marker--v1.png" alt="">
                <p id="booking_location">{{$provider->booking_address}}</p>
                <p>  • {{$provider->phone}}</p>
            </div>
        </div>
        <div class="below-title">
            <div class="left-picture">
                    <div class="provider-img-container">
                        @php
                            $images = $provider ? explode(',', $provider->photos) : [];
                            $imagesArr = array_reverse($images);
                        @endphp
                        <div class="" style="display: flex; width:100%; height:80%;">
                            {{-- <img  src="{{asset('storage/images/' . $images[0])}}" alt=""
                            style="display:flex; width:100%; height:100%;"> --}}
                            @if (count($images) <= 1)
                                 @if (count($images) < 1)
                                    <div class="side-images" style="display:flex; flex-direction:row; width:100%; height:100%;">
                                        <img src="{{asset('storage/images/img-not-found.jpg')}}" alt="{{asset('storage/images/img-not-found.jpg')}}">
                                    </div>
                                 @else
                                    <div class="side-images" style="display:flex; justify-content:flex-start; flex-direction:row; width:100%; height:100%; padding:0 0.25rem;">
                                        <img class="provider-img" src="{{asset('storage/images/' . $images[0])}}" alt="">
                                    </div>
                                 @endif
                            @else
                                <div class="side-images" style="display:flex; flex-direction:row; width:100%; height:100%;">
                                    <div style="display: flex; flex:2; width:100%; height:100%; margin:0 0.25rem;">
                                        <img class="provider-img" src="{{asset('storage/images/' . $images[0])}}" alt="">
                                    </div>
                                    <div style="display: flex; flex:1; flex-direction: column; width:100%; height:100%;margin:0 0.25rem;">
                                        <div style="display: flex; width:100%; height:100%; margin:0.25rem 0;">
                                            <img class="provider-img" height="100%" src="{{asset('storage/images/' . $images[1])}}" alt="">
                                        </div>
                                        <div style="display: flex; width:100%; height:100%; margin:0.25rem 0;">
                                            @if (count($images) > 2 )
                                                <img  class="provider-img" height="100%" src="{{asset('storage/images/' . $images[2])}}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="image-grid-bottom">
                            @for ($i = 0; $i < 5; $i++)
                                <div style="display: flex; width:100%; height:100%; margin: 0.5rem 0.3rem;">
                                    <img @if (count($imagesArr) > 2)
                                        class="provider-img"
                                    @else
                                        height="100%"
                                        style="border-radius: 0.3rem;"
                                    @endif src="{{asset('storage/images/' . $imagesArr[$i])}}" alt="">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="right-sidebar">
                        <div class="map-container">
                        </div>
                        <div class="reviews">
                            rating and reviews
                        </div>
                        <div class="map" id="map"></div>
                    </div>
            </div>
            <script>
                //retrieve mapbox token
                mapboxgl.accessToken = '{{ env('MAPBOX_ACCESS_TOKEN') }}';


                // Initialize the Mapbox map
                const map = new mapboxgl.Map({
                    container: 'map', // ID of the div element for the map
                    style: 'mapbox://styles/mapbox/streets-v12', // Style URL
                    center: [27.8257, -26.1962], // Initial center (South Africa)
                    zoom: 4, // Initial zoom level
                });

                // Add navigation controls to the map
                map.addControl(new mapboxgl.NavigationControl());

                // Geocode the provided location
                const booking_address = document.getElementById('booking_location'); // Example location
                // const address = booking_address.value;
                console.log(`the booking address is: ${booking_address.textContent}`);

                // Use MapboxGeocoder to geocode the address
                const geocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    countries: 'ZA', // Restrict to South Africa
                    language: 'en',
                    types: 'country,region,place,postcode,district,locality,neighborhood,street'
                });

                // Geocode the provided address
                geocoder.forwardGeocode({
                    query: booking_address.textContent
                })
                .send()
                .then((response) => {
                    if (response.body.features.length > 0) {
                        const result = response.body.features[0];

                        // Center the map on the geocoded location
                        map.flyTo({
                            center: result.center,
                            zoom: 14,
                            essential: true
                        });

                        // Add a marker at the geocoded location
                        const marker = new mapboxgl.Marker()
                            .setLngLat(result.center)
                            .addTo(map);

                        // Optionally, add a popup with the location name
                        const popup = new mapboxgl.Popup({ offset: [0, -15] })
                            .setText(result.place_name);
                        marker.setPopup(popup).togglePopup();
                    } else {
                        console.error("No results found for the provided address.");
                    }
                })
                .catch((error) => {
                    console.error("Error geocoding address:", error);
                });
            </script>
            <div class="content-container">
                <h2>About this property</h2>
                <div class="facilities">
                    <div>
                        
                    </div>                    
                </div>
                <div class="paragraph">
                    <h3>sub heading</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit autem alias, corrupti nihil repellat consectetur libero odit officia magnam at reprehenderit molestiae, aliquam accusantium ea perspiciatis dicta. Quam, nobis nulla?</p>
                </div>
                <div class="paragraph">
                    <h3>sub heading</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit autem alias, corrupti nihil repellat consectetur libero odit officia magnam at reprehenderit molestiae, aliquam accusantium ea perspiciatis dicta. Quam, nobis nulla?</p>
                </div>
            </div>
        </div>
        <form class="rooms" action="{{$actionUrl}}" method="">
            <h2>Rooms</h2>
            
            <div style="display: flex; width:100%; flex-direction:column; padding:0.5rem 0;">
                <p>please confirm staying dates</p>
                <div class="date-container" style="flex: 3;">
                    <input 
                        class="date-input"
                        id="check_in_time"
                        name="check_in_time"
                        type="datetime"
                        placeholder="Check in Time"
                    >
                    <input 
                        class="date-input"
                        id="check_out_time"
                        name="check_out_time"
                        type="datetime"
                        placeholder="Check Out Time"
                    >
                    <button class="btn-submit" style="width:60%;">change search</button>
                </div>
            </div>
            
            <script>
                // Retrieve values from localStorage
                const checkInTime = localStorage.getItem('checkInTime');
                const checkOutTime = localStorage.getItem('checkOutTime');
                const nightsMultiplier = localStorage.getItem('nightsMultiplier');

                // Populate the fields on the single room form
                document.getElementById('check_in_time').value = checkInTime;
                document.getElementById('check_out_time').value = checkOutTime;

                // Optional: Clear localStorage after retrieval to avoid reusing old data
                localStorage.removeItem('checkInTime');
                localStorage.removeItem('checkOutTime');
            </script>
            
            <table class="table">
                <tr class="table-head-row">
                    <th class="table-header" style="border-radius: 5px 0px 0px 0px;">Accommodation Type</th>
                    <th class="table-header">Number of Guests</th>
                    <th class="table-header">Price</th>
                    <th class="table-header">Available Rooms</th>
                    <th class="table-header">Reserve this room</th>
                </tr>

                
                @foreach ($rooms as $room)
                    @php
                        $guestOptions = explode(',', $room->num_people); // Example: "2 guests,1 guests"
                        $prices = explode(',', $room->prices);
                        $roomsId = explode(',', $room->roomId);
                    @endphp

                    {{-- Loop through each guest/price sub-option for the current room --}}
                    @foreach ($guestOptions as $index => $guestDescription)
                        <tr class="data-rows">
                            @if ($index == 0)
                                {{-- This cell is only added for the very first sub-option row of this room type --}}
                                <td class="rows" rowspan="{{ count($guestOptions) }}">{{ $room->room_type }}</td>
                            @endif
                            {{-- These cells are added for every sub-option row --}}
                            <td class="rows">{{ $guestDescription }} Guests</td>
                            <td class="rows">ZAR {{ $prices[$index] }} per night</td>
                            <td class="rows">{{ $room->rooms_available }}</td>
                            <td class="rows">
                                <select name="num_rooms" id="num_rooms"> {{-- Consider unique names for form submission --}}
                                    <option value="">0</option>
                                    @for ($i = 1; $i <= $room->rooms_available; $i++)
                                        <option value="{{$i}}" >{{ $i }} (ZAR {{$i * $prices[$index] }})</option>
                                    @endfor
                                </select>
                                <input 
                                    type="hidden"
                                    name="rooms_id"
                                    id="rooms_id"
                                    value="{{$roomsId[$index]}}"
                                >
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>

            <div class="button-container">
                <button class="btn btn-submit" id="submit-btn">Make reservation</button>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const makeReservationButton = document.getElementById("submit-btn");
                    const providerId = {{ $providerId }}

                    makeReservationButton.addEventListener("click", function (event) {
                        event.preventDefault();

                        const reservedRoomIds = [];
                        const numRooms = [];
                        const checkinTime = document.getElementById('check_in_time').value;
                        const checkoutTime = document.getElementById('check_out_time').value;

                        // More robust selector to target rows with actual selections
                        const rows = document.querySelectorAll(".main-container table .data-rows");

                        rows.forEach(function (row) {
                            const dropdown = row.querySelector("select[name='num_rooms']");
                            const roomIdInput = row.querySelector("input[name='rooms_id']");

                            if (dropdown && roomIdInput) {
                                const selectedValue = parseInt(dropdown.value, 10);
                                console.log(`the current drop down value id: ${selectedValue}`);
                                if (selectedValue > 0) {
                                    const roomId = roomIdInput.value;
                                    // Add the room ID 'selectedValue' times
                                    for (let i = 0; i < selectedValue; i++) {
                                        
                                    }
                                    reservedRoomIds.push(roomId);
                                    numRooms.push(selectedValue);
                                }
                            }
                        });
                        // console.log(`The providerId is: ${providerId}`);

                        if (reservedRoomIds.length > 0) {
                            // Redirect to the create booking page with room IDs and dates
                            const url = `/room_booking/create?room_ids=${reservedRoomIds.join(',')}&num_rooms=${numRooms.join(',')}&pid=${providerId}&check_in_time=${checkinTime}&check_out_time=${checkoutTime}`;
                            window.location.href = url;
                        } else {
                            // Inform the user to select at least one room
                            alert("Please select at least one room to make a reservation.");
                        }
                    });
                });
            </script>
        </form>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/provider.css') }}">
    @endpush
@endsection