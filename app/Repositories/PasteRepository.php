<?php

namespace App\Repositories;

use App\Enums\VisibilityEnum;
use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class PasteRepository extends BaseRepository
{
    /**
     * @var Paste
     */
    protected $model;

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Paste::class;
    }

    /**
     * @return Collection<int, Paste>
     */
    public function getLatestPublic(): Collection
    {
        return $this->model->newQuery()->where('visibility', VisibilityEnum::public->name)->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        })->latest()->take(10)->get();
    }

    /**
     * @return Collection<int,Paste>
     */
    public function getLatestUser(int $id): Collection
    {
        return $this->model->newQuery()->where('user_id', $id)->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        })->latest()->take(10)->get();
    }

    /**
     * @return LengthAwarePaginator<int,Paste>
     */
    public function getPaginatedWithUser(): LengthAwarePaginator
    {
        return $this->model->newQuery()->with(['user'])->paginate(15);
    }

    public function getByToken(string $token): Paste
    {
        return $this->model->newQuery()->firstWhere('token', $token);
    }
}
