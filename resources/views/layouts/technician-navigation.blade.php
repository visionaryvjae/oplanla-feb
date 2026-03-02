{{-- resources/views/layouts/partials/technician-navigation.blade.php --}}
<style>
    /* Custom complimentary color for the navigation bar */
    .bg-complimentary-nav {
        background-color: #68ADE4;
    }
    /* Darker shade for the active link background */
    .bg-complimentary-nav-darker {
        background-color: #457da2; /* A darker shade of #68E4AD */
    }
</style>

<nav x-data="{ open: false }" class="bg-complimentary-nav shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('technician.dashboard') }}">
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
                    <a href="{{ route('technician.dashboard') }}" class="{{ request()->routeIs('technician.dashboard') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Dashboard') }}
                    </a>
                    
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::guard('technician')->user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('technician.logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('technician.logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
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
            <x-responsive-nav-link :href="route('technician.dashboard')" :active="request()->routeIs('technician.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-green-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::guard('technician')->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('technician')->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('technician.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('technician.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
