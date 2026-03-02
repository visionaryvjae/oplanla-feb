<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to Payment Gateway...</title>
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: sans-serif; background-color: #f4f4f4; color: #333; text-align: center; }
        .container { padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { font-size: 1.5rem; margin-bottom: 1rem; }
        p { font-size: 1rem; color: #666; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #AD68E4; border-radius: 50%; width: 40px; height: 40px; animation: spin 2s linear infinite; margin: 1rem auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <h1>Redirecting to PayFast...</h1>
        <p>Please wait while we securely transfer you to the payment page.</p>
        <div class="loader"></div>
    </div>

    {{-- This form will be hidden and submitted automatically --}}
        @php
            // dd($formData);
        @endphp
    <form id="payfast-form" action="{{ $payfastUrl }}" method="post">
        @foreach($formData as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
    </form>

    <script type="text/javascript">
        // Auto-submit the form as soon as the page loads
        window.onload = function() {
            document.getElementById('payfast-form').submit();
        };
    </script>
</body>
</html>
