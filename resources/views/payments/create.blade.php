@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment for Booking #{{ $booking->id }}</h2>

            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-700 mb-2">Booking Details</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p><strong>Room:</strong> {{ $booking->room->room_number }} ({{ ucfirst($booking->room->type) }})</p>
                    <p><strong>Check-in:</strong> {{ $booking->check_in->format('M d, Y') }}</p>
                    <p><strong>Check-out:</strong> {{ $booking->check_out->format('M d, Y') }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>

            <form action="{{ route('payments.store', $booking) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" step="0.01" name="amount" id="amount" 
                           value="{{ $totalAmount }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring-primary-red"
                           readonly>
                </div>

                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select name="payment_method" id="payment_method" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring-primary-red">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="online">Online</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date" 
                           value="{{ date('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring-primary-red">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('bookings.show', $booking) }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-primary-red text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Complete Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 