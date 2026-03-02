{{-- resources/views/provider/enquiries.blade.php --}}
@extends('layouts.providers')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <form action="{{ route('provider.enquiries.index') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or Description..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                    <a href="{{ route('provider.enquiries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4">
                <div class="mt-2 ml-4">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $pagetitle }}</h1>
                    <p class="mt-1 text-sm text-gray-600">A list of all enquiries available at your properties.</p>
                </div>
                <div class="mt-4 ml-4 flex-shrink-0">
                    @php $pid = Auth::guard('provider')->user()->provider->id; @endphp
                    {{--<a href="{{ route('provider.enquiries.create.single', ['id' => $pid]) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add New enquiry
                    </a>--}}
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">{{ session('success') }}</div>
        @endif

        <div class="flex flex-col">
            <div class="-my-2 sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Name & Room No.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date created</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($enquiries as $enquiry)
                                    <tr class="hover:bg-gray-50 cursor-pointer" data-enquiry-id="{{ $enquiry->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $enquiry->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $enquiry->user->name }}</div>
                                            <div class="text-sm text-gray-500">room ID. {{ $enquiry->room->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $enquiry->created_at->diffForHumans() }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs" title="{{ $enquiry->message }}">{{ $enquiry->message }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                            You don't have any enquiries yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{-- Card layout for mobile screens --}}
                        <div class="grid grid-cols-1 gap-4 px-4 py-4 md:hidden">
                            @forelse ($enquiries as $enquiry)
                                <div class="bg-white p-4 rounded-lg border shadow-sm space-y-3 cursor-pointer" data-enquiry-id="{{ $enquiry->id }}">
                                    <div class="items-center flex justify-between mb-2">
                                        <div>
                                            
                                            <p class="text-xs text-gray-500">enquiry (ID: #{{$enquiry->id}})</p>
                                            <p class="text-sm font-semibold text-gray-800">{{ $enquiry->user->name }} ({{ $enquiry->user->id }})</p>
                                        </div>
                                        <div>
                                             @if ($enquiry->room->available)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Not Available</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4 text-center">
                                        <div class="flex flex-col w-full items-start justify-start">
                                            <div>
                                                <p class="text-xs text-left text-gray-500">Room</p>
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $enquiry->room->id }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Facilities</p>
                                        <p class="text-sm text-gray-800 truncate">{{ $enquiry->room->room_facilities ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="py-4 px-6 text-center text-gray-500">
                                    You don't have any enquiries yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('providers.enquiries.components.select-enquiry')

@endsection
