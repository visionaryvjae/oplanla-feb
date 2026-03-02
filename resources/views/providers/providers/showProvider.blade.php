@extends('layouts.admin')

@section('content')

<script>
    // Function to get the provider ID from the URL
            function getproviderIdFromUrlEdit() {
                const url = window.location.href; // Get the current URL
                // Match the provider ID pattern: /providers/{id} where {id} is one or more digits
                const provideridMatch = url.match(/admin\/provider\/(\d+)/);
                if (provideridMatch && provideridMatch[1]) {
                    let providerId = parseInt(provideridMatch[1], 10); // Extract and parse the provider ID

                    const editButtonLink = document.querySelector('.btn-edit').closest('a');
                    if (editButtonLink) {
                        // Dynamically generate the route using the provider ID
                        editButtonLink.href = "{{ route('providers.edit', '__provider_ID__') }}".replace('__provider_ID__', providerId);
                        console.log("Updated Edit button href:", editButtonLink.href);
                    }
                }
            }

            function getproviderIdFromUrlDelete() {
                const url = window.location.href; // Get the current URL
                // Match the provider ID pattern: /providers/{id} where {id} is one or more digits
                const provideridMatch = url.match(/admin\/provider\/(\d+)/);
                if (provideridMatch && provideridMatch[1]) {
                    let providerId = parseInt(provideridMatch[1], 10); // Extract and parse the provider ID

                    const editButtonLink = document.querySelector('.btn-delete').closest('form');
                    if (editButtonLink) {
                        // Dynamically generate the route using the provider ID
                        editButtonLink.action = "{{ route('providers.delete', '__provider_ID__') }}".replace('__provider_ID__', providerId);
                        console.log("Updated Edit button href:", editButtonLink.href);
                    }
                }
            }
</script>

