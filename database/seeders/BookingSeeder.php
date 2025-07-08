<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking; // Assuming your Booking model is in App\Models
use App\Models\User;    // Assuming your User model is in App\Models
use App\Models\Service; // Assuming your Service model is in App\Models

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!class_exists(Booking::class) || !class_exists(User::class) || !class_exists(Service::class)) {
             if ($this->command) {
                $this->command->warn('Booking, User, or Service model not found, skipping BookingSeeder.');
            }
            return;
        }

        if (!method_exists(Booking::class, 'factory')) {
             if ($this->command) {
                $this->command->warn('BookingFactory not found or not correctly associated with Booking model, skipping BookingSeeder factory call.');
            }
            return;
        }

        if (User::count() == 0) {
            if ($this->command) {
                $this->command->warn('No users found. Creating a default user for bookings or run UserSeeder first.');
            }
            User::factory()->create(); // Create at least one user if none exist
             if (User::count() == 0) { // Still no user
                if ($this->command) $this->command->error('Failed to create a default user. Skipping BookingSeeder.');
                return;
            }
        }

        if (Service::count() == 0) {
            if ($this->command) {
                $this->command->warn('No services found. Please run ServiceSeeder first or ensure services exist. Skipping BookingSeeder.');
            }
            return;
        }

        Booking::factory()->count(10)->create([
            // The user prompt included 'user_id' => User::factory(), which means each booking creates a new user.
            // This might be desired, or you might want to assign to existing random users:
            // 'user_id' => User::inRandomOrder()->first()->id,
            // The current implementation follows the prompt.
            // The ServiceFactory should handle creating/assigning service_id or it should be done here.
            // 'service_id' => Service::inRandomOrder()->first()->id, // This was in the user's prompt
        ]);

        // More robust if BookingFactory doesn't auto-assign user_id and service_id:
        // Booking::factory()->count(10)->make()->each(function ($booking) {
        //     $booking->user_id = User::inRandomOrder()->first()->id; // Or User::factory()->create()->id for new user per booking
        //     $booking->service_id = Service::inRandomOrder()->first()->id;
        //     $booking->save();
        // });
    }
}
