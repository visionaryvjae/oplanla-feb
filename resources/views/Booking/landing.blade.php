@extends('Booking.landingPage')

@section('rooms')

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    }

    .container {
    width: 75%;
    margin: 0 auto;
    padding: 20px;
    }

    /* Header Section */
    .header {
    margin-bottom: 20px;
    }

    .header h2 {
    font-size: 24px;
    margin-bottom: 5px;
    }

    .header p {
    font-size: 16px;
    color: #666;
    }

    /* Cards Section */
    .cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    }

    .card {
    flex: 1 1 calc(33.33% - 20px); /* Adjusts spacing for 3 columns */
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
    }

    .card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    }

    .card h3 {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 10px;
    text-align: center;
    font-size: 20px;
    }

    /* Footer Section */
    .footer {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    }

    .footer-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    }

    .footer-card img {
    width: 40px;
    height: 40px;
    margin-bottom: 10px;
    }

    .footer-card p {
    font-size: 16px;
    color: #333;    
    }
</style>

<div class="container">
    {{-- <section style="display: flex; padding:1rem 0rem;">
      <h1 style="font-size: 1.25rem; line-height:2rem; color:#AD68E4; ">no plan, no problem!</h1>
    </section> --}}
    <!-- Header Section -->
    <section class="header">
      <h2>Trending destinations</h2>
      <p>Travelers searching for South Africa also booked these</p>
    </section>

    <!-- Cards Section -->
    <section class="cards">
        @php
            $cityName = ['Johannesburg', 'Cape Town', 'Mbombela', 'Durban', 'Pretoria']    
        @endphp

        @foreach(['johannesburg', 'cape-town', 'mbombela', 'durban', 'pretoria'] as $index => $city)
            <form method="GET" action="{{ route('handle-click') }}" class="card-form">
                @csrf <!-- Include CSRF token for Laravel security -->
                <input type="hidden" name="city" value="{{ $cityName[$index] }}"> <!-- Hidden input to send the city name -->
                <button type="submit" class="card" style="border: none; background: none; cursor: pointer;">
                    <img src="{{ asset("storage/images/$city.jpg") }}" alt="{{ $city }}">
                    <h3>{{ $cityName[$index] }}</h3>
                </button>
            </form>
        @endforeach
    </section>

    {{-- <!-- Footer Section -->
    <footer class="footer">
      <div class="footer-card">
        <img src="{{ asset('storage/images/book-now-icon.png') }}" alt="Book now icon">
        <p>Book now, pay at the property</p>
      </div>
      <div class="footer-card">
        <img src="{{ asset('storage/images/million-properties-icon.png') }}" alt="Million properties icon">
        <p>2+ million properties</p>
      </div>
      <div class="footer-card">
        <img src="{{ asset('storage/images/customer-service-icon.png') }}" alt="Customer service icon">
        <p>Trusted 24/7 customer service</p>
      </div>
    </footer> --}}
  </div>

@endsection