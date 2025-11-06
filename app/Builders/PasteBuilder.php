<?php

namespace App\Builders;

use App\Enums\VisibilityEnum;
use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Paste>
 */
class PasteBuilder extends Builder
{
    public function whereNotExpired(): self
    {
        return $this->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        });
    }

    public function getLatest(): self
    {
        return $this->latest()->take(10);
    }

    public function getForUser(int $id): self
    {
        return $this->where('user_id', '=', $id);
    }

    public function getLatestPublic(): self
    {
        return $this->where('visibility', '=', VisibilityEnum::public->name)->getLatest();
    }

    public function getLatestUser(int $id): self
    {
        return $this->getForUser($id)->getLatest();
    }

    public function getByToken(string $uuid): self
    {
        return $this->where('token', $uuid);
    }
}
