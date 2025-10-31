<?php

namespace App\DTOs;

use Carbon\Carbon;
use Spatie\LaravelData\Dto;

class PasteForCreationDTO extends Dto
{
    public function __construct(
        public string $title,
        public string $text,
        public string $visibility,
        public Carbon $expires_at,
        public string $porgramming_language,
        public string $token
    ) {}

}
