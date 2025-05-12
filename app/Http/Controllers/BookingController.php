<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $availableRooms = Room::where('status', 'available')->get();
        return view('bookings.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'room_type' => 'required|in:single,double,suite',
        ]);

        // Find an available room of the requested type
        $room = Room::where('type', $validated['room_type'])
            ->where('status', 'available')
            ->first();

        if (!$room) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No rooms of this type are available for the selected dates.');
        }

        // Check if the room is already booked for these dates
        $existingBooking = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in', [$validated['check_in'], $validated['check_out']])
                    ->orWhereBetween('check_out', [$validated['check_in'], $validated['check_out']]);
            })
            ->first();

        if ($existingBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This room is already booked for the selected dates.');
        }

        // Create the booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'status' => 'pending',
        ]);

        // Update room status
        $room->update(['status' => 'booked']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully!');
    }

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('room')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Ensure the user can only view their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        // Ensure the user can only edit their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Ensure the user can only update their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        // Check if the room is already booked for these dates
        $existingBooking = Booking::where('room_id', $booking->room_id)
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in', [$validated['check_in'], $validated['check_out']])
                    ->orWhereBetween('check_out', [$validated['check_in'], $validated['check_out']]);
            })
            ->first();

        if ($existingBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This room is already booked for the selected dates.');
        }

        $booking->update($validated);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }
    public function print($id)
    {
        $booking = Booking::with(['room', 'user', 'payments'])->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bookings.print', compact('booking'));
        return $pdf->download('booking_' . $booking->id . '.pdf');
    }
} 