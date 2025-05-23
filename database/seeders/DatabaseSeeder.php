<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        if (config('app.env') === 'local') {
            $this->call([
                LocalSeeder::class,
            ]);
        } elseif (config('app.env') === 'production') {
            $this->call([
                ProdSeeder::class,
            ]);
        }
    }
}
