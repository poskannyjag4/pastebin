<?php

namespace App\Http\Controllers;

use App\DTOs\ComplaintDTO;
use App\Http\Requests\ComplaintRequest;
use App\Services\ComplaintService;
use App\Services\PasteService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    /**
     * @param ComplaintService $complaintService
     * @param PasteService $pasteService
     */
    public function __construct(
        private readonly ComplaintService $complaintService,
        private readonly PasteService $pasteService
    )
    {
    }

    /**
     * @param string $identifier
     * @return View
     */
    function show(string $identifier): View
    {
        $paste = $this->pasteService->getByIdentifier($identifier);
        return View('complaints.show', compact('paste', 'identifier'));
    }

    /**
     * @param ComplaintDTO $request
     * @param string $identifier
     * @return RedirectResponse
     * @throws \Exception
     */
    function store(ComplaintDTO $request, string $identifier): RedirectResponse
    {
        try {
            $this->complaintService->store($request, $identifier, Auth::user());
            return redirect()->route('paste.home');
        }
        catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
}
