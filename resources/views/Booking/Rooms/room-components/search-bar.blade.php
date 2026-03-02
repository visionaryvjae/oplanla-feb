<style>
    .container-form{
        width:80%;
    }
    
    .filter-container{
        display:grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
    
    .action-buttons{
        display:flex;
        align-items: center; 
        padding: 1.5rem; 
    }
    
    .suggestions-container-mb{
        max-height: 200px;  /*Limit height */
        overflow-y: auto;  /*Enable scrolling if needed*/ 
        background-color: #fff;
        border: 1px solid #AD68E4;
        border-radius: 5px;
    }

    .suggestion{
        padding: 0.5rem;
        border-bottom: 1px solid #eee;
        background-color: #fff;
        font-size: 14px;
        cursor: pointer;
    }

    .suggestion:hover{
        background-color: #222;
        color: #fff;
        cursor: pointer;
    }
    

    @media (max-width: 768px) {
        .container-form{
            width:95%;
        }

    }

    @media (max-width: 480px) {
        .container-form{
            width:90%;
        }
        
        .action-buttons{
            display:flex;
            align-items: center; 
            padding: 0.5rem 1rem; 
        }
        
        .filter-container{
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }
</style>

<div class="flex overflow-hidden mb-6 items-center justify-center" style="width: 100%; background-color: #ad68e4;">
    <form action="{{ $rental ? route('rentals.landing') : route('rooms.landing') }}" method="GET" class=" px-6 py-4 bg-gray-50 border-b border-gray-200" style="background-color: #ad68e4;">
        <div class="flex flex-col md:flex-row w-full items-start justify-center space-x-8">
            <div class="flex flex-col w-full">
                <div class="w-full">
                    <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                    <input type="text" name="search" id="location" value="{{ request('search') }}" placeholder="Title or Description..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                
                {{-- Suggestions container is now correctly placed here --}}
                <div class="suggestions-container-mb" id="suggestions-container" style="display:none;"></div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6" id="filters-container">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Property type</label>
                        <select name="property_type" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Properties</option>
                            <option value="Guest House" {{ request('property_type') == 'Guest House' ? 'selected' : '' }}>Guest House</option>
                            <option value="Hotel" {{ request('property_type') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="Lodge" {{ request('property_type') == 'Lodge' ? 'selected' : '' }}>Lodge</option>
                            <option value="Townhouse" {{ request('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                            <option value="Hostel" {{ request('property_type') == 'Hostel' ? 'selected' : '' }}>Hostel</option>
                            <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="B&B" {{ request('property_type') == 'B&B' ? 'selected' : '' }}>B&B</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Number of Beds</label>
                        <input type="number" name="num_beds" value="{{ request('num_beds') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Minimum Price</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Maximum Price</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                    </div>
                </div>
            </div>
            <div class="flex items-end space-x-2 items-start justify-center md:mt-auto mt-4">
                <button type="submit" class="action-buttons  rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150" style="background-color: #ade468;">
                    Filter
                </button>
                <a href="{{ $rental ? route('rentals.landing') : route('rooms.landing') }}" class="action-buttons bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase hover:bg-gray-300 transition ease-in-out duration-150">
                    Reset
                </a>
            </div>
        </div>
        <div class="px-3 sm:hidden">
            <button type="button" id="toggle-filters-button" class="text-white font-semibold py-2 w-full text-center">
                Filters
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>
</div>

@include('Booking.Rooms.room-components.toggle-filters')
@include('components.mapbox-search')

