@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Create New Booking</h2>

                @if($availableRooms->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    No rooms are currently available. Please check back later.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
                                <select name="room_type" id="room_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-red focus:border-primary-red sm:text-sm rounded-md">
                                    <option value="">Select a room type</option>
                                    @foreach($availableRooms->unique('type') as $room)
                                        <option value="{{ $room->type }}">{{ ucfirst($room->type) }}</option>
                                    @endforeach
                                </select>
                                @error('room_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="check_in" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in" class="mt-1 focus:ring-primary-red focus:border-primary-red block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('check_in')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="check_out" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out" class="mt-1 focus:ring-primary-red focus:border-primary-red block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('check_out')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-red hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-red">
                                Create Booking
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 