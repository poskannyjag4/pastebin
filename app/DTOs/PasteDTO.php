<?php

namespace App\DTOs;



use Illuminate\Support\Carbon;

class PasteDTO
{
    public function __construct(
        public int $id,
        public string $text,
        public string $visibility,
        public string $programming_language,
        public Carbon $created_at,
        public Carbon $expires_at
    )
    {
    }
}
