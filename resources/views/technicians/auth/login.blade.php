<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800">Technician Portal Login</h2>
        <div class="flex w-full items-center justify-center mb-2">
            <a href="/">
                <img width="100" height="100" src="{{ asset('storage/icons/logo.png') }}" alt="App Logo"/>
            </a>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="text-red-600 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('technician.login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div> --}}

            <div>
                <button type="submit"
                        class="w-full px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Log In
                </button>
            </div>
            {{-- <div class="flex flex-col w-full items-end px-2 py-2 justify-end">
                <div class="flex w-full space-x-2 items-center jusitfy-end">
                    <a href="{{route('technician.password.email')}}" class="text-sm font-semibold hover:undelined" style="color: #56ade4;">Forgot Password?</a>
                </div>
            </div> --}}
        </form>
    </div>
</x-guest-layout>