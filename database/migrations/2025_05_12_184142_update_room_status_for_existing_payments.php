<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Booking;
use App\Models\Room;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find all confirmed bookings and set their room status to 'booked'
        $confirmedBookings = Booking::where('status', 'confirmed')->get();
        
        foreach ($confirmedBookings as $booking) {
            // Update the associated room's status
            Room::where('id', $booking->room_id)->update(['status' => 'booked']);
        }
        
        // Find all pending bookings and ensure their room status is 'available'
        $pendingBookings = Booking::where('status', 'pending')->get();
        
        foreach ($pendingBookings as $booking) {
            Room::where('id', $booking->room_id)
                ->where('status', 'booked')
                ->update(['status' => 'available']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration fixes data, so there's no specific rollback needed
        // But we could reset all booked rooms to available if needed
    }
};