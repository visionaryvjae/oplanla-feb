<nav x-data="{ open: false }" class=" shadow-md" style="background-color: #fff">


    <style>

        .nav-label:{
            color: rgb(100, 100, 100);
            font-weight: 800;
        }

        .nav-label-focus{
            color: #222;
            border-bottom: solid #666 2px;
        }

        .nav-label:hover{
            color:#AD68E4;
        }

        .nav-label-focus:hover{
            color: #AD68E4;
            border-bottom:solid #AD68E4 2px; 
        }
        
        .primary-nav{
               
        }
    </style>

    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div 
            class="flex justify-between h-16"
            style="
                font-family: 'Lato', sans-serif;
                line-height: 1.8;
                font-weight: 300; /* Thin */
            "
        >
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('room.booking') }}" class="flex flex-col items-center justify-center">
                        <img width="60" height="60" src="{{ asset('storage/icons/logo.png') }}" alt="geography" />
                    </a>
                </div>

                @php
                    $user = Auth::guard('web')->user();
                @endphp
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 mx-4 sm:-my-px sm:ml-10 sm:flex">
                    @if (!Auth::check())
                        <a href="{{ route('rooms.landing') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rooms.landing') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="color: "
                        >
                            Rooms
                        </a>
                        <a href="{{ route('rentals.landing') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rentals.landing') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="color: "
                        >
                            Rentals
                        </a>
                        <a href="{{ route('login') }}" class="nav-label inline-flex items-center hover:bg-[#6b5131] text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="padding:0.5rem 1rem; border-radius: 0.25rem; background-color: #e4ad68; color:#fff"
                        >
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="nav-label inline-flex items-center hover:bg-[#6b5131] text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="padding:0.5rem 1rem; border-radius: 0.25rem; border:solid #e4ad68 1px; background-color:#e4ad68; color:#fff;"
                        >
                            Register
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="color: "
                        >
                            Dashboard
                        </a>
                        <a href="{{ route('rooms.landing') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rooms.landing') || request()->routeIs('room.show') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="color: "
                        >
                            Rooms
                        </a>
                        <a href="{{ route('tenant.documents.upload') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rooms.landing') || request()->routeIs('room.show') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="color: "
                        >
                            Upload Documents
                        </a>
                        @if ($user->role != 'tenant')
                            <a href="{{ route('rentals.landing') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rentals*') || request()->routeIs('rental*') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                                style="color: "
                            >
                                Rentals
                            </a>
                        @endif
                        {{-- <a href="{{ route('client.enquiries.index') }}" class="nav-label inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('client.enquiries*') || request()->routeIs('client.enquiry*') ? 'nav-label-focus' : 'nav-label' }} text-sm font-medium leading-5 transition duration-150 ease-in-out"
                            style="color: "
                        >
                            My Enquiries
                        </a> --}}
                    @endif
                    
                </div>
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
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            
            @if (!Auth::check())
                <a href="{{ route('rooms.landing') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('rooms.index') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition">
                    Rooms
                </a>
                <a href="{{ route('rentals.landing') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('rooms.index') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition"
                    style="color: "
                >
                    Rentals
                </a>
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4  text-base font-medium transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition">
                    Register
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition">
                    Dashboard
                </a>
                <a href="{{ route('rooms.landing') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('rooms.index') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition">
                    Rooms
                </a>
                <a href="{{ route('rentals.landing') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('rooms.index') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition"
                    style="color: "
                >
                    Rentals
                </a>
                {{-- <a href="{{ route('client.enquiries.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('client.enquiries*') || request()->routeIs('client.enquiry*') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition"
                    style="color: "
                >
                    My Enquiries
                </a> --}}
            @endif
        </div>

        @if (Auth::check())
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.show') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                        Profile
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>