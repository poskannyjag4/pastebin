<?php

namespace App\DTOs;

use App\Models\Paste;
use Spatie\LaravelData\Dto;

class PasteForLatestDTO extends DTO
{
    public function __construct(
        public Paste $paste,
        public string $hashId,

    )
    {
    }
}
