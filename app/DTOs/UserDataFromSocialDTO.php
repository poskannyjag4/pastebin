<?php

namespace App\DTOs;

use Spatie\LaravelData\Dto;

class UserDataFromSocialDTO extends Dto
{

    function __construct(
        public string $email,
        public string $name,
    )
    {

    }
}
