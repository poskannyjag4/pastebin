<?php

namespace App\Http\Resources;

use App\DTOs\PasteDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PasteDTO
 */
class PasteResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->paste->id,
            'title' => $this->paste->title,
            'text' => $this->paste->text,
            'programming_language' => $this->paste->programming_language,
            'visibility' => $this->paste->visibility,
            'expires_at' => $this->paste->expires_at,
            'user_id' => $this->paste->user_id,
            'created_at' => $this->paste->created_at,
            'updated_at' => $this->paste->updated_at,
            'identifier' => $this->identifier,
        ];
    }
}
