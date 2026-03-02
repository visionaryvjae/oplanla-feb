@extends('layouts.app')

@section('content')

    <style>
        /* Custom colors for Tailwind */
        :root {
            --color-primary-p: #ad68e4;
            --color-complimentary: #68e4ad;
            --color-tertiary: #e4ad68; /* New tertiary color */
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
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Unlock Your Property's Potential: Choose Oplanla.com</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            At Oplanla.com, we're dedicated to empowering property owners, especially those with unique or off-the-beaten-path accommodations, to thrive in the online booking market.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
            <!-- Selling Point 1: Targeted Audience -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="https://placehold.co/150x150/ade468/ffffff?text=Targeted+Audience" alt="Targeted Audience Icon" class="w-32 h-32 rounded-full object-cover flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Targeted Audience</h2>
                    <p class="text-gray-600">
                        We attract travelers specifically looking for authentic, local, and diverse stays.
                        Your property won't get lost among large chain hotels.
                    </p>
                </div>
            </div>

            <!-- Selling Point 2: Simplified Management -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="https://placehold.co/150x150/e4ad68/ffffff?text=Easy+Mgmt" alt="Simplified Management Icon" class="w-32 h-32 rounded-full object-cover flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Simplified Management</h2>
                    <p class="text-gray-600">
                        Our user-friendly Partner Hub gives you complete control over your listings, pricing, and availability.
                        Manage your bookings with ease, leaving you more time to focus on your guests.
                    </p>
                </div>
            </div>

            <!-- Selling Point 3: Global Reach, Local Focus -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="https://placehold.co/150x150/ade468/ffffff?text=Global+Local" alt="Global Reach, Local Focus Icon" class="w-32 h-32 rounded-full object-cover flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Global Reach, Local Focus</h2>
                    <p class="text-gray-600">
                        While we provide global visibility, we understand the nuances of local markets.
                        We help bring guests to your doorstep, wherever you are.
                    </p>
                </div>
            </div>

            <!-- Selling Point 4: Support That Cares -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="https://placehold.co/150x150/e4ad68/ffffff?text=Support" alt="Support That Cares Icon" class="w-32 h-32 rounded-full object-cover flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Support That Cares</h2>
                    <p class="text-gray-600">
                        Our dedicated partner support team is here to assist you every step of the way,
                        from onboarding to maximizing your bookings. We succeed when you succeed.
                    </p>
                </div>
            </div>

            <!-- Selling Point 5: Fair & Transparent Fees -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="https://placehold.co/150x150/ade468/ffffff?text=Fair+Fees" alt="Fair & Transparent Fees Icon" class="w-32 h-32 rounded-full object-cover flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Fair & Transparent Fees</h2>
                    <p class="text-gray-600">
                        We offer competitive and transparent commission rates, ensuring you get a fair return on your bookings with no hidden costs.
                    </p>
                </div>
            </div>

            <!-- Selling Point 6: Community & Growth -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="https://placehold.co/150x150/e4ad68/ffffff?text=Community" alt="Community & Growth Icon" class="w-32 h-32 rounded-full object-cover flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Community & Growth</h2>
                    <p class="text-gray-600">
                        Join a growing community of passionate hosts. Share experiences, get advice, and stay updated
                        on industry trends through our Partner Hub and Community Forum.
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg mb-16 text-center">
            <h2 class="text-3xl font-bold mb-6 text-dark-bg">Hear From Our Partners</h2>
            <blockquote class="text-lg italic text-gray-700 mb-4">
                "Oplanla.com has been a game-changer for our small guesthouse. We've seen a significant increase in bookings, and their support team is incredibly responsive. Highly recommend!"
            </blockquote>
            <p class="font-semibold text-dark-bg">- Sarah M., Owner of The Cozy Nook Guesthouse</p>
        </div>

        <div class="text-center">
            <p class="text-xl text-gray-700 mb-6">Ready to transform your bookings?</p>
            <a href="{{ route('footer.list-property') }}" class="inline-block bg-primary-p text-white font-semibold py-4 px-8 rounded-lg text-xl hover:bg-primary-p-darker transition duration-300 shadow-lg">Start Hosting Today</a>
        </div>  
    </main>
@endsection