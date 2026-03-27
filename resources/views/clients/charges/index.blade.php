@extends('layouts.tenant')

@section('content')

@php
    $totalOutstanding = Auth::guard('web')->user()->room->totalCharges();
@endphp

<div class="max-w-7xl container mx-auto p-6">
    @include('components.page-feedback')
    @include('components.back-button', ['title' => 'dashboard', 'route' => route('tenant.dashboard')])
    <div class="bg-white p-6 mb-8 border border-gray-100" style="border-radius: 20px;">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-gray-500 text-sm font-medium uppercase">Total Outstanding Bill</h2>
                <p class="text-3xl font-bold text-gray-900">R {{ number_format($totalOutstanding, 2) }}</p>
            </div>
            @if($totalOutstanding > 0)
                <form action="{{ route('tenant.payment.checkout') }}" method="POST"> {{--  --}}
                    @csrf
                    <input type="hidden" name="payment_type" value="all">
                    <button type="submit" class="text-white px-6 py-3 font-semibold transition hover:opacity-90" 
                            style="background-color: #ad68e4; border-radius: 12px;">
                        Pay Full Balance
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div x-data="{ open: false }" class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Your Transactions ({{ $charges->count() }})</h3>
            
            <button @click="open = !open" 
                    class="flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-600 transition hover:bg-gray-50"
                    style="border-radius: 12px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="text-sm font-medium" x-text="open ? 'Close Filters' : 'Filters'">Filters</span>
            </button>
        </div>

        <div x-show="open" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="bg-gray-50 p-6 border border-gray-100 mb-6"
            style="border-radius: 20px; display: none;">
            
            <form action="{{ route('tenant.billings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Charge Type</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Rent', 'Utiliity'] as $type)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="type[]" value="{{ $type }}" class="hidden peer" {{ in_array($type, request('type', [])) ? 'checked' : '' }}>
                                <span class="px-4 py-2 text-sm border border-gray-200 bg-white block peer-checked:border-purple-500 peer-checked:text-purple-600 transition" 
                                    style="border-radius: 12px; border-color: {{ in_array($type, request('type', [])) ? '#ad68e4' : '#e5e7eb' }}; color: {{ in_array($type, request('type', [])) ? '#ad68e4' : '#4b5563' }};">
                                    {{ $type }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Payment Status</label>
                    <select name="status" class="w-full p-2 bg-white border-gray-200 text-sm focus:ring-purple-500 focus:border-purple-500" style="border-radius: 12px;">
                        <option value="">All Statuses</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Verification</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 text-white py-2 font-semibold transition hover:opacity-90" 
                            style="background-color: #ad68e4; border-radius: 12px;">
                        Apply Filters
                    </button>
                    <a href="{{ route('tenant.billings.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="space-y-4">
        @foreach($charges as $charge)
            <div class="bg-white p-4 flex justify-between items-center border border-gray-50 shadow-sm" style="border-radius: 12px;">
                @php
                    // dd($charge->due_date)
                @endphp
                <div>
                    <div class="flex items-center space-x-1">
                        <span class="text-sm text-gray-500 font-light">#{{ $charge->id }}</span>
                        @if ($charge->payment)
                            @include('components.status-toast', ['item' => $charge->payment, 'size' => 'px-2', 'txtSize' => 'text-xs leading-5 font-semibold', 'uppercase' => ''])
                        @else
                            @if ($charge->is_paid == 1)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">paid</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">upaid</span>
                            @endif
                        @endif
                    </div>
                    <h3 class="text-lg text-gray-800">Charge type: {{ $charge->type }}</h3>
                    <p class="text-gray-900 font-medium mt-1">{{ $charge->description }}</p>
                    @if ($charge->is_paid == 1)
                        <p class="text-sm italic">paid on: <span class="text-green-500 text-sm italic">{{ $charge->updated_at ? $charge->updated_at->format('M d, Y') : 'N/A'}} </span></p>
                    @else
                        <p class="text-sm italic">due date: <span class="{{ ($charge->due_date < now()) ? 'text-red-500' : 'text-gray-500' }} text-sm italic">{{ ($charge->due_date > now()) ? $charge->due_date->format('M d, Y') : $charge->created_at->format('M d, Y') }}</span></p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900 mb-2">R {{ number_format($charge->amount, 2) }}</p>
                    <form action="{{ route('tenant.payment.checkout') }}" method="POST"> {{-- {{ route('tenant.payment.checkout') }} --}}
                        @csrf
                        <input type="hidden" name="charge_id" value="{{ $charge->id }}">
                        @if ($charge->is_paid == 1)
                            <button type="submit" class="bg-[#d2d2d2] border px-4 py-2 text-sm font-medium" 
                                style="color: #ad68e4; border-radius: 12px;" disabled>
                                Paid
                            </button>
                        @else
                            <button type="submit" class="border px-4 py-2 text-sm font-medium transition hover:bg-gray-50" 
                                style="border-color: #ad68e4; color: #ad68e4; border-radius: 12px;">
                                Pay Now
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection