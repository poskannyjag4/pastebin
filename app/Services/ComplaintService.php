<?php

namespace App\Services;

use App\DTOs\ComplaintDTO;
use App\Models\Complaint;
use App\Models\Paste;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ComplaintService
{
    /**
     * @param PasteService $pasteService
     */
    public function __construct(
        private readonly PasteService $pasteService
    ){}

    /**
     * @param ComplaintDTO $data
     * @param string $identifier
     * @param User|null $user
     * @return Complaint
     * @throws \Exception
     */
    public function store(ComplaintDTO $data, string $identifier, ?User $user): Complaint {
        $paste = $this->pasteService->getByIdentifier($identifier);

        return Complaint::create([
            'details' => $data->details,
            'paste_id' => $paste->id,
            'user_id' => $user->id ?? null,
        ]);
    }

    /**
     * @return LengthAwarePaginator<int, Complaint>
     */
    public function getComplaints(): LengthAwarePaginator {
        return Complaint::with(['user', 'paste'])->paginate(15);
    }
}

