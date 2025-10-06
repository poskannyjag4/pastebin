<?php

namespace App\Enums;

enum VisibilityEnum: string
{
    case public = 'Видно всем';
    case unlisted = 'Доступ только по ссылке';
    case private = 'Доступно только мне';

    public static function fromName(string $name): string{
        return match ($name) {
            self::public->name => self::public->value,
            self::private->name => self::private->value,
            self::unlisted->name => self::unlisted->value,
            default => null
        };
    }
}
