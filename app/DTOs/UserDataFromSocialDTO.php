<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class UserDataFromSocialDTO extends Dto
{
    public function __construct(
        public string $email,
        public string $name,
    ) {}
}
