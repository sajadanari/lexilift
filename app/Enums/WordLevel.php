<?php

namespace App\Enums;

enum WordLevel: string
{
    case WEAK = 'weak';
    case MEDIUM = 'medium';
    case STRONG = 'strong';

    public static function fromScore(int $score): self
    {
        return match(true) {
            $score < 40 => self::WEAK,
            $score <= 70 => self::MEDIUM,
            default => self::STRONG
        };
    }

    public function getRange(): array
    {
        return match($this) {
            self::WEAK => ['min' => 0, 'max' => 39],
            self::MEDIUM => ['min' => 40, 'max' => 70],
            self::STRONG => ['min' => 71, 'max' => 100],
        };
    }

    public function getQuestionCount(): int
    {
        return match($this) {
            self::WEAK => 6,
            self::MEDIUM => 3,
            self::STRONG => 1,
        };
    }
}
