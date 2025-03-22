<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Word;
use App\Enums\PartOfSpeech;
use App\Enums\DifficultyLevel;
use App\Enums\FrequencyLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordFactory extends Factory
{
    protected $model = Word::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'word' => fake()->word(),
            'meaning' => fake()->paragraph(),
            'synonyms' => fake()->words(3, true),
            'antonyms' => fake()->words(2, true),
            'pronunciation' => '/ˈwərd/',
            'part_of_speech' => fake()->randomElement(PartOfSpeech::cases()),
            'usage' => fake()->sentence(),
            'example' => fake()->sentence(),
            'plural' => fake()->word(),
            'countable' => fake()->boolean(),
            'root' => fake()->word(),
            'etymology' => fake()->paragraph(1),
            'collocations' => implode(', ', fake()->words(4)),
            'audio' => fake()->fileExtension() . '.mp3',
            'frequency' => fake()->randomElement(FrequencyLevel::cases()),
            'difficulty_level' => fake()->randomElement(DifficultyLevel::cases()),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
