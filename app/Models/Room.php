<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['room_number', 'type', 'price', 'status', 'image_path'];

    /**
     * Get the image URL.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            // If the path starts with 'public/', remove it
            $path = str_replace('public/', '', $this->image_path);
            
            // Now generate the URL
            return asset('storage/' . $path);
        }
        
        return asset('images/room-placeholder.jpg');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

