<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Dto;

class RegisterDTO extends Dto
{
    public function __construct(
        public string $name,
        #[Rule('required|string|unique:users,email')]
        public readonly string $email,
        #[Confirmed]
        public readonly string $password,
    ) {}
}
