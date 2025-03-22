<?php

namespace Database\Seeders\Local;

use App\Models\User;
use App\Models\Word;
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

        // Create 50 User and assign user role
        $users = User::factory()->count(50)->create();
        $users->each(function ($user) {
            $user->assignRole('user');
        });

        // Create 200 Word
        $words = Word::factory()->count(200)->create();
    }
}
