<?php

namespace App\Enums;

enum ExpirationEnum: int
{
    case never = 0;
    case minutes = 600;
    case hour = 3600;
    case hours = 10800;
    case day = 86400;
    case week = 604800;
    case month = 2419200;

    /**
     * Парсит количество секунд в человекопонятную строку
     */
    public static function toHumanString(self $expiration): string
    {
        return match ($expiration) {
            self::never => 'Никогда',
            self::minutes => '10 минут',
            self::hour => '1 час',
            self::hours => '3 часа',
            self::day => '1 день',
            self::week => '1 неделя',
            self::month => '1 месяц',
        };
    }
}
