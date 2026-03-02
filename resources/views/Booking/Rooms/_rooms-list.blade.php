{{-- resources/views/Booking/Rooms/_rooms-list.blade.php --}}

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    }

    .container {
    width: 75%;
    margin: 0 auto;
    padding: 20px;
    }

    /* Header Section */
    .header {
    margin-bottom: 20px;
    }

    .header h2 {
    font-size: 24px;
    margin-bottom: 5px;
    }

    .header p {
    font-size: 16px;
    color: #666;
    }

    /* Cards Section */
    .cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    }

    .card {
    flex: 1 1 calc(33.33% - 20px); /* Adjusts spacing for 3 columns */
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
    }

    .card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    }

    .card h3 {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 10px;
    text-align: center;
    font-size: 20px;
    }

    /* Footer Section */
    .footer {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    }

    .footer-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    }

    .footer-card img {
    width: 40px;
    height: 40px;
    margin-bottom: 10px;
    }

    .footer-card p {
    font-size: 16px;
    color: #333;    
    }
    
    .rooms-display{
        
    }
</style>    

@if($rooms->count() > 0)
    <div style="display: flex; align-items:center; justify-content:center; flex-direction:column; width:100;">
        <div style="margin-bottom: 2rem; width:100%; max-width:67rem; align-items:flex-start;">
        <h1 class="text-gray-900" style="text-align: left; font-size:2.25rem; font-weight:bolder;"> Filtered Rooms</h1>
    </div>
    {{-- _rooms-list form --}}
    <div class="rooms-display grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-3 gap-6" style="width:70%;">
        @foreach ($rooms as $room)
                @php
                    $images =  explode(',', $room->images);
                    $firstImage = $images[0];
    
                    $roundedRating = round($room->rating * 2) / 2;
                @endphp
                <div data-room-id="{{$room->id}}" class="room-card bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 flex flex-col" 
                    style="
                        max-width:30rem;
                        border-radius: 0.5rem;
                        overflow: hidden;
                    "
                >
                    <img src="{{ asset('storage/images/' . $firstImage) }}" class="h-48 object-cover" alt="Room Image" style="max-height:10rem; object-fit:cover">
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800 truncate">{{$room->provider_name}}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{$room->num_people}} Guests • {{$room->num_beds}} Bedrooms • {{$room->num_bathrooms}} Bathrooms</p>
                            <div class="flex items-center mt-2">
                                <span class="text-yellow-500 flex">
                                    @if ($room->rating)
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
                                <span class="text-xs text-gray-500 ml-2">({{ $room->num_reviews }} reviews)</span>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-row md:flex-row lg:flex-row justify-between items-center">
                            <p class="text-xl font-bold text-gray-900">ZAR {{$room->price}} <span class="text-sm font-normal text-gray-500">/ night</span></p>
                            <a href="{{ route('room.show', $room->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-black rounded-lg hover:bg-gray-800">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>


    </div>
@elseif($rooms->count() == 0 && request()->has('location') || request()->has('property_type') || request()->has('min_price') || request()->has('num_beds'))
    <div style="display: flex; align-items:center; justify-content:center; flex-direction:column; width:100%; padding: 0.5rem 1rem;">
        <div style="margin-bottom: 2rem; width:100%; max-width:67rem; align-items:flex-start;">
            <h1 class="text-gray-900" style="text-align: left; font-size:2.25rem; font-weight:bolder;"> No Rooms Found for {{$search ? "\"" . $search . "\"" : 'your search'}}</h1>
            <p class="text-gray-600" style="text-align: left; font-size:1rem;">We couldn't find any rooms matching your criteria. Please try adjusting your search.</p>
        </div>
    </div>
@else
    <div class="container">
        {{-- <section style="display: flex; padding:1rem 0rem;">
        <h1 style="font-size: 1.25rem; line-height:2rem; color:#AD68E4; ">no plan, no problem!</h1>
        </section> --}}
        <!-- Header Section -->
        <section class="header">
        <h2>Trending destinations</h2>
        <p>Travelers searching for South Africa also booked these</p>
        </section>

        <!-- Cards Section -->
        <section class="cards">
            @php
                $cityName = ['Johannesburg', 'Cape Town', 'Mbombela', 'Durban', 'Pretoria']    
            @endphp

            @foreach(['johannesburg', 'cape-town', 'mbombela', 'durban', 'pretoria'] as $index => $city)
                <form method="GET" action="{{ route('handle-click') }}" class="card-form">
                    @csrf <!-- Include CSRF token for Laravel security -->
                    <input type="hidden" name="city" value="{{ $cityName[$index] }}"> <!-- Hidden input to send the city name -->
                    <button type="submit" class="card" style="border: none; background: none; cursor: pointer;">
                        <img src="{{ asset("storage/images/$city.jpg") }}" alt="{{ $city }}">
                        <h3>{{ $cityName[$index] }}</h3>
                    </button>
                </form>
            @endforeach
        </section>

        {{-- <!-- Footer Section -->
        <footer class="footer">
        <div class="footer-card">
            <img src="{{ asset('storage/images/book-now-icon.png') }}" alt="Book now icon">
            <p>Book now, pay at the property</p>
        </div>
        <div class="footer-card">
            <img src="{{ asset('storage/images/million-properties-icon.png') }}" alt="Million properties icon">
            <p>2+ million properties</p>
        </div>
        <div class="footer-card">
            <img src="{{ asset('storage/images/customer-service-icon.png') }}" alt="Customer service icon">
            <p>Trusted 24/7 customer service</p>
        </div>
        </footer> --}}
  </div>
@endif