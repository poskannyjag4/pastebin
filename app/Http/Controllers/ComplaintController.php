<?php

namespace App\Http\Controllers;

use App\DTOs\ComplaintDTO;
use App\Services\ComplaintService;
use App\Services\PasteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function __construct(
        private readonly ComplaintService $complaintService,
        private readonly PasteService $pasteService
    ) {}

    public function show(string $identifier): View
    {
        $paste = $this->pasteService->getByIdentifier($identifier);

        return View('complaints.show', compact('paste', 'identifier'));
    }

    /**
     * @throws \Exception
     */
    public function store(ComplaintDTO $request, string $identifier): RedirectResponse
    {
        try {
            $this->complaintService->store($request, $identifier, Auth::user());

            return redirect()->route('paste.home');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
}
