<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor; // Assuming your Vendor model is in App\Models

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure you have a VendorFactory defined
        // Example: php artisan make:factory VendorFactory --model=Vendor
        if (!class_exists(Vendor::class)) {
            // Fallback or skip if model doesn't exist to prevent errors during generation
            if ($this->command) {
                $this->command->warn('Vendor model not found, skipping VendorSeeder.');
            }
            return;
        }

        // Check if factory exists, if not, can't run this seeder as intended by user prompt
        // This is a meta-check for the AI's understanding, in real Laravel, factory() would fail if not present
        if (!method_exists(Vendor::class, 'factory')) {
             if ($this->command) {
                $this->command->warn('VendorFactory not found or not correctly associated with Vendor model, skipping VendorSeeder factory call.');
            }
            // You could create a few manually here if no factory
            // Vendor::create(['name' => 'Default Vendor 1', 'email' => 'vendor1@example.com', ...]);
            return;
        }

        Vendor::factory()->count(5)->create();
    }
}
