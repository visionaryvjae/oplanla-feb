{{-- resources/views/layouts/partials/admin-navigation.blade.php --}}
<style>
    .bg-complimentary-nav { background-color: #E4AD68; }
    .bg-complimentary-nav-darker { background-color: #8c6a40; }
    /* New class to ensure badges sit to the right */
    .nav-link-flex { display: flex; align-items: center; justify-content: space-between; }
</style>

{{-- MODIFIED: Expanded x-data to handle notification polling --}}
<nav x-data="{ 
    open: false,
    notificationCounts: { enquiries: 0, booking_requests: 0, partner_requests: 0 },
    fetchNotifications() {
        fetch('{{ route('admin.notifications.counts') }}')
            .then(response => response.json())
            .then(data => {
                // Map the API categories to our javascript object
                this.notificationCounts.enquiries = data.enquiries ?? 0;
                this.notificationCounts.booking_requests = data.booking_requests ?? 0;
                this.notificationCounts.partner_requests = data.partner_requests ?? 0;
                // Add others here if you create more categories
            })
            .catch(error => console.error('Error fetching notifications:', error));
    },
    init() {
        // Fetch on load
        this.fetchNotifications();
        // Poll every 30 seconds (adjust as needed)
        setInterval(() => this.fetchNotifications(), 30000);
    }
}" class="bg-complimentary-nav border-b border-green-300 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <img height="50" width="50" src="{{ asset('storage/icons/logo.png') }}" alt="Oplanla Logo" class="block h-9 w-auto">
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        // MODIFIED: Added 'nav-link-flex' class for positioning badges
                        $activeLinkClasses = 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-white bg-complimentary-nav-darker transition duration-150 ease-in-out nav-link-flex';
                        $inactiveLinkClasses = 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-black hover:bg-green-200 hover:text-gray-900 transition duration-150 ease-in-out nav-link-flex';
                        
                        // Reusable Badge Component (using Alpine variables)
                        $badgeHtml = '<span x-show="count > 0" x-text="count" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>';
                    @endphp

                    {{-- Standard Links (No badges) --}}
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Users') }}
                    </a>
                    <a href="{{ route('room.booking.index') }}" class="{{ request()->routeIs('room.booking.index*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Bookings') }}
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms.index*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Rooms') }}
                    </a>
                    <a href="{{ route('admin.providers.index') }}" class="{{ request()->routeIs('admin.providers*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Providers') }}
                    </a>
                    <a href="{{ route('admin.provider-users.index') }}" class="{{ request()->routeIs('admin.provider-users.index*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Provider Users') }}
                    </a>

                    {{-- MODIFIED Links with Badges --}}

                    {{-- Booking Requests (Edit Requests) --}}
                    <a href="{{ route('admin.booking-requests.index') }}" class="{{ request()->routeIs('admin.booking-requests.index') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        <span>{{ __('Edit Requests') }}</span>
                        {{-- We bind the specific count variable to the generic badge HTML slot --}}
                        <span x-data="{ count: notificationCounts.booking_requests }">
                           {!! str_replace('count', 'notificationCounts.booking_requests', $badgeHtml) !!}
                        </span>
                    </a>

                     {{-- Partner Requests --}}
                    <a href="{{ route('admin.partner-requests.index') }}" class="{{ request()->routeIs('admin.partner-requests.index*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        <span>{{ __('Partner Requests') }}</span>
                        <span x-data="{ count: notificationCounts.partner_requests }">
                             {!! str_replace('count', 'notificationCounts.partner_requests', $badgeHtml) !!}
                        </span>
                    </a>

                     {{-- Enquiries --}}
                    <a href="{{ route('admin.enquiries.index') }}" class="{{ request()->routeIs('admin.enquiries*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                       <span>{{ __('Enquiries') }}</span>
                       <span x-data="{ count: notificationCounts.enquiries }">
                            {!! str_replace('count', 'notificationCounts.enquiries', $badgeHtml) !!}
                       </span>
                    </a>

                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.index') ? $activeLinkClasses : $inactiveLinkClasses }}">
                        {{ __('Reports') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::guard('admin')->user()->username }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('admin.logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Standard Mobile Links --}}
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- ... other standard links ... --}}

            {{-- MODIFIED Mobile Links with Badges --}}
            {{-- Note: x-responsive-nav-link components might be harder to style with flex inside.
                 If the badge doesn't show correctly on mobile, you might need to publish the component 
                 and edit it directly, or use standard <a> tags here instead of the component. --}}
             <x-responsive-nav-link :href="route('admin.booking-requests.index')" :active="request()->routeIs('admin.booking-requests.index*')" class="flex justify-between">
                <span>{{ __('Edit Requests') }}</span>
                 <span x-show="notificationCounts.booking_requests > 0" x-text="notificationCounts.booking_requests" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.partner-requests.index')" :active="request()->routeIs('admin.partner-requests.index*')" class="flex justify-between">
                <span>{{ __('Partner Requests') }}</span>
                <span x-show="notificationCounts.partner_requests > 0" x-text="notificationCounts.partner_requests" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>
            </x-responsive-nav-link>
            
             <x-responsive-nav-link :href="route('admin.enquiries.index')" :active="request()->routeIs('admin.enquiries*')" class="flex justify-between">
                 <span>{{ __('Enquiries') }}</span>
                 <span x-show="notificationCounts.enquiries > 0" x-text="notificationCounts.enquiries" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>
            </x-responsive-nav-link>

        </div>

        <div class="pt-4 pb-1 border-t border-green-200">
             {{-- ... user info and logout ... --}}
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('admin.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>