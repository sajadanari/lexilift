<?php

namespace Database\Seeders\Prod;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProdUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'sajaddehghananari@gmail.com',
            'password' => bcrypt('467391467391'),
        ]);

        $admin->assignRole('admin');
    }

}