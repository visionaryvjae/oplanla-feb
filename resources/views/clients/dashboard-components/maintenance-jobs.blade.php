
    @php
        // dd(Auth::guard('web')->user()->room->maintenanceJobs()->latest()->get());
        $jobs = Auth::guard('web')->user()->room->maintenanceJobs()->latest()->take(5)->get();
    @endphp
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Maintenance Requests</h2>
        <a href="{{ route('tenant.maintenance.create') }}" class="bg-teal-400 text-white px-6 py-2 rounded-xl font-bold shadow-lg" style="background-color: rgb(45 212 191); ">Report New Issue</a>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 hidden md:table">
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
                                            <p class="text-xs text-gray-500 capitalize" style="color:#23cab5">{{ str_replace('_', ' ', $job->category) }}</p>
                                           
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

                <div class="flex items-center justify-center w-full mt-6">
                    <a href="{{ route('tenant.maintenance.index') }}" class="underline hover:text-gray-900" style="color: #ad68e4;">View Full Maintenance History</a>
                </div>
            </div>
        </div>
    </div>

    @include('clients.maintenance.components.maintenance-select')
