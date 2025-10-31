<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ComplaintDTO;
use App\DTOs\PasteDTO;
use App\DTOs\PasteStoreDTO;
use App\Http\Controllers\Controller;
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

    public function store(PasteStoreDTO $data): JsonResponse|PasteResource
    {
        try {
            $identifier = $this->pasteService->store($data, Auth::user());

            $paste = $this->pasteService->getByIdentifier($identifier);

            return new PasteResource(PasteDTO::from([
                'paste' => $paste,
                'identifier' => $identifier,
            ]));
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => 'Неверно введены параметры!']);
        }
    }

    public function getLastPastes(): AnonymousResourceCollection
    {
        $pastes = $this->pasteService->getLatestPastes()->latestPastes;

        return PasteResource::collection($pastes);
    }

    public function getLatestUserPastes(): AnonymousResourceCollection
    {
        $pastes = $this->pasteService->getLatestUserPastes(Auth::user())->latestPastes;

        return PasteResource::collection($pastes);
    }

    public function getPaste(string $hashId): PasteResource
    {
        return new PasteResource(PasteDTO::from([
            'paste' => $this->pasteService->getByIdentifier($hashId),
            'identifier' => $hashId,
        ]));
    }

    public function getUnlistedPaste(string $uuid): PasteResource
    {
        return new PasteResource(PasteDTO::from([
            'paste' => $this->pasteService->getByIdentifier($uuid),
            'identifier' => $uuid,
        ]));
    }

    public function addComplaint(string $identifier, ComplaintDto $request): ComplaintResource|JsonResponse
    {
        try {
            $complaint = $this->complaintService->store($request, $identifier, Auth::user());

            return new ComplaintResource($complaint);
        } catch (\Exception $e) {
            return \response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
