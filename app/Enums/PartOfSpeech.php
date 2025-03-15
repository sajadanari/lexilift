<?php

namespace App\Enums;

enum PartOfSpeech: string
{
    case NOUN = 'noun';
    case PRONOUN = 'pronoun';
    case VERB = 'verb';
    case ADJECTIVE = 'adjective';
    case ADVERB = 'adverb';
    case PREPOSITION = 'preposition';
    case CONJUNCTION = 'conjunction';
    case INTERJECTION = 'interjection';
    case ARTICLE = 'article';

    public function label(): string
    {
        return match($this) {
            self::NOUN => 'Noun',
            self::PRONOUN => 'Pronoun',
            self::VERB => 'Verb',
            self::ADJECTIVE => 'Adjective',
            self::ADVERB => 'Adverb',
            self::PREPOSITION => 'Preposition',
            self::CONJUNCTION => 'Conjunction',
            self::INTERJECTION => 'Interjection',
            self::ARTICLE => 'Article/Determiner',
        };
    }
}
