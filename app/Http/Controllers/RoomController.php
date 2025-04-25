<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Show all rooms
    public function index()
    {
        $rooms = Room::all();
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
        ]);

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
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    // Delete a room
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }
}
?>