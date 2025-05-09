<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::sum('amount');
        $recentBookings = Booking::with(['client', 'room', 'payment'])
                                ->latest()
                                ->take(10)
                                ->get();

        return view('admin.index', compact(
            'totalRooms',
            'availableRooms',
            'totalBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }
} 