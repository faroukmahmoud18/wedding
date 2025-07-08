<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // It's often good practice to ensure a specific user exists if your
        // other seeders might rely on it, or create it within those seeders.
        // The MarketplaceSeeder creates its own 'testuser@example.com' if needed.
        // If you want this one from DatabaseSeeder to be the primary, adjust MarketplaceSeeder.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            MarketplaceSeeder::class,
            // Add other seeder classes here
        ]);
    }
}
