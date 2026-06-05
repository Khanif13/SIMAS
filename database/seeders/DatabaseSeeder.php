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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Akun Superadmin
        User::create([
            'name' => 'Superadmin SIMAS',
            'email' => 'superadmin@simas.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
        ]);

        // Akun Admin
        User::create([
            'name' => 'Admin Pengurus',
            'email' => 'admin@simas.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::factory(20)->create([
            'role' => 'member',
            'password' => bcrypt('password123'),
        ]);
    }
}
