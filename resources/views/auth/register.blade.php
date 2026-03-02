<x-guest-layout>
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-xl shadow-lg" style="padding: 2rem;">
        <div class="flex w-full items-center justify-center mb-2">
            <a href="/">
                <img width="64" height="64" src="{{ asset('storage/icons/logo.png') }}" alt="external-booking-vacation-planning-girls-trip-flaticons-lineal-color-flat-icons"/>
            </a>
        </div>
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800" style="
                font-size: 1.875rem;
                line-height: 2.25rem;
                font-weight:bolder;
            "
            >{{config('app.name')}}</h1>
            <h2 class="mt-2 text-xl font-semibold text-gray-900">Welcome Back</h2>
            <p class="mt-2 text-sm text-gray-600">Sign in to continue to your account.</p>
        </div>

        <!-- Session Status -->
        <!-- 
            Example of showing a session status message in Laravel.
            <x-auth-session-status class="mb-4" :status="session('status')" /> 
        -->

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div class="flex items-center justify-evenly " style="justify-content: space-evenly;">
                <a href="{{route('login.google')}}">
                    <div class="flex px-[2rem] py-4 border items-center justify-center border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" style="padding: 1rem 2rem;">
                        <img height="30px" width="30px" src="https://img.icons8.com/color/48/google-logo.png" alt="">
                    </div>
                </a>
                {{-- <a href="">
                    <div class="flex px-[2rem] py-4 border items-center justify-center border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" style="padding: 1rem 2rem;">
                        <img height="35px" width="35px" src="https://img.icons8.com/fluency/48/facebook.png" alt="">
                    </div>
                </a>
                <a href="">
                    <div class="flex px-[2rem] py-4 border items-center justify-center border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" style="padding: 1rem 2rem;">
                        <img height="30px" width="30px" src="https://img.icons8.com/ios-filled/50/mac-os.png" alt="">
                    </div>    
                </a>  --}}
            </div>


            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <div class="mt-1">
                    <input id="name" name="name" type="text" autocomplete="name" required autofocus
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           value="{{ old('name') }}"
                           placeholder="John Doe">
                </div>
                 <!-- @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror -->
            </div>

            
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           value="{{ old('email') }}"
                           placeholder="you@example.com">
                </div>
                <!-- @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror -->
            </div>

           <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                 <!-- @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror -->
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="mt-1">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <div>
                <button type="submit" class="
                    w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    style="
                        background-color:#AD68E4;
                    "
                >
                    Create Account
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500" style="color: rgb(37 99 235 / var(--tw-text-opacity, 1)); ">
                Sign in
            </a>
        </p>
    </div>
</x-guest-layout>
