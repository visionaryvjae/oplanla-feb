@extends('layouts.app')

@section('content')

    <style>
        /* General Body and Font Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            color: #1f2937;
        }

        /* Main Container and Layout */
        .container {
            max-width: 42rem; /* 672px */
            margin-left: auto;
            margin-right: auto;
            padding: 3rem 1rem;
        }

        /* Header Styles */
        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        .page-header h1 {
            font-size: 2.25rem; /* 36px */
            font-weight: 700;
            color: #111827;
        }
        .page-header p {
            margin-top: 0.5rem;
            font-size: 1.125rem; /* 18px */
            color: #4b5563;
        }
        .page-header .booking-name {
            font-weight: 600;
        }
        
        /* Form Container */
        .form-container {
            background-color: #ffffff;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            border-radius: 0.75rem; /* 12px */
            padding: 2rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-group-left {
             margin-bottom: 1.5rem;
             text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 1.125rem; /* 18px */
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        textarea.form-control {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem; /* 6px */
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            padding: 0.5rem 0.75rem;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        textarea.form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        /* Star Rating Styles */
        .star-rating {
            display: flex;
            justify-content: center;
            flex-direction: row-reverse;
        }
        .star-rating input { display: none; }
        .star-rating label {
            font-size: 2.5rem;
            color: #d1d5db; /* gray-300 */
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
        /* Hover and checked states for stars */
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f59e0b; /* amber-500 */
        }

        /* Submit Button */
        .submit-button {
            width: 100%;
            background-color: #ad68e4; /* blue-600 */
            color: #ffffff;
            font-weight: 700;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem; /* 8px */
            border: none;
            font-size: 1.125rem; /* 18px */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-button:hover {
            background-color: #5c367a; /* blue-700 */
        }

    </style>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

    <div class="container">
        <header class="page-header">
            <h1>Share Your Experience</h1>
            <p>Reviewing your stay at <span class="booking-name">{{ $booking->provider_name }}</span></p>
        </header>

        <div class="form-container">
            <form action="{{ route('review.store') }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                @csrf
                <input type="hidden" name="bookings_id" value="{{ $booking->id }}">
                <input type="hidden" name="providers_id" value="{{ $booking->provider_id }}">
                <input type="hidden" name="rating" x-bind:value="rating">
                    
                <!-- Star Rating -->
                <div class="form-group">
                    <h2>Your overall rating</h2>
                    <div class="star-rating">
                        <template x-for="star in [5, 4, 3, 2, 1]" :key="star">
                            <div>
                                <input type="radio" :id="'star' + star" name="star_rating" :value="star" @click="rating = star">
                                <label :for="'star' + star" title="star + ' stars'" 
                                        :style="(hoverRating >= star || rating >= star) ? {color: '#68e4ad'} : {}"
                                        @mouseover="hoverRating = star"
                                        @mouseleave="hoverRating = 0">★</label>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Comment -->
                <div class="form-group-left">
                    <label for="comment">Your review</label>
                    <textarea id="comment" name="comment" rows="5" class="form-control" placeholder="Tell us about your experience..."></textarea>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="submit-button">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection