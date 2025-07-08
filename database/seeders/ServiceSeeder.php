<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service; // Assuming your Service model is in App\Models
use App\Models\Vendor;  // Assuming your Vendor model is in App\Models

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!class_exists(Service::class) || !class_exists(Vendor::class)) {
            if ($this->command) {
                $this->command->warn('Service or Vendor model not found, skipping ServiceSeeder.');
            }
            return;
        }

        if (!method_exists(Service::class, 'factory')) {
             if ($this->command) {
                $this->command->warn('ServiceFactory not found or not correctly associated with Service model, skipping ServiceSeeder factory call.');
            }
            return;
        }

        // Check if there are any vendors to associate services with
        if (Vendor::count() == 0) {
            if ($this->command) {
                $this->command->warn('No vendors found. Please run VendorSeeder first or ensure vendors exist. Skipping ServiceSeeder.');
            }
            // Optionally, create a default vendor here if that makes sense for your logic
            // Vendor::factory()->create(['name' => 'Default Service Vendor']);
            // if (Vendor::count() == 0) return; // Still no vendor, exit
            return;
        }

        Service::factory()->count(20)->create([
            // Ensure your ServiceFactory correctly handles vendor_id assignment
            // The provided logic implies the factory might not handle it by default,
            // or this is an override. If the factory has a state for vendor_id, that's cleaner.
            // 'vendor_id' => Vendor::inRandomOrder()->first()->id, // This was the user's request
            // A common way in factories is: 'vendor_id' => Vendor::factory(), if a service always needs a new vendor
            // Or using a state in the factory: Service::factory()->forVendor(Vendor::inRandomOrder()->first())->count(20)->create();
        ]);

        // A more robust way if your ServiceFactory doesn't auto-assign vendor_id
        // or if you want to ensure each of the 20 services gets a random existing vendor:
        // Service::factory()->count(20)->make()->each(function ($service) {
        //     $service->vendor_id = Vendor::inRandomOrder()->first()->id;
        //     $service->save();
        // });
    }
}
