<?php

namespace App\Repositories;

use App\Criteria\Paste\WhereNotExpiredCriteriaCriteria;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class PasteRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return Paste::class;
    }

    /**
     * @return Collection
     */
    public function getLatestPublic(): Collection
    {
        return $this->model->newQuery()->where('visibility', VisibilityEnum::public->name)->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        })->latest()->take(10)->get();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getLatestUser(int $id): Collection
    {
        return $this->model->newQuery()->where('user_id', $id)->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        })->latest()->take(10)->get();
    }

}
