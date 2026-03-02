{{-- <x-app-layout> --}}
@extends('layouts.tenant')

@section('content')

    {{-- <x-slot name="header"> --}}
        <div class="max-w-[100rem] mx-auto bg-white sm:px-6 lg:px-8" style="height:100%; padding-right: 6rem; max-width: 90rem; margin-left:auto; margin-right:auto; padding: 2rem;">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @php
                session()->forget('success'); // Explicitly remove the message
            @endphp


            <div class="py-12 min-h-screen">
                <div class="mx-auto sm:px-6 lg:px-8">
                    
                    <header class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                        <div>
                            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Welcome, {{ Auth::user()->name }}!</h1>
                            <p class="mt-2 text-lg text-gray-500">
                                {{ auth()->user()->isTenant() ? 'Manage your residency and utilities below.' : 'Track your bookings and rental inquiries.' }}
                            </p>
                        </div>
                        
                        @if(auth()->user()->isTenant())
                            <div class="bg-purple-100 text-purple-700 px-4 py-2 rounded-2xl text-sm font-bold flex items-center">
                                <span class="w-2 h-2 bg-purple-500 rounded-full animate-ping mr-2"></span>
                                Verified Tenant: Room #{{ auth()->user()->room_id }}
                            </div>
                        @endif
                    </header>

                    <nav class=" space-x-2 mb-10 p-1 bg-gray-200 rounded-2xl" style="display: inline-block;">
                        <button onclick="switchTab('bookings')" id="tab-bookings" 
                            class="nav-tab active-tab px-6 py-2.5 rounded-xl text-sm font-bold transition-all">
                            My Bookings
                        </button>

                        @if(auth()->user()->isTenant())
                            <button onclick="switchTab('utilities')" id="tab-utilities" 
                                class="nav-tab px-6 py-2.5 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-700 transition-all">
                                Utilities & Billing
                            </button>
                            <button onclick="switchTab('maintenance')" id="tab-maintenance" 
                                class="nav-tab px-6 py-2.5 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-700 transition-all">
                                Maintenance
                            </button>
                        @else
                            <button onclick="switchTab('enquiries')" id="tab-enquiries" 
                                class="nav-tab px-6 py-2.5 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-700 transition-all">
                                Rental Enquiries
                            </button>
                        @endif
                    </nav>

                    <div id="content-bookings" class="tab-content">
                        <div class="space-y-10">
                            <section>
                                <h2 class="text-2xl font-bold text-gray-800 mb-6">Upcoming Stays</h2>
                                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" style="border-radius:1.5rem;">
                                    @forelse ($bookings as $booking)
                                        <div class="p-6 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <img src="{{ $booking->bookingRooms->room->provider->photos->where('area','display')->first() ? asset('storage/images/' . $booking->bookingRooms->room->provider->photos->where('area','display')->first()->image) : 'https://placehold.co/100' }}" class="w-20 h-20 rounded-2xl object-cover shadow-sm">
                                                    <div>
                                                        <h3 class="font-bold text-gray-900">{{ $booking->bookingRooms->room->room_type }}</h3>
                                                        <p class="text-sm text-gray-500">{{ $booking->bookingRooms->room->provider->provider_name }}</p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('booking.show.single', $booking->id) }}" class="bg-purple-600 text-white px-6 py-2 rounded-xl font-bold text-sm shadow-lg shadow-purple-100" style="background-color: #ad68e4;">View Details</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="flex flex-col items-center text-center py-12">
                                            <p class="text-gray-400 mb-6">No upcoming bookings found.</p>
                                            <a href="{{ route('rooms.landing') }}" class="bg-purple-600 text-white px-6 py-2 rounded-xl font-bold text-sm shadow-md" style="background-color: #ad68e4;">Find rooms</a>
                                        </div>
                                    @endforelse
                                </div>
                            </section>

                            <section>
                                <h2 class="text-2xl font-bold text-gray-800 mb-6">History</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @forelse ($pastBookings as $past)
                                        <div class="bg-white p-4 rounded-2xl border border-gray-100 flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-600">{{ $past->provider_name }}</span>
                                            <span class="text-xs bg-gray-100 px-3 py-1 rounded-full text-gray-500">Completed</span>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 italic">No past activity to display.</p>
                                    @endforelse
                                </div>
                            </section>
                        </div>
                    </div>

                    @if(auth()->user()->isTenant())
                        <div id="content-utilities" class="tab-content hidden">
                            @include('clients.dashboard-components.utility-billing')
                        </div>

                        <div id="content-maintenance" class="tab-content hidden">
                            @include('clients.dashboard-components.maintenance-jobs')
                            {{-- <div>hello</div> --}}
                        </div>
                    @else
                        <div id="content-enquiries" class="tab-content hidden">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Long-term Rental Enquiries</h2>
                            @include('clients.enquiries.index')
                        </div>
                    @endif

                </div>
            </div>

            <script>
                function switchTab(tabId) {
                    // Hide all content
                    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
                    // Remove active styles from all tabs
                    document.querySelectorAll('.nav-tab').forEach(el => {
                        el.classList.remove('active-tab', 'bg-white', 'shadow-sm', 'text-teal-600');
                        el.classList.add('text-gray-500');
                    });

                    // Show selected content
                    document.getElementById('content-' + tabId).classList.remove('hidden');
                    // Add active styles to clicked tab
                    const activeTab = document.getElementById('tab-' + tabId);
                    activeTab.classList.add('active-tab', 'bg-white', 'shadow-sm', 'text-teal-600');
                    activeTab.classList.remove('text-gray-500');
                }

                // Initialize first tab
                document.addEventListener('DOMContentLoaded', () => {
                    switchTab('bookings');
                });
            </script>

            <style>
                .active-tab {
                    background-color: white !important;
                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
                    color: #ad68e4 !important; /* Mint Teal */
                }
            </style>
        </div>
    </div>
{{-- </x-slot> --}}

    

@endsection
{{-- </x-app-layout> --}}
