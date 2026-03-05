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
                            <table class="min-w-full divide-y divide-gray-200">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection