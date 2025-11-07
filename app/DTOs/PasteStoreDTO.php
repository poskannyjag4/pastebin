<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class PasteStoreDTO extends Dto
{
    public function __construct(
        public readonly string $text,
        public readonly string $title,
        public readonly string $programming_language,
        public readonly int $expires_at,
        public readonly string $visibility,
    ) {}
}
