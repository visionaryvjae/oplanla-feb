@extends('layouts.app')

@section('content')

    <style>
        h1{
            font-size: 2.5rem; margin:1rem;font-weight: bolder;
        }

        .main-container{
            display:flex;
            align-items: flex-start;
            justify-content: center;
            width:100%;
            height:auto;
            padding-left: 13rem;
            padding-right: 13rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .table{
            display: flex;
            border-radius: 0.125rem;
            align-items: center;
            justify-content: center;
        }

        .button-container{
            display: flex;
            justify-content: flex-end;
            width: 100%;
            padding: 0.2rem 0.4rem;
        }

        .btn-add{
            display:flex;
            width:100%;
            align-items:center;
            justify-content:center;
            padding:0.5rem 2rem;
            background-color:rgb(30,110,200);
            color:#fff;
            border-radius: 0.25rem;
            margin: 0.25rem 0rem;
        }

        .btn-add:hover{
            opacity: 0.7;
        }

        .table-header{
            border-right: solid #fff 1px; padding: 0.4rem 1rem;
        }

        .table-head-row{
            background-color: rgb(31 41 55);
            color: #fff;
        }

        .rows{
            border-right: solid #000 1px; padding: 0.4rem 1rem;
        }

        .data-rows:hover{
            background-color: #ddd;
            cursor: pointer;
        }

        .side-bar{
            display: flex;
            height: 100vh;
            width: 100%;
            flex: 3;
            border: solid #555 1px;
            border-radius: 0.5rem;
            margin: 0 1rem;
        }

        .providers-container{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: 100%;
            width: 100%;
            flex: 8;
        }

        .providers-display{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            width: 100%;
            height: auto;
        }

        .provider-card{
            display: flex;
            height: 16.5rem;
            width: 100%;
            flex: 8;
            border-radius: 0.5rem;
            border:solid #aaa 1px;
            padding: 1rem;
            margin: 0.5rem 0;
        }

        .title-container{
            display: flex;
            width: 100%;
            padding: 1rem;
        }

        .title{
            font-size: 2rem;
            font-weight: bold;
        }

        .card-img{
            display: flex;
            flex: 2.5;
            width: 100%;
            height: 100%;
            align-items: center;
            padding-right: 1.3rem;
            justify-content: center;
        }
        .provider-info{
            display: flex;
            flex: 3.5;
            flex-direction: column;
            padding-right:1rem;
            width: 100%;
            height: 100%;
            align-items: flex-start;
            justify-content: flex-start;
        }
        .reviews{
            display: flex;
            flex: 2;
            flex-direction: column;
            width: 100%;
            height: 100%;
            align-items: flex-start;
            justify-content: flex-start;
        }

        .provider-img{
            height: 100%;
            border-radius: 0.5rem;

        }

        .provider-title{
            font-size: 1.5rem;
            font-weight: 900;
        }

        .below-name{
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

        .location-div{
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            width: 100%;
            padding: 0.5rem 0;
            color: rgb(80, 80, 232);
            text-decoration-line: underline;
        }
        .provider-type{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            width: 100%;
            padding: 0.5rem 0;
            font-weight: 900;
            font-size: 1rem;
        }

        .review-score{
            display: flex;
            flex: 1;
            height: 100%;
            width: 100%;
            justify-content: center;    
            font-weight: 500;
            padding: 0.3rem 0;
        }
        .provider-price{
            display: flex;
            flex: 1;
            height: 100%;
            width: 100%;
            align-items: center;
            justify-content: space-around;
            font-weight: 500;
            padding: 0 3rem;
        }
        .provider-available{
            display: flex;
            flex: 1;
            height: 100%;
            width: 100%;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            padding: 0.3rem 0;
        }

        .btn{
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .btn:hover{
            opacity: 0.7;
        }

        .btn-available{
            padding: 0.45rem 0.7rem;
            background-color:rgb(30,110,200);
            color:#fff;
            border-radius: 0.3rem;
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

    <h1>{{$pagetitle}}</h1>
    <div class="main-container">
        
        <div class="side-bar">

        </div>
        <div class="providers-container">
            <div class="title-container">
                <h2 class="title">Search Result</h2>
            </div>
            <div class="providers-display">
                @foreach ($providers as $provider)
                    <div class="provider-card" data-provider-id="{{$provider->id}}">
                        <div class="card-img">
                            @php
                                $images =  explode(',', $provider->images);
                                $firstImage = $images[0];
                            @endphp
                            <img 
                                class="provider-img" 
                                src="{{asset('storage/images/' . $firstImage)}}" {{-- https://images.unsplash.com/photo-1611892440504-42a792e24d32?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aG90ZWwlMjByb29tfGVufDB8fDB8fHww --}} 
                                alt=""
                            >
                        </div>
                        <div class="provider-info">
                            <h2 class="provider-title">{{$provider->provider_name}}</h2>
                            <div class="below-name">
                                <div class="location-div">{{$provider->booking_address}}</div>
                                <div class="provider-type">
                                    provider type

                                </div>
                            </div>
                        </div>
                        <div class="reviews">
                            <div class="review-score">
                                Review

                            </div>
                            <div class="provider-price">
                                <p>ZAR</p>
                                <p>{{$provider->price}}</p>
                            </div>
                            <div class="provider-available">
                                <button class="btn btn-available">See Availability</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Select all table rows
                const rows = document.querySelectorAll(" div[data-provider-id]");

                // Add click event listener to each row
                rows.forEach(function (row) {
                    row.addEventListener("click", function () {
                        const providerId = this.getAttribute("data-provider-id");
                        window.location.href = `/booking/provider/${providerId}`;
                    });
                });
            });
        </script>
        
    </div>
@endsection