<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc; /* A light gray background to match the image */
    }
    /* Custom scrollbar hiding */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .container-slider {
        width:100%;
        margin: 0 auto;
        padding: 20px;
    }
</style>

<div class="container-slider">
    <!-- New Accommodation Types Section -->
    <div class="mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Accommodation Types</h2>
        <p class="text-gray-500 mb-6">Explore different types of places to stay</p>

        @php
            $propetyTypes = [
                "Guest House",
                "Hotel",
                "Townhouse",
                "Lodge",
                "Apartment",
                "B&B",
                "Hostel"
            ]
        @endphp

        <div class="relative">
            <!-- Carousel Container -->
            <div id="carousel-container" class="flex overflow-x-auto py-2 space-x-6 no-scrollbar scroll-smooth">
                <!-- Carousel Items -->
                @foreach ($propertyTypes as $type)
                    <form action="{{ route('handle-property-click') }}" method="GET">
                        <button class="flex-shrink-0 w-64 hover:scale-105" type="submit" >
                            <div class="bg-white rounded-lg shadow-md overflow-hidden" style="background-color:#68e4ad max-width: 256px; maxa-height: 300px; object-fit: cover; ">
                                <img src="{{ asset('storage/images/'. $type . '.jpg') }}" alt="https://placehold.co/400x300/F472B6/FFFFFF?text={{$type}}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800">{{ $type }}</h3>
                                </div>
                            </div>
                        </button>
                        <input type="hidden" name="property_type" value="{{ $type }}">
                    </form>
                @endforeach
            </div>

            <!-- Carousel Buttons -->
            <button id="prevBtn" class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-4 bg-white rounded-full p-2 shadow-lg z-10 hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button id="nextBtn" class="absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-4 bg-white rounded-full p-2 shadow-lg z-10 hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Select all table rows
            const rows = document.querySelectorAll(" div[data-room-id]");

            // Add click event listener to each row
            rows.forEach(function (row) {
                row.addEventListener("click", function () {
                    const roomId = this.getAttribute("data-room-id");
                    window.location.href = `/booking/room/${roomId}`;
                });
            });
        });
    </script>

    <script>
        const carouselContainer = document.getElementById('carousel-container');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // The width of one carousel item including its margin-right (w-64 + space-x-6 -> 16rem + 1.5rem = 17.5rem).
        // A more robust way is to get it dynamically.
        const itemWidth = carouselContainer.children[0] ? carouselContainer.children[0].offsetWidth + 24 : 280; // 256px + 24px

        nextBtn.addEventListener('click', () => {
            carouselContainer.scrollBy({ left: itemWidth, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            carouselContainer.scrollBy({ left: -itemWidth, behavior: 'smooth' });
        });

        // Optional: Hide/show buttons based on scroll position
        function updateButtonState() {
            const maxScrollLeft = carouselContainer.scrollWidth - carouselContainer.clientWidth;
            prevBtn.style.display = carouselContainer.scrollLeft <= 0 ? 'none' : 'block';
            nextBtn.style.display = carouselContainer.scrollLeft >= maxScrollLeft -1 ? 'none' : 'block'; // -1 for precision issues
        }

        carouselContainer.addEventListener('scroll', updateButtonState);
        window.addEventListener('resize', updateButtonState); // Update on resize
        updateButtonState(); // Initial check
    </script>
</div>