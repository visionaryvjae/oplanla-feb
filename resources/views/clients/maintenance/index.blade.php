@extends('layouts.tenant')

@section('content')

    @php
        $user = Auth::guard('web')->user();
    @endphp

    <div class="py-12 max-w-[90rem] mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Maintenance History</h1>

        <div class="mb-16">
            {{-- Summary block --}}
            <div class="col-span-2">
                <div class="bg-white border border-gray-100 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-black text-gray-700 uppercase tracking-widest">Maintenance Overview</h3>
                        <span class="text-xs font-bold px-3 py-1 bg-purple-50 text-[#ad68e4] rounded-full">Monthly Snapshot</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50/50 border border-gray-50">
                            <div class="w-12 h-12 rounded-lg bg-white shadow-sm flex items-center justify-center text-[#ad68e4]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-gray-900">{{ $jobs->where('created_at', '>=', now()->subMonth())->count() }}</p>
                                <p class="text-xs font-bold text-gray-500 uppercase">New Requests</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50/50 border border-gray-50">
                            <div class="w-12 h-12 rounded-lg bg-white shadow-sm flex items-center justify-center text-[#23cab5]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-gray-900">{{ number_format($summary['avg_response_time'], 0) }} Days</p>
                                <p class="text-xs font-bold text-gray-500 uppercase">Avg Response</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50/50 border border-gray-50">
                            <div class="w-12 h-12 rounded-lg bg-white shadow-sm flex items-center justify-center text-orange-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-gray-900">{{ $jobs->whereIn('status', ['pending', 'in_progress'])->count() }}</p>
                                <p class="text-xs font-bold text-gray-500 uppercase">Active Issues</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid layout view --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Maintenace Requests Table --}}
            <div class="md:col-span-2 bg-white rounded-xl overflow-hidden border p-2 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-lg text-gray-700">Maintenance Requests</h2>
                    <a href="{{ route('tenant.maintenance.create') }}" class="bg-teal-400 text-white px-6 py-2 rounded-xl font-bold" style="background-color: rgb(45 212 191); ">Report New Issue</a>
                </div>

                <div class="overflow-hidden  rounded-lg">
                    <table class="divide-y divide-gray-200 hidden md:table">
                        <thead class="bg-gray-100 rounded">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Reported</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($jobs as $job)
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex space-x-2 items-center">
                                            <img src="{{ $job->photo_url ? asset('storage/maintenance/' . $job->photo_url) : 'https://placehold.co/800x800/aec8ff/3881ff?text='.$job->category }}" alt="Issue Image" class="w-16 h-16 rounded-lg object-cover">
                                            <div>
                                                <p class="text-gray-400">#{{ $job->id }}</p>
                                                <p class="text-lg font-bold">{{ $job->title }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @include('components.status-toast', ['item' => $job])
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $job->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $job->created_at->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <a href="{{ route('tenant.maintenance.show', $job->id) }}" class="text-purple-600 hover:underline">View Details</a>
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

            @php
                use Carbon\Carbon;

                $now = Carbon::now();
                $stayStartRaw = $user->tenant->stay_start ?? $now;
                $stayStart = Carbon::parse($stayStartRaw);

                $difference = $stayStart->diff($now);
                $years = $stayStart->diffInYears($now);
                $months = $stayStart->diffInMonths($now);
                $days = $stayStart->diffInDays($now);
            @endphp
            <div class="space-y-6">
                {{-- // Room maintenance summary --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#d2a7f3] w-full px-6 pt-6" style="padding-bottom:0.5rem;">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6">Room Maintenance History</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b px-6 py-2">
                            <span class="text-gray-500 font-medium text-sm">Room No.</span>
                            <span class="text-gray-900 font-black text-md">{{ $summary['room_number'] }}</span>
                        </div>

                        <div class="flex justify-between items-center border-b px-6 py-2">
                            <span class="text-gray-500 font-medium text-sm">Total Requests:</span>
                            <span class="text-gray-900 font-black text-md">{{ $summary['total_requests'] }}</span>
                        </div>

                        <div class="flex justify-between items-center border-b px-6 py-2">
                            <span class="text-gray-500 font-medium text-sm">Total days as resident:</span>
                            <span class="text-gray-900 font-black">{{ number_format($days, 0) }} days</span>
                        </div>

                        <div class="flex justify-between items-center px-6 py-4">
                            <span class="text-gray-500 font-medium text-sm">Last Service Date:</span>
                            <span class="text-gray-900 font-black text-sm">{{ $summary['last_service_date'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('clients.maintenance.components.maintenance-select')
@endsection