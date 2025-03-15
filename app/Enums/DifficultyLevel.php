<?php

namespace App\Enums;

enum DifficultyLevel: string
{
    case A1 = 'a1';
    case A2 = 'a2';
    case B1 = 'b1';
    case B2 = 'b2';
    case C1 = 'c1';
    case C2 = 'c2';

    public function label(): string
    {
        return strtoupper($this->value);
    }
}