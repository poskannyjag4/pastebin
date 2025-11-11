<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return LengthAwarePaginator<int,User>
     */
    public function getPaginated(): LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate(15);
    }
}
