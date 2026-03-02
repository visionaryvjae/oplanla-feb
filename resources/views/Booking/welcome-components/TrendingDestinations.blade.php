<style>
    /* Custom colors for Tailwind */
    :root {
        --color-primary: #ad68e4;
        --color-complimentary: #68e4ad;
        --color-dark-bg: #282c34; /* Dark background from footer image */
        --color-text-light: #e0e0e0; /* Light text for dark backgrounds */
        --color-text-dark: #333333; /* Dark text for light backgrounds */
    }
    .bg-[#ad68e4] { background-color: var(--color-primary); }
    .text-primary { color: var(--color-primary); }
    .hover\:bg-[#ad68e4]-darker:hover { background-color: #973fdf; /* Slightly darker primary */ }
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

<main class="flex flex-col w-full px-8 justify-start">
    <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Explore Our Most Popular Destinations</h1>
    <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700" >
        Discover the vibrant cities and serene escapes that travelers love most on Oplanla.com.
        From bustling urban centers to breathtaking coastal towns, find your next unforgettable stay.
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Destination Card 1: Johannesburg -->
        <form method="GET" action="{{ route('handle-click') }}">
            <div class="bg-white rounded-xl text-left shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <input type="hidden" name="city" value="johannesburg" >
                <img src="{{ asset('storage/images/johannesburg.jpg') }}" alt="https://placehold.co/600x400/ade468/ffffff?text=Johannesburg" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Johannesburg</h2>
                    <p class="text-gray-600 mb-4">Experience the heart of South Africa, a city of gold and vibrant culture.</p>
                    <button type="submit" class="inline-block bg-[#ad68e4] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#ad68e4]-darker transition duration-300">View Properties</button>
                </div>
            </div>
        </form>

        <!-- Destination Card 2: Cape Town -->
        <form method="GET" action="{{ route('handle-click') }}">
            <div class="bg-white rounded-xl text-left shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <input type="hidden" name="city" value="cape town" >
                <img src="{{ asset('storage/images/cape-town.jpg') }}" alt="Cape Town" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Cape Town</h2>
                    <p class="text-gray-600 mb-4">Coastal charm meets vibrant culture at the foot of Table Mountain.</p>
                    <button type="submit" class="inline-block bg-[#ad68e4] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#ad68e4]-darker transition duration-300">View Properties</button>
                </div>
            </div>
        </form>

        <!-- Destination Card 3: Mbombela -->
        <form method="GET" action="{{ route('handle-click') }}">
            <div class="bg-white rounded-xl text-left shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <input type="hidden" name="city" value="mbombela" >
                <img src="{{ asset('storage/images/mbombela.jpg') }}" alt="Mbombela" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Mbombela</h2>
                    <p class="text-gray-600 mb-4">Gateway to the Kruger National Park and stunning natural beauty.</p>
                    <button type="submit" class="inline-block bg-[#ad68e4] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#ad68e4]-darker transition duration-300">View Properties</button>
                </div>
            </div>
        </form>

        <!-- Destination Card 4: Durban -->
        <form method="GET" action="{{ route('handle-click') }}">
            <div class="bg-white rounded-xl text-left shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <input type="hidden" name="city" value="durban" >
                <img src="{{ asset('storage/images/durban.jpg') }}"lt="Durban" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Durban</h2>
                    <p class="text-gray-600 mb-4">Sun-kissed beaches and a vibrant multicultural atmosphere.</p>
                    <button type="submit" class="inline-block bg-[#ad68e4] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#ad68e4]-darker transition duration-300">View Properties</button>
                </div>
            </div>
        </form>

        <!-- Destination Card 5: Port Elizabeth -->
        <form method="GET" action="{{ route('handle-click') }}">
            <div class="bg-white rounded-xl text-left shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <input type="hidden" name="city" value="port elizabeth" >
                <img src="{{ asset('storage/images/port-elizabeth.jpg') }}" alt="Port Elizabeth" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Port Elizabeth</h2>
                    <p class="text-gray-600 mb-4">The friendly city, known for its beautiful beaches and wildlife.</p>
                    <button type="submit" class="inline-block bg-[#ad68e4] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#ad68e4]-darker transition duration-300">View Properties</button>
                </div>
            </div>
        </form>

        <!-- Destination Card 6: Garden Route -->
        <form method="GET" action="{{ route('handle-click') }}">
            <div class="bg-white rounded-xl text-left shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <input type="hidden" name="city" value="garden route" >
                <img src="{{ asset('storage/images/garden-route.jpg') }}" alt="Garden Route" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2 text-dark-bg">Garden Route</h2>
                    <p class="text-gray-600 mb-4">A scenic stretch of the southeastern coast of South Africa.</p>
                    <button type="submit" class="inline-block bg-[#ad68e4] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#ad68e4]-darker transition duration-300">View Properties</button>
                </div>
            </div>
        </form>
    </div>

    <!--<div class="text-center mt-16">-->
    <!--    <p class="text-xl text-gray-700 mb-6">Can't find your ideal destination? Search for more using our search bar!</p>-->
    <!--    <a href="/rooms" class="inline-block bg-complimentary text-white font-semibold py-4 px-8 rounded-lg text-xl hover:bg-green-600 transition duration-300 shadow-lg">Find a Room Now!</a>-->
    <!--</div>-->
</main>

