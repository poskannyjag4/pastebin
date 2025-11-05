<?php

namespace App\Http\Resources;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;


/**
 * @mixin Complaint
 */
class ComplaintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'details' => $this->details,
            'user' => $this->user,
        ];
    }
}
