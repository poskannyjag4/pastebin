<?php

namespace App\DTOs;

use App\Enums\LanguageEnum;
use App\Enums\VisibilityEnum;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Dto;

class PasteStoreDTO extends Dto
{
    public function __construct(
        public readonly string $text,
        public readonly string $title,
        public readonly string $programming_language,
        public readonly int $expires_at,
        public readonly string $visibility,
    )
    {
    }
}
