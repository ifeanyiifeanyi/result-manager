<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator with limited system access'],
            ['name' => 'student', 'description' => 'Student with limited system access'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
