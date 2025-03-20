<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'local_name' => 'Admin'],
            ['name' => 'user', 'local_name' => 'User'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
