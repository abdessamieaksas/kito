<x-dashboard-layout>
    <!-- Room list and search -->
    <div class="p-6 bg-white rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Room Management</h2>
            
            <div class="flex items-center space-x-4">
                <!-- Search Form -->
                <form action="{{ route('rooms.index') }}" method="GET" class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search rooms..." 
                        class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
                
                <!-- Add Room Button -->
                <a href="{{ route('rooms.create') }}" class="bg-primary-red text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Room
                </a>
            </div>
        </div>
        
        <!-- Room List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $room->room_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucfirst($room->type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ number_format($room->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : ($room->status === 'booked' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('rooms.show', $room) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('rooms.edit', $room) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No rooms found. Add one using the button above.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $rooms->links() }}
        </div>
    </div>

    <!-- Add Room Form - hidden by default -->
    <div id="addRoomForm" class="p-6 max-w-4xl mx-auto bg-white rounded-lg shadow-md" style="display: none;">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Room</h2>

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
            
            <!-- Room Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Image</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="room_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                <span>Upload a file</span>
                                <input id="room_image" name="room_image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
            </div>

        <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelAddRoom" 
                    class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 shadow transition duration-300">
                    Cancel
                </button>
            <button type="submit"
                    class="py-2 px-4 bg-primary-red text-white font-semibold rounded-lg hover:bg-red-700 shadow transition duration-300">
                Add Room
            </button>
        </div>
    </form>
</div>

    <!-- JavaScript for form toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoomBtn = document.getElementById('addRoomBtn');
            const addRoomForm = document.getElementById('addRoomForm');
            const cancelAddRoom = document.getElementById('cancelAddRoom');
            
            addRoomBtn.addEventListener('click', function() {
                addRoomForm.style.display = 'block';
                addRoomBtn.scrollIntoView({ behavior: 'smooth' });
            });
            
            cancelAddRoom.addEventListener('click', function() {
                addRoomForm.style.display = 'none';
            });
        });
    </script>
</x-dashboard-layout>
