@extends('layouts.providers')

@section('content')
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8 my-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">{{ $action }} Charge</h1>
                <p class="mt-1 text-sm text-gray-600">Please fill out the details below.</p>
            </div>
            <form action="{{$actionUrl}}" method="POST" class="px-6 py-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="room_number" class="block text-sm font-medium text-gray-700">Select Room</label>
                        <select name="rooms_id" id="rooms_id" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="">-- Select room --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('rooms_id', $charge->rooms_id) == $room->id)>Room no.{{ $room->room_number }} - #ID {{$room->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') ?? $charge->due_date }}" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount (R)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') ?? $charge->amount }}" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md" step="1">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Utility Type</label>
                        <select name="type" id="type" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="">-- Select type --</option>
                            <option value="utility" @selected(old('type', $charge->type) == 'utility')>Utility</option>
                            <option value="rent" @selected(old('type', $charge->type) == 'rent')>Rent</option>
                            <option value="penalty" @selected(old('type', $charge->type) == 'penalty')>Penalty</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea type="text" name="description" id="description" required class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') ?? $charge->description }}</textarea>
                    </div>  
                    
                </div>
                <div class="mt-4 px-6 py-4 bg-gray-50 text-right">
                    <button type="submit" id="submit-button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{$action}} charge
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection