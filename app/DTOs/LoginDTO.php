<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Dto;

class LoginDTO extends Dto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $email = $validator->getData()['email'];
            $password = $validator->getData()['password'];

            if (RateLimiter::tooManyAttempts($email, 5)) {
                $seconds = RateLimiter::availableIn($email);
                $validator->errors()->add('email', 'Слишком много попыток! Попробуйте через '.ceil($seconds / 60).' минут!');

                return;
            }

            if (! Auth::attempt([
                'email' => $email,
                'password' => $password,
            ])) {
                RateLimiter::hit($email);
                $validator->errors()->add('email', 'Неправильный логин или пароль.');

                return;
            }

            RateLimiter::clear($email);
        });
    }
}
