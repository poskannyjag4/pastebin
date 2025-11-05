<?php

namespace App\Builders;

use App\Enums\VisibilityEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Paste;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * @extends Builder<Paste>
 */
class PasteBuilder extends Builder {


    /**
     * @return PasteBuilder
     */

    public function whereNotExpired(): self {
        return $this->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        });
    }

    /**
     * @return PasteBuilder
     */
    public function getLatest(): self {
        return $this->latest()->take(10);
    }

    /**
     * @param int $id
     * @return PasteBuilder
     */
    public function getForUser(int $id): self {
        return $this->where('user_id', '=', $id);
    }


    /**
     * @return PasteBuilder
     */
    public function getLatestPublic(): self {
        return $this->where('visibility', '=', VisibilityEnum::public->name)->getLatest();
    }

    /**
     * @param int $id
     * @return PasteBuilder
     */
    public function getLatestUser(int $id): self {
        return $this->getForUser($id)->getLatest();
    }

    /**
     * @param string $uuid
     * @return PasteBuilder
     */
    public function getByToken(string $uuid): self {
        return $this->where('token', $uuid);
    }
}
