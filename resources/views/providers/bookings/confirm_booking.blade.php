@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')

<style>

    .container{
        display:flex;
        flex-direction: column;
        margin: auto;
        margin-top: 2rem;
        padding: 0 5rem;
    }

    .page-heading{
        font-size: 1.5rem;
        line-height: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .cancel-btn{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        margin-left: 0.5rem; color: rgb(75 85 99); padding:0 0.5rem;
    }
    .cancel-btn:hover{
        color: rgb(31 41 55);
        text-decoration-line: underline;
    }

    .cfrm-btn{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        background-color: #AD68E4; color:#fff; font-weight:bold; padding: 0.5rem 1rem; border-radius: 0.5rem;
    }
    .cfrm-btn:hover{
        background-color:#683b8d;
    }
</style>

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
            
            
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h1 class="page-heading">Confirm Your Booking</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Selected Rooms</h2>

        @if(count($rooms) > 0)
            <form action="{{ route('room.booking.store') }}" method="POST" class="form">
                @csrf
                <input type="hidden" name="check_in_time" value="{{ $check_in_time }}">
                <input type="hidden" name="check_out_time" value="{{ $check_out_time }}">

                <table class="min-w-auto bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Accommodation Type</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Guests</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nights</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Price</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm"></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @php
                            $totalPrice = 0;

                            $date1 = new DateTime($check_in_time);
                            $date2 = new DateTime($check_out_time);

                            $interval = $date1->diff($date2);
                            $daysBetween = $interval->days;

                            if($daysBetween < 1){
                                $daysBetween = 1;
                            }
                        @endphp
                        @foreach($rooms as $index => $room)
                            <tr>
                                <td class="text-left py-3 px-4">{{ $room->room_type }}</td>
                                <input type="hidden" name="room_types[]" id="room_types" value="{{ $room->room_type }}">
                                <td class="text-left py-3 px-4">{{ $room->num_people }}</td>
                                <td class="text-left py-3 px-4">{{ $daysBetween }}</td>
                                <td class="text-left py-3 px-4">ZAR {{ $room->price }} p/night</td>
                                <td class="text-left py-3 px-4"> X {{$num_rooms[$index]}}</td>
                                <input type="hidden" name="room_ids[]" id="room_ids" value="{{ $room->id }}">
                                <input type="hidden" name="num_rooms[]" id="num_rooms" value="{{ $num_rooms[$index] }}">
                            </tr>
                            @php
                                

                                $roomsPrice = $room->price * $daysBetween * $num_rooms[$index];
                                $totalPrice = $totalPrice + $roomsPrice;
                            @endphp
                        @endforeach
                        <input type="hidden" name="booking_price" id="booking_price" value="{{ $totalPrice }}">
                        <tr style="border-top: solid rgb(75 85 99) 2px;">
                            <td class="text-left py-3 px-4">Total Price</td>
                            <td class="text-left py-3 px-4"></td>
                            <td class="text-left py-3 px-4">ZAR {{ $totalPrice }}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 1.5rem;">
                    <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($check_in_time)->format('F j, Y, g:i a') }}</p>
                    <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($check_out_time)->format('F j, Y, g:i a') }}</p>
                    <input type="hidden" name="pid" value="{{ $providerId }}">
                </div>

                <div style="display:flex; margin-top: 1.5rem;">
                    <button 
                        type="submit" 
                        class="cfrm-btn"
                    >
                        <p>Confirm and Book</p>
                    </button>
                    <a href="{{ route('room.booking') }}"  class="cancel-btn">
                        cancel
                    </a>
                </div>
            </form>
        @else
            <p>You have not selected any rooms.</p>
            <a href="{{ route('booking.back') }}" class="text-blue-500 hover:text-blue-700">Go back to select rooms</a>
        @endif
    </div>
</div>
@endsection
