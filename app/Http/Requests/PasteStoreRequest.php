<?php

namespace App\Http\Requests;

use App\DTOs\PasteDTO;
use App\Enums\ExpirationEnum;
use App\Enums\LanguageEnum;
use App\Enums\VisibilityEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PasteStoreRequest extends FormRequest
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

        /** @var array<int, string> $allowedLanguages */
        $allowedLanguages = array_map(fn($language) => $language->name, LanguageEnum::cases());
        /** @var array<int, string> $allowedVisibility */
        $allowedVisibility = array_map(fn($visibility) => $visibility->name, VisibilityEnum::cases());
        /** @var array<int, string> $allowedExpiration */
        $allowedExpiration = array_map(fn($expiration) => $expiration->name, ExpirationEnum::cases());

        return [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'programming_language' => [
                'required',
                Rule::in($allowedLanguages),
            ],
            'visibility' => [
                'required',
                Rule::in($allowedVisibility),
            ],
            'expires_at' => [
                'required',
                Rule::in($allowedExpiration),
            ],
        ];
    }

    public function toDTO(): PasteDTO
    {
        return  PasteDTO::fromArray($this->validated());
    }
}
