@extends('layouts.app')

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
                    <h2 class="text-xl font-black text-gray-900 mb-6">Last 3 Months Payslips</h2>
                    <label class="block w-full border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center hover:bg-teal-50/30 transition cursor-pointer">
                        <input type="file" name="pay_slips" class="hidden" accept="application/pdf" @change="if($event.target.files.length) step = 4">
                        <div class="w-16 h-16 bg-teal-50 text-[#23cab5] rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <p class="font-bold text-gray-700">Attach Combined PDF</p>
                    </label>
                    <button type="button" @click="step = 2" class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">← Back to Statements</button>
                </div>
            </div>

            <div x-show="step === 4" x-transition>
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

                    <button type="button" @click="step = 5" class="w-full mt-8 py-4 bg-[#ad68e4] text-white font-black rounded-xl shadow-lg shadow-purple-100">Continue to Review</button>
                    <button type="button" @click="step = 3" class="mt-6 block mx-auto text-xs font-bold text-gray-400 uppercase tracking-widest">← Back</button>
                </div>
            </div>

            <div x-show="step === 5" x-transition>
                <div class="bg-gray-900 p-10 rounded-3xl shadow-2xl text-white text-center">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-[#23cab5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black mb-4">Ready to Submit?</h2>
                    <p class="text-gray-400 text-sm mb-10 leading-relaxed">By clicking submit, you confirm that all uploaded documents are valid and belong to you. Our providers usually review applications within 48 hours.</p>
                    
                    <button type="submit" class="w-full py-5 bg-[#23cab5] text-white font-black rounded-2xl text-lg hover:bg-[#1eb4a1] transition-colors shadow-xl shadow-teal-900/20">
                        Submit Application
                    </button>
                    
                    <button type="button" @click="step = 4" class="mt-6 text-xs font-bold text-gray-500 uppercase tracking-widest hover:text-white">Review Documents</button>
                </div>
            </div>

        </form>
    </div>
@endsection