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
        $recentBookings = Booking::with(['user', 'room', 'payments'])
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
     public function reservations(Request $request)
    {
      
        
        $query = Booking::with(['user', 'room', 'payments']);
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('room', function($roomQuery) use ($search) {
                    $roomQuery->where('room_number', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%");
            });
        }
        
        // Sort by most recent bookings
        $query->orderBy('created_at', 'desc');
        
        // Paginate results
        $bookings = $query->paginate(10);
        
        return view('admin.reservations', compact('bookings'));
    }

} 