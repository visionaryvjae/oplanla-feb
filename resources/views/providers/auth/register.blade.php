<!-- resources/views/provider/auth/register.blade.php -->

@extends('layouts.app')

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

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
            <h1 class="text-3xl font-bold mb-2 text-center text-dark-bg">Become a Partner</h1>
            <p class="text-gray-600 text-center mb-8">Create your account to list and manage your properties on Oplanla.com.</p>

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

            @php
                $step = 2;
                $existingProviders = App\Models\Booking\Providers::all();
            @endphp

            <form method="POST" enctype="multipart/form-data" action="{{ route('provider.register') }}" class="space-y-6">
                @csrf

                <fieldset class="border-t border-gray-200 pt-6">
                    <legend class="text-lg font-semibold text-gray-900">Business Details</legend>
                    
                    {{-- NEW: Dropdown to select an existing provider or create a new one --}}
                    <div class="mt-4">
                        <label for="provider_id" class="block text-sm font-medium text-gray-700">Select a Business</label>
                        <select id="provider_id" name="provider_id" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="0">Create a new business</option>
                            {{-- This part assumes you will pass a collection of $existingProviders from your controller --}}
                            @isset($existingProviders)
                                @foreach($existingProviders as $provider)
                                    <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                        {{$provider->id}} - {{ $provider->provider_name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    {{-- NEW: This container will only show when "Create a new business" is selected --}}
                    <div id="new-business-fields">
                         <!-- Provider Name -->
                        <div class="mt-4">
                            <label for="provider_name" class="block text-sm font-medium text-gray-700">Company / Property Name</label>
                            <input id="provider_name" type="text" name="provider_name" value="{{ old('provider_name') }}" required autofocus
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
    
                        <!-- Booking Address -->
                        <div class="mt-4">
                            <label for="booking_address" class="block text-sm font-medium text-gray-700">Business Address</label>
                            <input id="booking_address" type="text" name="booking_address" value="{{ old('booking_address') }}" required
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-t border-gray-200 pt-6">
                     <legend class="text-lg font-semibold text-gray-900">Your Login Details</legend>
                    <!-- Name -->
                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Your Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </fieldset>
                
                <fieldset class="border-t border-gray-200 pt-6">
                    <legend class="text-lg font-semibold text-gray-900">Business Verification and Document Upload</legend>
                      Bank Information 
                    <div class="flex flex-col w-full mb-4">
                        <h2 class="text-xl font-bold mt-6 text-gray-800">Bank Account Details</h2>
                         <!--Bank name -->
                        <div class="mt-4">
                            <label for="provider_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                            <input id="bank_name" type="text" name="bank_name" value="{{ old('bank_name') }}" required autofocus
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <!--branch code -->
                        <div class="mt-4">
                            <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                            <input id="account_number" type="text" name="account_number" value="{{ old('provider_name') }}" required autofocus
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <!--account number -->
                        <div class="mt-4">
                            <label for="account_holder_name" class="block text-sm font-medium text-gray-700">Account Holder Name</label>
                            <input id="account_holder_name" type="text" name="account_holder_name" value="{{ old('account_holder_name') }}" required autofocus
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <!-- Verifications Docs -->
                    
                    <h2 class="text-xl font-bold mt-6 text-gray-800">Document Uploads</h2>
                    <!-- Account Proof -->
                    <div class="flex flex-col mb-4">
                        <h2 class="text-lg font-bold mt-6 text-gray-800">Proof of Account</h2>
                        <p class="text-gray-600 mb-6">You must provide a document to prove your account is valid.</p>
                        <div class="mb-4">
                            <label for="ownership_document_type" class="block text-gray-700 font-medium mb-2">Document Type</label>
                            <select name="ownership_document_type" id="document_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                                <option value="Proof of account">proof of account</option>
                                <option value="Bank Statement">Bank Statement</option>
                            </select>
                        </div>
                
                        <div class="mb-6">
                            <label for="ownership_document_file" class="block text-gray-700 font-medium mb-2">Upload Document</label>
                            <input type="file" name="ownership_document_file" id="ownership_document_file" class="block text-sm font-medium text-gray-700" required>
                        </div>
                    </div>
                    
                    <!-- addres proof -->
                    <div class="flex flex-col w-full my-4">
                        <h2 class="text-lg font-bold text-gray-800">Proof of Address</h2>
                        <p class="text-gray-600 mb-6">Please provide a recent document showing your current address.</p>
                        <div class="mb-4">
                            <label for="address_document_type" class="block text-gray-700 font-medium mb-2">Document Type</label>
                            <select name="address_document_type" id="document_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                                <option value="utility_bill">Recent Utility Bill</option>
                                <option value="tax_assessment">Tax Assessment or Property Tax Receipt</option>
                                <option value="insurance_policy">Homeowners/Insurance Policy Document</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label for="address_document_file" class="block text-gray-700 font-medium mb-2">Upload Proof of Address</label>
                            <input type="file" name="address_document_file" id="address_document_file" class="block text-sm font-medium text-gray-700" required>
                        </div>
                    </div>
                    
                    
                    
                    
                    <!-- Identity Proof -->
                    <div class="flex flex-col w-full my-4">
                        <h2 class="text-lg font-bold mb-6 text-gray-800">Identity Verification</h2>
                        <p class="text-gray-600 mb-6">The full name on the document must match the name on your profile.</p>
                        <div class="mb-4">
                            <label for="id_document_type" class="block text-sm font-medium text-gray-700">ID Type</label>
                            <select name="id_document_type" id="id_document_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                                <option value="National ID Card">National ID Card</option>
                                <option value="passport">Passport</option>
                                <option value="Drivers License">Driver's License</option>
                            </select>
                        </div>
                
                        <div class="mb-6">
                            <label for="id_document_file" class="block text-sm font-medium text-gray-700">Upload proof of ID Document</label>
                            <input type="file" name="id_document_file" id="id_document_file" class="block text-sm font-medium text-gray-700" required>
                        </div>
                    </div>
                    
                    <!-- Business Details -->
                    <div class="flex flex-col w-full my-4">
                        <h2 class="text-lg font-bold text-gray-800">Business Documents upload if applicable</h2>
                        <p class="text-gray-600 mb-6">Please provide your business documents</p>
                        
                        <div class="flex flex-col w-full">
                            <label for="business_document_file" class="block font-medium text-gray-700 text-lg mb-2">Business License</label>
                                
                            <div class="mb-6">
                                <label for="business_document_file" class="block text-sm font-medium text-gray-700">Upload Business License</label>
                                <input type="file" name="business_document_file" id="business_document_file" class="block text-sm font-medium text-gray-700" required>
                            </div>
                        </div>
                
                        <div class="flex flex-col w-full mt-2">
                            <label class="block font-medium text-gray-700 text-lg mb-2">Tax registration number</label>
                
                            <div class="mb-6">
                                <label for="tax_file" class="block text-sm font-medium text-gray-700">Upload regisitration number proof</label>
                                <input type="file" name="tax_file" id="tax_file" class="block text-sm font-medium text-gray-700" required>
                            </div>
                        </div>
                    </div>
                </fieldset>


                <div class="">
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-p hover:bg-primary-p-darker focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Account
                    </button>
                </div>

                <div class="flex w-full  items-center justify-center px-6 py-2 pt-4">
                    <p class="text-sm text-gray-600">
                        <a href="{{ url()->previous() }}" class="font-medium text-primary-p hover:text-primary-p-darker">
                            Back
                        </a>
                    </p>
                </div>
            </form>
        </div>
        {{-- NEW: JavaScript to toggle the visibility of the new business fields --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const providerSelect = document.getElementById('provider_id');
                const newBusinessFields = document.getElementById('new-business-fields');
                const providerNameInput = document.getElementById('provider_name');
                const bookingAddressInput = document.getElementById('booking_address');
    
                function toggleBusinessFields() {
                    // If value is '0', it means "Create a new business" is selected
                    if (providerSelect.value === '0') {
                        newBusinessFields.style.display = 'block';
                        providerNameInput.required = true;
                        bookingAddressInput.required = true;
                    } else {
                        newBusinessFields.style.display = 'none';
                        providerNameInput.required = false;
                        bookingAddressInput.required = false;
                    }
                }
    
                // Run the function when the page loads
                toggleBusinessFields();
    
                // Add an event listener to run the function whenever the selection changes
                providerSelect.addEventListener('change', toggleBusinessFields);
            });
        </script>
    </main>
@endsection