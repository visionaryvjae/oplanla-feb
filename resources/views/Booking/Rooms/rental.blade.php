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
        /* Custom focus ring color to match the theme */
        .focus\:ring-custom:focus {
            --tw-ring-color: #ad68e4;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .gallery img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }
        
        .btn_close{
            display:flex;
            width:100%;
            align-items:center;
            justify-content:flex-end;
            padding: 0.5rem;
            color: #aaa;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
            display: flex; /* Use flexbox for centering */
            align-items: stretch; /* Center vertically */
            justify-content: center; /* Center horizontally */
        }

        .modal-content {
            margin: auto; /* Auto margin will center it */
            padding: 5px;
            background-color: #fefefe;
            height:100%;
            width: 90%; /* Responsive width */
            max-width: 800px;
            text-align: center;
            border-radius: 1rem; /* Rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); /* Subtle shadow */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .carousel-image {
            width: 100%;
            height:100%;
            max-height: 70vh; /* Max height relative to viewport */
            object-fit: contain;
            background-color: #010101;
            border-radius: 0.5rem; /* Slightly rounded corners for the image */
            margin-bottom: 0.125rem;
            user-select: none; /* Prevent text selection on drag */
            -webkit-user-drag: none; /* Prevent image drag on webkit browsers */
            touch-action: pan-y; /* Allow vertical pan, but handle horizontal pan with JS */
        }

        .carousel-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 90%; /* Adjust width for controls */
            max-width: 700px; /* Max width for controls */
            margin-top: 1rem;
            gap: 0.5rem; /* Space between elements */
        }

        .carousel-button {
            background-color: #4CAF50; /* Green background */
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 9999px; /* Fully rounded */
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .carousel-button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .carousel-button:active {
            transform: scale(0.95);
        }

        .mini-image-carousel-container {
            flex-grow: 1; /* Allows the container to take available space */
            overflow-x: auto; /* Enable horizontal scrolling */
            white-space: nowrap; /* Prevent wrapping of mini-images */
            padding: 0.5rem 0; /* Add some padding for better aesthetics */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
            scrollbar-width: none; /* Hide scrollbar for Firefox */
            -ms-overflow-style: none;  /* Hide scrollbar for IE and Edge */
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .mini-image-carousel-container::-webkit-scrollbar {
            display: none;
        }

        .mini-image-carousel {
            display: flex;
            gap: 0.5rem; /* Space between mini-images */
            align-items: center;
        }

        .mini-image-wrapper {
            flex-shrink: 0; /* Prevent mini-images from shrinking */
            width: 4rem; /* Fixed width for mini-images */
            height: 4rem; /* Fixed height for mini-images */
            overflow: hidden;
            border-radius: 0.5rem;
            border: 2px solid transparent; /* Default border */
            transition: border-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
        }

        .mini-image-wrapper.active {
            border-color: #4CAF50; /* Highlight active image */
            transform: scale(1.05);
        }

        .mini-carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover the wrapper area */
            border-radius: 0.5rem;
        }
        
        .description-container {
            margin-bottom: 1.5rem;
            }
            
        .description-content {
            overflow: hidden;
            line-height: 1.6;
            max-height: 8em; /* ≈ 3 lines */
            transition: max-height 0.3s ease;
        }
        
        .description-content.expanded {
            max-height: none;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            color: #ad67e4;
            cursor: pointer;
            font-size: 0.95rem;
            margin-top: 8px;
            padding: 0;
            text-decoration: underline;
        }
        
        .toggle-btn:hover {
            color: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
            }
            .carousel-controls {
                width: 95%;
            }
            .mini-image-wrapper {
                width: 3.5rem;
                height: 3.5rem;
            }
            
            .gallery{
                max-height:200px;
            }

        }

        @media (max-width: 480px) {
            .mini-image-wrapper {
                width: 3rem;
                height: 3rem;
            }
            .carousel-button {
                padding: 0.5rem;
                font-size: 1.2rem;
            }
            
            .gallery{
                max-height:130px;
            }
        }
    </style>

    <div class="main-container">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" style="max-width: 70rem;">
            @php
                $address = explode(',', $room->provider->booking_address) ?? [];
                $city = $address[count($address) - 3];

                $roundedRating = $reviews->count() ? round($reviews->sum('rating')/$room->provider->review->count() ?? 1, 1) : 0;
            @endphp
            <!-- Room Title and Info -->
            <header class="mb-4" style="margin-bottom:1rem;">
                <h1 class="text-4xl font-bold text-gray-900" style="font-size: 2.25rem; line-height:2.5rem; font-weight:bolder;">{{ $room->room_type }}</h1>
                <div class="mt-2 flex flex-col md:flex-row items-center text-sm text-gray-600" style="margin-top: 1rem;">
                    <span>{{ $room->provider->provider_name }}, {{ $city }}</span>
                    <span class="mx-2">·</span>
                    <span class="text-yellow-500 flex">
                        @if ($room->provider->review->count() > 0)
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $roundedRating)
                                    {{-- Full Star --}}
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: #68e4ad;">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @elseif ($i - 0.5 == $roundedRating)
                                    {{-- Half Star --}}
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: #68e4ad;">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0v15z"/>
                                    </svg>
                                @else
                                    {{-- Empty Star --}}
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: rgb(209 213 219 / var(--tw-text-opacity, 1));">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                             @endfor
                        @else
                            <p class="text-xs text-gray-500 ml-2">not reviewed yet</p>
                        @endif
                    </span>
                    <span class="text-xs text-gray-500 ml-2">({{ $reviews->count() }} reviews)</span>
                </div>
            </header>

            <!-- Image Gallery -->
            <div   
                class="grid-container mb-10 gap-2" 
                style="margin-bottom: 1.5rem;">
                @php
                    $images = $room->provider->photos->pluck('image')->toArray() ?? [];
                @endphp
                @foreach ($images as $index => $image)
                    <div class="gallery relative overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/images/' . $image) }}" data-index="{{ $index }}" alt="Room view 4" class="gallery-image rounded-lg" style="height:100%; width:100%; object-fit:cover; overflow:hidden; max-height:300px">
                    </div>
                @endforeach
            </div>

            <!-- Modal/ImageViewer -->
            <div id="myModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <button class="btn_close" id="btn_close">
                        <img width="30" height="30" src="https://img.icons8.com/ios-filled/50/delete-sign--v1.png" alt="delete-sign--v1"/>
                    </button>
                    <!-- Main image display area -->
                    <img id="carouselImage" class="carousel-image" src="" alt="Current Image">
                    <div class="flex w-full items-center justify-end">
                        <button class="px-2 text-md" id="close_modal" style="color:#e4ad68;">Close Modal</button>
                    </div>

                    <!-- Carousel controls with previous/next buttons and mini-images -->
                    <div class="carousel-controls">
                        <button id="prevButton" class="carousel-button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12 15.75 4.5" />
                            </svg>
                        </button>

                        <!-- Container for mini-images, allowing horizontal scrolling -->
                        <div class="mini-image-carousel-container">
                            <div class="mini-image-carousel" id="miniImageCarousel">
                                @foreach ($images as $index => $item)
                                    <div class="mini-image-wrapper" data-index="{{ $index }}">
                                        <img src="{{ asset('storage/images/' . $item) }}" alt="Room view" class="mini-carousel-image rounded-lg">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button id="nextButton" class="carousel-button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5 15.75 12 8.25 19.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content & Booking Form -->
            <div class="lg:flex lg:flex-col">
                <!-- Left Column: Details -->
                <div class="lg:w-full border-b border-gray-200 pb-6 mb-6">
                    <div class="pb-6 border-b border-gray-200" style="padding-bottom: 0.125rem;">
                        <h2 class="text-2xl font-semibold text-gray-800" style="font-size: 1.5rem; line-height: 2rem;">Deluxe suite hosted by {{ $room->provider->provider_name }}</h2>
                        <p class="text-gray-600 mt-1" style="margin-top: 0.5rem;">{{ $room->num_beds }} Bedrooms • {{ $room->num_bathrooms }} bathrooms • {{ $room->furnishing }}</p>
                        
                        <h2 class="mt-2 text-2xl font-semibold text-purple-800" style="color: rgb(100,100,100)">R{{ number_format($room->rental_price, 2) }} <span style="font-size: 1.5rem; line-height: 2rem;color: #68E4ad">p/month</span> </h2>
                        <div class="flex justify-end mb-2">
                            <button id="shareButton" class="flex space-x-2 lg:px-4 px-2 py-2 rounded-md items-center text-white bg-black hover:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                                    <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z"/>
                                </svg>
                                <p class="hidden lg:flex">Share Room</p>
                            </button>
                            
                            <p id="feedback" style="display: none; color: green; margin-top: 10px;">Link copied to clipboard!</p>
                        </div>
                    </div>
                    

                    <div class="description-container py-6 border-b border-gray-200" style="padding: 1.5rem 0rem;">
                        <div class="description-content" id="property-description">
                            <?php echo nl2br(htmlspecialchars($room->provider->description)); ?>
                        </div>
                        
                        <button type="button" class="toggle-btn" onclick="toggleDescription()">
                            Show more
                        </button>
                    </div>

                    <div class="py-6" style="padding: 1.5rem 0rem;">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">What this place offers</h3>
                        @php
                            $roomfacilities = explode(',', $room->room_facilities) ?? [];
                            $providerfacilities = explode(',', $room->provider->provider_facilities) ?? [];
                            
                            $facilities = array_merge($providerfacilities, $roomfacilities);
                            
                            $uniqueFacilities = array_unique($facilities);
                        @endphp
                        <ul 
                            class="grid grid-cols-2 gap-x-8 gap-y-3 text-gray-700"
                            style="
                                display: grid;
                                grid-template-columns: repeat(2, minmax(0, 1fr));
                                column-gap: 2rem;
                                row-gap: 0.75rem;
                            "
                        >
                            @if ($room->room_facilities)
                                @foreach ($facilities as $facility)
                                    <li class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #68E4AD;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></svg>{{$facility}}<img height="20px" width="20px" style="margin-left:0.5rem;" src="{{ asset('storage/icons/' . $facility.'.png') }}" alt=""></li>
                                @endforeach
                            @else
                                <p class="px-4">no facilities added</p>
                            @endif
                        </ul>
                    </div>
                </div>

                <aside class="w-full">
                    <!-- Main component container -->
                    <div class="w-full items-start">
                        <!-- Left Side: Contact Agent Form -->
                        <div class="bg-white rounded-2xl shadow-md border p-6 md:p-8 w-full">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Contact Property Owner</h2>

                            <div class="space-y-4">

                                <!-- Form for sending a message -->
                                <form action="{{ route('rental.send.enquiry', $room->id) }}" method="POST" class="space-y-4 pt-4">
                                    
                                    @csrf
                                    
                                    
                                    <!-- Mobile Number Input -->
                                    <div class="relative">
                                        <label class="text-xl font-bold" style="color: #ad67e4;">Send an equiry to the property owner</label>
                                    </div>
                                    
                                    <!-- Message Textarea -->
                                    <textarea name="message" id="message" rows="4" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom focus:border-transparent transition">Hello, I’m interested in renting this property. Could you please let me know the next steps to apply?</textarea>
                                    
                                    <!-- Send Message Button -->
                                    <button type="submit" class="w-full px-4 py-3 rounded-lg bg-[#ad68e4] text-white font-bold transition-all duration-300 hover:bg-opacity-90">Send Message</button>
                                </form>
                            </div>
                            
                            <!-- Disclaimer Text -->
                            <p class="text-xs text-gray-500 mt-6 text-center">
                                By continuing you understand and agree with the <br> <a href="/terms-and-conditions" class="underline">Terms & Conditions</a> and <a href="/privacy-policy" class="underline">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
            
        </div>
        <!-- review section -->
        @if($reviews->count() > 0)
            <div class="flex flex-col mt-6 lg:mt-8 w-full" style="width:100%;">
                @include('Booking.Rooms.room-components.reviews', [
                'numReviews' => $reviews->count(), 
                'reviews' => $reviews,
                'avgRating' => $roundedRating
                ])
            </div>
        @endif
    </div>

    @include('Booking.Rooms.room-components.image-modal')
    @include('Booking.Rooms.room-components.text-truncate')
    @include('Booking.Rooms.room-components.share-button')

    @push('styles') <!-- If your layout has a 'styles' section -->
        <link rel="stylesheet" href="{{ asset('css/room.css') }}">
    @endpush
@endsection