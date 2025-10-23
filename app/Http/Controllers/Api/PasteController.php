<?php

namespace App\Http\Controllers\Api;

use App\DTOs\PasteStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintRequest;
use App\Http\Requests\PasteStoreRequest;
use App\Http\Resources\PasteResource;
use App\Services\ComplaintService;
use App\Services\PasteService;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PasteController extends Controller
{
    public function __construct(
        private readonly PasteService $pasteService,
        private readonly ComplaintService $complaintService,
    )
    {
    }

    /**
     * @param PasteStoreDTO $data
     * @return JsonResponse
     */
    public function store(PasteStoreDTO $data){
        try {
           $identifier = $this->pasteService->store($data, Auth::user());
           $paste = $this->pasteService->getByIdentifier($identifier);
           return new PasteResource($paste);
        }
        catch (\InvalidArgumentException $e){
            return response()->json(["error" => 'Неверно введены параметры!']);
        }
    }

    /**
     * 
     */
    public function getLastPastes()
    {
        $pastes = $this->pasteService->getLatestPastes()->latestPastes;
        return PasteResource::collection($pastes);
    }

    public function getLatestUserPastes(){

    }

    /**
     * @param string $hashId
     * @return JsonResponse
     */
    public function getPaste(string $hashId)
    {
        return response()->json($this->pasteService->get($hashId));
    }

    /**
     * @param string $uuid
     * @return JsonResponse
     */
    public function getUnlistedPaste(string $uuid)
    {
        return response()->json($this->pasteService->getUnlisted($uuid));
    }

    /**
     * @param string $identifier
     * @param ComplaintRequest $complaintRequest
     * @return JsonResponse
     */
    public function addComplaint(string $identifier, ComplaintRequest $complaintRequest)
    {
        if($this->complaintService->store($complaintRequest->toDTO(), $identifier))
            return response()->json(['message' => 'Жалоба успешно добавлена!'], 201);
        return response()->json(['message' => 'Произошла ошибка!'], 500);
    }


}
