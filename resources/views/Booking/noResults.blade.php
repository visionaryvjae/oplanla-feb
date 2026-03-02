@extends('Booking.landingPage')

@section('rooms')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div style="display:flex; align-items:center; justify-content:center; margin-bottom: 2rem; width:100%; max-width:67rem; align-items:flex-start;">
        <h1 class="heading text-gray-600" style="text-align: left;font-size: 2.5rem; margin:1rem;font-weight: 700;">No results found</h1>
    </div>
@endsection