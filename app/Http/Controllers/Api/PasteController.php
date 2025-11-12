<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ComplaintDTO;
use App\DTOs\PasteStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintStoreRequest;
use App\Http\Requests\PasteStoreRequest;
use App\Http\Resources\ComplaintResource;
use App\Http\Resources\PasteResource;
use App\Services\ComplaintService;
use App\Services\PasteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PasteController extends Controller
{
    public function __construct(
        private readonly PasteService $pasteService,
        private readonly ComplaintService $complaintService,
    ) {}

    public function store(PasteStoreRequest $request): JsonResponse|PasteResource
    {
        $data = PasteStoreDTO::from($request->validated());
        try {
            $identifier = $this->pasteService->store($data, Auth::user());

            return new PasteResource($this->pasteService->getByIdentifier($identifier));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getLastPastes(): AnonymousResourceCollection
    {
        $pastes = $this->pasteService->getLatestPastes();

        return PasteResource::collection($pastes);
    }

    public function getLatestUserPastes(): AnonymousResourceCollection
    {
        $pastes = $this->pasteService->getLatestUserPastes(Auth::user());

        return PasteResource::collection($pastes);
    }

    public function getPaste(string $hashId): PasteResource|JsonResponse
    {
        return new PasteResource($this->pasteService->getByIdentifier($hashId));
    }

    public function getUnlistedPaste(string $uuid): PasteResource|JsonResponse
    {
        return new PasteResource($this->pasteService->getByIdentifier($uuid));
    }

    public function addComplaint(string $identifier, ComplaintStoreRequest $request): ComplaintResource|JsonResponse
    {
        $data = ComplaintDTO::from($request->validated());
        try {
            $complaint = $this->complaintService->store($data, $identifier, Auth::user());

            return new ComplaintResource($complaint);
        } catch (\Exception $e) {
            return \response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
