<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class UserSocialCreationDTO extends Dto
{
    public function __construct(
        public string $providerId,
        public string $providerName,
    )
    {
    }
}
