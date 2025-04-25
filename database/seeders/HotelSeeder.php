<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hotel::create([
            'name' => 'Keto',
            'address' => 'Avenue Zerktouni, Marrakech',
            'phone_number' => '+212630438020'
        ]);
    }
}
