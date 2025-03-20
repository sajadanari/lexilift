<?php

namespace Database\Seeders\Local;

use App\Models\User;
use Illuminate\Database\Seeder;

class LocalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@lexilift.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        // Create User
        $user = User::create([
            'name' => 'User',
            'email' => 'user@lxilift.com',
            'password' => 'password',
        ]);

        $user->assignRole('user');
    }
}
