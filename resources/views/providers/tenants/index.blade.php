@extends('layouts.providers')

@section('content')
    <div class=" flex flex-col-reverse md:flex-col max-w-7xl mx-auto py-10 px-6 md:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden md:mb-6 mt-6">
            <form action="{{ route('provider.tenants.index') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex md:hidden w-full mb-8">
                    <p class="text-xl font-bold text-gray-800">Tenant Filters</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="w-full col-span-2">
                        <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or Description..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Room Number</label>
                        <input type="number" name="room_num" value="{{ request('room_num') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Payment Status</label>
                        <select name="owing" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select room type</option>
                            <option value="1" {{ request('owing') ==  1 ? 'selected' : '' }}>Up To Date</option>
                            <option value="0" {{ request('owing') == 0 ? 'selected' : '' }}>Owing</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Filter
                        </button>
                        <a href="{{ route('provider.tenants.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">List of Tenants</h1>
                    <p class="text-gray-600 mt-1">Manage all standard tenants on the platform.</p>
                </div>
                <a href="{{ route('provider.tenants.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Add New tenant
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">property</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Staying Since</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tenants as $tenant)
                            <tr class="hover:bg-gray-50" data-tenant-id="{{ $tenant->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2 items-center">
                                        @include('components.user-avatar', ['user' => $tenant])
                                        <div class="flex-felex-col">
                                            <div class="text-sm font-medium text-gray-900">{{ $tenant->name }}</div>
                                            <div class="text-sm text-gray-600">ID: {{ $tenant->id }}</div>  
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tenant->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $tenant->room->property->name ?? $tenant->room->provider->provider_name }}</div>
                                    <div class="text-sm text-gray-600">Room Number: {{ $tenant->room->room_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $tenant->tenant->stay_start->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('provider.tenants.edit', $tenant) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('provider.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-600">
                                    No tenants found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Card layout for mobile screens --}}
                <div class="grid grid-cols-1 gap-4 md:hidden ">
                    @forelse ($tenants as $tenant)
                        <div class="bg-white p-4 rounded-lg shadow-md space-y-3 border" data-tenant-id="{{ $tenant->id }}">
                            <div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center justify-start space-x-2">
                                        @include('components.user-avatar', ['user' => $tenant, 'size' => '2.5rem'])
                                        <div class="flex flex-col">
                                            <p class="text-xs text-gray-600">#{{ $tenant->id }}</p>
                                            <p class="text-lg font-semibold text-[#7f4ea8]">{{ $tenant->name }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-light text-gray-5 00">tenant since: {{ $tenant->tenant->stay_start->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col px-4 space-y-2">
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs text-gray-600">Room number:</p>
                                    <p class="text-sm text-gray-800">{{ $tenant->room->room_number }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs text-gray-600">Email:</p>
                                    <p class="text-sm text-gray-800">{{ $tenant->email }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs text-gray-600">Property:</p>
                                    <p class="text-sm text-gray-800">{{ $tenant->room->property->name ?? $tenant->room->provider->provider_name }}</p>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-4 pt-2">
                                <a href="{{ route('provider.tenants.edit', $tenant) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                <form action="{{ route('provider.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 px-6 text-center text-gray-600">
                            No tenants found.
                        </div>
                    @endforelse
                </div>
                <div class="p-4">
                    {{ $tenants->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('providers.tenants.components.tenant-select');

@endsection