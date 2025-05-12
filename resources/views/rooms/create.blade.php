<x-dashboard-layout>
    <div class="p-6 max-w-4xl mx-auto bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Room</h2>
            <a href="{{ route('rooms.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to Rooms
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Room Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" name="room_number" value="{{ old('room_number') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Room Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Type</label>
                <select name="type" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Type</option>
                    <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single</option>
                    <option value="double" {{ old('type') == 'double' ? 'selected' : '' }}>Double</option>
                    <option value="suite" {{ old('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                </select>
            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Price per Night ($)</label>
                <input type="number" name="price" step="0.01" value="{{ old('price') }}" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            
            <!-- Room Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Room Image</label>
                <input type="file" name="room_image" id="room_image" accept="image/*"
                    class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100">
                <p class="mt-1 text-sm text-gray-500">PNG, JPG, or GIF up to 2MB</p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="py-2 px-4 bg-primary-red text-white font-semibold rounded-lg hover:bg-red-700 shadow transition duration-300">
                    Add Room
                </button>
            </div>
        </form>
    </div>
</x-dashboard-layout> 