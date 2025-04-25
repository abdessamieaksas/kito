<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->default(1);
            $table->string('room_number');
            $table->string('type');
            $table->decimal('price', 8, 2);
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamps();
        
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
