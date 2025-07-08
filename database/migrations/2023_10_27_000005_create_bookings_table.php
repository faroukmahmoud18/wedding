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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Link to the booked service
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Link to the user who made the booking
            $table->dateTime('event_date'); // Date and time of the event
            $table->integer('qty')->default(1); // Quantity (e.g., number of guests, hours)
            $table->decimal('total', 10, 2); // Total price for the booking
            $table->string('status')->default('pending'); // e.g., pending, confirmed, cancelled, completed
            $table->timestamps(); // created_at and updated_at

            $table->index('status');
            $table->index('event_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
