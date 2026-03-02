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

    <div style="margin-bottom: 2rem; width:100%; max-width:67rem; align-items:flex-start;">
        <h1 class="text-gray-900" style="text-align: left; font-size:2.25rem; font-weight:bolder;">{{ $pagetitle }}</h1>
    </div>
    {{-- seached rooms form --}}
    <div class="rooms-display grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6" >
        @if($rooms->count() > 0)
            @foreach ($rooms as $room)
                @php
                    $images =  explode(',', $room->images);
                    $firstImage = $images[0];
    
                    $roundedRating = round($room->rating * 2) / 2;
                @endphp
                <div data-room-id="{{$room->id}}" class="room-card bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 flex flex-col" 
                    style="
                        max-width:30rem;
                        border-radius: 0.5rem;
                        overflow: hidden;
                        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    
                    "
                >
                    <img src="{{ asset('storage/images/' . $firstImage) }}" class="h-48 object-cover" alt="Room Image" style="max-height:10rem; object-fit:fill">
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800 truncate">{{$room->provider_name}}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{$room->num_people}} Guests • 1 Bedroom • 1 Bath</p>
                            <div class="flex items-center mt-2">
                                <span class="text-yellow-500 flex">
                                    @if ($room->rating)
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $roundedRating)
                                                {{-- Full Star --}}
                                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.125rem; height:1.125rem; color: #68e4ad;">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @elseif ($i - 0.5 == $roundedRating)
                                                {{-- Half Star --}}
                                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.125rem; height:1.125rem; color: #68e4ad;">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0v15z"/>
                                                </svg>
                                            @else
                                                {{-- Empty Star --}}
                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" style="width:1.125rem; height:1.125rem; color: rgb(209 213 219 / var(--tw-text-opacity, 1));">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    @else
                                        <p class="text-xs text-gray-500 ml-2">not reviewed yet</p>
                                    @endif
                                </span>
                                <span class="text-xs text-gray-500 ml-2">({{ $room->num_reviews }} reviews)</span>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col md:flex-row lg:flex-row justify-between items-center">
                            <p class="text-xl font-bold text-gray-900">ZAR {{$room->price}} <span class="text-sm font-normal text-gray-500">/ night</span></p>
                            <a href="{{ route('room.show', $room->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-black rounded-lg hover:bg-gray-800">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="display:flex; align-items:flex-start; justify-content:center; width:100%;">
                <h1 style="font-size:3rem; line-height: 3rem; font-weight: bolder; color: #666;">No rooms found</h1>
            </div>
        @endif
    </div>
    <!-- Pagination Links -->
    <div class="pagination-links">
        {!! $rooms->links() !!}
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/searchedRooms.css') }}">
    @endpush

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Select all table rows
            const rows = document.querySelectorAll(" div[data-room-id]");

            // Add click event listener to each row
            rows.forEach(function (row) {
                row.addEventListener("click", function () {
                    const roomId = this.getAttribute("data-room-id");
                    window.location.href = `/booking/room/${roomId}`;
                });
            });
        });
    </script>
@endsection