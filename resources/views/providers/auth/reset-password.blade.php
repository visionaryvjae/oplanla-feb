<x-guest-layout>
    <div class="flex flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <div class="w-full px-6 py-8 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-xl">
            
            <div class="mb-4 text-sm text-gray-600">
                <a href="{{ route('provider.login') }}" class="flex items-center hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    back
                </a>
            </div>
            <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">
                Reset Password
            </h2>

            <form method="POST" action="{{ route('provider.password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email Address')" class="mb-2 font-semibold text-gray-700" />
                    <x-text-input id="email" class="block w-full px-4 py-3 border-gray-200 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" 
                                    type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="your.partner.email@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="mb-2 font-semibold text-gray-700" />
                    <x-text-input id="password" class="block w-full px-4 py-3 border-gray-200 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" 
                                    type="password" name="password" required autocomplete="new-password" placeholder="********" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-8">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mb-2 font-semibold text-gray-700" />
                    <x-text-input id="password_confirmation" class="block w-full px-4 py-3 border-gray-200 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                                    type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit" class="w-full px-4 py-3 font-bold text-white transition duration-150 ease-in-out bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    {{ __('Reset Password') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>