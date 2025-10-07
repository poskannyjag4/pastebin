<?php

namespace App\Repositories;

use App\Models\Complaint;

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
}
