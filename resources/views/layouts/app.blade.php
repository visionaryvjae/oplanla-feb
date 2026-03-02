<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- styles -->
        @stack('styles')
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Indie+Flower&family=Lexend:wght@100..900&family=Libre+Caslon+Display&display=swap" rel="stylesheet">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Display&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
        
        <!-- Alppine js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap @5.2.3-alpha3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                // Initialize Flatpickr for your check-out date input
                const checkOutTimePicker = flatpickr("#check_out_time", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    altInput: true,
                    altFormat: "F j, Y h:i K",
                    minDate: "today",
                });
                
                // Initialize Flatpickr for your check-in date input
                flatpickr("#check_in_time", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    altInput: true,
                    altFormat: "F j, Y h:i K",
                    minDate: "today", // Prevents selecting past dates
                    onChange: function(selectedDates) {
                        // Update the minDate for the check-out time
                        if (selectedDates.length > 0) {
                            const checkInDateTime = selectedDates[0];

                            // Create a new Date object for the minimum checkout date and time
                            const minCheckOutDateTime = new Date(checkInDateTime);

                            // Add 8 hours to the check-in time
                            minCheckOutDateTime.setHours(checkInDateTime.getHours() + 21);

                            checkOutTimePicker.set("minDate", minCheckOutDateTime);

                            // Optional: If the current checkout date is before the new check-in date,
                            // clear the checkout date or set it to the check-in date.
                            if (checkOutTimePicker.selectedDates.length > 0 && checkOutTimePicker.selectedDates[0] < minCheckOutDateTime) {
                                checkOutTimePicker.setDate(minCheckOutDateTime, true); // Set to check-in date and trigger onChange
                            }
                        } else {
                            // If check-in date is cleared, perhaps reset check-out minDate
                            checkOutTimePicker.set("minDate", "today");
                        }
                    }
                });

            })

        </script>
    </head>
    <body class="font-sans antialiased">
        <style>
            body{
                font-family: "Libre Caslon Display", sans-serif;
                font-optical-sizing: auto;
                font-weight: 600;
                font-style: normal;
                background-color: #fff;
            }

            .content-container-app{
                min-height: 100vh;
                background-color: rgb(243 244 246);
            }
        </style>
        
        <div class="content-container-app" {{--"min-h-[100vh] bg-gray-100 dark:bg-gray-900"--}}>
            @php
                $user = Auth::guard('web')->user() ?? null;
            @endphp

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow" style="height: auto;">
                    <div class="flex max-w-7xl mx-auto py-6 px-2 sm:px-6 lg:px-8" 
                        style="height: auto;">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <div class=""
                style="
                    display:flex;
                    flex-direction:column;
                    height:100%;
                    min-height:100vh;
                    width:100%;
                    background-color:white;
                    align-items:flex-start;
                    justify-content:flex-start;
                "
            >
                @yield('content')
            </div>
            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </body>
</html>
