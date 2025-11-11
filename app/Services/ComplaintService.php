<?php

namespace App\Services;

use App\DTOs\ComplaintDTO;
use App\Models\Complaint;
use App\Models\User;
use App\Repositories\ComplaintRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ComplaintService
{
    public function __construct(
        private readonly PasteService $pasteService,
        private readonly ComplaintRepository $complaintRepository,
    ) {}

    /**
     * @throws \Exception
     */
    public function store(ComplaintDTO $data, string $identifier, ?User $user): Complaint
    {
        $paste = $this->pasteService->getByIdentifier($identifier);
        return $this->complaintRepository->create([
            'details' => $data->details,
            'paste_id' => $paste->id,
            'user_id' => $user->id ?? null,
        ]);
    }

    /**
     * @return LengthAwarePaginator<int, Complaint>
     */
    public function getComplaints(): LengthAwarePaginator
    {
        return $this->complaintRepository->getPaginated();
    }
}
