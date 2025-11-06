<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class UserDTO extends Dto
{
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly string $password,
        public readonly string $apiToken
    ) {}
}
