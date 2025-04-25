<x-dashboard-layout>


    <div class="p-6 max-w-4xl mx-auto bg-white rounded-2xl shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Room</h2>
    
        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-6">
            @csrf
    
            <!-- Room Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" name="room_number" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
    
            <!-- Room Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Type</label>
                <select name="type" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Type</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="suite">Suite</option>
                </select>
            </div>
    
            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Price per Night ($)</label>
                <input type="number" name="price" step="0.01" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
    
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
    
            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 shadow transition duration-300">
                    Add Room
                </button>
            </div>
        </form>
    </div>
    </x-dashboard-layout>
    