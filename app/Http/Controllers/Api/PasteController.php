<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ComplaintDTO;
use App\DTOs\PasteDTO;
use App\DTOs\PasteStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintRequest;
use App\Http\Requests\PasteStoreRequest;
use App\Http\Resources\ComplaintResource;
use App\Http\Resources\PasteResource;
use App\Models\Complaint;
use App\Models\User;
use App\Services\ComplaintService;
use App\Services\PasteService;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PasteController extends Controller
{
    public function __construct(
        private readonly PasteService $pasteService,
        private readonly ComplaintService $complaintService,
    ){}

    /**
     * @param PasteStoreDTO $data
     * @return JsonResponse|PasteResource
     */
    public function store(PasteStoreDTO $data): JsonResponse|PasteResource
    {
        try {
           $identifier = $this->pasteService->store($data, Auth::user());

           $paste = $this->pasteService->getByIdentifier($identifier);

           return new PasteResource(PasteDTO::from([
               'paste' => $paste,
               'identifier' => $identifier,
           ]));
        }
        catch (\Exception $e){
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getLastPastes(): AnonymousResourceCollection {
        $pastes = $this->pasteService->getLatestPastes()->latestPastes;

        return PasteResource::collection($pastes);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getLatestUserPastes(): AnonymousResourceCollection {
        $pastes = $this->pasteService->getLatestUserPastes(Auth::user())->latestPastes;

        return PasteResource::collection($pastes);
    }

    /**
     * @param string $hashId
     * @return PasteResource
     */
    public function getPaste(string $hashId): PasteResource {
        return new PasteResource(PasteDTO::from([
            'paste' => $this->pasteService->getByIdentifier($hashId),
            'identifier' => $hashId,
        ]));
    }

    /**
     * @param string $uuid
     * @return PasteResource
     */
    public function getUnlistedPaste(string $uuid): PasteResource {
        return new PasteResource(PasteDTO::from([
            'paste' => $this->pasteService->getByIdentifier($uuid),
            'identifier' => $uuid,
        ]));
    }

    /**
     * @param string $identifier
     * @param ComplaintDTO $request
     * @return ComplaintResource|JsonResponse
     */
    public function addComplaint(string $identifier, ComplaintDto $request): ComplaintResource|JsonResponse {
        try{
            $complaint = $this->complaintService->store($request, $identifier, Auth::user());

            return new ComplaintResource($complaint);
        } catch (\Exception $e) {
            return \response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
