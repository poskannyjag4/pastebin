<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Paste;
use App\Http\Resources\UserResource;

/**
 * @mixin Paste
 */
class PasteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'title' => $this->title,
            'expires_at' => $this->expires_at,
            'visibility' => $this->visibility,
            'programming_language' => $this->programming_language,
            'token' => $this->token,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->user)
        ];
    }
}
