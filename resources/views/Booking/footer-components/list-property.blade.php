@extends('layouts.app')

@section('content')

    <style>
        /* Custom colors for Tailwind */
        :root {
            --color-primary-p: #68e4ad;
            --color-complimentary: #e4ad68;
            --color-tertiary: #ad68e4; /* New tertiary color */
            --color-dark-bg: #282c34; /* Dark background from footer image */
            --color-text-light: #e0e0e0; /* Light text for dark backgrounds */
            --color-text-dark: #333333; /* Dark text for light backgrounds */
        }
        .bg-primary-p { background-color: var(--color-primary-p); }
        .text-primary-p { color: var(--color-primary-p); }
        .hover\:bg-primary-p-darker:hover { background-color: #973fdf; /* Slightly darker primary-p */ }
        .bg-complimentary { background-color: var(--color-complimentary); }
        .text-complimentary { color: var(--color-complimentary); }
        .bg-tertiary { background-color: var(--color-tertiary); }
        .text-tertiary { color: var(--color-tertiary); }
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
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Partner with Oplanla.com: List Your Property Today!</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            Join the Oplanla.com community and connect with thousands of travelers looking for unique and authentic accommodations.
            Listing your property is easy and offers great benefits.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Benefit Card 1 -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform transition duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-p rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-dark-bg">Reach a Wider Audience</h3>
                <p class="text-gray-600">Gain visibility among our growing community of travelers seeking diverse accommodation options, including those off the beaten path.</p>
            </div>

            <!-- Benefit Card 2 -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform transition duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-p rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-5h-4v-4h4v4z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-dark-bg">Easy Management</h3>
                <p class="text-gray-600">Our intuitive Partner Hub allows you to manage your listings, availability, and bookings with ease.</p>
            </div>

            <!-- Benefit Card 3 -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform transition duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-p rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V8h16v10zm-12-7h4v2h-4z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-dark-bg">Secure Payments</h3>
                <p class="text-gray-600">We handle secure payment processing, ensuring timely and reliable payouts directly to you.</p>
            </div>

            <!-- Benefit Card 4 -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform transition duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-p rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-dark-bg">Dedicated Support</h3>
                <p class="text-gray-600">Access to our dedicated partner support team for any assistance you need, ensuring a smooth experience.</p>
            </div>

            <!-- Benefit Card 5 -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform transition duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-p rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-dark-bg">Competitive Edge</h3>
                <p class="text-gray-600">Stand out in the market, especially if you're a smaller establishment, and attract bookings you might otherwise miss.</p>
            </div>

            <!-- Benefit Card 6 -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform transition duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-p rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-dark-bg">Community & Growth</h3>
                <p class="text-gray-600">Join a growing community of passionate hosts. Share experiences, get advice, and stay updated on industry trends.</p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg mb-16">
            <h2 class="text-3xl font-bold mb-6 text-dark-bg text-center">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-complimentary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                    <h3 class="text-xl font-bold mb-2 text-dark-bg">Register as a Partner</h3>
                    <p class="text-gray-600">Create your Oplanla.com partner account in minutes.</p>
                </div>
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-complimentary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                    <h3 class="text-xl font-bold mb-2 text-dark-bg">Add Property Details</h3>
                    <p class="text-gray-600">Provide information, amenities, and high-quality photos.</p>
                </div>
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-complimentary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                    <h3 class="text-xl font-bold mb-2 text-dark-bg">Set Availability & Rates</h3>
                    <p class="text-gray-600">Control your calendar and pricing to match your business needs.</p>
                </div>
                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-complimentary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                    <h3 class="text-xl font-bold mb-2 text-dark-bg">Go Live & Get Bookings</h3>
                    <p class="text-gray-600">Once approved, your property will be visible to travelers.</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <p class="text-xl text-gray-700 mb-6">Ready to become an Oplanla.com partner?</p>
            <a href="{{route('provider.register')}}" class="inline-block bg-tertiary text-white font-semibold py-4 px-8 rounded-lg text-xl hover:bg-primary-p-darker transition duration-300 shadow-lg">List Your Property Now</a>
            <p class="text-gray-600 mt-4">
                <a href="{{ route('footer.partner-hub') }}" class="text-tertiary hover:underline">Visit our Partner Hub</a> for more resources and information.
            </p>
        </div>
    </main>
@endsection