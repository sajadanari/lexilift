<?php

namespace App\Models;

use App\Enums\PartOfSpeech;
use App\Enums\DifficultyLevel;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'word',
        'meaning',
        'synonyms',
        'antonyms',
        'pronunciation',
        'part_of_speech',
        'usage',
        'example',
        'plural',
        'countable',
        'root',
        'etymology',
        'collocations',
        'audio',
        'frequency',
        'difficulty_level',
        'notes'
    ];

    protected $casts = [
        'part_of_speech' => PartOfSpeech::class,
        'countable' => 'boolean',
        'difficulty_level' => DifficultyLevel::class,
    ];

    protected $guarded = ['id'];
}
