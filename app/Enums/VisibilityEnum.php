<?php

namespace App\Enums;

enum VisibilityEnum: string
{
    case public = 'Видно всем';
    case unlisted = 'Доступ только по ссылке';
    case private = 'Доступно только мне';
}
