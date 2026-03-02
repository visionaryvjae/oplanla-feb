@extends('layouts.providers')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <form action="{{ route('provider.maintenance-users.index') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="w-full">
                    <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or Description..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

               <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Specialty</label>
                    <select name="specialty" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Filter
                    </button>
                    <a href="{{ route('provider.maintenance-users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">List of Technicians</h1>
                <p class="text-gray-600 mt-1">Manage all technicians on the platform.</p>
            </div>
            <a href="{{ route('provider.maintenance-users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Add New User
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialty</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
            
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->specialty }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('provider.maintenance-users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('provider.maintenance-users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center text-gray-500">
                                No technicians found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{-- Card layout for mobile screens --}}
            <div class="grid grid-cols-1 gap-4 md:hidden ">
                @forelse ($users as $user)
                    <div class="bg-white p-4 rounded-lg shadow-sm space-y-3 border-2">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm text-gray-800">{{ $user->email }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-xs text-gray-500">Specialty</p>
                            <p class="text-sm text-gray-800">{{ $user->specialty }}</p>
                        </div>
                        <div class="flex justify-end space-x-4 pt-2">
                            <a href="{{ route('provider.maintenance-users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            <form action="{{ route('provider.maintenance-users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-4 px-6 text-center text-gray-500">
                        No technicians found.
                    </div>
                @endforelse
            </div>
            <div class="p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
