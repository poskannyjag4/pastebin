<?php

namespace App\Repositories;

use App\Criteria\Paste\WhereNotExpiredCriteriaCriteria;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        return $this->model->newQuery()->where('visibility', VisibilityEnum::public->name)->latest()->take(10)->get();
    }

    /**
     * @return Collection
     */
    public function getLatestUser(int $id): Collection
    {
        return $this->getByCriteria( new WhereNotExpiredCriteriaCriteria());
    }

}
