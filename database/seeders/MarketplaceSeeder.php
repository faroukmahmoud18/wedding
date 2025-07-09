<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Service;
use App\Models\User; // Assuming you want to associate with a user
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; // If creating users

class MarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a generic user for associating with vendors/services if needed
        // This is a simplified approach. In a real app, users would register.
        $defaultUser = User::firstOrCreate(
            ['email' => 'testuser@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $categories = ['Photography', 'Catering', 'Music Band'];
        $serviceUnits = ['per hour', 'per event', 'per person'];

        foreach ($categories as $category) {
            for ($i = 1; $i <= 3; $i++) {
                $vendorName = "{$category} Vendor {$i}";
                $vendor = Vendor::create([
                    'name' => $vendorName,
                    'email' => Str::slug($vendorName) . '@example.com',
                    'about' => "About {$vendorName}, offering the best {$category} services.",
                    'phone' => '123-456-789' . $i,
                    'address' => "123 {$category} Lane, Wedding City",
                    // 'user_id' => $defaultUser->id, // If vendors are linked to users
                ]);

                for ($j = 1; $j <= 2; $j++) {
                    $serviceTitle = "Awesome {$category} Package {$j} by {$vendorName}";
                    Service::create([
                        'vendor_id' => $vendor->id,
                        'category' => $category,
                        'title' => $serviceTitle,
                        'slug' => Str::slug($serviceTitle),
                        'short_desc' => "Short description for {$serviceTitle}.",
                        'long_desc' => "This is a longer, more detailed description for the {$serviceTitle}. It outlines all the great features and benefits of choosing this service for your special day. We ensure quality and satisfaction.",
                        'price_from' => rand(100, 500) * 10,
                        'price_to' => rand(600, 1000) * 10,
                        'unit' => $serviceUnits[array_rand($serviceUnits)],
                        'is_live' => true,
                    ]);
                }
            }
        }
    }
}
