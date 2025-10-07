<?php

namespace App\Repositories;

use App\Models\Complaint;
use Illuminate\Pagination\LengthAwarePaginator;

class ComplaintRepository
{
    /**
     * @param array{
     *     details: string,
     *     user_id: int|null,
     *     paste_id: int
     * } $data
     * @return ?Complaint
     */
    public function create(array $data): ?Complaint{
        return Complaint::create($data);
    }

    /**
     * @return LengthAwarePaginator<int, Complaint>
     */
    public function getComplaints(): LengthAwarePaginator
    {
        return Complaint::with(['user', 'paste'])->paginate(15);
    }
}
