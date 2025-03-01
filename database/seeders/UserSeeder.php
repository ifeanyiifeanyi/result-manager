<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'role_id' => Role::where('name', 'admin')->first()->id,
            'first_name' => 'System',
            'last_name' => 'Admin',
            'username' => 'admin',
            'other_names' => null, // Remove username repetition
            'email' => 'admin@example.com',
            'phone' => '+12345678901', // Consistent format
            'password' => Hash::make('password'), // Consistent password
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create Sample Student
        User::create([
            'role_id' => Role::where('name', 'student')->first()->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'student',
            'other_names' => null, // Remove username repetition
            'email' => 'student@example.com',
            'phone' => '+12345678902', // Consistent format
            'address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'id_number' => '1234567890',
            'password' => Hash::make('password'), // Same password
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
    }
}
