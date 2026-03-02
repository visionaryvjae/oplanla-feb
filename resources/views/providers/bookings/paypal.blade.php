@extends('layouts.app')

@section('content')
    <h1>Booking Confirmation</h1>
    <p><strong>Service:</strong> {{ $booking->service_name }}</p>
    <p><strong>Price:</strong> ${{ number_format($booking->price, 2) }}</p>

    <div id="paypal-status" style="margin-top:20px;"></div>
    <div id="paypal-button-container" style="max-width: 500px;"></div>

    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>

    <script>
        const bookingId = "{{ $booking->id }}";
        const createUrl = "{{ route('paypal.create', $booking->id) }}";
        const captureUrl = "{{ route('paypal.capture') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const paypalStatusDiv = document.getElementById('paypal-status');

        // 2. Render the PayPal buttons
        paypal.Buttons({
            // 3. Call your server to set up the transaction
            createOrder: function(data, actions) {
                paypalStatusDiv.innerHTML = 'Connecting to PayPal...';
                return fetch(createUrl, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    console.log('Order Data:', orderData);
                    paypalStatusDiv.innerHTML = 'Please complete the payment in the pop-up window.';
                    return orderData.id; // The id of the order
                });
            },

            // 4. Call your server to finalize the transaction
            onApprove: function(data, actions) {
                paypalStatusDiv.innerHTML = 'Processing your payment... Please wait.';
                return fetch(captureUrl, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        orderId: data.orderID
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];

                    // Show a success message to the buyer
                    paypalStatusDiv.innerHTML = `
                        <h3 style="color: green;">Payment Successful!</h3>
                        <p>Thank you for your payment. Your booking is confirmed.</p>
                        <p>Transaction ID: ${transaction.id}</p>
                    `;

                    // Hide the PayPal buttons
                    document.getElementById('paypal-button-container').innerHTML = '';
                });
            },

            // Optional: Handle payment cancellation
            onCancel: function(data) {
                paypalStatusDiv.innerHTML = `<p style="color:orange;">You cancelled the payment.</p>`;
            },

            // Optional: Handle errors
            onError: function(err) {
                console.error('An error occurred during the transaction', err);
                paypalStatusDiv.innerHTML = `<p style="color:red;">An error occurred. Please try again.</p>`;
            }

        }).render('#paypal-button-container');
    </script>
@endsection