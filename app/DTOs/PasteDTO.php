<?php

namespace App\DTOs;

use App\Models\Paste;
use Spatie\LaravelData\Dto;

class PasteDTO extends DTO
{
    public function __construct(
        public Paste $paste,
        public string $identifier,
    ) {}
}
