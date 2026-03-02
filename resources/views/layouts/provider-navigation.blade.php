{{-- resources/views/layouts/partials/provider-navigation.blade.php --}}
<style>
    /* Custom complimentary color for the navigation bar */
    .bg-complimentary-nav {
        background-color: #68E4AD;
    }
    /* Darker shade for the active link background */
    .bg-complimentary-nav-darker {
        background-color: #45a27d; /* A darker shade of #68E4AD */
    }
</style>

<nav x-data="{ open: false }" class="bg-complimentary-nav border-b border-green-300 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('provider.dashboard') }}">
                        <img height="50" width="50" src="{{ asset('storage/icons/logo.png') }}" alt="Oplanla Logo" class="block h-9 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        // Define classes for active and inactive links to keep the template clean
                        $activeLinkClasses = 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-white bg-complimentary-nav-darker transition duration-150 ease-in-out';
                        $inactiveLinkClasses = 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-black hover:bg-green-200 hover:text-gray-900 transition duration-150 ease-in-out';
                    @endphp
                    <a href="{{ route('provider.dashboard') }}" class="{{ request()->routeIs('provider.dashboard') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Dashboard') }}
                    </a>
                    @if (Auth::guard('provider')->user()->partnerRequests->status == "pending" || Auth::guard('provider')->user()->partnerRequests->status == "rejected")
                        <a href="{{ route('partner.edit.verification') }}" class="{{ request()->routeIs('partner.edit.verification') {{--|| routeIs('provider.verification.*') || reqeust()->routeIs('provider.verification.identity') || reqeust()->routeIs('provider.verification.address') || reqeust()->routeIs('provider.verification.ownership') --}} ? $activeLinkClasses : $inactiveLinkClasses }}">
                            {{ __('Edit Request Info') }}
                        </a>
                    @endif
                    
                    @if (Auth::guard('provider')->user()->partnerRequests->status === 'accepted')
                        <a href="{{ route('room.booking.index.provider') }}" class="{{ request()->routeIs('room.booking.index.provider*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                                {{ __('All Bookings') }}
                        </a>
                        <a href="{{ route('provider.rooms.index') }}" class="{{ request()->routeIs('provider.rooms*') || request()->routeIs('provider.room*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            {{ __('Rooms') }}
                        </a>
                        <a href="{{ route('provider.image.index', ['pid' => Auth::guard('provider')->user()->provider->id]) }}" class="{{ request()->routeIs('provider.image*') || request()->routeIs('provider.images*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            {{ __('My Images') }}
                        </a>
                        <a href="{{ route('provider.enquiries.index') }}" class="{{ request()->routeIs('provider.enquiries*') || request()->routeIs('provider.enquiry*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            {{ __('Enquiries') }}
                        </a>
                        <a href="/provider/reports" class="{{ request()->routeIs('provider.reports.index') || request()->routeIs('provider.reports.index') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            {{ __('Reports') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::guard('provider')->user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('provider.logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('provider.logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        <x-dropdown-link :href="route('provider.password.request')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Reset Password') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-white hover:bg-complimentary-nav-darker focus:outline-none focus:bg-complimentary-nav-darker focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('provider.dashboard')" :active="request()->routeIs('provider.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::guard('provider')->user()->partnerRequests->status == "pending" || Auth::guard('provider')->user()->partnerRequests->status == "rejected")
                <x-responsive-nav-link :href="route('partner.edit.verification')" :active="request()->routeIs('partner.edit.verification')">
                    {{ __('Edit Request Info') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::guard('provider')->user()->partnerRequests->status == "accepted")
                <x-responsive-nav-link :href="route('room.booking.index.provider')" :active="request()->routeIs('room.booking.index.provider*')">
                    {{ __('All Bookings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('provider.rooms.index')" :active="request()->routeIs('provider.rooms*')">
                    {{ __('Rooms') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('provider.image.index', ['pid' => Auth::guard('provider')->user()->provider->id])" :active="request()->routeIs('provider.image.index*')">
                    {{ __('My Images') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('provider.enquiries.index')" :active="request()->routeIs('provider.enquiry*') || request()->routeIs('provider.enquiries*')">
                    {{ __('Enquiries') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('provider.reports.index')" :active="request()->routeIs('provider.reports.index*')">
                    {{ __('Reports') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-green-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::guard('provider')->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('provider')->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('provider.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('provider.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                <x-responsive-nav-link :href="route('provider.password.request')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Reset Password') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </div>
</nav>
