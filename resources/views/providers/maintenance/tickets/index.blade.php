@extends('layouts.providers')

@section('content')

    <div class="flex flex-col-reverse md:flex-col w-full items-center mx-auto py-10 px-4 md:px-8">
        <div class="w-full bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <form action="{{ route('provider.maintenance.tickets.index') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Room number..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Ticket Status</label>
                        <select name="completed" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Option</option>
                            <option value="completed" {{ request('completed') ==  'completed' ? 'selected' : '' }}>completed</option>
                            <option value="in_progress" {{ request('completed') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Properties</label>
                        <select name="property" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Properties</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}" {{ request('property') == $property->id ? 'selected' : '' }}>{{ $property->id . ' - ' . $property->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Category</label>
                        <select name="category" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Categories</option>
                            @for ($i = 0; $i < count($categories); $i++)
                                <option value="{{ $categories[$i] }}" {{ request('property') == $categories[$i] ? 'selected' : '' }}>{{ $categories[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Tenants</label>
                        <select name="tenant" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select tenant</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ request('tenant') == $tenant->id ? 'selected' : '' }}>{{ $tenant->id . ' - ' . $tenant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Filter
                        </button>
                        <a href="{{ route('provider.maintenance.tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="py-2 align-middle inline-block w-full sm:px-6">
            <div class="w-full overflow-hidden rounded-lg">
                <div class="flex w-full mb-2 px-6">
                    <p class="text-xl font-bold text-gray-400">All Tickets ({{ $tickets->count() }})</p>
                </div>
                <table class="w-full hidden md:table">
                    <thead class="bg-gray-100 rounded">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earliest Start Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest Completion Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50 cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">
                                    <div class="flex items-center ">
                                        <div class="p-1">
                                            @include('components.user-avatar', ['user' => $ticket->user, 'size' => '2.5rem'])
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500 font-light">(ID: #{{ $ticket->user->id }})</span>
                                            <p class="text-gray-800">{{ $ticket->user->name }} ({{ $ticket->user->specialty }})</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    <div class="flex space-x-2 items-center">
                                        <div>
                                            <p class="text-gray-400">#{{ $ticket->id }} - {{ $ticket->job->room->tenant->name }}</p>
                                            <p class="font-bold">{{ $ticket->job->title }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $ticket->job->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $ticket->earliest_start_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $ticket->latest_completion_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">
                                    @include('components.status-toast', ['item' => $ticket, 'size' => 'px-[0.75rem] py-1', 'txtSize' => 'text-xs', 'uppercase' => ''])
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">
                                    <a href="{{ route('provider.maintenance.tickets.show', $ticket->id) }}" class="text-purple-600 hover:underline">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">You have no active maintenance requests.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Card layout for mobile screens --}}
            <div class="grid grid-cols-1 gap-4 px-2 py-4 md:hidden">
                @forelse ($tickets as $ticket)
                    <div class="flex bg-white p-2 space-x-2 rounded-lg border shadow-sm space-y-3 cursor-pointer" data-job-id="{{ $ticket->id }}">
                        <img src="{{ $ticket->photo_url ? asset('storage/maintenance/' . $ticket->photo_url) : 'https://placehold.co/800x800/aec8ff/3881ff?text='.$ticket->category }}" alt="Issue Image" class="h-32 rounded-lg object-cover">
                        <div>
                            <div>
                                
                                <p class="text-xs text-gray-500">(ID: #{{$ticket->id}})</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $ticket->title }}</p>
                                <div>
                                    <p class="text-xs text-gray-500">{{ $ticket->created_at->format('M j, Y') }}</p>
                                    <p class="text-xs text-gray-500 capitalize" style="color:rgb(35 202 181)">{{ str_replace('_', ' ', $ticket->category) }}</p>
                                    
                                    <div>
                                        @if ($ticket->status == 'in_progress')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                        @elseif($ticket->status == 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 px-6 text-center text-gray-500">
                        You haven't added any jobs yet.
                    </div>
                @endforelse
            </div>
        </div>
        @include('components.pagination', ['items' => $tickets])
    </div>
    
@endsection