<?php

namespace Database\Seeders;

use Database\Seeders\Prod\ProdUserSeeder;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ProdUserSeeder::class,
        ]);
    }
}
