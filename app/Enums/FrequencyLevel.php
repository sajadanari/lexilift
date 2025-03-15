<?php

namespace App\Enums;

enum FrequencyLevel: string
{
    case VERY_HIGH = 'very_high';
    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';
    case VERY_LOW = 'very_low';

    public function label(): string
    {
        return match($this) {
            self::VERY_HIGH => 'Very High',
            self::HIGH => 'High',
            self::MEDIUM => 'Medium',
            self::LOW => 'Low',
            self::VERY_LOW => 'Very Low',
        };
    }
}