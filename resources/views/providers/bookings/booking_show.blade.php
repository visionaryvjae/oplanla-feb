@extends('layouts.app')

@section('content')

    <style>
        .booking-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
        }

        .grid-container{
            margin-bottom: 1.5rem;
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }

        .grid-container > div:nth-child(n+6) {
            display: none; /* Hide all images after the first 6 */
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


        .facility{
            display: flex; padding:1rem; align-items:center; justify-content:center; color: #444; border: solid #666 1px; border-radius: 0.5rem;
        }

        .facilitiesDisplay{
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin: 1rem 0rem;
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

            .grid-container{
                margin-bottom: 1.5rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid-container > div:nth-child(n+5) {
                display: none; /* Hide all images after the first 6 */
            }

            .facility{
                display: flex; padding:0.25rem 0.5rem; align-items:center; justify-content:center; color: #444; border: solid #666 1px; border-radius: 0.5rem;
            }

            .facilitiesDisplay{
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                gap: 10px;
                margin: 0.5rem 0rem;
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

            .grid-container{
                margin-bottom: 1.5rem;
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }

            .grid-container > div:nth-child(n+4) {
                display: none; /* Hide all images after the first 6 */
            }
        }
    </style>

    <div class="booking-container">
        <h2 class="text-4xl font-bold text-gray-900" style="margin-bottom: 2rem;">Booking at {{ $booking->provider_name }}</h2>
        @php
            $datestrCheckIn = new DateTime($booking->check_in_time);
            $formattedCheckInDate = $datestrCheckIn->format('h:iA');

            $datestrCheckOut = new DateTime($booking->check_out_time);
            $formattedCheckOutDate = $datestrCheckOut->format('d F Y h:iA');

            $images = explode(',', $booking->images);

            $facilities = explode(',', $booking->room_facilities);

        @endphp
        <div class="bg-gray-200 px-4 py-2 w-full mb-6 rounded-lg shadow-md" style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h3 class="text-xl mb-6 text-gray-900 underline">Booking Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-x-4 gap-y-3 ">
                <p class="px-4 py-2 "><strong>Lead Guest:</strong> {{ Auth::user()->name }}</p>
                <p class="px-4 py-2 "><strong>Booking Status:</strong> {{ $booking->status}}</p>
                <p class="px-4 py-2 "><strong>Accomodation Type:</strong> {{ $booking->room_type }}</p>
                <p class="px-4 py-2 "><strong>Stay Date:</strong> {{ $datestrCheckIn->format('d F Y')}}</p>
                <p class="px-4 py-2 "><strong>Check in time:</strong> {{ $formattedCheckInDate }}</p>
                <p class="px-4 py-2 "><strong>Check out time:</strong> {{ $formattedCheckOutDate }}</p>
                <p class="px-4 py-2 "><strong>Price:</strong> ZAR {{ $booking->booking_price }}</p>
            </div>

        </div>

        @php
            $address = explode(',', $booking->booking_address);
            $city = $address[count($address) - 3];

            // $roundedRating = round($booking->rating * 2) / 2;
        @endphp
        {{-- <!-- booking Title and Info -->
        <header class="mb-4" style="margin-bottom:1rem;">
            <h1 class="text-4xl font-bold text-gray-900" style="font-size: 2.25rem; line-height:2.5rem; font-weight:bolder;">{{ $booking->booking_type }}</h1>
            <div class="mt-2 flex items-center text-sm text-gray-600" style="margin-top: 1rem;">
                <span>{{ $booking->provider_name }}, {{ $city }}</span>
                <span class="mx-2">·</span>
                <span class="text-yellow-500 flex">
                    @if ($booking->rating)
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $roundedRating)
                                <!-- Full Star -->
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: #68e4ad;">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @elseif ($i - 0.5 == $roundedRating)
                                <!-- Half Star -->
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: #68e4ad;">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0v15z"/>
                                </svg>
                            @else
                                <!-- Empty Star -->
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: rgb(209 213 219 / var(--tw-text-opacity, 1));">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    @else
                        <p class="text-xs text-gray-500 ml-2">not reviewed yet</p>
                    @endif
                </span>
                <span class="text-xs text-gray-500 ml-2">({{ $booking->num_reviews }} reviews)</span>
            </div>
        </header> --}}

        <!-- Image Gallery -->
        <div class="flex flex-col items-center bg-gray-200 px-4 py-2 w-full mb-6 rounded-lg shadow-md" style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h1 class="text-2xl w-full items-start font-bold text-gray-900" style="font-size: 2.25rem; line-height:2.5rem; font-weight:bolder;">{{ $booking->provider_name }}</h1>
            <div class="mt-2 flex w-full items-start text-sm text-gray-600" style="margin-top: 1rem; margin-bottom: 0.5rem;">
                <span>{{ $booking->room_type }}, {{ $city }}</span>
            </div>
            <div   
                class="grid-container mb-10 grid gap-2" >
                
                @foreach ($images as $index => $image)
                    <div class="gallery relative overflow-hidden rounded-lg" style="max-height: 15rem; max-width: 15rem;">
                        <img src="{{ asset('storage/images/' . $image) }}" data-index="{{ $index }}" alt="booking view 4" class="gallery-image rounded-lg" style="height:100%; width:100%; object-fit:fill; overflow:hidden; max-height:300px">
                    </div>
                @endforeach
            </div>
            <!-- Facilities Display -->
            <div class="facilitiesDisplay">
                @if ($booking->room_facilities)
                    @foreach ($facilities as $facility)
                        <div class="facility">
                            <p style="margin:0rem 0.3rem; font-weight:600;">{{$facility}}</p>
                            <img class="margin:0rem 0.25rem;" width="27" height="27" src="{{ asset('storage/icons/' . $facility.'.png') }}" alt="tv"/> {{-- https://img.icons8.com/ios/50/tv.png--}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- <div class="bg-gray-200 px-4 py-2 w-full mb-6 rounded-lg shadow-md" style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <a href=""><button>

            </button></a>
        </div> --}}

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

        <div>
            
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const images = @json($images); // Convert PHP array to JavaScript array
                const modal = document.getElementById('myModal');
                const carouselImage = document.getElementById('carouselImage');
                const prevButton = document.getElementById('prevButton');
                const nextButton = document.getElementById('nextButton');
                const miniImageCarousel = document.getElementById('miniImageCarousel');
                const closeButton = document.getElementById('btn_close');
                const closeModal = document.getElementById('close_modal');
                let currentIndex = 0;

                // Variables for swipe/drag functionality
                let startX = 0;
                let isDragging = false;
                let dragThreshold = 50; // Minimum pixels to drag for a swipe

                // Open modal when an image is clicked from the gallery
                document.querySelectorAll('.gallery-image').forEach((image, index) => {
                    image.addEventListener('click', () => {
                        modal.style.display = 'flex'; // Use flex to center the modal
                        currentIndex = index;
                        updateCarouselImage();
                    });
                });

                // Close modal when clicking outside
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                };
                

                // Update the carousel image and mini-image focus
                function updateCarouselImage() {
                    carouselImage.src = "{{ asset('storage/images') }}" + '/' + images[currentIndex];
                    updateMiniImageFocus();
                    scrollMiniImageCarousel();
                }

                // Update focus on mini-images
                function updateMiniImageFocus() {
                    document.querySelectorAll('.mini-image-wrapper').forEach((wrapper, index) => {
                        if (index === currentIndex) {
                            wrapper.classList.add('active');
                        } else {
                            wrapper.classList.remove('active');
                        }
                    });
                }

                // Scroll mini-image carousel to focus on the current image
                function scrollMiniImageCarousel() {
                    const activeMiniImage = miniImageCarousel.querySelector('.mini-image-wrapper.active');
                    if (activeMiniImage) {
                        const containerWidth = miniImageCarousel.offsetWidth;
                        const imageWidth = activeMiniImage.offsetWidth;
                        const scrollLeft = activeMiniImage.offsetLeft - (containerWidth / 2) + (imageWidth / 2);
                        miniImageCarousel.scrollTo({
                            left: scrollLeft,
                            behavior: 'smooth'
                        });
                    }
                }
                
                // Close modal when clicking close button
                closeButton.addEventListener('click', () => {
                    modal.style.display = 'none'; // Hide the modal
                });
                
                // Close modal when clicking close modal button
                closeModal.addEventListener('click', () => {
                    modal.style.display = 'none'; // Hide the modal
                });

                // Previous button click event
                prevButton.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    updateCarouselImage();
                });

                // Next button click event
                nextButton.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % images.length;
                    updateCarouselImage();
                });

                // Click on mini-images to change main image
                miniImageCarousel.addEventListener('click', (event) => {
                    const clickedWrapper = event.target.closest('.mini-image-wrapper');
                    if (clickedWrapper) {
                        const index = parseInt(clickedWrapper.dataset.index);
                        if (!isNaN(index) && index >= 0 && index < images.length) {
                            currentIndex = index;
                            updateCarouselImage();
                        }
                    }
                });

                // --- Swipe/Drag functionality for the main image ---

                // Mouse events for dragging
                carouselImage.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    startX = e.clientX;
                    carouselImage.style.cursor = 'grabbing';
                });

                carouselImage.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    // Prevent default drag behavior (e.g., image ghosting)
                    e.preventDefault();
                });

                carouselImage.addEventListener('mouseup', (e) => {
                    if (!isDragging) return;
                    isDragging = false;
                    carouselImage.style.cursor = 'grab';
                    const endX = e.clientX;
                    const diffX = startX - endX; // Positive for left swipe, negative for right swipe

                    if (Math.abs(diffX) > dragThreshold) {
                        if (diffX > 0) { // Swiped left
                            currentIndex = (currentIndex + 1) % images.length;
                        } else { // Swiped right
                            currentIndex = (currentIndex - 1 + images.length) % images.length;
                        }
                        updateCarouselImage();
                    }
                });

                carouselImage.addEventListener('mouseleave', () => {
                    isDragging = false; // Reset dragging if mouse leaves the image area
                    carouselImage.style.cursor = 'grab';
                });

                // Touch events for swiping
                carouselImage.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    isDragging = true;
                }, { passive: true }); // Use passive listener for better scroll performance

                carouselImage.addEventListener('touchmove', (e) => {
                    if (!isDragging) return;
                    // Prevent default touch scroll for horizontal movement if dragging
                    const currentX = e.touches[0].clientX;
                    const diffX = startX - currentX;
                    if (Math.abs(diffX) > 10) { // Small threshold to distinguish from accidental taps
                        e.preventDefault();
                    }
                }, { passive: false }); // Non-passive to allow preventDefault

                carouselImage.addEventListener('touchend', (e) => {
                    if (!isDragging) return;
                    isDragging = false;
                    const endX = e.changedTouches[0].clientX;
                    const diffX = startX - endX;

                    if (Math.abs(diffX) > dragThreshold) {
                        if (diffX > 0) { // Swiped left
                            currentIndex = (currentIndex + 1) % images.length;
                        } else { // Swiped right
                            currentIndex = (currentIndex - 1 + images.length) % images.length;
                        }
                        updateCarouselImage();
                    }
                });

                // Initial update when modal opens (if an image is clicked)
                // This is handled by the click event listener on gallery-image elements
                // but if the modal is opened by other means, you might call updateCarouselImage() here.
            });
        </script>
    </div>
@endsection