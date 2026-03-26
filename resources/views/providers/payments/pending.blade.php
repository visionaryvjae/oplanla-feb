@extends('layouts.providers')

@section('content')
<div class="max-w-7xl container mx-auto p-6">
    @include('components.page-feedback')
    @include('components.back-button', ['title' => 'dashboard', 'route' => route('provider.dashboard')])
    <h2 class="text-2xl font-bold mb-6">Pending Payment Verifications</h2>

    <div class="space-y-4">
        @forelse($pendingPayments as $payment)
            <div class="bg-white p-6 shadow-sm border border-gray-100 flex justify-between md:items-center" style="border-radius: 20px;">
                <div> 
                    <h3 class="font-bold text-gray-900">{{ $payment->tenant->name }}</h3>
                    <p class="text-sm text-gray-500">Reference: <span class="font-mono">{{ $payment->invoice_number }}</span></p>
                    <p class="text-lg font-bold text-purple-700">R {{ number_format($payment->amount, 2) }}</p>
                </div>

                <div class="flex md:flex-row flex-col items-center space-y-4 md:space-x-4">
                    <a href="{{ route('provider.payments.view', $payment->id) }}" 
                       class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        View Proof of Payment
                    </a>
                    <form action="{{ route('provider.payments.verify', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="sm:w-full text-white px-6 py-2 font-semibold transition hover:opacity-90" 
                                style="background-color: #ad68e4; border-radius: 12px;">
                            Confirm Receipt
                        </button>
                    </form>

                    <button onclick="/* Logic to show rejection modal */" class="md:w-auto w-full px-6 border rounded-[12px] py-2 text-red-500 text-sm font-medium hover:text-red-800 hover:bg-gray-200">
                        Reject
                    </button>

                    <div class="flex space-x-4">
                        
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <p class="text-gray-500 italic">No payments currently awaiting verification.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection