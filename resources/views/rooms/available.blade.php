@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-red-600 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3m-8 9v6a2 2 0 002 2h8a2 2 0 002-2v-6"></path></svg>
            Search Available Rooms
        </h2>

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('rooms.available') }}" class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="check_in" class="block text-sm font-medium text-gray-700 mb-1">Check-in Date</label>
                    <input type="date" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" id="check_in" name="check_in" value="{{ request('check_in') }}" required>
                </div>
                <div>
                    <label for="check_out" class="block text-sm font-medium text-gray-700 mb-1">Check-out Date</label>
                    <input type="date" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" id="check_out" name="check_out" value="{{ request('check_out') }}" required>
                </div>
                <div>
                    <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                    <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" id="room_type" name="room_type">
                        <option value="">All Types</option>
                        <option value="standard" {{ request('room_type') == 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="deluxe" {{ request('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                        <option value="suite" {{ request('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">Search Rooms</button>
                    <a href="{{ route('rooms.available') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg shadow transition text-center">Reset</a>
                </div>
            </div>
        </form>

        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h3 class="text-xl font-semibold text-gray-800">Available Rooms</h3>
            <div class="text-sm text-gray-500">
                Showing <span class="font-bold">{{ $rooms->total() }}</span> room(s)
                @if(request('room_type')) of type <span class="font-bold capitalize">{{ request('room_type') }}</span>@endif
                @if(request('check_in') && request('check_out')) from <span class="font-bold">{{ request('check_in') }}</span> to <span class="font-bold">{{ request('check_out') }}</span>@endif
            </div>
        </div>
        @if($rooms->isEmpty())
            <div class="p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded text-center">
                No rooms available for the selected criteria.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-white border-2 border-red-200 rounded-xl shadow-lg hover:shadow-2xl transition overflow-hidden flex flex-col">
                        <img src="https://source.unsplash.com/400x200/?hotel,room,{{ $room->type }}" alt="Room Image" class="w-full h-40 object-cover">
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h5 class="text-lg font-bold text-black">Room {{ $room->room_number }}</h5>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-red-600 text-white capitalize">{{ $room->type }}</span>
                                </div>
                                <p class="text-gray-700 mb-4">
                                    <span class="block"><span class="font-semibold text-black">Type:</span> {{ ucfirst($room->type) }}</span>
                                    <span class="block"><span class="font-semibold text-black">Price:</span> <span class="text-red-600 font-bold">${{ number_format($room->price, 2) }}</span> <span class="text-xs text-gray-400">per night</span></span>
                                </p>
                            </div>
                            <div>
                                @auth
                                    <form action="{{ route('bookings.store') }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                        <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                                        <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                                        <input type="hidden" name="room_type" value="{{ $room->type }}">
                                        <button type="submit" class="w-full bg-red-600 hover:bg-black text-white font-semibold py-2 px-4 rounded-lg shadow transition flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                                            Book Now
                                        </button>
                                    </form>
                                @else
                                    <div class="p-2 bg-red-50 border border-red-200 text-red-700 rounded text-center">
                                        Please <a href="{{ route('login') }}" class="underline text-red-800 hover:text-black">login</a> to book this room.
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="mt-6">
            {{ $rooms->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection