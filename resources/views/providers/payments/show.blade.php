@extends('layouts.providers')

@section('content')
    <div class="container mx-auto p-6 max-w-5xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                @include('components.back-button', ['route' => route('provider.payments.index'), 'title' => 'Payment History'])
                <h1 class="text-2xl font-bold text-gray-900">Transaction Details</h1>
                <p class="text-sm text-gray-500">Internal Reference: <span class="font-mono">{{ $payment->invoice_number }}</span></p>
            </div>

            <div class="px-6 py-2 rounded-full font-bold text-sm uppercase tracking-widest" 
                style="background-color: {{ $payment->status === 'paid' ? '#ecfdf5' : ($payment->status === 'rejected' ? '#fef2f2' : '#fff7ed') }}; 
                        color: {{ $payment->status === 'paid' ? '#059669' : ($payment->status === 'rejected' ? '#dc2626' : '#d97706') }};">
                {{ $payment->status }}
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 border border-gray-100 shadow-sm" style="border-radius: 20px;">
                    <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-50">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Payment Amount</label>
                            <p class="text-3xl font-bold text-gray-900">R {{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Settlement Date</label>
                            <p class="text-lg font-medium text-gray-800">{{ $payment->verified_at ? $payment->verified_at->format('d M Y') : 'Awaiting Settlement' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4"> 
                            <h4 class="font-bold text-gray-900 border-l-4 border-purple-500 pl-3" style="border-color: #ad68e4;">Tenant Information</h4>
                            <div class="text-sm text-gray-600">
                                <p class="font-bold text-gray-800">{{ $payment->tenant->name }}</p>
                                <p>{{ $payment->tenant->email }}</p>
                                <p class="mt-2 text-gray-500">Property: {{ $payment->tenant->room->property->name ?? 'N/A' }}</p>
                                <p class="text-gray-500">Unit: {{ $payment->tenant->room->room_number ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-900 border-l-4 border-purple-500 pl-3" style="border-color: #ad68e4;">Payment Method</h4>
                            <div class="text-sm text-gray-600">
                                <p><span class="font-medium text-gray-800">Source:</span> {{ $payment->payment_type }}</p>
                                <p><span class="font-medium text-gray-800">Gateway ID:</span> {{ $payment->gateway_transaction_id ?? 'None' }}</p>
                                <p><span class="font-medium text-gray-800">Submitted:</span> {{ $payment->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 border border-gray-100" style="border-radius: 20px;">
                    <h4 class="font-bold text-gray-800 mb-4">Linked Charges</h4>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-400 text-left">
                                <th class="pb-2 font-bold uppercase text-xs">Description</th>
                                <th class="pb-2 font-bold uppercase text-xs text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @if($payment->charge)
                                <tr>
                                    <td class="py-2">{{ $payment->charge->type }} - {{ $payment->charge->created_at->format('M Y') }}</td>
                                    <td class="py-2 text-right">R {{ number_format($payment->charge->amount, 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="py-2 italic">Bulk Balance Settlement</td>
                                    <td class="py-2 text-right font-bold text-gray-800">R {{ number_format($payment->amount, 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 shadow-sm border border-gray-100 h-full" style="border-radius: 20px;">
                    <h4 class="font-bold text-gray-900 mb-4">Audit Evidence</h4>
                    
                    @if($payment->pop_path)
                        <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden relative group">
                            <iframe src="{{ route('provider.payments.stream', $payment->id) }}" class="w-full h-full border-none"></iframe>
                            
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition flex items-center justify-center">
                                <a href="{{ route('provider.payments.stream', $payment->id) }}" target="_blank" 
                                class="bg-white text-gray-900 px-4 py-2 rounded-full text-xs font-bold shadow-lg group-hover:opacity-100 transition">
                                    Open Full View
                                </a>
                            </div>
                        </div>
                        
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <p class="text-xs text-gray-400 px-4">Electronic Verification:<br>No manual document required.</p>
                        </div>
                    @endif

                    <button class="w-full mt-6 py-3 border-2 border-purple-100 text-purple-600 font-bold text-sm transition hover:bg-purple-50" 
                            style="border-radius: 12px; color: #ad68e4; border-color: #f3e8ff;">
                        Download PDF Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection