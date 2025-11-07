<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Метод делает поптыку аутентификация и в случае если неверных попыток больше 5, выдает ошибку
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        if (RateLimiter::tooManyAttempts($this->email, 5)) {
            $seconds = RateLimiter::availableIn($this->email);
            throw ValidationException::withMessages([
                'email' => 'Слишком много попыток! Попробуйте через '.ceil($seconds / 60).' минут!',
            ]);
        }

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            RateLimiter::hit($this->email);
            throw ValidationException::withMessages([
                'email' => 'Неправильный логин или пароль!',
            ]);
        }

        RateLimiter::clear($this->email);
    }
}
