{{-- resources/views/layouts/partials/tenant-navigation.blade.php --}}
<style>
    /* Custom complimentary color for the navigation bar */
    .bg-complimentary-nav {
        background-color: #AD68E4;
    }
    /* Darker shade for the active link background */
    .bg-complimentary-nav-darker {
        background-color: #7d45a2; /* A darker shade of #68E4AD */ 
    }
</style>

<nav x-data="{ open: false }" class="bg-complimentary-nav shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 overflow-hidden"> 
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    {{-- <a href="{{ route('dashboard') }}">
                        <img height="50" width="50" src="{{ asset('storage/icons/logo.png') }}" alt="Oplanla Logo" class="block h-9 w-auto">
                    </a> --}}
                    <h1 class="text-xl font-bold text-black">OPLANLA</h1>
                </div>
            </div>

            <div class="flex space-x-4 items-center">
                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        // Define classes for active and inactive links to keep the template clean
                        $activeLinkClasses = 'inline-flex items-center px-3 py-4 rounded-md text-sm font-medium text-white bg-complimentary-nav-darker transition duration-150 ease-in-out';
                        $inactiveLinkClasses = 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-black hover:bg-green-200 hover:text-gray-900 transition duration-150 ease-in-out';

                        $user = Auth::guard('web')->user();
                    @endphp
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('rooms.landing') }}" class="{{ request()->routeIs('rooms.landing') || request()->routeIs('room.show') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Bookings') }}
                    </a>
                    <a href="{{ route('tenant.room.show', $user->room->id) }}" class="{{ request()->routeIs('tenant.room*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('My Room') }}
                    </a>
                    <a href="{{ route('tenant.documents.upload') }}" class="{{ request()->routeIs('tenant.documents.upload*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('My Documents') }}
                    </a>
                    {{-- <a href="{{ route('room.booking.index.tenant') }}" class="{{ request()->routeIs('room.booking.index.tenant*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            {{ __('All Bookings') }}
                    </a> --}}
                    {{-- <a href="{{ route('tenant.rooms.index') }}" class="{{ request()->routeIs('tenant.rooms*') || request()->routeIs('tenant.room*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Rooms') }}
                    </a> --}}
                    {{-- <a href="{{ route('tenant.image.index', ['pid' => Auth::guard('tenant')->user()->tenant->id]) }}" class="{{ request()->routeIs('tenant.image*') || request()->routeIs('tenant.images*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('My Images') }}
                    </a> --}}
                    {{-- <a href="{{ route('tenant.enquiries.index') }}" class="{{ request()->routeIs('tenant.enquiries*') || request()->routeIs('tenant.enquiry*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Enquiries') }}
                    </a> --}}
                    {{-- <a href="/tenant/reports" class="{{ request()->routeIs('tenant.reports.index') || request()->routeIs('tenant.reports.index') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Reports') }}
                    </a> --}}
                </div>

                <!-- Settings Dropdown -->
                @if (Auth::check())
                    <div x-data="{ open: false }" @click.away="open = false" class="ml-3 relative">
                        <div>
                            <button @click="open = !open" class="flex text-sm border-2 items-center border-transparent rounded-full focus:outline-none ">
                                {{--<img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar->avatar) : "https://placehold.co/256x256/EFEFEF/333333?text=". substr(Auth::user()->name, 0, 1) }}" alt="{{ Auth::user()->name }}" >--}}
                                @include('components.user-avatar', ['user' => auth()->user(), 'height' => '2rem', 'width' => '2rem'])
                            </button>
                            
                        </div>

                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50"
                            style="display: none;">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                @endif
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-green-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::guard('web')->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('web')->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
