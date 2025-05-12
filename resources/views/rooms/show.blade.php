<x-dashboard-layout>
    <div class="p-6 max-w-4xl mx-auto bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Room Details: {{ $room->room_number }}</h2>
            <a href="{{ route('rooms.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to Rooms
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Room Image -->
            <div>
                <img src="{{ $room->image_url }}" alt="Room {{ $room->room_number }}" class="w-full h-auto rounded-lg shadow">
            </div>

            <!-- Room Details -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-700">Room Information</h3>
                    <div class="mt-2 border-t border-gray-200 pt-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-sm font-medium text-gray-500">Room Number</div>
                            <div class="text-sm text-gray-900">{{ $room->room_number }}</div>

                            <div class="text-sm font-medium text-gray-500">Type</div>
                            <div class="text-sm text-gray-900">{{ ucfirst($room->type) }}</div>

                            <div class="text-sm font-medium text-gray-500">Price per Night</div>
                            <div class="text-sm text-gray-900">${{ number_format($room->price, 2) }}</div>

                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : ($room->status === 'booked' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </div>

                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-sm text-gray-900">{{ $room->created_at->format('M d, Y') }}</div>

                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div class="text-sm text-gray-900">{{ $room->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6">
                    <a href="{{ route('rooms.edit', $room) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Edit Room
                    </a>
                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            Delete Room
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($room->bookings->count() > 0)
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-700 mb-3">Booking History</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($room->bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->check_in->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $booking->check_out->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</x-dashboard-layout> 