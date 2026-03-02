@extends('layouts.providers')

@section('content')
    {{-- resources/views/provider/dashboard.blade.php --}}
    <style>
        /* Custom colors from your provided file */
        :root {
            --color-primary-p: #ad68e4;
            --color-complimentary: #68e4ad;
            --color-dark-bg: #282c34;
        }
        .bg-primary-p { background-color: var(--color-primary-p); }
        .text-primary-p { color: var(--color-primary-p); }
        .hover\:bg-primary-p-darker:hover { background-color: #973fdf; }
        .bg-complimentary { background-color: var(--color-complimentary); }
        .text-complimentary { color: var(--color-complimentary); }
        .bg-dark-bg { background-color: var(--color-dark-bg); }

        body {
            font-family: 'Inter', sans-serif;
            color: #333333;
        }
    </style>

    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Welcome to the Oplanla.com Partner Hub</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            Your central resource for managing your listings, understanding your performance, and connecting with the Oplanla.com community.
        </p>

        {{-- Use the 'provider' guard to check authentication state. --}}
        @auth('provider')
            <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-lg">
                {{-- The $partnerName variable is passed from the DashboardController --}}
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Hello, {{ Auth::guard('provider')->user()->name }}!</h2>
                <p class="text-gray-700 mb-8">Here's a quick overview of your property's performance and quick links to manage your listings.</p>

                {{-- @php
                    dd(Auth::guard('provider')->user()->partnerRequests->status);
                @endphp --}}
                @if (Auth::guard('provider')->user()->partnerRequests->status === 'accepted')
                    {{-- These stats should be passed as variables from your controller --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                            <p class="text-5xl font-bold text-primary-p mb-2">{{ $upcomingBookings->num_bookings }}</p>
                            <p class="text-gray-600">Upcoming Bookings</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                            @if ($upcomingBookings->payouts)
                                <p class="text-5xl font-bold text-complimentary mb-2">R {{ $upcomingBookings->payouts }}</p>
                            @else
                                <p class="text-3xl font-bold text-complimentary mb-2">No upcoming payouts</p>
                            @endif
                            <p class="text-gray-600">Pending Payouts</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                            
                                @if ($avgReview->avg_rating)
                                    <p class="text-5xl font-bold text-blue-500 mb-2">
                                        {{ round($avgReview->avg_rating, 2) }}
                                    </p>
                                @else
                                    <p class="text-3xl font-bold text-blue-500 mb-2">
                                        Not yet reviewed
                                    </p>
                                @endif
                            <p class="text-gray-600">Average Rating</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                            <p class="text-5xl font-bold text-purple-500 mb-2">{{ $activeRooms->num_rooms }}</p>
                            <p class="text-gray-600">Active Listings</p>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold mb-4 text-dark-bg">Quick Links</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Tip: Use the route() helper for cleaner links --}}
                        <a href="{{route('provider.rooms.index')}}" class="bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300 text-center">Manage Listings</a>
                        <a href="{{route('room.booking.index.provider')}}" class="bg-complimentary text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-600 transition duration-300 text-center">View All Bookings</a>
                        <a href="/provider/reports" class="bg-red-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-purple-600 transition duration-300 text-center">Performance Reports</a>
                        <a href="{{url('/help#partner')}}" class="bg-gray-300 text-dark-bg font-semibold py-3 px-6 rounded-lg hover:bg-gray-400 transition duration-300 text-center">Help Articles</a>
                        {{-- <a href="/community-forum" class="bg-orange-400 text-white font-semibold py-3 px-6 rounded-lg hover:bg-orange-500 transition duration-300 text-center">Community Forum</a> --}}
                    </div>
                @else
                    @php
                        $partnerRequest = Auth::guard('provider')->user()->partnerRequests;
                        // dd($partnerRequest->addressProof);
                    @endphp
                    <div class="flex flex-col max-w-7xl bg-gray-200 p-6 rounded-lg shadow-sm text-center mt-8">
                        <div class="flex flex-col justify-start items-center px-6">
                            @if ($partnerRequest->status === 'pending')
                                <div class=" w-full justify-center mb-4">
                                    <h2 class="text-4xl font-bold mb-4 text-dark-bg" style="color: #f2a; font-weight:bolder;">Your Partner Request is Pending.</h2>
                                    <a href="{{route('partner.edit.verification')}}" class="text-4xl font-bold mb-4 text-dark-bg underline hover:bg-blue-500" style="color: #f2a; font-weight:bolder;">
                                        upload your documents here.
                                    </a>
                                </div>
                                <p class="text-gray-700 mb-6">We are currently reviewing your request. Please check back later.</p>

                                @if(!$partnerRequest->ownershipProofs)
                                    <p class="text-red-500 font-medium">your request is missing the ownership proof of the property</p>
                                @else
                                    <div class="flex justify-start items-start">
                                        <span>✅</span>
                                        <p class="text-green-600 text-left font-medium">proof of ownership</p>
                                    </div>
                                @endif

                                @if (!$partnerRequest->addressProof)
                                    <p class="text-red-500 font-medium">your request is missing the proof of address of your property</p>
                                @else
                                    <div class="flex justify-start items-start">
                                        <span>✅</span>
                                        <p class="text-green-600 text-left font-medium">proof of address</p>
                                    </div>
                                @endif
                                
                                @if(!$partnerRequest->identityProofs)
                                    <p class="text-red-500 font-medium">your request is missing the identity proof of the property owner</p>
                                @else
                                    <div class="flex justify-start items-start">
                                        <span>✅</span>
                                        <p class="text-green-600 text-left font-medium">proof of Identity</p>
                                    </div>
                                @endif
                                
                                @if(!$partnerRequest->businessDetail)
                                    <p class="text-red-500 font-medium">your request is missing your Business verification documents</p>
                                @else
                                    <div class="flex justify-start items-start">
                                        <span>✅</span>
                                        <p class="text-green-600 text-left font-medium">Busienss Details</p>
                                    </div>
                                @endif
                                
                            @else
                                <p class="text-lg font-semibold text-red-500">You partner request has been rejected. Edit the necessary information in the <span class="font-bold ">"Edit Request Info"</span> tab above</p>
                                <!-- Place this right after your existing status message -->
                                <div class="mt-3 p-3 bg-white border rounded shadow-sm">
                                    <p class="text-danger mb-0">
                                        <strong>Reason for rejection:</strong><br>
                                        {{ $partnerRequest->ownershipProofs?->reason ?? 
                                           $partnerRequest->addressProof?->reason ?? 
                                           $partnerRequest->identityProofs?->reason ?? 
                                           $partnerRequest->businessDetail?->reason ?? 
                                           'Please contact support for more information.' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Added a logout form for proper functionality --}}
                 <div class="mt-12 text-center border-t pt-8">
                    <form method="POST" action="{{ route('provider.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-primary-p">Logout of Partner Hub</button>
                    </form>
                </div>
            </div>
        @else
            <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
                <div class="flex max-w-md w-full jusitify-start" style="margin-top: -1rem;">
                    <a href="{{url()->previous()}}" class="text-gray-500 font-semibold hover:underline">< back</a>
                </div>
                <h2 class="text-3xl font-bold mb-6 text-center text-dark-bg">Partner Login</h2>
                {{-- Use the named route for the form action --}}
                <form action="{{ route('provider.login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="partner_email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input type="email" id="partner_email" name="email" class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-primary-p" placeholder="your.partner.email@example.com" required>
                    </div>
                    <div>
                        <label for="partner_password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" id="partner_password" name="password" class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline focus:border-primary-p" placeholder="********" required>
                    </div>
                    <div class="flex flex-col items-center justify-between">
                        <button type="submit" class="bg-primary-p text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline hover:bg-primary-p-darker transition duration-300 w-full">
                            Login to Partner Hub
                        </button>
                        <div class="flex flex-col w-full items-end px-2 py-2 justify-end">
                            <div class="flex w-full space-x-2 items-center jusitfy-end">
                                <p>Don't have an account?</p>
                                <a href="{{route('provider.register')}}" class="text-sm font-semibold hover:undelined" style="color: #ad56e4;">Sign up</a>
                            </div>
                            <div class="flex w-full space-x-2 items-center jusitfy-end">
                                <a href="{{route('provider.password.email')}}" class="text-sm font-semibold hover:undelined" style="color: #ad56e4;">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endauth
    </main>
@endsection