@extends('layouts.providers')

@section('content')

    <form action="{{ route('provider.enquiry.reply.store', $enquiry) }}" method="POST">
        @csrf
        <h3>Responding to: {{ $enquiry->room->provider->provider_name . " room no. " . $enquiry->room->room_number}}</h3>
        <p>Client Message: {{ $enquiry->message }}</p>
    
        <label>Your Response (Availability & Next Steps):</label>
        <textarea name="message" required placeholder="Tell them when it's free..."></textarea>
    
        <button type="submit">Send Response to Client</button>
    </form>
    
@endsection