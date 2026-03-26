@extends('layouts.providers')

@section('content') 
<div class="container mx-auto p-6">
    <div class="mb-6">
        <a href="{{ route('provider.payments.pending') }}" class="text-gray-500 hover:text-purple-600 flex items-center gap-2 text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Pending Payments
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 shadow-sm border border-gray-100" style="border-radius: 20px;">
                <h2 class="text-xl font-bold mb-6 text-gray-900">Payment Summary</h2>
                
                <div class="space-y-4 mb-8">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Tenant</label>
                        <p class="text-gray-900 font-medium">{{ $payment->tenant->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Amount Claimed</label>
                        <p class="text-2xl font-bold text-purple-700">R {{ number_format($payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Reference Used</label>
                        <p class="font-mono text-gray-700">{{ $payment->invoice_number }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Submission Date</label>
                        <p class="text-gray-900">{{ $payment->uploaded_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <form action="{{ route('provider.payments.verify', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-white py-3 font-semibold shadow-sm transition hover:opacity-90" 
                                style="background-color: #ad68e4; border-radius: 12px;">
                            Confirm & Clear Invoice
                        </button>
                    </form>

                    <button onclick="document.getElementById('reject-modal').classList.remove('hidden')" 
                            class="w-full bg-white border border-red-200 text-red-500 py-3 font-semibold transition hover:bg-red-50" 
                            style="border-radius: 12px;">
                        Reject Payment
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-gray-100 overflow-hidden flex items-center justify-center border border-gray-200 min-h-[600px]" style="border-radius: 20px;">
                @php
                    $extension = pathinfo($payment->pop_path, PATHINFO_EXTENSION);
                @endphp

                @if(strtolower($extension) === 'pdf')
                    <iframe src="{{ route('provider.payments.stream', $payment->id) }}" class="w-full h-full min-h-[600px]" frameborder="0"></iframe>
                @else
                    <img src="{{ route('provider.payments.stream', $payment->id) }}" alt="Proof of Payment" class="max-w-full h-auto shadow-lg">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection