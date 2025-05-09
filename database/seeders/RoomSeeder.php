<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            [
                'room_number' => '101',
                'type' => 'single',
                'price' => 100.00,
                'status' => 'available'
            ],
            [
                'room_number' => '102',
                'type' => 'double',
                'price' => 150.00,
                'status' => 'available'
            ],
            [
                'room_number' => '103',
                'type' => 'suite',
                'price' => 250.00,
                'status' => 'available'
            ],
            [
                'room_number' => '201',
                'type' => 'single',
                'price' => 100.00,
                'status' => 'available'
            ],
            [
                'room_number' => '202',
                'type' => 'double',
                'price' => 150.00,
                'status' => 'available'
            ],
            [
                'room_number' => '203',
                'type' => 'suite',
                'price' => 250.00,
                'status' => 'available'
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
} 