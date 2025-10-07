<?php

namespace App\Http\Requests;

use App\DTOs\ComplaintDTO;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
            'details' => 'required|string',
        ];
    }

    public function toDTO(): ComplaintDTO{
        return ComplaintDTO::fromArray($this->validated());
    }
}
