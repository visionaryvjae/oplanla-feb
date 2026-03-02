@extends('layouts.providers')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('provider.maintenance-users.index') }}" class="text-sm font-medium hover:text-purple-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Technicians
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" style="width:40rem;">
        <div class="px-6 py-5 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">{{ $action }} Technician</h1>
            <p class="mt-1 text-sm text-gray-600">Please fill out the details below.</p>
        </div>

        <form method="POST" action="{{ $action === 'Create' ? route('provider.maintenance-users.store') : route('provider.maintenance-users.update', $user) }}">
            @csrf
            @if($action === 'Edit')
                @method('PUT')
            @endif

            <div class="p-6 space-y-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Please correct the errors below:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Specialty -->
                    <div>
                        <label for="specialty" class="block text-sm font-medium text-gray-700">Specialty</label>
                        <select name="specialty" class="mt-1 block w-full p-2 shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="">All Categories</option>
                            <option value="plumbing" {{ request('specialty') == 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                            <option value="electrical" {{ request('specialty') == 'electrical' ? 'selected' : '' }}>Electrical</option>
                            <option value="carpentry" {{ request('specialty') == 'carpentry' ? 'selected' : '' }}>Carpentry</option>
                            <option value="painting" {{ request('specialty') == 'painting' ? 'selected' : '' }}>Painting</option>
                            <option value="roofing" {{ request('specialty') == 'roofing' ? 'selected' : '' }}>Roofing</option>
                            <option value="appliance repair" {{ request('specialty') == 'appliance repair' ? 'selected' : '' }}>Appliance Repair</option>
                            <option value="tile work" {{ request('specialty') == 'tile work' ? 'selected' : '' }}>TileWork</option>
                            <option value="drywall" {{ request('specialty') == 'drywall' ? 'selected' : '' }}>Drywall</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="col-span-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" {{ $action === 'Create' ? 'required' : '' }} class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @if($action === 'Edit')
                            <p class="mt-1 text-xs text-gray-500">Leave blank to keep the current password.</p>
                        @endif
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="col-span-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" {{ $action === 'Create' ? 'required' : '' }} class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end items-center space-x-4">
                <a href="{{ route('provider.maintenance-users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $action }} Technician
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
