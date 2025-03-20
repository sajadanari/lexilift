<?php

namespace Database\Seeders;

use Database\Seeders\Local\LocalUserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            LocalUserSeeder::class,
        ]);
    }
}
