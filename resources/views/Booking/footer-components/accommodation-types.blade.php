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
    
    @php
        $accomodationTypes = [
            "apartments",
            "guest house",
            "Hotels",
            "Villas",
            "Farm Stays",
            "Boutique Hotel",
            "Hostels",
            "Townhouse",
            "Lodge",
            "B&B"
        ]
    @endphp

    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Find Your Perfect Stay: All Accommodation Types</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            Oplanla.com offers a diverse range of accommodations to suit every traveler's needs and preferences.
            Explore the options below to find the ideal place for your next adventure.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Accommodation Type Card: Apartments -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="https://placehold.co/600x400/e4ad68/ffffff?text=Apartments" alt="Apartments" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Apartments</h2>
                    <p class="text-gray-600 mb-4">Modern, fully-equipped apartments perfect for short or long stays, offering the comforts of home.</p>
                    <a href="/handle-property-click?property_type=apartment" class="inline-block bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300">Browse Apartments</a>
                </div>
            </div>

            <!-- Accommodation Type Card: Guesthouses -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="https://placehold.co/600x400/68e4ad/ffffff?text=Guesthouses" alt="Guesthouses" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Guesthouses</h2>
                    <p class="text-gray-600 mb-4">Charming and intimate guesthouses providing personalized service and a cozy atmosphere.</p>
                    <a href="/handle-property-click?property_type=guest+house" class="inline-block bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300">Browse Guesthouses</a>
                </div>
            </div>

            <!-- Accommodation Type Card: Hotels -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="https://placehold.co/600x400/e4ad68/ffffff?text=Hotels" alt="Hotels" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Hotels</h2>
                    <p class="text-gray-600 mb-4">From budget-friendly to luxury, find hotels with a wide range of amenities and services.</p>
                    <a href="/handle-property-click?property_type=hotel" class="inline-block bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300">Browse Hotels</a>
                </div>
            </div>

            <!-- Accommodation Type Card: Villas -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="https://placehold.co/600x400/68e4ad/ffffff?text=Villas" alt="Villas" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Villas</h2>
                    <p class="text-gray-600 mb-4">Spacious and luxurious villas, ideal for families or groups seeking privacy and comfort.</p>
                    <a href="/handle-property-click?property_type=villa" class="inline-block bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300">Browse Villas</a>
                </div>
            </div>

            <!-- Accommodation Type Card: Farm Stays -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="https://placehold.co/600x400/e4ad68/ffffff?text=Farm+Stays" alt="Farm Stays" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Farm Stays</h2>
                    <p class="text-gray-600 mb-4">Escape to the countryside with unique farm stays, offering a tranquil experience and connection with nature.</p>
                    <a href="/handle-property-click?property_type=farm+stay" class="inline-block bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300">Browse Farm Stays</a>
                </div>
            </div>

            <!-- Accommodation Type Card: Boutique Hotels -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <img src="https://placehold.co/600x400/68e4ad/ffffff?text=Boutique+Hotels" alt="Boutique Hotels" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Boutique Hotels</h2>
                    <p class="text-gray-600 mb-4">Distinctive and stylish boutique hotels, offering unique character and personalized attention.</p>
                    <a href="/handle-property-click?property_?type=boutique+hotel" class="inline-block bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300">Browse Boutique Hotels</a>
                </div>
            </div>
        </div>
    </main>
@endsection