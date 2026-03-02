<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>
        
        <!-- styles -->
        @stack('styles')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

        <!-- Scripts -->
        
        <!-- tailwiwnd css -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <!-- Mapbox GL JS -->
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css'  rel='stylesheet' />
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script> 

        <!-- Mapbox Geocoder Plugin -->
        <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js'></script>  
        <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css'  type='text/css' />

        <!-- functions -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>

            
            document.addEventListener('DOMContentLoaded', function() {
            // Initialize Flatpickr for your check-in date input
                flatpickr("#check_in_time", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    altInput: true,
                    altFormat: "F j, Y h:i K",
                    minDate: "today" // Prevents selecting past dates
                });

                // Initialize Flatpickr for your check-out date input
                flatpickr("#check_out_time", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    altInput: true,
                    altFormat: "F j, Y h:i K",
                    minDate: "today",
                });
            })

        </script>
    </head>

    @php
        $user = Auth::guard('web')->user() ?? null;
    @endphp
    <body class="font-sans antialiased">
        <div class="min-h-[100vh] bg-gray-100">
            
            @if ($user)
                @if ($user->role == 'tenant')
                    @include('layouts.tenant-navigation')
                @else
                    @include('layouts.navigation')
                @endif
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <div class="flex flex-col w-[100%] bg-white items-center justify-start" 
                style="
                    min-height:100vh;
                    height: 100%;
                    margin: 0;
                    padding:2rem 0;">
                @yield('content')
            </div>
        </div>
    </body>
</html>
