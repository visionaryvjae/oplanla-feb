<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Oplanla</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .brand-purple { background-color: #ad67e4; } /* Matches your header */
        .brand-orange { background-color: #e4ad67; } /* Matches your buttons */
        .brand-orange:hover { background-color: #d97706; }
        .brand-green {background-color: #67e4ad; }
    </style>
</head>
<body class="bg-slate-50 antialiased font-sans">
    <div class="brand-purple h-2 w-full"></div>
    
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full text-center">
            <div class="mb-8 flex justify-center">
                <div class="brand-green w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                   <img src="{{ asset('storage/icons/logo.png') }}">
                </div>
            </div>

            <h1 class="text-9xl font-extrabold text-slate-200 tracking-tight mb-4">
                @yield('code')
            </h1>
            
            <h2 class="text-2xl font-bold text-slate-800 mb-4 uppercase tracking-wide">
                @yield('title')
            </h2>
            
            <p class="text-slate-500 mb-8 text-lg">
                @yield('message')
            </p>

            <div class="space-y-4">
                <a href="{{ url('/') }}" class="brand-orange inline-block w-full py-3 px-6 text-white font-semibold rounded-lg shadow-md transition-all">
                    Return to Homepage
                </a>
                <button onclick="window.history.back()" class="block w-full text-sm text-slate-400 hover:text-purple-600 font-medium transition-colors">
                    &larr; Go Back to Previous Page
                </button>
            </div>
        </div>
    </div>
</body>
</html>