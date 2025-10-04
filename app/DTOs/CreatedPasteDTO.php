<?php

namespace App\DTOs;

use App\Models\Paste;

class CreatedPasteDTO
{
    /**
     * @param Paste $paste
     * @param string $hashids
     */
    public function __construct(
        public readonly  Paste $paste,
        public readonly string $hashids
    )
    {
    }


}
