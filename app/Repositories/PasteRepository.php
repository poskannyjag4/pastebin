<?php

namespace App\Repositories;

use App\Enums\VisibilityEnum;
use App\Models\Paste;
use Illuminate\Database\Eloquent\Collection;
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

}
