<?php

namespace App\Http\Resources;

use App\DTOs\PasteDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Paste;
use App\Http\Resources\UserResource;

/**
 * @mixin PasteDTO
 */
class PasteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'paste' => $this->paste,
            'identifier' => $this->identifier
        ];
    }
}
