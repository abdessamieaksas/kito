<x-dashboard-layout>
    <div class="p-6 max-w-4xl mx-auto bg-white rounded-2xl shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Booking Details</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-700">Room Information</h3>
                    <p class="mt-1">Room Number: {{ $booking->room->room_number }}</p>
                    <p class="mt-1">Room Type: {{ ucfirst($booking->room->type) }}</p>
                    <p class="mt-1">Price per Night: ${{ number_format($booking->room->price, 2) }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-700">Booking Information</h3>
                    <p class="mt-1">Check-in: {{ $booking->check_in->format('M d, Y') }}</p>
                    <p class="mt-1">Check-out: {{ $booking->check_out->format('M d, Y') }}</p>
                    <p class="mt-1">Status: <span class="px-2 py-1 rounded-full text-sm {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">{{ ucfirst($booking->status) }}</span></p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Payment Information</h3>
                @if($booking->payments->count() > 0)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600">Total Paid: ${{ number_format($booking->payments->sum('amount'), 2) }}</p>
                    </div>
                @else
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <p class="text-yellow-700">No payments made yet</p>
                        <a href="{{ route('payments.create', $booking) }}" class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Make Payment</a>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('bookings.index') }}" class="inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Back to Bookings</a>
                @if($booking->status === 'pending')
                    <a href="{{ route('payments.create', $booking) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Make Payment</a>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout> 