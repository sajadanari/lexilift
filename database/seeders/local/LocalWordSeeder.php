<?php

namespace Database\Seeders\Local;

use App\Models\Word;
use Illuminate\Database\Seeder;

class LocalWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1000 Word
        $words = Word::factory()->count(1000)->create();
    }
}
