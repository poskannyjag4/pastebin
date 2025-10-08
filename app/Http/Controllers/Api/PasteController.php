<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintRequest;
use App\Http\Requests\PasteStoreRequest;
use App\Services\ComplaintService;
use App\Services\PasteService;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param PasteStoreRequest $request
     * @return JsonResponse
     */
    public function store(PasteStoreRequest $request): JsonResponse{
        $validated = $request->toDTO();
        try {
            $identifier = $this->pasteService->store($validated);
        }
        catch (\InvalidArgumentException $e){
            return response()->json(["error" => 'Неверно введены параметры!']);
        }

        return response()->json($this->pasteService->getByIdentifier($identifier));
    }

    /**
     * @return JsonResponse
     */
    public function getLastPastes()
    {
        return \response()->json($this->pasteService->getDataForLayout());
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
