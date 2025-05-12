@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100">
        <div class="border-b border-gray-100 px-6 py-4 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Payment for Booking #{{ $booking->id }}</h2>
        </div>
        
        <div class="p-6">
            <!-- Booking Details -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Booking Details
                </h3>
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="mb-3">
                                <span class="text-gray-500 text-sm font-medium">Room:</span>
                                <span class="block text-gray-800 font-semibold">{{ $booking->room->room_number }} ({{ ucfirst($booking->room->type) }})</span>
                            </p>
                            <p class="mb-3">
                                <span class="text-gray-500 text-sm font-medium">Check-in:</span>
                                <span class="block text-gray-800 font-semibold">{{ $booking->check_in->format('M d, Y') }}</span>
                            </p>
                        </div>
                        <div>
                            <p class="mb-3">
                                <span class="text-gray-500 text-sm font-medium">Check-out:</span>
                                <span class="block text-gray-800 font-semibold">{{ $booking->check_out->format('M d, Y') }}</span>
                            </p>
                            <p>
                                <span class="text-gray-500 text-sm font-medium">Total Amount:</span>
                                <span class="block text-gray-800 font-bold text-lg">${{ number_format($totalAmount, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form -->
            <form action="{{ route('payments.store', $booking) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                            Payment Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="amount" id="amount"
                                        value="{{ $totalAmount }}"
                                        class="pl-7 mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-primary-red focus:ring focus:ring-primary-red focus:ring-opacity-20 transition-all"
                                        readonly>
                                </div>
                            </div>
                            
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date"
                                    value="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring focus:ring-primary-red focus:ring-opacity-20 transition-all">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <div class="grid grid-cols-3 gap-4 mt-2">
                                    <div>
                                        <input type="radio" name="payment_method" id="payment_cash" value="cash" class="hidden peer" checked>
                                        <label for="payment_cash" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg cursor-pointer peer-checked:border-primary-red peer-checked:bg-red-50 hover:bg-gray-50 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 peer-checked:text-primary-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                            <span class="font-medium text-gray-700 peer-checked:text-primary-red">Cash</span>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="radio" name="payment_method" id="payment_card" value="card" class="hidden peer">
                                        <label for="payment_card" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg cursor-pointer peer-checked:border-primary-red peer-checked:bg-red-50 hover:bg-gray-50 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 peer-checked:text-primary-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span class="font-medium text-gray-700 peer-checked:text-primary-red">Card</span>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="radio" name="payment_method" id="payment_online" value="online" class="hidden peer">
                                        <label for="payment_online" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg cursor-pointer peer-checked:border-primary-red peer-checked:bg-red-50 hover:bg-gray-50 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 peer-checked:text-primary-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                            <span class="font-medium text-gray-700 peer-checked:text-primary-red">Online</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Details Section (conditionally shown) -->
                    <div id="card-details-section" class="bg-gray-50 p-5 rounded-lg border border-gray-100 hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Card Details
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring focus:ring-primary-red focus:ring-opacity-20 transition-all">
                            </div>
                            
                            <div>
                                <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                                <input type="text" name="card_name" id="card_name" placeholder="John Doe"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring focus:ring-primary-red focus:ring-opacity-20 transition-all">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                    <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/YY"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring focus:ring-primary-red focus:ring-opacity-20 transition-all">
                                </div>
                                
                                <div>
                                    <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                    <input type="text" name="card_cvv" id="card_cvv" placeholder="123"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-red focus:ring focus:ring-primary-red focus:ring-opacity-20 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <!-- Payment Summary -->
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-5 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Payment Summary
                            </h3>
                            <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">Secure Payment</span>
                        </div>
                        
                        <div class="border-t border-b border-blue-100 py-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Room Charges:</span>
                                <span class="text-gray-800 font-medium">${{ number_format($totalAmount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Tax:</span>
                                <span class="text-gray-800 font-medium">Included</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-800 font-bold">Total Amount:</span>
                            <span class="text-xl font-bold text-blue-700">${{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row md:justify-between gap-4">
                        <div class="order-2 md:order-1">
                            <a href="{{ route('bookings.show', $booking) }}"
                                class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-red transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </a>
                        </div>
                        
                        <div class="order-1 md:order-2 flex gap-3">
                            <button type="submit" name="action" value="save"
                                class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-red transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Save Only
                            </button>
                            
                            <button type="submit" name="action" value="pay"
                                class="w-full md:w-auto inline-flex items-center justify-center px-5 py-3 border border-transparent rounded-md shadow-sm bg-primary-red text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-red transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection