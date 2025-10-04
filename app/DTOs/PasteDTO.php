<?php

namespace App\DTOs;



use Illuminate\Support\Carbon;

class PasteDTO
{
    /**
     * @param string $title
     * @param string $text
     * @param string $visibility
     * @param string $programming_language
     * @param string $expires_at
     */
    public function __construct(
        public readonly string $title,
        public readonly string $text,
        public readonly string $visibility,
        public readonly string $programming_language,
        public readonly string $expires_at,
    )
    {
    }

    /**
     * @param array<string> $data
     * @return PasteDTO
     */
    public static function fromArray(array $data): PasteDTO{
        return  new self(
            title: $data['title'],
            text: $data['text'],
            visibility: $data['visibility'],
            programming_language: $data['programming_language'],
            expires_at: $data['expires_at']
        );
    }
}
