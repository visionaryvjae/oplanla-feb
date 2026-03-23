@extends('layouts.providers')

@section('content')
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4">
                    <div class="mt-2 ml-4">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $pagetitle }}</h1>
                        <p class="mt-1 text-sm text-gray-600">Manage all property providers on the platform.</p>
                    </div>
                    <div class="mt-4 ml-4 flex-shrink-0">
                        <a href="{{ route('providers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add New Provider
                        </a>
                    </div>
                </div>
            </div>

            {{-- Session Messages --}}
            @if(session('success'))
                <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">{{ session('success') }}</div>
            @endif

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Potential Tenant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">documents verified</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($tenant_documents as $documents)
                                        <tr class="hover:bg-gray-50 cursor-pointer">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex space-x-2 items-center">
                                                    @include('components.user-avatar', ['user' => $documents->enquiry->user])
                                                    <div class="flex-felex-col">
                                                        <div class="text-sm font-medium text-gray-900">{{ $documents->enquiry->user->name }}</div>
                                                        <div class="text-sm text-gray-600">ID: {{ $documents->enquiry->id }}</div>  
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 max-w-sm truncate" >
                                                @if ($documents->all_documents_verified)
                                                    <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} leading-5 font-semibold rounded-full bg-green-100 text-green-800">Documents Verified</span>
                                                @else
                                                    <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} leading-5 font-semibold rounded-full bg-red-100 text-red-800">Documents Not Verified</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                @if($documents->id_copy && $documents->pay_slips && $documents->bank_statements && $documents->proof_of_address)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">all documents uploaded</span>
                                                @elseif($documents->id_copy || $documents->pay_slips || $documents->bank_statements || $documents->proof_of_address)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">some documents uploaded</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">none uploaded</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-between space-x-2">
                                                    <a href="{{ route('provider.potential-tenant.show', $documents->id) }}" class="text-indigo-600 hover:text-indigo-900" onclick="event.stopPropagation();">View documents</a>
                                                    @if ($documents->all_documents_verified)
                                                        <a href="{{ route('provider.enquiry.show', $documents->enquiry_id) }}" class="text-[#46e54f] hover:text-[#2e8131]" onclick="event.stopPropagation();">Go to Enquiry</a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">No documentss found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Mobile Card Layouts --}}
                            <div class="grid grid-cols-1 gap-4 md:hidden px-4 mt-6">
                                @forelse ($tenant_documents as $documents)
                                    <div class="flex flex-col justify-end bg-white p-4 rounded-lg shadow-md space-y-3 border">
                                        <div class="mb-4">
                                            <div class="flex items-center  justify-between">
                                                <div class="flex items-center  justify-start space-x-2">
                                                    @include('components.user-avatar', ['user' => $documents->enquiry->user, 'size' => '2.5rem'])
                                                    <div class="flex flex-col">
                                                        <p class="text-xs text-gray-600">#{{ $documents->enquiry->user->id }}</p>
                                                        <p class="text-lg font-semibold text-[#7f4ea8]">{{ $documents->enquiry->user->name }}</p>
                                                    </div>
                                                </div>
                                                @if ($documents->all_documents_verified)
                                                    <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} leading-5 font-semibold rounded-full bg-green-100 text-green-800">Documents Verified</span>
                                                @else
                                                    <span class="{{ $size ?? 'px-2' }} inline-flex {{ $txtSize ?? 'text-sm' }} leading-5 font-semibold rounded-full bg-red-100 text-red-800">Documents Not Verified</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 px-3 mb-3">
                                            <span class="flex items-center justify-start {{ $documents->id_copy ? 'text-[#469873]' : 'text-[#e468ad]' }}">ID Copy @if ($documents->id_copy)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #68E4AD;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></svg>
                                                @else
                                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#f46899" d="M504.6 148.5C515.9 134.9 514.1 114.7 500.5 103.4C486.9 92.1 466.7 93.9 455.4 107.5L320 270L184.6 107.5C173.3 93.9 153.1 92.1 139.5 103.4C125.9 114.7 124.1 134.9 135.4 148.5L278.3 320L135.4 491.5C124.1 505.1 125.9 525.3 139.5 536.6C153.1 547.9 173.3 546.1 184.6 532.5L320 370L455.4 532.5C466.7 546.1 486.9 547.9 500.5 536.6C514.1 525.3 515.9 505.1 504.6 491.5L361.7 320L504.6 148.5z"/></svg>
                                            @endif</span>
                                            <span class="flex items-center justify-start {{ $documents->pay_slips ? 'text-[#469873]' : 'text-[#e468ad]' }}">Pay slips @if ($documents->pay_slips)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #68E4AD;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></svg>
                                            @else
                                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#f46899" d="M504.6 148.5C515.9 134.9 514.1 114.7 500.5 103.4C486.9 92.1 466.7 93.9 455.4 107.5L320 270L184.6 107.5C173.3 93.9 153.1 92.1 139.5 103.4C125.9 114.7 124.1 134.9 135.4 148.5L278.3 320L135.4 491.5C124.1 505.1 125.9 525.3 139.5 536.6C153.1 547.9 173.3 546.1 184.6 532.5L320 370L455.4 532.5C466.7 546.1 486.9 547.9 500.5 536.6C514.1 525.3 515.9 505.1 504.6 491.5L361.7 320L504.6 148.5z"/></svg>
                                            @endif</span>
                                            <span class="flex items-center justify-start {{ $documents->bank_statements ? 'text-[#469873]' : 'text-[#e468ad]' }}">bank statments @if ($documents->bank_statements)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #68E4AD;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></svg>
                                            @else
                                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#f46899" d="M504.6 148.5C515.9 134.9 514.1 114.7 500.5 103.4C486.9 92.1 466.7 93.9 455.4 107.5L320 270L184.6 107.5C173.3 93.9 153.1 92.1 139.5 103.4C125.9 114.7 124.1 134.9 135.4 148.5L278.3 320L135.4 491.5C124.1 505.1 125.9 525.3 139.5 536.6C153.1 547.9 173.3 546.1 184.6 532.5L320 370L455.4 532.5C466.7 546.1 486.9 547.9 500.5 536.6C514.1 525.3 515.9 505.1 504.6 491.5L361.7 320L504.6 148.5z"/></svg>
                                            @endif</span>
                                            <span class="flex items-center justify-start {{ $documents->proof_of_address ? 'text-[#469873]' : 'text-[#e468ad]' }}">proof of address @if ($documents->proof_of_address)
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #68E4AD;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></svg>
                                            @else
                                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#f46899" d="M504.6 148.5C515.9 134.9 514.1 114.7 500.5 103.4C486.9 92.1 466.7 93.9 455.4 107.5L320 270L184.6 107.5C173.3 93.9 153.1 92.1 139.5 103.4C125.9 114.7 124.1 134.9 135.4 148.5L278.3 320L135.4 491.5C124.1 505.1 125.9 525.3 139.5 536.6C153.1 547.9 173.3 546.1 184.6 532.5L320 370L455.4 532.5C466.7 546.1 486.9 547.9 500.5 536.6C514.1 525.3 515.9 505.1 504.6 491.5L361.7 320L504.6 148.5z"/></svg>
                                            @endif</span>
                                        </div>
                                        <div class="flex items-center  justify-end space-x-2 border-t py-3">
                                            <a href="{{ route('provider.potential-tenant.show', $documents->id) }}" class="text-indigo-600 hover:text-indigo-900" onclick="event.stopPropagation();">View documents</a>
                                            @if ($documents->all_documents_verified)
                                                <a href="{{ route('provider.enquiry.show', $documents->enquiry_id) }}" class="text-[#46e54f] hover:text-[#2e8131]" onclick="event.stopPropagation();">Go to Enquiry</a>
                                            @endif
                                        </div>  
                                        {{-- <div class="flex flex-col px-4 space-y-2">
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
                                        </div> --}}
                                        {{-- <div class="flex justify-end space-x-4 pt-2">
                                            <a href="{{ route('provider.tenants.edit', $tenant) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                            <form action="{{ route('provider.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                            </form>
                                        </div> --}}
                                    </div>
                                @empty
                                    <div class="py-4 px-6 text-center text-gray-600">
                                        No tenants found.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection