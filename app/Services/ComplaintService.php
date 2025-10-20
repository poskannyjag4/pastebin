<?php

namespace App\Services;

use App\DTOs\ComplaintDTO;
use App\Models\Complaint;
use App\Models\Paste;
use App\Repositories\ComplaintRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ComplaintService
{
    /**
     * @param ComplaintRepository $complaintRepository
     * @param PasteService $pasteService
     */
    public function __construct(
        private readonly ComplaintRepository $complaintRepository,
        private readonly PasteService $pasteService
    )
    {
    }

    /**
     * @param ComplaintDTO $data
     * @param string $identifier
     * @return bool
     */
    public function store(ComplaintDTO $data, string $identifier): bool{
        $paste = $this->pasteService->getByIdentifier($identifier);
        $complaint = Complaint::create([
            'details' => $data->details,
            'paste_id' => $paste->id,
            'user_id' => Auth::check() ? Auth::user()->id : null,
        ]);

        if(is_null($complaint)){
            return false;
        }
        return true;
    }

    /**
     * @return LengthAwarePaginator<int, Complaint>
     */
    public function getComplaints(): LengthAwarePaginator
    {
        return Complaint::with(['user', 'paste'])->paginate(15);
    }
}
