<!-- resources/views/provider/auth/register.blade.php -->

@extends('layouts.providers')

@section('content')

    <style>
        :root {
            --color-primary-p: #ad68e4;
            --color-dark-bg: #282c34;
        }
        .bg-primary-p { background-color: var(--color-primary-p); }
        .text-primary-p { color: var(--color-primary-p); }
        .hover\:bg-primary-p-darker:hover { background-color: #973fdf; }
        .border-primary-p { border-color: var(--color-primary-p); }
        .focus\:border-primary-p:focus {
            --tw-border-opacity: 1;
            border-color: rgb(173 104 228 / var(--tw-border-opacity));
        }
         body {
            font-family: 'Inter', sans-serif;
            color: #333333;
        }
    </style>

    <main class="flex flex-col w-full h-full md:items-center">
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div x-data="{ tab: '{{$initialTab}}' }">
            <h1 class="text-3xl font-bold mb-2 text-center text-dark-bg">Partner Verification</h1>

            <div class="border-b border-gray-200">
                <nav class="lg:flex hidden space-x-8" aria-label="Tabs">
                    <a href="#" @click.prevent="tab = 'ownership'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'ownership', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'ownership' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        verify property ownership
                    </a>

                    <a href="#" @click.prevent="tab = 'identity'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'identity', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'identity' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        verify identity
                    </a>

                    <a href="#" @click.prevent="tab = 'address'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'address', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'address' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        verify property address
                    </a>

                    <a href="#" @click.prevent="tab = 'business'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'business', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'business' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        verify business documents
                    </a>
                </nav>
            </div>
            @php
                $user = Auth::guard('provider')->user();
                // dd($user->partnerRequests);
            @endphp

            <div class="py-6 hidden hidden md:flex flex-col">
                <div x-show="tab === 'ownership'">
                    @include('providers.auth.register_components.ownership_proof', ['request' => $user->partnerRequests])
                </div>
                <div x-show="tab === 'identity'">
                    @include('providers.auth.register_components.identity_proofs', ['request' => $user->partnerRequests])
                </div>
                <div x-show="tab === 'address'">
                    @include('providers.auth.register_components.address_proofs', ['request' => $user->partnerRequests])
                </div>
                <div x-show="tab === 'business'">
                    @include('providers.auth.register_components.business_details', ['request' => $user->partnerRequests])
                </div>
            </div>
            
            <!-- mobile view -->
            <div class="py-6">
                <div class="mb-2">
                    @include('providers.auth.register_components.ownership_proof', ['request' => $user->partnerRequests])
                </div>
                <div class="mb-2">
                    @include('providers.auth.register_components.identity_proofs', ['request' => $user->partnerRequests])
                </div>
                <div class="mb-2">
                    @include('providers.auth.register_components.address_proofs', ['request' => $user->partnerRequests])
                </div>
                <div class="mb-2">
                    @include('providers.auth.register_components.business_details', ['request' => $user->partnerRequests])
                </div>
            </div>

            <div>

            </div>
        </div>
    </main>
@endsection