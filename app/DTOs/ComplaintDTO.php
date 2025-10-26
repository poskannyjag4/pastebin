<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class ComplaintDTO extends Dto
{
    /**
     * @param string $details
     */
    public function __construct (
        public readonly string $details,
    ){}
}
