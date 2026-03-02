@extends('layouts.admin')

@section('content')

    <style>
        h1{
            font-size: 2rem; margin:1rem;
        }

        .main-container{
            display: flex;
            align-items: center;
            justify-content: flex-start;
            height: 100%;
            flex-direction: column;
        }

        .table{
            display: flex;
            border-radius: 0.125rem;
            align-items: center;
            justify-content: center;
            padding-bottom: 2rem;
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
            padding:0.5rem 1rem;
            background-color:rgb(30,110,200);
            color:#fff;
            border-radius: 0.25rem;
            margin: 0.25rem 0rem;
        }
        .btn-add:hover{
            opacity: 0.7;
        }
        .btn-change{
            display:flex;
            width:100%;
            align-items:center;
            justify-content:center;
            padding:0.5rem 1rem;
            background-color:rgb(75,75,75);
            color:#fff;
            border-radius: 0.25rem;
            margin: 0.25rem 0rem;
        }

        .table-header{
            border-right: solid #fff 1px; padding: 0.4rem 1rem;
        }

        .table-head-row{
            background-color: rgb(31 41 55);
            color: #fff;
        }

        .rows{
            border: solid #777 1px; padding: 0.4rem 1rem;
        }

        .data-rows:hover{
            background-color: #ddd;
            cursor: pointer;
        }

        .img-link{
            color: rgb(31,41,55); 
            margin-right: 0.3rem;
        }
        .img-link:hover{
            color: rgb(101,111,125);
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
        <div class="button-container">
            <a href="{{route('providers.create')}}"><button class="btn-add">add provider</button></a>
        </div>
        <table class="table">
            <tr class="table-head-row">
                <th class="table-header">Provider ID</th>
                <th class="table-header">Hotel Name</th>
                <th class="table-header">Address</th>
                <th class="table-header">Phone Number</th>
                <th class="table-header">Photos</th>
            </tr>

            @foreach ($providers as $provider)
                <tr class="data-rows" data-provider-id="{{$provider->id}}">
                    <td class="rows">{{$provider->id}}</td>
                    <td class="rows">{{$provider->provider_name}}</td>
                    <td class="rows" style="max-width:35rem;">{{$provider->booking_address}}</td>
                    <td class="rows">
                        @if ($provider->contacts->phone)
                            {{$provider->contacts->phone}}
                        @else
                            <div>
                                <a href="{{route('contact.create', $provider->id)}}"><button class="btn-change">add number</button></a>
                            </div>
                            {{-- rgb(200,40,30) --}}
                        @endif
                    </td>
                    <td class="rows">
                        <div class="flex flex-row items-center justify-center">
                            <a class="img-link" href="{{route('image.index', $provider->id)}}">images</a>
                            <img src="https://img.icons8.com/ios-glyphs/30/image.png" alt="" style="height: 22px; width:22px;">
                        </div>
                    </td>
                </tr>
            @endforeach

        </table>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Select all table rows
                const rows = document.querySelectorAll("table tr[data-provider-id]");

                // Add click event listener to each row
                rows.forEach(function (row) {
                    row.addEventListener("click", function () {
                        const providerId = this.getAttribute("data-provider-id");
                        window.location.href = `/admin/provider/${providerId}`;
                    });
                });
            });
        </script>
    </div>
@endsection