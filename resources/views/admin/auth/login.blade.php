<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="w-full max-w-md p-8 space-y-6 rounded-lg shadow-md" style="background-color: rgb(121, 10, 120);">
        <h2 class="text-2xl font-bold text-center text-gray-800">Admin Portal Login</h2>
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

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="text-sm font-medium text-gray-300">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="password" class="text-sm font-medium text-gray-300">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <button type="submit"
                        class="w-full px-4 py-2 font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="background-color: #ade456;">
                    Log In
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
