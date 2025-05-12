<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    // Show all rooms with pagination and search
    public function index(Request $request)
    {
        $query = Room::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }
        
        // Add sorting if needed
        $query->orderBy('room_number');
        
        // Paginate results
        $rooms = $query->paginate(10);
        
        return view('admin.room', compact('rooms'));
    }

    // Show form to create a room
    public function create()
    {
        return view('rooms.create');
    }

    // Store a newly created room
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:available,booked,maintenance',
            'room_image' => 'nullable|image|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('room_image')) {
            // Store directly to the public disk in the 'rooms' directory
            $path = $request->file('room_image')->store('rooms', 'public');
            $validated['image_path'] = $path;
        }

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully!');
    }

    // Show a single room
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    // Show form to edit a room
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    // Update a room
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:available,booked,maintenance',
            'room_image' => 'nullable|image|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('room_image')) {
            // Delete old image if exists
            if ($room->image_path) {
                Storage::disk('public')->delete($room->image_path);
            }
            
            // Store directly to the public disk in the 'rooms' directory
            $path = $request->file('room_image')->store('rooms', 'public');
            $validated['image_path'] = $path;
        }

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    // Delete a room
    public function destroy(Room $room)
    {
        // Delete room image if exists
        if ($room->image_path) {
            Storage::disk('public')->delete($room->image_path);
        }
        
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }

    public function available(Request $request)
    {
        try {
            // Start with all available rooms
            $query = Room::where('status', 'available');

            // Filter by room type if selected
            if ($request->filled('room_type')) {
                $query->where('type', $request->room_type);
            }

            // If dates are provided, filter by availability
            if ($request->filled(['check_in', 'check_out'])) {
                // Validate dates
                $request->validate([
                    'check_in' => 'required|date|after:today',
                    'check_out' => 'required|date|after:check_in',
                ]);

                // Get rooms that are not booked for the selected dates
                $bookedRoomIds = Booking::where(function ($query) use ($request) {
                    $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
                })->pluck('room_id');

                $query->whereNotIn('id', $bookedRoomIds);
            }

            // Get the results with pagination
            $rooms = $query->paginate(6)->withQueryString();

            return view('rooms.available', compact('rooms'));

        } catch (\Exception $e) {
            \Log::error('Room search error: ' . $e->getMessage());
            return redirect()->route('rooms.available')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
?>