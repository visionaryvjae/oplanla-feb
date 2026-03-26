@extends('layouts.tenant')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    @include('components.back-button', ['title' => 'billings', 'route' => route('tenant.billings.index')])
    <div class="bg-white p-8 shadow-lg" style="border-radius: 20px;">
        <h2 class="text-2xl font-bold text-center mb-2 text-gray-900">Complete Your Payment</h2>
        <p class="text-center text-gray-500 mb-8 font-medium">Amount Due: <span class="text-gray-900">R {{ number_format($amount, 2) }}</span></p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border-2 p-6 flex flex-col items-center text-center cursor-pointer transition hover:border-purple-400 group" 
                 style="border-radius: 12px; border-color: #f3f4f6;"
                 onclick="document.getElementById('ozow-form').submit();">
                <div class="h-12 w-12 bg-purple-100 flex items-center justify-center mb-4 group-hover:bg-purple-200" style="border-radius: 50%;">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800">Instant EFT</h3>
                <p class="text-xs text-gray-500 mt-2">Automatic verification. No PoP required.</p>
                <form id="ozow-form" action="{{ route('tenant.pay.ozow') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="amount" value="{{$amount}}">
                </form>
            </div>

            <div id="eft-card" class="border-2 p-6 flex flex-col items-center text-center cursor-pointer transition hover:border-purple-400" 
                 style="border-radius: 12px; border-color: #f3f4f6;"
                 onclick="toggleEFTSection()">
                <div class="h-12 w-12 bg-blue-100 flex items-center justify-center mb-4" style="border-radius: 50%;">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <h3 class="font-bold text-gray-800">Direct Bank Transfer</h3>
                <p class="text-xs text-gray-500 mt-2">Manual upload of Proof of Payment required.</p>
            </div>
        </div>

        @php
            // dd($bankDetails);
        @endphp
        <div id="manual-eft-section" class="hidden mt-12 pt-8 border-t border-gray-100">
            <h4 class="font-bold text-gray-800 mb-4">Owner Bank Details</h4>
            <div class="bg-gray-50 p-4 mb-6 text-sm" style="border-radius: 12px;">
                <p><strong>Bank:</strong> {{ $bankDetails->bank_name ?? 'N/A' }}</p>
                <p><strong>Account Holder:</strong> {{ $bankDetails->account_holder ?? $bankDetails->provider->provider_name }}</p>
                <p><strong>Account Number:</strong> {{ $bankDetails->account_number ?? 'N/A' }}</p>
                <p><strong>Branch Code:</strong> {{ $bankDetails->branch_code ?? 'N/A' }}</p>
                <p><strong>Reference:</strong> <span class="text-red-600 font-bold">{{ $reference }}</span></p>
            </div>

            <form action="{{ route('tenant.upload.pop') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Proof of Payment (PDF/Image)</label>
                <input type="file" name="pop_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 mb-4"/>
                <button type="submit" class="w-full text-white py-3 font-semibold shadow-sm" style="background-color: #ad68e4; border-radius: 12px;">
                    Submit PoP for Verification
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleEFTSection() {
    const section = document.getElementById('manual-eft-section');
    const card = document.getElementById('eft-card');
    
    // Show the section
    section.classList.remove('hidden');
    
    // Style the card as "active"
    card.style.borderColor = '#ad68e4';
    card.style.backgroundColor = '#f9fafb';
    
    // Smooth scroll to the details
    section.scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection