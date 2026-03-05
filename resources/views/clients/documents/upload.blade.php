@extends('layouts.tenant')

@section('content')

    @if(session('error'))
        <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">{{ session('success') }}</div>
    @endif

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- CASE 1: Tenant has already uploaded documents --}}
        @if($tenantDocuments->id_copy || $tenantDocuments->pay_slips || $tenantDocuments->bank_statements || $tenantDocuments->proof_of_address)
            <div class="mb-10">
                <h1 class="text-3xl font-black text-gray-900 mb-2">My Documents</h1>
                <p class="text-gray-500 font-medium">Track the verification status of your application documents below.</p>
            </div>

            <div class="flex w-full justify-between items-center px-6 py-5">
                {{-- Overall Application Status Badge --}}
                @if ($tenantDocuments->comments)
                    <div class="flex flex-col">
                        <span>Comments:</span>
                        <span class="text-red-400 font-medium">{{$tenantDocuments->comments}}</span>
                    </div>
                @endif
                <div class="inline-flex">
                    @if($tenantDocuments->all_documents_verified)
                        <span class="bg-[#23cab5]/10 text-[#23cab5] px-6 py-2 rounded-full text-xs font-black uppercase border border-[#23cab5]/20">
                            Verified & Active
                        </span>
                    @elseif($tenantDocuments->status == 'rejected')
                        <span class="bg-red-50 text-red-600 px-6 py-2 rounded-full text-xs font-black uppercase border border-red-100">
                            Action Required
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-6 py-2 rounded-full text-xs font-black uppercase border border-yellow-200">
                            Pending Review
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    // Define the documents to display and their human-readable labels
                    $docs = [
                        'id_copy' => 'Copy of ID',
                        'bank_statements' => 'Bank Statements',
                        'pay_slips' => 'Last 3 Months Payslips',
                        'proof_of_address' => 'Proof of Address',
                        'marriage_certificate' => 'Marriage Certificate',
                        'passport' => 'Passport',
                        'work_permit' => 'Work Permit'
                    ];
                @endphp

                

                @foreach($docs as $field => $label)
                    {{-- Only show optional docs if they were actually uploaded, or show all if you want them to be able to add later --}}
                    @if($tenantDocuments->$field || in_array($field, ['id_copy', 'bank_statements', 'pay_slips', 'proof_of_address']))
                        <div class="bg-white rounded-lg p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-black text-gray-900">{{ $label }}</h3>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Last Updated: {{ $tenantDocuments->updated_at->format('d M Y') }}</p>
                                </div>
                                
                                {{-- Status Indicator --}}
                                <div>
                                    @if($tenantDocuments->{$field . '_status'} == 'verified')
                                        <span class="flex items-center gap-1 bg-green-50 text-green-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Verified
                                        </span>
                                    @elseif($tenantDocuments->{$field . '_status'} == 'rejected')
                                        <span class="flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            Rejected
                                        </span>
                                    @else
                                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">Pending</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Provider Comments for Rejection --}}
                            @if($tenantDocuments->{$field . '_status'} == 'rejected' && $tenantDocuments->{$field . '_comments'})
                                <div class="mb-4 p-3 bg-red-50/50 border-l-4 border-red-500 rounded-r-xl">
                                    <p class="text-xs font-bold text-red-800 uppercase mb-1">Feedback from Provider:</p>
                                    <p class="text-sm text-red-700 font-medium italic">"{{ $tenantDocuments->{$field . '_comments'} }}"</p>
                                </div>
                            @endif

                            {{-- Re-upload / Update Action --}}
                            <div class="mt-4 flex items-center justify-between gap-4">
                                @if ($tenantDocuments->$field)
                                    <a href="{{route('tenant.doc.show', ['filename' => $tenantDocuments->$field ? $tenantDocuments->$field : ''])}}" target="_blank" class="text-xs font-bold text-[#ad68e4] hover:underline">View Current File</a>
                                @else
                                    <span class="text-gray-400 teext-xs">No Document uploaded</span>
                                @endif
                                
                                <form action="{{ route('tenant.verify.update', $field) }}" method="POST" enctype="multipart/form-data" class="flex-grow">
                                    @csrf
                                    <input type="hidden" name="document_field" value="{{ $field }}">
                                    <label class="flex items-center justify-center gap-2 w-full py-2 bg-gray-900 text-white rounded-xl text-xs font-bold cursor-pointer hover:bg-gray-800 transition">
                                        <input type="file" name="new_file" class="hidden" onchange="this.form.submit()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Update Version
                                    </label>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Final Submission Box if some are still pending --}}
            @if (!$tenantDocuments->comments && !$tenantDocuments->all_documents_verified)
                <div class="mt-12 p-8 bg-[#23cab5] rounded-3xl text-white flex items-center justify-between shadow-xl shadow-teal-100">
                    <div>
                        <h2 class="text-xl font-black mb-1">All Documents Submitted</h2>
                        <p class="text-teal-900/70 font-medium">Wait for the provider to verify your profile.</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-2xl">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            @endif

        {{-- CASE 2: Fresh user - Show the Wizard (Your Original Code) --}}
        @else
            <div x-data="{ step: 1 }">
                <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ step: 1 }">
        
                    <div class="mb-10 text-center">
                        <h1 class="text-3xl font-black text-gray-900 mb-4">Tenant Verification</h1>
                        <div class="flex items-center justify-center gap-2">
                            <template x-for="i in 5">
                                <div :class="step >= i ? 'bg-[#ad68e4] w-8' : 'bg-gray-200 w-3'" class="h-2 rounded-full transition-all duration-500"></div>
                            </template> 
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase mt-4 tracking-widest">
                            Step <span x-text="step"></span> of 6: <span x-show="step === 1">Identity</span><span x-show="step === 2">Statements</span><span x-show="step === 2">Proof Of Address</span><span x-show="step === 3">Income</span><span x-show="step === 4">Additional</span><span x-show="step === 5">Finalize</span>
                        </p>
                    </div>

                    <form action="{{ route('tenant.verify.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div x-show="step === 1" x-transition>
                            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 text-center">
                                <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-[#ad68e4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3h7m-7 0a1 1 0 110-2h3m-3 2h3"></path></svg>
                                </div>
                                <h2 class="text-xl font-black text-gray-900 mb-2">Copy of ID</h2>
                                <p class="text-gray-500 text-sm mb-8">Please upload a clear color scan of your National ID or Smart Card.</p>
                                
                                <label class="block w-full cursor-pointer group">
                                    <input type="file" name="id_copy" class="hidden" accept="image/*,application/pdf" @change="if($event.target.files.length) step = 2">
                                    <div class="py-12 border-2 border-dashed border-gray-200 rounded-2xl group-hover:border-[#ad68e4] transition-colors">
                                        <span class="bg-[#ad68e4] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-purple-100">Select File</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div x-show="step === 2" x-transition>
                            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                                <h2 class="text-xl font-black text-gray-900 mb-6">Last 3 Months Bank Statements</h2>
                                <div class="space-y-4">
                                    <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-[#23cab5] cursor-pointer transition-all">
                                        <span class="text-sm font-bold text-gray-700">Upload PDF Statements</span>
                                        <input type="file" name="bank_statements" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 3">
                                        <svg class="w-6 h-6 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </label>
                                </div>
                                <button type="button" @click="step = 1" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Identity</button>
                            </div>
                        </div>

                        <div x-show="step === 3" x-transition>
                            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                                <h2 class="text-xl font-black text-gray-900 mb-6">Proof of Address</h2>
                                <div class="space-y-4">
                                    <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-[#23cab5] cursor-pointer transition-all">
                                        <span class="text-sm font-bold text-gray-700">Upload PDF Statements</span>
                                        <input type="file" name="proof_of_address" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 4">
                                        <svg class="w-6 h-6 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </label>
                                </div>
                                <button type="button" @click="step = 2" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Statements</button>
                            </div>
                        </div>

                        <div x-show="step === 4" x-transition>
                            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                                <h2 class="text-xl font-black text-gray-900 mb-6">Last 3 Months Payslips</h2>
                                <label class="block w-full border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center hover:bg-teal-50/30 transition cursor-pointer">
                                    <input type="file" name="pay_slips" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 5">
                                    <div class="w-16 h-16 bg-teal-50 text-[#23cab5] rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <p class="font-bold text-gray-700">Attach Combined PDF</p>
                                </label>
                                <button type="button" @click="step = 3" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Statements</button>
                            </div>
                        </div>

                        <div x-show="step === 5" x-transition>
                            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                                <h2 class="text-xl font-black text-gray-900 mb-2">Optional Documents</h2>
                                <p class="text-sm text-gray-400 mb-8">Upload these if applicable to your status.</p>
                                
                                <div class="space-y-3">
                                    @foreach(['marriage_certificate' => 'Marriage Certificate', 'passport' => 'Passport', 'work_permit' => 'Work Permit'] as $name => $label)
                                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                                        <span class="text-sm font-bold text-gray-600">{{ $label }}</span>
                                        <input type="file" name="{{ $name }}" class="text-xs text-gray-400">
                                    </div>
                                    @endforeach
                                </div>

                                <button type="button" @click="step = 6" class="w-full mt-8 py-4 bg-[#ad68e4] text-white font-black rounded-xl shadow-lg shadow-purple-100">Continue to Review</button>
                                <button type="button" @click="step = 4" class="mt-6 block mx-auto text-xs font-bold text-gray-400 uppercase tracking-widest">← Back</button>
                            </div>
                        </div>

                        <div x-show="step === 6" x-transition>
                            <div class="bg-gray-900 p-10 rounded-3xl shadow-2xl text-white text-center">
                                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h2 class="text-2xl font-black mb-4">Ready to Submit?</h2>
                                <p class="text-gray-400 text-sm mb-10 leading-relaxed">By clicking submit, you confirm that all uploaded documents are valid and belong to you. Our providers usually review applications within 48 hours.</p>
                                
                                <button type="submit" class="w-full py-5 bg-[#23cab5] text-white font-black rounded-2xl text-lg hover:bg-[#1eb4a1] transition-colors shadow-xl shadow-teal-900/20">
                                    Submit Application
                                </button>
                                
                                <button type="button" @click="step = 5" class="mt-6 text-xs font-bold text-gray-500 uppercase tracking-widest hover:text-white">Review Documents</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        @endif

    </div>
@endsection

{{-- @extends('layouts.app')

@section('content')
    @if(session('error'))
        <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">{{ session('success') }}</div>
    @endif
    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ step: 1 }">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-gray-900 mb-4">Tenant Verification</h1>
            <div class="flex items-center justify-center gap-2">
                <template x-for="i in 5">
                    <div :class="step >= i ? 'bg-[#ad68e4] w-8' : 'bg-gray-200 w-3'" class="h-2 rounded-full transition-all duration-500"></div>
                </template> 
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase mt-4 tracking-widest">
                Step <span x-text="step"></span> of 5: <span x-show="step === 1">Identity</span><span x-show="step === 2">Statements</span><span x-show="step === 3">Income</span><span x-show="step === 4">Additional</span><span x-show="step === 5">Finalize</span>
            </p>
        </div>

        <form action="{{ route('tenant.verify.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div x-show="step === 1" x-transition>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 text-center">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-[#ad68e4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3h7m-7 0a1 1 0 110-2h3m-3 2h3"></path></svg>
                    </div>
                    <h2 class="text-xl font-black text-gray-900 mb-2">Copy of ID</h2>
                    <p class="text-gray-500 text-sm mb-8">Please upload a clear color scan of your National ID or Smart Card.</p>
                    
                    <label class="block w-full cursor-pointer group">
                        <input type="file" name="id_copy" class="hidden" accept="image/*,application/pdf" @change="if($event.target.files.length) step = 2">
                        <div class="py-12 border-2 border-dashed border-gray-200 rounded-2xl group-hover:border-[#ad68e4] transition-colors">
                            <span class="bg-[#ad68e4] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-purple-100">Select File</span>
                        </div>
                    </label>
                </div>
            </div>

            <div x-show="step === 2" x-transition>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 mb-6">Last 3 Months Bank Statements</h2>
                    <div class="space-y-4">
                        <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-[#23cab5] cursor-pointer transition-all">
                            <span class="text-sm font-bold text-gray-700">Upload PDF Statements</span>
                            <input type="file" name="bank_statements" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 3">
                            <svg class="w-6 h-6 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </label>
                    </div>
                    <button type="button" @click="step = 1" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Identity</button>
                </div>
            </div>

            <div x-show="step === 3" x-transition>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 mb-6">Proof of Address</h2>
                    <div class="space-y-4">
                        <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-[#23cab5] cursor-pointer transition-all">
                            <span class="text-sm font-bold text-gray-700">Upload PDF Statements</span>
                            <input type="file" name="proof_of_address" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 4">
                            <svg class="w-6 h-6 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </label>
                    </div>
                    <button type="button" @click="step = 2" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Statements</button>
                </div>
            </div>

            <div x-show="step === 4" x-transition>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 mb-6">Last 3 Months Payslips</h2>
                    <label class="block w-full border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center hover:bg-teal-50/30 transition cursor-pointer">
                        <input type="file" name="pay_slips" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 5">
                        <div class="w-16 h-16 bg-teal-50 text-[#23cab5] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <p class="font-bold text-gray-700">Attach Combined PDF</p>
                    </label>
                    <button type="button" @click="step = 3" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Statements</button>
                </div>
            </div>

            <div x-show="step === 5" x-transition>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 mb-2">Optional Documents</h2>
                    <p class="text-sm text-gray-400 mb-8">Upload these if applicable to your status.</p>
                    
                    <div class="space-y-3">
                        @foreach(['marriage_certificate' => 'Marriage Certificate', 'passport' => 'Passport', 'work_permit' => 'Work Permit'] as $name => $label)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                            <span class="text-sm font-bold text-gray-600">{{ $label }}</span>
                            <input type="file" name="{{ $name }}" class="text-xs text-gray-400">
                        </div>
                        @endforeach
                    </div>

                    <button type="button" @click="step = 6" class="w-full mt-8 py-4 bg-[#ad68e4] text-white font-black rounded-xl shadow-lg shadow-purple-100">Continue to Review</button>
                    <button type="button" @click="step = 4" class="mt-6 block mx-auto text-xs font-bold text-gray-400 uppercase tracking-widest">← Back</button>
                </div>
            </div>

            <div x-show="step === 6" x-transition>
                <div class="bg-gray-900 p-10 rounded-3xl shadow-2xl text-white text-center">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black mb-4">Ready to Submit?</h2>
                    <p class="text-gray-400 text-sm mb-10 leading-relaxed">By clicking submit, you confirm that all uploaded documents are valid and belong to you. Our providers usually review applications within 48 hours.</p>
                    
                    <button type="submit" class="w-full py-5 bg-[#23cab5] text-white font-black rounded-2xl text-lg hover:bg-[#1eb4a1] transition-colors shadow-xl shadow-teal-900/20">
                        Submit Application
                    </button>
                    
                    <button type="button" @click="step = 5" class="mt-6 text-xs font-bold text-gray-500 uppercase tracking-widest hover:text-white">Review Documents</button>
                </div>
            </div>

        </form>
    </div>
@endsection --}}