<style>
    .main-container{
        display:flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width:100%;
        height:100%;
        padding:3rem 0rem;
    }

    .title-container{
       display: flex;
        flex-direction: column;
        justify-content:flex-end;
        max-width: 70rem;
        width: 100%;
        padding:1rem 0.2rem;
    }

    .title{
        font-size: 2rem;
        font-weight:bold;
    }

    .address-container{
        display: flex; 
        margin-top:0.2rem; 
        flex-direction:row;
    }

    .location-img{
        height:20px; 
        width:20px; 
        margin-right:0.2rem 
    }

    .below-title{
        display:flex;
        width: 100%;
        max-width: 70rem;
        flex-direction: column; 
        align-items: flex-start; 
        justify-content: center;
        border-radius: 0.125rem;
    }

    .btn-submit{
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius: 0.25rem;
        padding:0.125rem 0.5rem;
        background-color:rgb(30,110,200);
        color:#fff;
        margin: 0 0.25rem;
    }
    .btn:hover{
        opacity: 0.7;
    }

    .content-container{

    }

    h2{
        font-size:1.3rem;
        font-weight:bold;
        padding-top:1rem;
        padding-bottom:0.5rem;
    }

    h3{
        font-size:1rem;
        font-weight:900;
        padding-top:1rem;
        padding-bottom:0.5rem;
        padding-left: 1rem;
    }

    .title-div{
        display: flex;
        width: 100%;
        align-items: center;
    }
    .title-div-container{
        display: flex;
        flex-direction: row;
        width: 100%;
    }

    .btn-edit{
        display:flex;
        align-items:center;
        justify-content:center;
        padding:0.5rem 2rem;
        background-color:rgb(30,110,50);
        color:#fff;
        margin: 0rem 0.125rem;
        border-radius: 0.3rem;
    }

    .btn-delete{
        display:flex;
        align-items:center;
        justify-content:center;
        padding:0.5rem 2rem;
        background-color:rgb(170,50,20);
        color:#fff;
        margin: 0rem 0.125rem;
        border-radius: 0.3rem;
    }

    .table-container{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        width: 100%;
    }

    .review-container{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        margin: 2rem 0rem;
    }

    .table{
        display: flex;
        width: 100%;
        border-radius: 0.125rem;
        align-items: center;
        justify-content: center;
        border-radius: 0.3rem;
    }

    .table-header{
        border-right: solid #fff 1px; padding: 0.4rem 1rem;
    }

    .table-head-row{
        background-color: rgb(31 41 55);
        color: #fff;
        padding: 0 0.7rem;
    }

    .rows{
        border: solid #000 0.2px; padding: 0.2rem 0.7rem;
    }

    .data-rows:hover{
        background-color: #ddd;
        cursor: pointer;
    }

    .arrow-container{
        display: flex; width:100%; padding:1rem 2rem;
    }

    .arrow{
        height: 3rem; width:3rem;
        padding: 0.5rem;
    }
    .arrow:hover{
        background-color: rgb(0,0,0, 0.2);
    }

    .contact-div{
        display:flex; 
        height: wrap; 
        width: 100%; 
        flex-direction: column; 
        align-items: flex-start; 
        justify-content: flex-start;
        border: solid rgb(75, 75, 75) 1px;
        border-radius: 1rem;
        padding: 1rem 2rem;
    }

    .contact{
        display: flex; 
        flex-direction: column;
        align-items: flex-start;
        width: 100%;    
        padding: 1rem 0.5rem;
    }

    .button-container{
        display: flex;
        justify-content: flex-end;
        width: 100%;
        padding: 0.2rem 0.4rem;
    }

    .review{
        display:flex;
        flex-direction:column;
        padding:1rem 2rem;
        width:100%;
        align-items:flex-start;
        justify-content:center;
        background-color:#ddd;
        border-radius: 0.3rem;
        margin:1rem 0rem;
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

    <div class="arrow-container" style="display: flex; width:100%; padding:1rem 2rem;">
        <a href="{{route('providers.index')}}"><img class="arrow" src="https://img.icons8.com/ios/50/back.png" alt=""></a>
    </div>
    <div class="main-container">
        <div class="title-container">
            <div class="title-div-container">
                <div class="title-div left"><h1 class="title">{{$provider->provider_name}}</h1></div>
                <div class="title-div"></div>
                <div class="title-div right">
                    <a href=""><button class="btn btn-edit" onclick="getproviderIdFromUrlEdit({{$providerId}})">Edit</button></a>
                    <form action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="getproviderIdFromUrlDelete({{$providerId}})">Delete</button>
                    </form>
                </div>
            </div>
            <div class="address-container">
                <img class="location-img" src="https://img.icons8.com/color/48/marker--v1.png" alt="">
                <p>{{$provider->booking_address}}</p>
            </div>
        </div>
        <div class="below-title">
            <div class="table-container">
                <h2>Rooms</h2>
                <table class="table">
                    <tr class="table-header">
                        <th class="table-head-row" style="border-radius: 5px 0px 0px 0px;">Room Id</th>
                        <th class="table-head-row">Room Number</th>
                        <th class="table-head-row">Price</th>
                        <th class="table-head-row">Number of Guests</th>
                        <th class="table-head-row" style="border-radius: 0px 5px 0px 0px;">Availability</th>
                    </tr>
                    
                    @foreach ($rooms as $room)
                        <tr class="data-rows" data-room-id="{{$room->id}}">
                            <td class="rows">{{$room->id}}</td>
                            <td class="rows">{{$room->room_number}}</td>
                            <td class="rows">{{$room->price}}</td>
                            <td class="rows">{{$room->num_people}}</td>
                            <td class="rows">
                                @if ($room->available)
                                    Available
                                @else
                                    Not Available
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="button-container" style="justify-content:center;">
                    <a href="{{route('admin.rooms.create.single', $providerId)}}"><button class="btn btn-submit">+</button></a>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Select all table rows
                        const rows = document.querySelectorAll("table tr[data-room-id]");

                        // Add click event listener to each row
                        rows.forEach(function (row) {
                            row.addEventListener("click", function () {
                                const roomId = this.getAttribute("data-room-id");
                                window.location.href = `/admin/room/${roomId}`;
                            });
                        });
                    });
                </script>
            </div>
            <div class="table-container" style="padding:1rem 0">
                <h2>Contact Information</h2>
                <div class="table">
                    <div class="contact-div">
                        <div class="contact">
                            <h3>Phone Number</h3>
                            <div style="display:flex; width:100%; padding:0.5rem 1rem;">
                                @if ($provider->phone)
                                    <p>{{$provider->phone}}</p>
                                @else
                                    <p>no Phone number</p>
                                @endif
                            </div>
                        </div>
                        <div class="contact">
                            <h3>Email</h3>
                            <div style="display:flex; width:100%; padding:0.5rem 1rem;">
                                @if ($provider->email)
                                    <p>{{$provider->email}}</p>
                                @else
                                    <p>no Email address</p>
                                @endif
                            </div>
                        </div>
                        <div style="display: flex; ">
                            @if ($provider->contact_id)
                                <a href="{{route('contact.edit', [$providerId, $provider->contact_id])}}" ><button class="btn btn-submit" style="background-color: rgb(30,110,50); padding:0.5rem 2rem;">Edit</button></a>
                                <form action="{{route('contact.delete', [$providerId, $provider->contact_id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-submit" style="background-color: rgb(170,50,20); padding:0.5rem 2rem;">Delete</button>
                                </form>
                            @else
                                <a href="{{route('contact.create', $providerId)}}" ><button class="btn btn-submit">Add Contact Details</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-sidebar">
                <h2>Reviews</h2>
                <div class="reviews-container">
                    @php
                        $ratings = explode(',', $provider->ratings);
                        $reviews = explode(',', $provider->reviews);
                        $users = explode(',', $provider->usernames);
                        $display = explode(',', $provider->avatars);
                    @endphp
                    @foreach ($ratings as $index => $rating)
                        <div class="review">
                            <div class="flex items-center justify-start mb-2">
                                <div class="rounded-full" style="height:30px; width:30px; overflow:hidden;">
                                    <img style="object-fit:fill; width:100%; height:100%;" src="{{ asset('storage/avatars/' . $display[$index]) }}" alt="https://placehold.co/256x256/3b82f6/FFFFFF?text={{ substr($users[$index], 0, 1) }}">
                                </div>
                                <p style="margin:0rem 0.5rem;">{{ $users[$index] }}</p>
                            </div>
                            <span style="font-size: 1rem;  padding:0rem 0.5rem; margin-bottom:0.75rem; color:rgb(0, 0, 0)">
                                @for ($i = 0; $i < $rating; $i++)
                                    ★
                                @endfor
                            </span>
                            <div>
                                {{ $reviews[$index] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection