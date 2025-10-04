<?php

namespace App\Enums;

enum ExpirationEnum:string
{
    case never = 'Никогда';
    case minutes = '10 минут';
    case hour = '1 час';
    case hours = '3 часа';
    case day = '1 день';
    case week = '1 неделя';
    case month = '1 месяц';

    /**
     * @param string $name
     * @return float
     */
    public static function hoursFromName(string $name): float{
        return match ($name){
            self::never->name =>0,
            self::hour->name => 1,
            self::minutes->name => 1/60,
            self::hours->name => 3,
            self::day->name => 24,
            self::week->name => 168,
            self::month->name => 744,
            default => throw new \InvalidArgumentException("Invalid expiration type"),
        };
    }
}
