@extends('layouts.app')

@section('content')
    <style>
        /* Custom colors for Tailwind */
        :root {
            --color-primary-p: #ad68e4;
            --color-complimentary: #68e4ad;
            --color-dark-bg: #282c34; /* Dark background from footer image */
            --color-text-light: #e0e0e0; /* Light text for dark backgrounds */
            --color-text-dark: #333333; /* Dark text for light backgrounds */
        }
        .bg-primary-p { background-color: var(--color-primary-p); }
        .text-primary-p { color: var(--color-primary-p); }
        .hover\:bg-primary-p-darker:hover { background-color: #973fdf; /* Slightly darker primary-p */ }
        .bg-complimentary { background-color: var(--color-complimentary); }
        .text-complimentary { color: var(--color-complimentary); }
        .bg-dark-bg { background-color: var(--color-dark-bg); }
        .text-text-light { color: var(--color-text-light); }
        .text-text-dark { color: var(--color-text-dark); }

        /* Inter font */
        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-text-dark);
        }
    </style>
    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Your Guide to Booking on Oplanla.com</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            Booking your perfect accommodation on Oplanla.com is simple and straightforward.
            Follow these easy steps to secure your stay.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Step 1 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">1</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Search for Your Stay</h2>
                    <p class="text-gray-600 mb-4">
                        Use our intuitive search bar on the homepage to find accommodations by city, suburb, or even a specific reference.
                        You can refine your search using property type, price range, and number of guests.
                    </p>
                    <img src="{{ asset('storage/icons/search-bar.png') }}" alt="Search Bar Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">2</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Browse Results</h2>
                    <p class="text-gray-600 mb-4">
                        Explore the list of available rooms that match your criteria. Each listing provides essential details like price,
                        number of guests, bedrooms, baths, and reviews.
                    </p>
                    <img src="{{ asset('storage/icons/scroll-results.png') }}" alt="Room Listings Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">3</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">View Details & Reviews</h2>
                    <p class="text-gray-600 mb-4">
                        Click on a listing to view more detailed information, including photos, amenities, location on a map,
                        and guest reviews to help you make an informed decision.
                    </p>
                    <img src="{{ asset('storage/icons/room-details.png') }}" alt="Property Details Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">4</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Select Your Dates</h2>
                    <p class="text-gray-600 mb-4">
                        On the property's page, select your desired check-in and check-out dates from the availability calendar.
                    </p>
                    <img src="{{ asset('storage/icons/select-date.png') }}" alt="Calendar Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>

            <!-- Step 5 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">5</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Confirm Your Booking</h2>
                    <p class="text-gray-600 mb-4">
                        Review your booking details, including the total price. If you're happy, proceed to confirm.
                        You might need to create an account or log in if you haven't already.
                    </p>
                    <img src="{{ asset('storage/icons/confirm-booking.png') }}" alt="Confirmation Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>

            <!-- Step 6 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">6</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Make Payment</h2>
                    <p class="text-gray-600 mb-4">
                        Complete your booking by making a secure payment through our trusted payment gateway.
                        We accept various payment methods.
                    </p>
                    <img src="{{ asset('storage/icons/pay-room.png') }}" alt="Payment Gateway Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>

            <!-- Step 7 -->
            <div class="flex items-start space-x-6 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-p text-white rounded-full flex items-center justify-center text-2xl font-bold">7</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Receive Confirmation</h2>
                    <p class="text-gray-600 mb-4">
                        Once your payment is processed, you'll receive an email confirmation with all your booking details.
                        You can also view and manage your booking in your 'Dashboard'.
                    </p>
                    <img src="{{ asset('storage/icons/confirmed.png') }}" alt="Dashboard Screenshot" class="w-full rounded-lg shadow-md mt-4">
                </div>
            </div>
        </div>

        <div class="text-center mt-16">
            <p class="text-xl text-gray-700 mb-6">Ready to start your next adventure?</p>
            <a href="/rooms" class="inline-block bg-complimentary text-white font-semibold py-4 px-8 rounded-lg text-xl hover:bg-green-600 transition duration-300 shadow-lg">Find a Room Now!</a>
        </div>
    </main>
@endsection