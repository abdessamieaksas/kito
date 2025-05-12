<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        // Calculate total amount based on room price and duration
        $checkIn = \Carbon\Carbon::parse($booking->check_in);
        $checkOut = \Carbon\Carbon::parse($booking->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $booking->room->price * $nights;

        return view('payments.create', compact('booking', 'totalAmount'));
    }

    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,online',
            'payment_date' => 'required|date',
        ]);

        // Create the payment
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_date' => $validated['payment_date'],
        ]);

        // Update booking status to confirmed
        $booking->update(['status' => 'confirmed']);
        
        // Update room status to booked
        $booking->room->update(['status' => 'booked']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Payment recorded successfully. Your booking is now confirmed!');
    }

    public function receipt(Payment $payment)
    {
        $booking = $payment->booking;
        $user = $booking->user;
        $room = $booking->room;

        $pdf = Pdf::loadView('payments.receipt', compact('payment', 'booking', 'user', 'room'));
        
        return $pdf->download('receipt-' . $payment->id . '.pdf');
    }
}