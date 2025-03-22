<?php

namespace App\Models;

use App\Enums\PartOfSpeech;
use App\Enums\DifficultyLevel;
use App\Enums\FrequencyLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'user_id',
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
        'frequency' => FrequencyLevel::class,
    ];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
