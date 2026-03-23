<style>
    .bg-oplanla-green { background-color: #68E4AD; }
    .bg-oplanla-green-dark { background-color: #45a27d; }
    .text-oplanla-purple { color: #ad68e4; }
    .bg-oplanla-purple { background-color: #ad68e4; }
</style>

<nav x-data="{ open: false }" class="shadow-sm">
    <div class="bg-oplanla-green px-8 py-3 flex items-center justify-between">
        
        <div class="flex items-center gap-8">
            <a href="{{ route('provider.dashboard') }}" class="shrink-0">
                <img height="50" width="50" src="{{ asset('storage/icons/logo.png') }}" alt="Oplanla Logo" class="block h-9 w-auto">
            </a>
            
            <div class="hidden md:flex gap-1">
                <div class="group relative">
                    <button class="{{ request()->routeIs('provider.rooms*') || request()->routeIs('provider.enquiry*') || request()->routeIs('provider.enquiries*') || request()->routeIs('provider.properties*') || request()->routeIs('provider.meters*') || request()->routeIs('provider.tenants*') || request()->routeIs('provider.potential-tenant*') ? 'text-white bg-oplanla-green-dark' : 'text-black' }} px-4 py-2 rounded-md  font-medium hover:bg-white/20 transition flex items-center gap-2">
                        Properties <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute hidden group-hover:block w-48 bg-white shadow-xl rounded-lg mt-1 border py-2 z-50">
                        <a href="{{ route('provider.properties.index') }}" class="{{ request()->routeIs('provider.properties*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">All Properties</a>
                        <a href="{{ route('provider.rooms.index') }}" class="{{ request()->routeIs('provider.rooms*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 hover:bg-[#68e4ad]/10">Rooms & Units</a>
                        <a href="{{ route('provider.enquiries.index') }}" class="{{ request()->routeIs('provider.enquiry*') || request()->routeIs('provider.enquiries*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 hover:bg-[#68e4ad]/10">Enquiries</a>
                        <a href="{{ route('provider.meters.index') }}" class="{{ request()->routeIs('provider.meters*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Manage meters</a>
                        <a href="#" class="{{ request()->routeIs('') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Amenities</a>
                        <a href="{{ route('provider.tenants.index') }}" class="{{ request()->routeIs('provider.tenants*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Tenants</a>
                        <a href="{{ route('provider.potential-tenant.index') }}" class="{{ request()->routeIs('provider.potential-tenant*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Potential Tenant Documents</a>
                    </div>
                </div>
    
                <div class="group relative">
                    <button class="{{ request()->routeIs('provider.maintenance*') || request()->routeIs('provider.maintenance-users*') ? 'text-white bg-oplanla-green-dark' : 'text-black' }} px-4 py-2 rounded-md  font-medium hover:bg-white/20 transition flex items-center gap-2">
                        Maintenance <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute hidden group-hover:block w-48 bg-white shadow-xl rounded-lg mt-1 border py-2 z-50">
                        <a href="{{ route('provider.maintenance.jobs.index') }}" class="{{ request()->routeIs('provider.maintenance.jobs*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 hover:bg-[#68e4ad]/10">Jobs (Requests)</a>
                        <a href="{{ route('provider.maintenance.tickets.index') }}" class="{{ request()->routeIs('provider.maintenance.tickets*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Active Tickets</a>
                        <a href="{{ route('provider.maintenance-users.index') }}" class="{{ request()->routeIs('provider.maintenance-users*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Maintenance Users</a>
                    </div>
                </div>
    
                <div class="group relative">
                    <button class="{{ request()->routeIs('provider.reports*') || request()->routeIs('provider.utilities*') || request()->routeIs('provider.utility*') || request()->routeIs('provider.charges*') ? 'text-white bg-oplanla-green-dark' : 'text-black' }} px-4 py-2 rounded-md  font-medium hover:bg-white/20 transition flex items-center gap-2">
                        Financials <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute hidden group-hover:block w-56 bg-white shadow-xl rounded-lg mt-1 border py-2 z-50">
                        <a href="#" class="{{ request()->routeIs('') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 text-gray-700 hover:bg-[#68e4ad]/10">Rent Ledger</a>
                        <a href="{{ route('provider.utilities.import') }}" class="{{ request()->routeIs('provider.utilities*') || request()->routeIs('provider.utility*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 hover:bg-[#ad68e4]/5">Motla CSV Import</a>
                        <a href="{{ route('provider.charges.index') }}" class="{{ request()->routeIs('provider.charges*') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 hover:bg-[#ad68e4]/5">Room Utility Charges</a>
                        <a href="#" class="{{ request()->routeIs('') ? 'text-oplanla-purple font-bold' : 'text-gray-700' }} block px-4 py-2 hover:bg-[#68e4ad]/10">Payment History</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            
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

            <div class="lg:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-black hover:bg-white/20 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="lg:hidden bg-white mt-3 rounded-2xl shadow-2xl overflow-hidden border border-green-100">
        
        <div class="py-4 space-y-1">
            <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 mb-1">Properties</div>
            <x-responsive-nav-link :href="route('provider.properties.index')" class="{{ request()->routeIs('provider.properties*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Properties</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.rooms.index')" class="{{ request()->routeIs('provider.rooms*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Rooms & Units</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.enquiries.index')" class="{{ request()->routeIs('provider.enquiries*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Enquiries</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.meters.index')" class="{{ request()->routeIs('provider.meters*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Meters</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.tenants.index')" class="{{ request()->routeIs('provider.tenants*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Tenants</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.potential-tenant.index')" class="{{ request()->routeIs('provider.potential-tenant *') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Potential Tenant Documents</x-responsive-nav-link>

            
            
            <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 mt-4 mb-1">Maintenance</div>
            <x-responsive-nav-link :href="route('provider.maintenance.jobs.index')" class="{{ request()->routeIs('provider.maintenance.jobs*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Maintenance Requests</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.maintenance.tickets.index')" class="{{ request()->routeIs('provider.maintenance.tickets*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Tickets</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.maintenance-users.index')" class="{{ request()->routeIs('provider.maintenance-users*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Maintenance Users</x-responsive-nav-link>

            <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 mt-4 mb-1">Financials</div>
            <x-responsive-nav-link href="#" class="{{ request()->routeIs('') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Rent Ledger</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.utilities.import')" class="{{ request()->routeIs('provider.utilities*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Motla CSV Import</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('provider.charges.index')" class="{{ request()->routeIs('provider.charges.*') ? 'text-oplanla-purple border-l-2 border-purple-500 bg-purple-200' : '' }} font-black">Charges</x-responsive-nav-link>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <x-responsive-nav-link :href="route('provider.reports.index')" :active="request()->routeIs('provider.reports.*')">
                    Reports Center
                </x-responsive-nav-link>
            </div>
        </div>

        <div class="bg-gray-50 p-4 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-4">
                {{-- <img src="{{ asset('storage/icons/user-avatar.png') }}" class="w-10 h-10 rounded-full"> --}}
                <div>
                    <p class="font-bold text-gray-800 leading-tight">{{ Auth::guard('provider')->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::guard('provider')->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('provider.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left font-bold text-red-500 py-2">
                    <i class="fa-solid fa-power-off mr-2"></i> Log Out
                </button>
            </form>
        </div>
    </div>
</nav>

