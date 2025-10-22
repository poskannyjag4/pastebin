<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class ApiLoginDTO extends Dto{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
        
    }
}