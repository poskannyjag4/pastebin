<?php

namespace App\Repositories;

use App\Models\Complaint;
use Prettus\Repository\Eloquent\BaseRepository;

class ComplaintRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Complaint::class;
    }

    public function getPaginated()
    {
        return $this->model()->newQuery->with(['user', 'paste'])->paginate(15);
    }
}
