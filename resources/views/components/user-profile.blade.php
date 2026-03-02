@extends('layouts.app')

@section('content')

    <style>
        .btn-update{
            background-color: #000;
            color: #fff;
            padding:0.5rem 1rem;
            border-radius:0.5rem;
        }
        .btn-update:hover{
            background-color: rgb(0,0,0,0.6);
        }

        .profile-container{
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
        }

        .avatar_input{
            display: none;
            width: 100%;
            font-size: 0.875rem;
            color: #64748b;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
            border-radius: 9999px;
            border: 0;
            background-color: #bfdbfe;
            color: #1d4ed8;
            font-weight: 600;
            transition: background-color 0.2s ease;"
        }
    </style>

    <div class="profile-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <header>
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Account Settings</h1>
                <p class="mt-2 text-md text-gray-600">Manage your profile information and password.</p>
            </header>

            <!-- Update Profile Information Form -->
            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Profile Information
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Update your account's profile information and email address.
                            </p>
                        </header>

                        <!-- Add enctype for file uploads -->
                        <form method="POST" action="{{ route('profile.update', Auth::id()) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="flex items-center space-x-6">
                                <!-- Profile Picture Display & Upload -->
                                <div class="shrink-0">
                                    <img  
                                        id="avatar-preview" class="h-20 w-20 object-cover rounded-full"
                                        <?php if(auth()->user()->avatar): ?>
                                            src="{{ asset('storage/avatars/' . auth()->user()->avatar->avatar) }}" 
                                        <?php else: ?>
                                            src="https://placehold.co/256x256/3b82f6/FFFFFF?text={{ substr(Auth::user()->name, 0, 1) }}"
                                        <?php endif; ?>
                                        alt="Current profile photo">
                                </div>
                                <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                    <!-- The actual file input is hidden and triggered by the styled button -->
                                    <input type="file" id="avatar" name="avatar" onmouseover="this.style.backgroundColor='#dbeafe'" onmouseout="this.style.backgroundColor='#bfdbfe'" accept="image/png, image/jpeg" class="avatar_input" style=" onmouseover="this.style.backgroundColor=#dbeafe; onmouseout="this.style.backgroundColor:#bfdbfe"/>
                                    <!-- Styled "button" to trigger the file input -->
                                    <label for="avatar" class="cursor-pointer px-4 py-2 bg-white text-sm font-semibold text-gray-700 rounded-md border border-gray-300 hover:bg-gray-50"
                                        style="padding:0.5rem 1rem; margin-left:1rem;"
                                    >
                                        Change Photo
                                    </label>
                                </label>
                            </div>
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email">
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="px-5 py-2 bg-black text-white text-sm font-semibold rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">Save</button>
                                
                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Saved.</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Update Password
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Ensure your account is using a long, random password to stay secure.
                            </p>
                        </header>
                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="current-password">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password">
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="px-5 py-2 bg-black text-white text-sm font-semibold rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">Save</button>
                                
                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Saved.</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle the live preview of the avatar.
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');

        avatarInput.addEventListener('change', () => {
            const file = avatarInput.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection