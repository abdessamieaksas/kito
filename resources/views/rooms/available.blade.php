@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Search Available Rooms</div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('rooms.available') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="check_in">Check-in Date</label>
                                    <input type="date" class="form-control" id="check_in" name="check_in" 
                                           value="{{ request('check_in') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="check_out">Check-out Date</label>
                                    <input type="date" class="form-control" id="check_out" name="check_out" 
                                           value="{{ request('check_out') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="room_type">Room Type</label>
                                    <select class="form-control" id="room_type" name="room_type">
                                        <option value="">All Types</option>
                                        <option value="standard" {{ request('room_type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                        <option value="deluxe" {{ request('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                        <option value="suite" {{ request('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Search Rooms</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(request()->hasAny(['check_in', 'check_out', 'room_type']))
                        <h3>Available Rooms</h3>
                        @if($rooms->isEmpty())
                            <div class="alert alert-info">
                                No rooms available for the selected criteria.
                            </div>
                        @else
                            <div class="row">
                                @foreach($rooms as $room)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Room {{ $room->room_number }}</h5>
                                                <p class="card-text">
                                                    <strong>Type:</strong> {{ ucfirst($room->type) }}<br>
                                                    <strong>Price:</strong> ${{ number_format($room->price, 2) }} per night
                                                </p>
                                                @auth
                                                    <form action="{{ route('bookings.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                        <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                                                        <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                                                        <input type="hidden" name="room_type" value="{{ $room->type }}">
                                                        <button type="submit" class="btn btn-success">Book Now</button>
                                                    </form>
                                                @else
                                                    <div class="alert alert-warning">
                                                        Please <a href="{{ route('login') }}">login</a> to book this room.
                                                    </div>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif

                    <!-- Debug Information -->
                    @if(config('app.debug'))
                        <div class="mt-4">
                            <h4>Debug Information:</h4>
                            <pre>{{ print_r(request()->all(), true) }}</pre>
                            <pre>Rooms found: {{ $rooms->count() }}</pre>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 