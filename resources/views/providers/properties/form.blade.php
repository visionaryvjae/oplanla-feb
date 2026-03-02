@extends('layouts.providers')

@section('content')
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8 my-6">
        <div class="mb-2">
            <a href="{{ route('provider.properties.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-700">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                Back to properties
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">{{ $action }} Property</h1>
                <p class="mt-1 text-sm text-gray-600">Please fill out the details below.</p>
            </div>
            @php
                //dd($actionUrl);
            @endphp
            <form action="{{$actionUrl}}" method="{{ $method }}" class="px-6 py-4">
                @csrf
                <div class="form-content space-y-4">
                    {{-- <div>
                        <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                        <input type="text" name="room_number" id="room_number" value="{{ old('room_number') ?? $room->room_number }}" required class="">
                    </div> --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="name">Property Name: </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            value="{{old('name') ?? $property->name}}"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                    </div>

                    {{-- <div>
                        <label class="block text-sm font-medium text-gray-700" for="description">Property Description: </label>
                        <textarea 
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            name="description" 
                            id="description" 
                            cols="100" rows="10" 
                        >
                            {{old('description') ?? $property->description}}
                        </textarea>
                    </div> --}}

                    <div style="flex-direction:column;">
                        <div class="content-container">
                            <label class="block text-sm font-medium text-gray-700" for="address">Address: </label>
                            <input 
                                type="text" 
                                name="address" 
                                id="location"
                                value="{{old('address') ?? $property->address}}"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required
                            >
                        </div>
                            
                        <div id="suggestions-container" class="suggestions-container"></div>
                    </div>
                </div>
                <div class="mt-4 px-6 py-4 bg-gray-50 text-right">
                    <button type="submit" id="submit-button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{$action}} Property
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.mapbox-search')
@endsection