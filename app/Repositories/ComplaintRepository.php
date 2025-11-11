<?php

namespace App\Repositories;

use App\Models\Complaint;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository;

class ComplaintRepository extends BaseRepository
{
    /**
     * @var Complaint
     */
    protected $model;

    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return Complaint::class;
    }

    /**
     * @return LengthAwarePaginator<int, Complaint>
     */
    public function getPaginated(): LengthAwarePaginator
    {
        return $this->model->newQuery()->with(['user', 'paste'])->paginate(15);
    }
}
