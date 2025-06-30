<?php

namespace Database\Seeders;

use App\Containers\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'department' => 'IT Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'department' => 'IT Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'superadmin@example.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'department' => 'Management',
                'email_verified_at' => now(),
            ]);
        }

        // Create manager users
        if (!User::where('email', 'manager.john@example.com')->exists()) {
            User::create([
                'name' => 'Manager John',
                'email' => 'manager.john@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'status' => 'active',
                'department' => 'Sales Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'manager.jane@example.com')->exists()) {
            User::create([
                'name' => 'Manager Jane',
                'email' => 'manager.jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'status' => 'active',
                'department' => 'Marketing Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'manager.bob@example.com')->exists()) {
            User::create([
                'name' => 'Manager Bob',
                'email' => 'manager.bob@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'status' => 'inactive',
                'department' => 'HR Department',
                'email_verified_at' => now(),
            ]);
        }

        // Create regular users
        if (!User::where('email', 'john.doe@example.com')->exists()) {
            User::create([
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'department' => 'Sales Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'jane.smith@example.com')->exists()) {
            User::create([
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'department' => 'Marketing Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'bob.wilson@example.com')->exists()) {
            User::create([
                'name' => 'Bob Wilson',
                'email' => 'bob.wilson@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'department' => 'IT Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'alice.johnson@example.com')->exists()) {
            User::create([
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'inactive',
                'department' => 'Finance Department',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'charlie.brown@example.com')->exists()) {
            User::create([
                'name' => 'Charlie Brown',
                'email' => 'charlie.brown@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'department' => 'Operations',
                'email_verified_at' => now(),
            ]);
        }

        // Create additional users with factory for more variety
        if (User::count() < 20) {
            User::factory(10)->create();
        }
    }
}
