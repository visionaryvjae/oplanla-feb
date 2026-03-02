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
    
    .card {
        flex: 1 1 calc(33.33% - 20px); /* Adjusts spacing for 3 columns */
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    
    .card-h3 {
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
    
    .no-img-container{
        display:flex;
        align-items:center;
        justify-content:center;
        background: linear-gradient(35deg, rgba(104, 228, 173, 0.8), rgba(28, 158, 100, 0.8));
        color: #fff;
    }
</style>

<div class="container-slider">
    <!-- New Accommodation Types Section -->
    <div class="mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">New Room Providers</h2>
        <p class="text-gray-500 mb-6">Checkout our new providers for uniques experiences</p>

        @php
            $allProviders = App\Models\Booking\Providers::orderBy('created_at', 'desc')->join('rooms', 'rooms.providers_id', '=', 'providers.id')->select('providers.*') // Optional: avoid duplicate columns from rooms
            ->distinct()
            ->get();
            $newProviders = $allProviders->take(5);
        @endphp

        <div class="relative">
            <!-- Carousel Container -->
            <div id="carousel-container-newProv" class="flex overflow-x-auto py-2 px-2 space-x-6 no-scrollbar scroll-smooth">
                <!-- Carousel Items -->
                @foreach ($newProviders as $provider)
                    <form action="{{ route('provider.rooms.filter') }}" method="GET">
                        <button class="flex-shrink-0 card w-64 hover:scale-105" type="submit" >
                            <div class="bg-white rounded-lg shadow-md overflow-hidden" style="background-color:#68e4ad max-width: 256px; maxa-height: 300px; object-fit: cover; ">
                                @if($provider->photos->count() > 0)
                                    <img src="{{ asset('storage/images/'. $provider->photos->where('area','display')->first()->image) }}" alt="pretoria" class="w-full h-48 object-cover">
                                @else
                                    <div class="no-img-container w-full h-48 object-cover">
                                        <p>No images uploaded yet</p>
                                    </div>
                                @endif                    
                                
                                <h3 class="card-h3">
                                    {{$provider->provider_name}}
                                </h3>
                            </div>
                        </button>
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                    </form>
                @endforeach
            </div>
        </div>
    </div>

</div>