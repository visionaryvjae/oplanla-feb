{{-- NEW SearchBar.blade.php --}}
<form class="content-container" id="room-filter-form" action="" method="GET">
    @csrf

    <div class="search-action-btn-container rounded-lg pt-2" style="min-width:10rem;">
        <div class="search-bar flex flex-col items-end lg:flex-row md:flex-row gap-3 mb-2">
            {{-- MODIFIED: Wrapper class fixed and suggestions div moved inside --}}
            <div class="flex relative flex-col flex-grow w-full rounded-sm">
                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="Search for a City, Suburb or Web Reference"
                    class="w-full rounded-lg py-3 px-6 focus:outline-none focus:ring-2 focus:ring-[#AD68E4]"
                    style="border:none; padding:0.25rem 2rem;"
                    autocomplete="off"
                />
                {{-- Suggestions container is now correctly placed here --}}
                <div class="suggestions-container" id="suggestions-container" style="display: none;"></div>
            </div>
            
            <button type="submit" class="search-btn bg-red-500 hover:bg-black lg:w-auto text-white white-6 py-3 rounded-lg font-semibold transition duration-200" style="background-color:#54c08f; padding:0.75rem 2rem;">
                Search
            </button>
        </div>
        
        <div class="px-3 sm:hidden">
            <button type="button" id="toggle-filters-button" class="text-white font-semibold py-2 w-full text-center">
                Filters
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <div id="filters-container" class="hidden sm:flex px-3 pt-1 rounded-md flex-wrap gap-3">
            
            <!-- Property Type Dropdown -->
            <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="">
                <select 
                    class="select-input w-full px-3 py-2 text-white" 
                    name="property_type"
                    id="property_type"
                >
                    <option class="option-input" value="">Property Type</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type }}">{{ $type }} Room</option>
                    @endforeach
                </select>
            </div>

            <!-- Number of beds -->
            <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="">
                <select 
                    class="select-input w-full px-3 py-2 text-white" 
                    name="num_beds"
                    id="num_beds"
                >
                    <option class="option-input" value="">Number of Beds</option>
                    <option value="1">1 bed</option>
                    <option value="2">2 beds</option>
                    <option value="3">3 beds</option>
                    <option value="4">4 beds</option>
                </select>
            </div>

            <!-- Min Price Dropdown -->
            <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="max-height:100px;">
                <select 
                    class="select-input w-full px-3 py-2 text-white"
                    name="min_price"
                    id="min_price"
                    style=""
                >
                    <option class="option-input" value="">Min Price</option>
                    @foreach($minPrices as $price)
                        <option value="{{ $price }}">R{{ number_format($price) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Max Price Dropdown -->
            <div class="rounded-lg overflow-hidden min-w-[150px] flex-grow" style="">
                <select 
                    class="select-input w-full px-3 py-2 text-white" 
                    name="max_price"
                    id="max_price"
                >
                    <option class="option-input" value="">Max Price</option>
                    @foreach($maxPrices as $price)
                        <option value="{{ $price }}">R{{ number_format($price) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>


<!-- Impoprted scritps section -->
@include('components.mapbox-search')
@include('Booking.welcome-components.toggle-mobile-filters')
@include('Booking.welcome-components.live-filter')
