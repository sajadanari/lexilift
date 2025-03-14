<?php

namespace App\Models;

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
}
