@extends('layouts.providers')

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('provider.tenants.index') }}" class="text-sm font-medium hover:text-purple-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Tenants
            </a>
        </div>


        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Tenant Profile: {{ $tenant->name }}</h1>
            <div class="flex space-x-3">
                <a href="{{ route('provider.tenants.edit', $tenant->id) }}" class="bg-white border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Edit Tenant</a>
                <form action="" method="POST"> {{-- {{ route('provider.tenants.reset-password', $tenant->id) }} --}}
                    @csrf
                    <button type="submit" class="bg-[#ad68e4] text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-yellow-600">Send Password Reset</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="h-24 w-24 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                    @include('components.user-avatar', ['user' => $tenant, 'size' => '6rem'])
                </div>
                <h2 class="text-xl font-bold text-gray-900">{{ $tenant->name }}</h2>
                <p class="text-sm text-gray-500">{{ $tenant->email }}</p>
                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    {{-- @foreach($tenant->getRoleNames() as $role)
                        <span class="px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">{{ ucfirst($role) }}</span>
                    @endforeach --}}
                </div>
            </div>

            <div class="md:col-span-3 bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Account Details</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Property</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $tenant->room->property->name ?? $tenant->room->provider->provider_name }}</dd>
                            <dd class="text-xs text-gray-600">Room number: {{ $tenant->room->room_number ?? 'unknown' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Verification Status</dt>
                            <dd class="mt-1">
                                @if($tenant->isTenant())
                                    <span class="text-green-600 flex items-center text-sm font-medium">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg> Verified
                                    </span>
                                @else
                                    <span class="text-red-500 text-sm font-medium">Not Verified</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tenant Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $tenant->tenant->stay_start->format('F d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            {{-- <dd class="mt-1 text-sm text-gray-900">{{ $tenant->updated_at->diffForHumans() }}</dd> --}}
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Invoices and Charges table --}}
            <div class="md:col-span-4 bg-white shadow rounded-lg overflow-hidden px-4">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Tenant invoices</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($tenant->room->charges()->latest()->take(3)->get() as $charge)
                                <tr>
                                    <td class="px-6 py-2 text-sm font-medium text-gray-900">{{ ($charge->description == '' ) ? 'no description provided' : $charge->description }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-900">R{{ number_format($charge->amount, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $charge->is_paid ? 'bg-green-100' : 'bg-red-100' }}">
                                            @if ($charge->is_paid)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-left text-sm text-gray-500">{{ $charge->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 border-b whitespace-nowrap text-sm text-gray-700">
                                        <a href="{{ route('provider.charges.show', $charge->id) }}" class="text-purple-600 hover:underline">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No charges posted yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- Maintenance Requests Table --}}
            <div class="md:col-span-4 bg-white shadow rounded-lg overflow-hidden px-4">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Tenant Maintenance requests</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                        <thead class="bg-gray-50 rounded">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Reported</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tenant->room->MaintenanceJobs()->latest()->take(3)->get() as $job)
                                <tr class="hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4 border-b whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex space-x-2 items-center">
                                            <div>
                                                <p class="text-gray-400">#{{ $job->id }}</p>
                                                <p class="text-md font-bold">{{ $job->title }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 border-b whitespace-nowrap text-sm text-gray-700">
                                        @include('components.status-toast', ['item' => $job, 'uppercase' => ''])
                                    </td>
                                    <td class="px-6 py-4 border-b whitespace-nowrap text-sm text-gray-700">{{ $job->category }}</td>
                                    <td class="px-6 py-4 border-b whitespace-nowrap text-sm text-gray-700">{{ $job->created_at->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 border-b whitespace-nowrap text-sm text-gray-700">
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
            </div>
        </div>
    </div>
@endsection