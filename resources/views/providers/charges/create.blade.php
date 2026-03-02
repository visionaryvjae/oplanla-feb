@extends('layouts.providers')

@section('content')
    <form action="{{ route('provider.charges.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Select Room</label>
            <select name="room_id" class="form-control" required>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">Room no.{{ $room->room_number }} - #ID {{$room->id}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="description" class="form-control" placeholder="e.g. Manual Water Adjustment" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Amount (R)</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Type</label>
                <select name="type" class="form-control">
                    <option value="utility">Utility</option>
                    <option value="rent">Rent</option>
                    <option value="penalty">Penalty</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Save Charge</button>
    </form>
@endsection