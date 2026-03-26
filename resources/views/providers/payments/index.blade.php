@extends('layouts.providers')

@section('content')

    @php
        $headers = ['ID', 'Tenant and Room No', 'Property',  'Payment Type', 'Amount', 'Status', 'Invoice Number', 'Date Invoiced', 'Date Settled', 'Action'];

        $rows = [
            fn($payment) => $payment->id,
            fn($payment) => '<div class="flex flex-col justify-start"><p class="text-xs text-gray-500 font-light">Room# '.$payment->tenant->room->room_number.'</p><span>'.$payment->tenant->name.'</span></div>',
            fn($payment) => $payment->tenant->room->property->name,
            fn($payment) => ucfirst($payment->payment_type),
            fn($payment) => 'R'.number_format($payment->amount, 2), 
            fn($payment) => view('components.status-toast', ['item' => $payment, 'txtSize' => 'text-xs'])->render(),
            fn($payment) => $payment->invoice_number,
            fn($payment) => $payment->charge ? $payment->charge->created_at->format('d M y, H:m') : 'N/A',
            fn($payment) => $payment->uploaded_at ? $payment->uploaded_at->format('d M y, H:m') : 'Not yet Settled',
            fn($payment) => '<a href="' . route('provider.payments.show', $payment->id) . '" class="text-indigo-600 hover:text-indigo-900">View</a>',
        ];

        $mobileConfig = [
            'primaryIndex' => 3,      // Amount (index 2)
            'statusIndex' => 4,       // Status (index 3)
            'actionIndex' => 7,       // Action button (index 6)
            'excludeIndices' => [0],  // Hide ID from details (shown in header)
        ];
    @endphp

    <div class="flex flex-col md:max-w-7xl w-full min-h-screen py-10 px-6 md:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <form action="{{ route('provider.payments.index') }}" method="GET" class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Search: Invoice Number or Tenant Name --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-700 uppercase">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice # or Tenant..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    {{-- Payment Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Status</label>
                        <select name="status" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending_verification" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Verification</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            
                        </select>
                    </div>

                    {{-- Payment Type --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Payment Type</label>
                        <select name="payment_type" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Types</option>
                            <option value="single" {{ request('payment_type') == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="all" {{ request('payment_type') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="utility" {{ request('payment_type') == 'utility' ? 'selected' : '' }}>Utility</option>
                            <option value="rent" {{ request('payment_type') == 'rent' ? 'selected' : '' }}>Rent</option>
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    {{-- Date To --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    {{-- Min Amount --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Min Amount</label>
                        <input type="number" name="min_amount" value="{{ request('min_amount') }}" placeholder="R 0.00" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    {{-- Max Amount --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase">Max Amount</label>
                        <input type="number" name="max_amount" value="{{ request('max_amount') }}" placeholder="R 0.00" class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    {{-- Filter & Reset Buttons --}}
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Filter
                        </button>
                        <a href="{{ route('provider.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div x-data="{ openFilters: false }" class="w-full px-6 pt-8">
                <div class="flex w-full justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Payment History</h1>
                        <p class="mt-1 text-sm text-gray-600">Review settled transactions and export financial reports.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button @click="openFilters = !openFilters" 
                                class="flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-600 transition hover:bg-gray-50"
                                style="border-radius: 12px;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="text-sm font-medium">Filters</span>
                        </button>

                        <a href="{{ route('provider.reports.payments.download', request()->query()) }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition hover:opacity-90"
                        style="background-color: #ad68e4; border-radius: 12px;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Export PDF Report
                        </a>
                    </div>
                </div>

                <div x-show="openFilters" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-gray-50 p-6 border border-gray-100 mb-8"
                    style="border-radius: 20px; display: none;">
                    
                    <form action="{{ route('provider.payments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Specific Tenant</label>
                            <select name="tenant_id" class="w-full bg-white p-2 border-gray-200 text-sm focus:ring-purple-500" style="border-radius: 12px;">
                                <option value="">All Tenants</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }} (Room {{ $tenant->room->room_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Reporting Month</label>
                            <select name="month" class="w-full bg-white p-2 border-gray-200 text-sm focus:ring-purple-500" style="border-radius: 12px;">
                                <option value="">All Months</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Payment Status</label>
                            <select name="status" class="w-full bg-white p-2 border-gray-200 text-sm focus:ring-purple-500" style="border-radius: 12px;">
                                <option value="">All Statuses</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid / Verified</option>
                                <option value="pending_verification" {{ request('status') == 'pending_verification' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 text-white py-2 font-semibold transition hover:opacity-90" 
                                    style="background-color: #ad68e4; border-radius: 12px;">
                                Apply
                            </button>
                            <a href="{{ route('provider.payments.index') }}" class="px-4 py-2 text-gray-500 text-sm font-medium hover:text-gray-700">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <x-dynamic-table 
                :headers="$headers"
                :items="$payments"
                :rows="$rows"
                :mobileConfig="$mobileConfig"
            />
        </div>
    </div>
@endsection