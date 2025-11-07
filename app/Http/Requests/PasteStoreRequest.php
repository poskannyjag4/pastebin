<?php

namespace App\Http\Requests;

use App\Enums\LanguageEnum;
use App\Enums\VisibilityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
         $allowedLanguages = array_map(fn($language) => $language->name, LanguageEnum::cases());
        $allowedVisibility = array_map(fn($visibility) => $visibility->name, VisibilityEnum::cases());

        return [
            'text' => ['required', 'string'],
            'title' => ['required', 'string'],
            'programming_language' => ['required', 'string', Rule::in($allowedLanguages)],
            'expires_at' => ['required', 'numeric', 'between:0,3155760000'],
            'visibility' => ['required', 'string', Rule::in($allowedVisibility)]
        ];
    }
}
