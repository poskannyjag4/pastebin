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
}
