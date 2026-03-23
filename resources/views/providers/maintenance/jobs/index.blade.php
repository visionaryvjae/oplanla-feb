@extends('layouts.providers')

@section('content')

    <style>
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
    </style>

    <div class="flex flex-col w-full items-start justify-center space-y-6 p-4">
        <div class="flex flex-col w-full space-y-4">
            <h3 class="font-black text-gray-400 uppercase text-xs tracking-widest px-2 flex justify-between">
                New Requests <span>({{ $jobs->where('status', 'pending')->count()}})</span>
            </h3>
            <div class="relative">
                <div id="carousel-container" class="flex space-x-6 overflow-auto no-scrollbar scroll-smooth">
                    @forelse ($jobs->where('status', 'pending') as $job)
                        <div class="flex-shrink-0 md:w-[32rem] w-[90%] bg-white p-4 rounded-2xl shadow-sm border border-l-4 border-l-[#ad68e4] hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4">
                                <img src="{{ $job->photo_url ? asset('storage/maintenance/' . $job->photo_url) : 'https://placehold.co/800x800/aec8ff/3881ff?text='.$job->category }}" alt="Issue Image" class="h-32 rounded-lg object-cover">
                                <div>
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="text-[10px] font-bold bg-[#ad68e4]/10 text-[#ad68e4] px-2 py-0.5 rounded">{{ $job->category }}</span>
                                        <p class="text-[10px] text-gray-400 font-bold">{{ $job->created_at->diffForhumans() }}</p>
                                    </div>
                                    <h4 class="font-bold text-gray-800 mb-1">{{ $job->title }}</h4>
                                    <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $job->description }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between border-t pt-4 mt-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-gray-800">Room {{ $job->room_id }}</span>
                                    <span class="text-xs font-bold text-gray-600">user: {{ $job->room->tenant->name }}</span>
                                </div>
                                <a href="{{ route('provider.maintenance.create.ticket', $job->id) }}" class="text-[#68e4ad] font-bold text-xs hover:underline flex items-center gap-1">
                                    Assign Ticket <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>No New Requests</p>
                    @endforelse
                </div>
                <!-- Carousel Buttons -->
                <button id="prevBtnConference" class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-4 bg-white rounded-full p-2 shadow-lg z-10 hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtnConference" class="absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-4 bg-white rounded-full p-2 shadow-lg z-10 hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            @include('components.carousel')  
        </div>
    
        
    
        <div class="flex flex-col w-full items-start justify-start space-y-4 opacity-70">
            <h3 class="font-black text-gray-400 uppercase text-xs tracking-widest px-2">All Requests ({{ $jobs->count() }})</h3>

            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="w-full overflow-hidden  rounded-lg">
                    <table class="w-full hidden md:table">
                        <thead class="bg-gray-100 rounded">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Reported</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($jobs as $job)
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                        <div class="flex space-x-2 items-center">
                                            <div>
                                                <p class="text-gray-400">#{{ $job->id }}</p>
                                                <p class="font-bold">{{ $job->title }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $job->room->tenant->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $job->room->room_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $job->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $job->created_at->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">
                                        @include('components.status-toast', ['item' => $job, 'uppercase' => ''])
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">
                                        <a href="{{ route('provider.maintenance.jobs.show', $job->id) }}" class="text-purple-600 hover:underline">View Details</a>
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
                    @forelse ($jobs as $job)
                        <div class="flex bg-white p-2 space-x-2 rounded-lg border shadow-sm space-y-3 cursor-pointer" data-job-id="{{ $job->id }}">
                            <img src="{{ $job->photo_url ? asset('storage/maintenance/' . $job->photo_url) : 'https://placehold.co/800x800/aec8ff/3881ff?text='.$job->category }}" alt="Issue Image" class="h-32 rounded-lg object-cover">
                            <div>
                                <div>
                                    
                                    <p class="text-xs text-gray-500">(ID: #{{$job->id}})</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $job->title }}</p>
                                    <div>
                                        <p class="text-xs text-gray-500">{{ $job->created_at->format('M j, Y') }}</p>
                                        <p class="text-xs text-gray-500 capitalize" style="color:rgb(35 202 181)">{{ str_replace('_', ' ', $job->category) }}</p>
                                        
                                        <div>
                                            @if ($job->status == 'in_progress')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                            @elseif($job->status == 'completed')
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
            @include('components.pagination', ['items' => $jobs])
        </div>
    </div>

    
@endsection