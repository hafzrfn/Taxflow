<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ensure admin user exists with known password (for development only)
        $adminData = [
            'name' => 'Administrator',
            'email' => 'admin@demo.test',
            'password' => bcrypt('secret123'), // hardcoded development password
        ];

        // Create or update admin user
        \App\Models\User::updateOrCreate(
            ['email' => $adminData['email']],
            ['name' => $adminData['name'], 'password' => $adminData['password']]
        );

        // keep example user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
